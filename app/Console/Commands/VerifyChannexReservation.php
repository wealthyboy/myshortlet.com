<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\Reservations\ReservationsController;
use App\Jobs\ProcessChannexAriOutbox;
use App\Models\Apartment;
use App\Models\ChannexAriOutboxEvent;
use App\Models\ChannexCertificationLog;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;

class VerifyChannexReservation extends Command
{
    protected $signature = 'channex:verify-reservation
        {property : Local property ID, exact name, or Channex property UUID}
        {apartment : Local apartment ID or exact name}
        {checkin : Check-in date (YYYY-MM-DD)}
        {checkout : Check-out date (YYYY-MM-DD)}
        {--execute : Create a real PMS reservation}
        {--process : Process its Channex ARI events immediately}
        {--move-week : Move the reservation exactly seven days later and process that update}
        {--error-reference= : Find a previous reservation failure in laravel.log without creating data}
        {--email=channex-certification@invalid.local : Guest email stored on the test booking}
        {--phone=+2340000000000 : Guest phone stored on the test booking}';

    protected $description = 'Create and optionally move a real PMS reservation while reporting Channex ARI evidence';

    public function handle(): int
    {
        if ($this->option('error-reference')) {
            return $this->reportErrorReference((string) $this->option('error-reference'));
        }

        if (! $this->option('execute')) {
            $this->warn('No reservation was created. Add --execute after reviewing the selected property, room, and dates.');
            return self::FAILURE;
        }

        if ($this->option('move-week') && ! $this->option('process')) {
            $this->error('--move-week requires --process. No reservation was created.');
            return self::FAILURE;
        }

        try {
            [$property, $apartment, $checkin, $checkout] = $this->resolveInputs();
            $this->preflight($property, $apartment, $checkin, $checkout);

            $this->table(['Field', 'Value'], [
                ['Property', "#{$property->id} {$property->name}"],
                ['Channex property', $property->channex_property_id],
                ['Apartment', "#{$apartment->id} {$apartment->name}"],
                ['Channex room type', $apartment->channex_room_type_id],
                ['Stay', $checkin->toDateString() . ' to ' . $checkout->toDateString()],
                ['Availability before booking', app(\App\Services\Channex\InventorySyncService::class)->availability($apartment, $checkin->toDateString())],
            ]);

            $reservation = $this->createReservation($property, $apartment, $checkin, $checkout);
            $this->info("Created PMS reservation #{$reservation->id} ({$reservation->invoice}).");

            $this->reportAri('Create', $apartment, 'test_9_booking_create');

            if ($this->option('move-week')) {
                $this->moveReservationOneWeek($reservation, $checkin, $checkout);
                $this->reportAri('Move +7 days', $apartment, 'test_9_booking_move');
            }

            $this->line('PMS details: ' . url('/admin/reservations/' . $reservation->id));
            $this->line('Channex logs: ' . url('/admin/channex/certification/logs'));

            return self::SUCCESS;
        } catch (ValidationException $exception) {
            foreach ($exception->errors() as $field => $messages) {
                $this->error($field . ': ' . implode(' ', $messages));
            }
        } catch (\Throwable $exception) {
            $this->error(get_class($exception) . ': ' . $exception->getMessage());
            logger()->error('Channex reservation verification failed', [
                'exception' => $exception,
                'property' => $this->argument('property'),
                'apartment' => $this->argument('apartment'),
                'checkin' => $this->argument('checkin'),
                'checkout' => $this->argument('checkout'),
            ]);
        }

        $this->line('Recent reservation errors:');
        $this->line($this->recentReservationErrors());
        return self::FAILURE;
    }

    protected function resolveInputs(): array
    {
        $propertyIdentifier = (string) $this->argument('property');
        $property = Property::query()
            ->when(ctype_digit($propertyIdentifier), fn ($query) => $query->whereKey((int) $propertyIdentifier))
            ->when(! ctype_digit($propertyIdentifier), function ($query) use ($propertyIdentifier) {
                $query->where(function ($nested) use ($propertyIdentifier) {
                    $nested->where('name', $propertyIdentifier)
                        ->orWhere('channex_property_id', $propertyIdentifier);
                });
            })
            ->firstOrFail();

        $apartmentIdentifier = (string) $this->argument('apartment');
        $apartment = $property->apartments()
            ->when(ctype_digit($apartmentIdentifier), fn ($query) => $query->whereKey((int) $apartmentIdentifier))
            ->when(! ctype_digit($apartmentIdentifier), fn ($query) => $query->where('name', $apartmentIdentifier))
            ->firstOrFail();

        $checkin = Carbon::createFromFormat('Y-m-d', (string) $this->argument('checkin'))->startOfDay();
        $checkout = Carbon::createFromFormat('Y-m-d', (string) $this->argument('checkout'))->startOfDay();

        if ($checkout->lte($checkin)) {
            throw new \InvalidArgumentException('Checkout must be after check-in.');
        }

        return [$property, $apartment, $checkin, $checkout];
    }

