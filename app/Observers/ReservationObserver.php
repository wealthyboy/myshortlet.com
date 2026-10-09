<?php

namespace App\Observers;

use App\Models\Reservation;
use App\Services\ChannexPro\ReservationEventService;

class ReservationObserver
{
    public function created(Reservation $reservation): void
    {
        app(ReservationEventService::class)->created($reservation);
    }

    public function updated(Reservation $reservation): void
    {
        app(ReservationEventService::class)->updated($reservation);
    }

    public function deleted(Reservation $reservation): void
    {
        app(ReservationEventService::class)->deleted($reservation);
    }
}
