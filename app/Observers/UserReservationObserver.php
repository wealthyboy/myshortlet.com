<?php

namespace App\Observers;

use App\Models\UserReservation;
use App\Services\ChannexPro\ReservationEventService;

class UserReservationObserver
{
    public function updated(UserReservation $reservation): void
    {
        if ($reservation->wasChanged(['status', 'is_cancelled'])) {
            app(ReservationEventService::class)->statusChanged($reservation);
        }
    }
}
