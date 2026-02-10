<?php

namespace App\Services\Channex;

use App\Models\Facility;

class FacilitySyncService extends ChannexClient
{
    public function sync(): void
    {
        $this->syncPropertyFacilities();
        $this->syncRoomFacilities();
    }

    protected function syncPropertyFacilities(): void
    {
        $response = $this->get('/property_facilities/options');

        foreach ($response['data'] as $item) {
            Facility::updateOrCreate(
                ['channex_facility_id' => $item['id']],
                [
                    'name' => $item['attributes']['title'],
                    'scope' => 'property',
                    'channex_kind' => 'property',
                    'is_active' => true,
                    'category' => $item['attributes']['category']
                ]
            );
        }
    }

    protected function syncRoomFacilities(): void
    {
        $response = $this->get('/room_facilities/options');

        foreach ($response['data'] as $item) {
            Facility::updateOrCreate(
                ['channex_facility_id' => $item['id']],
                [
                    'name' => $item['attributes']['title'],
                    'scope' => 'room',
                    'channex_kind' => 'room',
                    'is_active' => true,
                    'category' => $item['attributes']['category']
                ]
            );
        }
    }
}
