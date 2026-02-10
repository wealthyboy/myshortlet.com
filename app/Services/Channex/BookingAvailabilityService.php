<?php

namespace App\Services\Channex;

use App\Models\Reservation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BookingAvailabilityService extends ChannexClient
{
    public function sync(Reservation $reservation): void
    {
        $apartment = $reservation->apartment;

        Log::info($apartment);
        Log::info($reservation);

        // Safety checks
        if (
            !$apartment ||
            !$apartment->channex_room_type_id ||
            !$apartment->property?->channex_property_id
        ) {
            return;
        }

        $checkIn  = $reservation->checkin;
        $checkOut = $reservation->checkout; // nights only

        Log::info(
            [
                'property_id' => $apartment->property->channex_property_id,
                'room_type_id' => $apartment->channex_room_type_id,
                'date_from' => $checkIn->toDateString(),
                'date_to' => $checkOut->toDateString(),
                'availability' => 0,

            ]
        );

        $response  = $this->post('/availability', [
            'values' => [
                [
                    'property_id' => $apartment->property->channex_property_id,
                    'room_type_id' => $apartment->channex_room_type_id,
                    'date_from' => $checkIn->toDateString(),
                    'date_to' => $checkOut->toDateString(),
                    'availability' => 0,
                ],
            ],
        ]);

        Log::info($response);
    }
}
