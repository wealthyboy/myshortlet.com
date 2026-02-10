<?php

namespace App\Services\Channex;

use App\Models\Apartment;
use App\Models\Image;

class RoomTypeService extends ChannexClient
{
    public function create($propertyChannexId, array $room)
    {
        return $this->post('/room_types', [
            'data' => [
                'type' => 'room_type',
                'attributes' => [
                    'title'       => $room['name'],
                    'max_occupancy' => $room['max_occupancy'],
                ],
                'relationships' => [
                    'property' => [
                        'data' => [
                            'type' => 'property',
                            'id'   => $propertyChannexId,
                        ],
                    ],
                ],
            ],
        ]);
    }


    public function sync(Apartment $apartment): void
    {
        $images = $apartment->images()->orderBy('id')->get();

        $facilityIds = $apartment->apartmentfacilities()
            ->whereNotNull('channex_facility_id')
            ->pluck('channex_facility_id')
            ->values()
            ->toArray();

        \Log::info($facilityIds);

        $payload = [
            'room_type' => [
                'property_id' => $apartment->property->channex_property_id,
                'title' => $apartment->name,

                // Inventory
                'count_of_rooms' => 1,

                // Occupancy
                'occ_adults' => 7,
                'occ_children' => 1,
                'occ_infants' => 1,
                'default_occupancy' => min($apartment->max_adults ?? 2, 2),

                // Metadata
                'facilities' => $facilityIds,
                'room_kind'  => 'room',
                'capacity'   => null,

                // Content
                'content' => [
                    'description' => $apartment->teaser ?? $apartment->name,
                    'photos' => $images->map(function ($image, $index) {
                        return [
                            'author'      => 'Avenue Montaigne',
                            'description' => $image->caption ?? 'Apartment photo',
                            'kind'        => 'photo',
                            'position'    => $index,
                            'url'         => $image->image,
                        ];
                    })->values()->toArray(),
                ],
            ],
        ];

        /** -------------------------
         * CREATE
         * ------------------------*/
        if (!$apartment->channex_room_type_id) {
            $response = $this->post('/room_types', $payload);

            $roomTypeId =
                $response['data']['attributes']['id']
                ?? $response['data']['id']
                ?? null;

            if (!$roomTypeId) {
                throw new \Exception('Channex room type ID not returned');
            }

            $apartment->update([
                'channex_room_type_id' => $roomTypeId,
                'channex_synced' => true,
            ]);

            return;
        }

        /** -------------------------
         * UPDATE
         * ------------------------*/
        $this->put(
            '/room_types/' . $apartment->channex_room_type_id,
            $payload
        );
    }
}
