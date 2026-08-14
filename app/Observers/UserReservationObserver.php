<?php

namespace App\Observers;

use App\Models\UserReservation;
use App\Services\Channex\InventorySyncService;

class UserReservationObserver
{
    public function updated(UserReservation $reservation): void
    {
        if ($reservation->wasChanged(['status', 'is_cancelled'])) {
            app(InventorySyncService::class)->queueUserReservation($reservation);
        }
    }
}
