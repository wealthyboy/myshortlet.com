<?php

namespace App\Services\ChannexPro;

use App\Jobs\NotifyChannexProReservationEvent;
use App\Models\Apartment;
use App\Models\Reservation;
use App\Models\UserReservation;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ReservationEventService
{
    public function created(Reservation $reservation): void
    {
        $this->dispatch($reservation, 'reservation.created', [
            $this->affectedWindow(
                $this->propertyId($reservation),
                $reservation->checkin,
                $reservation->checkout,
                $reservation->apartment_id
            ),
        ]);
    }

    public function updated(Reservation $reservation): void
    {
        if (! $reservation->wasChanged([
            'apartment_id',
            'property_id',
            'quantity',
            'checkin',
            'checkout',
            'is_blocked',
        ])) {
            return;
        }

        $oldApartmentId = $reservation->getOriginal('apartment_id');
        $oldPropertyId = $reservation->getOriginal('property_id');

        if (! $oldPropertyId && $oldApartmentId) {
            $oldPropertyId = Apartment::query()->whereKey($oldApartmentId)->value('property_id');
        }

        $this->dispatch($reservation, 'reservation.updated', [
            $this->affectedWindow(
                $oldPropertyId,
                $reservation->getOriginal('checkin'),
                $reservation->getOriginal('checkout'),
                $oldApartmentId
            ),
            $this->affectedWindow(
                $this->propertyId($reservation),
                $reservation->checkin,
                $reservation->checkout,
                $reservation->apartment_id
            ),
        ]);
    }

    public function deleted(Reservation $reservation): void
    {
        $this->dispatch($reservation, 'reservation.deleted', [
            $this->affectedWindow(
                $this->propertyId($reservation),
                $reservation->checkin,
                $reservation->checkout,
                $reservation->apartment_id
            ),
        ], true);
    }

    public function statusChanged(UserReservation $userReservation): void
    {
        $userReservation->loadMissing(['reservations.apartment', 'guest_user']);

        $cancelled = (bool) ($userReservation->is_cancelled ?? false)
            || in_array(strtolower((string) $userReservation->status), ['cancelled', 'canceled'], true);

        foreach ($userReservation->reservations as $reservation) {
            $this->dispatch(
                $reservation,
                $cancelled ? 'reservation.cancelled' : 'reservation.status_changed',
                [
                    $this->affectedWindow(
                        $this->propertyId($reservation),
                        $reservation->checkin,
                        $reservation->checkout,
                        $reservation->apartment_id
                    ),
                ]
            );
        }
    }

    protected function dispatch(Reservation $reservation, string $event, array $affected, bool $forceCancelled = false): void
    {
        if (! (bool) config('services.channexpro.events_enabled', true)) {
            return;
        }

        $affected = $this->normalizeAffected($affected);
        if ($affected === []) {
            return;
        }

        $reservation->loadMissing(['apartment.property', 'user_reservation.guest_user']);
        $header = $reservation->user_reservation;
        $guest = $header?->guest_user;
        $apartment = $reservation->apartment;
        $propertyId = $this->propertyId($reservation);

        $cancelled = $forceCancelled
            || $event === 'reservation.cancelled'
            || ($header && (
                (bool) ($header->is_cancelled ?? false)
                || in_array(strtolower((string) $header->status), ['cancelled', 'canceled'], true)
            ));

        $status = $cancelled
            ? 'cancelled'
            : (trim((string) ($header?->status ?? '')) ?: 'confirmed');

        $currencyCode = strtoupper(trim((string) (
            $header?->currency_code
            ?: $reservation->currency_code
            ?: $header?->currency
            ?: $reservation->currency
            ?: 'USD'
        )));

        $currencyCode = match ($currencyCode) {
            '₦', 'NGN', 'NAIRA' => 'NGN',
            '$', 'USD' => 'USD',
            default => strlen($currencyCode) === 3 ? $currencyCode : 'USD',
        };

        $reference = trim((string) ($header?->invoice ?? ''));
        if ($reference === '') {
            $reference = 'AVM-'.$reservation->id;
        }

        $payload = [
            'schema' => 'channexpro.source-event.v1',
            'event' => $event,
            'event_id' => (string) Str::uuid(),
            'occurred_at' => now()->toIso8601String(),
            'source' => [
                'driver' => 'myshortlet',
                'name' => (string) config('app.name', 'Avenue Montaigne'),
                'url' => rtrim((string) config('app.url'), '/'),
            ],
            'property_id' => $propertyId !== null ? (string) $propertyId : null,
            'affected' => $affected,
            'reservation' => [
                'id' => (string) $reservation->id,
                'user_reservation_id' => $header?->id ? (string) $header->id : null,
                'reference' => $reference,
                'status' => $status,
                'is_blocked' => (bool) ($reservation->is_blocked ?? false),
                'source' => (string) ($reservation->source ?? 'website'),
                'ota_name' => $reservation->ota_name ?? $header?->ota_name,
                'external_id' => $reservation->external_id ?? $header?->external_id,
                'property_id' => $propertyId !== null ? (string) $propertyId : null,
                'check_in' => $this->dateString($reservation->checkin),
                'check_out' => $this->dateString($reservation->checkout),
                'adults' => max(0, (int) ($reservation->adults ?? 1)),
                'children' => max(0, (int) ($reservation->children ?? 0)),
                'currency' => $currencyCode,
                'total' => (float) ($header?->total ?? 0),
                'payment_status' => (bool) ($header?->checked ?? false) ? 'paid' : 'unpaid',
                'guest' => $guest ? [
                    'first_name' => (string) ($guest->name ?? ''),
                    'last_name' => (string) ($guest->last_name ?? ''),
                    'email' => $guest->email ?? null,
                    'phone' => $guest->phone_number ?? null,
                ] : null,
                'rooms' => $apartment ? [[
                    'room_type_id' => (string) $apartment->id,
                    'rate_plan_id' => 'standard:'.$apartment->id,
                    'quantity' => max(1, (int) ($reservation->quantity ?: 1)),
                    'check_in' => $this->dateString($reservation->checkin),
                    'check_out' => $this->dateString($reservation->checkout),
                    'room_total' => (float) ($header?->total ?? 0),
                ]] : [],
            ],
        ];

        NotifyChannexProReservationEvent::dispatch($payload)
            ->onConnection('database')
            ->afterCommit();
    }

    protected function normalizeAffected(array $affected): array
    {
        return collect($affected)
            ->filter(fn ($item) => is_array($item) && ! empty($item['property_id']) && ! empty($item['from']) && ! empty($item['to']))
            ->groupBy(fn ($item) => (string) $item['property_id'])
            ->map(function ($items) {
                $from = $items->pluck('from')->filter()->sort()->first();
                $to = $items->pluck('to')->filter()->sort()->last();
                $roomIds = $items->pluck('room_type_id')->filter()->map(fn ($id) => (string) $id)->unique()->values()->all();

                return [
                    'property_id' => (string) $items->first()['property_id'],
                    'room_type_ids' => $roomIds,
                    'from' => $from,
                    'to' => $to,
                ];
            })
            ->values()
            ->all();
    }

    protected function affectedWindow($propertyId, $checkin, $checkout, $apartmentId = null): ?array
    {
        if (! $propertyId || ! $checkin || ! $checkout) {
            return null;
        }

        try {
            $from = Carbon::parse($checkin)->startOfDay();
            $to = Carbon::parse($checkout)->startOfDay()->subDay();
        } catch (\Throwable $e) {
            return null;
        }

        if ($to->lt($from)) {
            return null;
        }

        return [
            'property_id' => (string) $propertyId,
            'room_type_id' => $apartmentId ? (string) $apartmentId : null,
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
        ];
    }

    protected function propertyId(Reservation $reservation): ?int
    {
        if ($reservation->property_id) {
            return (int) $reservation->property_id;
        }

        if ($reservation->relationLoaded('apartment') && $reservation->apartment) {
            return (int) $reservation->apartment->property_id;
        }

        return $reservation->apartment_id
            ? (int) Apartment::query()->whereKey($reservation->apartment_id)->value('property_id')
            : null;
    }

    protected function dateString($value): ?string
    {
        if (! $value) {
            return null;
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable $e) {
            return null;
        }
    }
}
