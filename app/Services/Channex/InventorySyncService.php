<?php

namespace App\Services\Channex;

use App\Jobs\ProcessChannexAriOutbox;
use App\Models\Apartment;
use App\Models\Reservation;
use App\Models\UserReservation;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class InventorySyncService
{
    public function availability(Apartment $apartment, string $date): int
    {
        if (! (bool) $apartment->allow) {
            return 0;
        }

        $dailyCapacity = $apartment->dailyRates()
            ->whereNull('channex_rate_plan_id')
            ->whereDate('date', $date)
            ->value('availability');

        $capacity = $dailyCapacity !== null
            ? (int) $dailyCapacity
            : max(1, (int) ($apartment->quantity ?? 1));

        $reserved = (int) Reservation::query()
            ->where('apartment_id', $apartment->id)
            ->where('checkin', '<=', $date)
            ->where('checkout', '>', $date)
            ->whereHas('user_reservation', function ($query) {
                $query->where(function ($statusQuery) {
                    $statusQuery->whereNull('status')
                        ->orWhereNotIn('status', ['cancelled', 'canceled']);
                })->where(function ($cancelQuery) {
                    $cancelQuery->whereNull('is_cancelled')
                        ->orWhere('is_cancelled', false);
                });
            })
            ->sum('quantity');

        return max(0, $capacity - $reserved);
    }

    public function queueReservation(Reservation $reservation): void
    {
        $apartment = $reservation->apartment()->with('property')->first();
        if (! $apartment || ! $apartment->property || ! $reservation->checkin || ! $reservation->checkout) {
            return;
        }

        if (! $apartment->property->channex_property_id || ! $apartment->channex_room_type_id) {
            return;
        }

        $end = Carbon::parse($reservation->checkout)->subDay();
        $start = Carbon::parse($reservation->checkin);
        if ($end->lt($start)) {
            return;
        }

        $this->queueDates(
            $apartment,
            collect(CarbonPeriod::create($start, $end))
                ->map(fn ($date) => $date->toDateString())
                ->all()
        );
    }

    public function queueDates(Apartment $apartment, array $dates): void
    {
        $apartment->loadMissing('property');

        if (! $apartment->property
            || ! $apartment->property->channex_property_id
            || ! $apartment->channex_room_type_id) {
            return;
        }

        $dates = collect($dates)
            ->filter()
            ->map(fn ($date) => Carbon::parse($date)->toDateString())
            ->unique()
            ->sort()
            ->values();

        if ($dates->isEmpty()) {
            return;
        }

        $ranges = [];
        foreach ($dates as $dateString) {
            $date = Carbon::parse($dateString);
            $value = $this->availability($apartment, $dateString);
            $lastIndex = count($ranges) - 1;

            if ($lastIndex >= 0
                && $ranges[$lastIndex]['availability'] === $value
                && Carbon::parse($ranges[$lastIndex]['date_to'])->addDay()->isSameDay($date)) {
                $ranges[$lastIndex]['date_to'] = $dateString;
                continue;
            }

            $ranges[] = [
                'date_from' => $dateString,
                'date_to' => $dateString,
                'availability' => $value,
            ];
        }

        foreach ($ranges as $payload) {
            app(AriOutboxService::class)->queueApartmentChange($apartment, $payload);
        }

        // Keep the outbox event and its processor job in the same database
        // transaction as the reservation. A database queue record is not
        // visible to workers until the transaction commits, and is rolled
        // back with the reservation if the transaction fails. This also
        // prevents a failing after-commit callback from making a successful
        // reservation appear to have failed in the admin UI.
        ProcessChannexAriOutbox::dispatch()
            ->onConnection('database')
            ->delay(now()->addSeconds(15));
    }

    public function queueUserReservation(UserReservation $userReservation): void
    {
        $userReservation->loadMissing('reservations');

        foreach ($userReservation->reservations as $reservation) {
            $this->queueReservation($reservation);
        }
    }
}
