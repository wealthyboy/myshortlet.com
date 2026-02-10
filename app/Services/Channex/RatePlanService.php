<?php

namespace App\Services\Channex;

use App\Models\Apartment;


class RatePlanService extends ChannexClient
{
    public function create($propertyId, $roomTypeId, array $rate)
    {
        return $this->post('/rate_plans', [
            'data' => [
                'type' => 'rate_plan',
                'attributes' => [
                    'title' => $rate['name'],
                ],
                'relationships' => [
                    'property' => [
                        'data' => [
                            'type' => 'property',
                            'id'   => $propertyId,
                        ],
                    ],
                    'room_type' => [
                        'data' => [
                            'type' => 'room_type',
                            'id'   => $roomTypeId,
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function sync(Apartment $apartment): void
    {
        if ($apartment->channex_rate_plan_id) {
            return;
        }

        $response = $this->post('/rate_plans', [
            'rate_plan' => [
                'title' => 'Standard Rate',
                'property_id' => $apartment->property->channex_property_id,
                'room_type_id' => $apartment->channex_room_type_id,
                'sell_mode' => 'per_room',
                'rate_mode' => 'manual',
                'options' => [
                    [
                        'occupancy' => $apartment->max_adults,
                        'is_primary' => true,
                    ],
                ],
                "currency" => "USD",
            ],
        ]);

        \Log::info($response);

        $apartment->update([
            'channex_rate_plan_id' => $response['data']['id'],
        ]);
    }
}
