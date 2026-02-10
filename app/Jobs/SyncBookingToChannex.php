<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Reservation;
use App\Services\Channex\BookingAvailabilityService;


class SyncBookingToChannex implements ShouldQueue
{
    use Dispatchable, Queueable, SerializesModels;

    public function __construct(public Reservation $reservation) {}


    public function handle()
    {
        app(BookingAvailabilityService::class)
            ->sync($this->reservation);
    }
}
