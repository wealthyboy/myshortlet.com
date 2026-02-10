<?php

namespace App\Services\Channex;

use App\Models\Apartment;

class RoomTypePhotoService extends ChannexClient
{
    public function sync(Apartment $apartment): void
    {
        if (
            !$apartment->channex_room_type_id ||
            !$apartment->property ||
            !$apartment->property->channex_property_id
        ) {
            return;
        }

        $roomTypeId = $apartment->channex_room_type_id;
        $propertyId = $apartment->property->channex_property_id;


        foreach ($images as $index => $image) {

            // 🔒 Idempotency
            if ($image->channex_photo_id) {
                continue;
            }

            $response = $this->post('/photos', [
                'photo' => [
                    'property_id'  => $propertyId,
                    'room_type_id' => $roomTypeId,
                    'url' => $image->image,
                    'kind' => 'photo',
                    'position'     => $index,
                ],
            ]);

            $image->update([
                'channex_photo_id'     => $response['data']['id'],
                'channex_room_type_id' => $roomTypeId,
            ]);
        }
    }
}
