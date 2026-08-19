<?php

namespace App\Services\Channex;

use App\Models\Reservation;
class BookingAvailabilityService extends ChannexClient
{
    public function sync(Reservation $reservation): void
    {
        // Retained for old callers, but no longer bypasses the outbox or sends
        // an incorrect hard-coded zero (including the checkout date).
        app(InventorySyncService::class)->queueReservation($reservation);
    }
}
