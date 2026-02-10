<?php

namespace App\Services\Channex;

use App\Models\Apartment;



class AvailabilityService extends ChannexClient
{
    public function sync(Apartment $apartment): void
    {
        $this->post('/availability', [
            'values' => [
                [
                    'property_id' => $apartment->property->channex_property_id,
                    'room_type_id' => $apartment->channex_room_type_id,
                    'date_from' => now()->toDateString(),
                    'date_to' => now()->addYear()->toDateString(),
                    'availability' => $apartment->allow ? 1 : 0,
                ],
            ],
        ]);
    }
}