    protected function preflight(Property $property, Apartment $apartment, Carbon $checkin, Carbon $checkout): void
    {
        if (! Schema::hasColumn('channex_ari_outbox_events', 'scenario')) {
            throw new \RuntimeException('The Channex scenario migration is pending. Run php artisan migrate --force.');
        }

        if (! $property->channex_property_id || ! $apartment->channex_room_type_id) {
            throw new \RuntimeException('The selected property and apartment must be mapped to Channex first.');
        }

        $lock = Cache::lock('channex:reservation-verification', 10);
        if (! $lock->get()) {
            throw new \RuntimeException('The verification lock is already held. Retry in ten seconds.');
        }
        $lock->release();

        $conflict = Reservation::query()
            ->where('apartment_id', $apartment->id)
            ->where('checkin', '<', $checkout)
            ->where('checkout', '>', $checkin)
            ->whereHas('user_reservation', function ($query) {
                $query->where(function ($nested) {
                    $nested->whereNull('is_cancelled')->orWhere('is_cancelled', false);
                })->where(function ($nested) {
                    $nested->whereNull('status')->orWhereNotIn('status', ['cancelled', 'canceled']);
                });
            })
            ->exists();

        if ($conflict) {
            throw new \RuntimeException('The apartment already has an active reservation overlapping these dates.');
        }
    }

    protected function createReservation(Property $property, Apartment $apartment, Carbon $checkin, Carbon $checkout): UserReservation
    {
        $beforeId = (int) UserReservation::query()->max('id');
        $request = $this->request([
            'property_id' => $property->id,
            'apartment_id' => $apartment->id,
            'first_name' => 'Channex',
            'last_name' => 'Certification',
            'email' => (string) $this->option('email'),
            'phone_number' => (string) $this->option('phone'),
            'checkin' => $checkin->toDateString(),
            'checkout' => $checkout->toDateString(),
            'currency' => '$',
            'discount_type' => 'percent',
            'discount' => 0,
            'caution_fee' => 0,
            '_channex_verification' => true,
        ]);

        $response = app(ReservationsController::class)->store($request);
        $error = $request->session()->get('error');
        if ($error) {
            throw new \RuntimeException($error);
        }

        return UserReservation::with('reservations')
            ->where('id', '>', $beforeId)
            ->where('property_id', $property->id)
            ->where('coming_from', 'checkin')
            ->latest('id')
            ->firstOrFail();
    }

    protected function moveReservationOneWeek(UserReservation $reservation, Carbon $checkin, Carbon $checkout): void
    {
        $request = $this->request([
            'checkin' => $checkin->copy()->addWeek()->toDateString(),
            'checkout' => $checkout->copy()->addWeek()->toDateString(),
        ], 'PUT');

        app(ReservationsController::class)->update($request, $reservation->id);
        $error = $request->session()->get('error');
        if ($error) {
            throw new \RuntimeException($error);
        }

        $reservation->refresh();
        $this->info('Moved reservation to ' . $checkin->copy()->addWeek()->toDateString()
            . ' through ' . $checkout->copy()->addWeek()->toDateString() . '.');
    }

    protected function request(array $input, string $method = 'POST'): Request
    {
        $request = Request::create('/artisan/channex-reservation-verification', $method, $input);
        $request->setLaravelSession(app('session')->driver());
        app()->instance('request', $request);
        return $request;
    }

    protected function reportAri(string $label, Apartment $apartment, string $scenario): void
    {
        $events = ChannexAriOutboxEvent::query()
            ->where('apartment_id', $apartment->id)
            ->where('status', 'pending')
            ->orderBy('id')
            ->get();

        if ($events->isEmpty()) {
            throw new \RuntimeException("{$label}: no pending ARI event was created by the reservation observer.");
        }

        ChannexAriOutboxEvent::whereIn('id', $events->pluck('id'))->update(['scenario' => $scenario]);
        $this->line($label . ' ARI payload: ' . json_encode($events->pluck('payload')->all()));

        if (! $this->option('process')) {
            $this->warn($label . ': ARI is queued but not processed. Run the queue worker or add --process.');
            return;
        }

        app()->call([new ProcessChannexAriOutbox(), 'handle']);
        $eventIds = $events->pluck('id')->values()->all();
        $log = ChannexCertificationLog::query()
            ->where('source', 'ari_outbox')
            ->where('scenario', $scenario)
            ->latest('id')
            ->get()
            ->first(function ($candidate) use ($eventIds) {
                return array_values((array) data_get($candidate->request_payload, 'event_ids')) === $eventIds;
            });

        if (! $log || $log->status !== 'success' || empty($log->task_ids)) {
            throw new \RuntimeException("{$label}: Channex did not return a successful task ID.");
        }

        $this->info($label . ' Channex task ID(s): ' . implode(', ', $log->task_ids));
    }

    protected function recentReservationErrors(): string
    {
        $log = storage_path('logs/laravel.log');
        if (! is_file($log) || ! is_readable($log)) {
            return 'Laravel log is not readable at ' . $log;
        }

        $lines = array_slice(file($log, FILE_IGNORE_NEW_LINES) ?: [], -300);
        $matches = array_values(array_filter($lines, function ($line) {
            return stripos($line, 'Reservation creation failed') !== false
                || stripos($line, 'Channex reservation verification failed') !== false;
        }));

        return $matches ? implode(PHP_EOL, array_slice($matches, -5)) : 'No recent matching errors found.';
    }

    protected function reportErrorReference(string $reference): int
    {
        $log = storage_path('logs/laravel.log');
        if (! is_file($log) || ! is_readable($log)) {
            $this->error('Laravel log is not readable at ' . $log);
            return self::FAILURE;
        }

        $handle = new \SplFileObject($log, 'r');
        foreach ($handle as $line) {
            if (is_string($line) && strpos($line, $reference) !== false) {
                $this->line(trim($line));
                return self::SUCCESS;
            }
        }

        $this->error('Error reference was not found in ' . $log);
        return self::FAILURE;
    }
}