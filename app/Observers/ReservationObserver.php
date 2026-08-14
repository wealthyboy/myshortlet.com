<?php

namespace App\Observers;

use App\Models\Apartment;
use App\Models\Reservation;
use App\Services\Channex\InventorySyncService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class ReservationObserver
{
    public function created(Reservation $reservation): void
    {
        app(InventorySyncService::class)->queueReservation($reservation);
    }

    public function updated(Reservation $reservation): void
    {
        if ($reservation->wasChanged(['apartment_id', 'quantity', 'checkin', 'checkout', 'is_blocked'])) {
            $inventory = app(InventorySyncService::class);
            $original = new Reservation();
            $original->apartment_id = $reservation->getOriginal('apartment_id');
            $original->checkin = $reservation->getOriginal('checkin');
            $original->checkout = $reservation->getOriginal('checkout');

            $sameInventoryLine = (int) $reservation->getOriginal('apartment_id') === (int) $reservation->apartment_id
                && (int) $reservation->getOriginal('quantity') === (int) $reservation->quantity
                && (bool) $reservation->getOriginal('is_blocked') === (bool) $reservation->is_blocked;

            if ($sameInventoryLine && $reservation->wasChanged(['checkin', 'checkout'])) {
                $oldDates = $this->occupiedDates($original->checkin, $original->checkout);
                $newDates = $this->occupiedDates($reservation->checkin, $reservation->checkout);
                $changedDates = array_values(array_merge(
                    array_diff($oldDates, $newDates),
                    array_diff($newDates, $oldDates)
                ));

                $apartment = Apartment::with('property')->find($reservation->apartment_id);
                if ($apartment) {
                    $inventory->queueDates($apartment, $changedDates);
                }

                return;
            }

            $inventory->queueReservation($original);
            $inventory->queueReservation($reservation);
        }
    }

    public function deleted(Reservation $reservation): void
    {
        app(InventorySyncService::class)->queueReservation($reservation);
    }

    protected function occupiedDates($checkin, $checkout): array
    {
        if (! $checkin || ! $checkout) {
            return [];
        }

        $start = Carbon::parse($checkin)->startOfDay();
        $end = Carbon::parse($checkout)->startOfDay()->subDay();

        if ($end->lt($start)) {
            return [];
        }

        return collect(CarbonPeriod::create($start, $end))
            ->map(fn ($date) => $date->toDateString())
            ->all();
    }
}
