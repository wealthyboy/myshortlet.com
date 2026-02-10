<?php

namespace App\Services\Channex;

use App\Models\Property;
use Illuminate\Support\Facades\Log;

class GroupPropertyService extends ChannexClient
{
    public function sync(Property $property): Property
    {

        if (!$property->channex_group_id) {
            $groupResponse = $this->post('/groups', [
                'group' => [
                    'title' => $property->name,
                ],
            ]);

            $property->channex_group_id = $groupResponse['data']['id'];
            $property->save();
        }


        if (!$property->channex_property_id) {
            $propertyResponse = $this->post('/properties', [
                'property' => [
                    'title' => $property->name,
                    'currency' => 'USD',
                    'email' => 'info@avenuemontaigne.ng',
                    'phone' => '+2347018971322',
                    'zip_code' => '100001',
                    'country' => 'NG',
                    'state' => 'Lagos',
                    'city' => 'Ikoyi',
                    'address' => '37 cooper road',
                    'latitude'  => '6.4548',
                    'longitude' => '3.4347',
                    'timezone' => 'Africa/Lagos',
                    'property_type' => 'apart_hotel',
                    'group_id' => $property->channex_group_id, // or explicit UUID
                    'settings' => [
                        'allow_availability_autoupdate_on_confirmation' => true,
                        'allow_availability_autoupdate_on_modification' => false,
                        'allow_availability_autoupdate_on_cancellation' => false,
                        'min_stay_type' => 'both',
                        'min_price' => null,
                        'max_price' => null,
                        'state_length' => 500,
                        'cut_off_time' => '00:00:00',
                        'cut_off_days' => 0,
                        'max_day_advance' => null,
                    ],

                    'content' => [
                        'description' => 'Avenue Montaigne - Premium service apartments with modern amenities, perfect for short or long stays. Enjoy a comfortable, home-like experience in prime locations.',
                        'important_information' => 'Check-in instructions and house rules will be shared prior to arrival.',
                        'photos' => [
                            [
                                'url' => 'https://avevuemontaigne-ng.lon1.cdn.digitaloceanspaces.com/images/apartments/1764494799_PHOTO-2025-11-30-10-24-37.webp',
                                'position' => 0,
                                'author' => 'Avenue Montaigne',
                                'kind' => 'photo',
                                'description' => 'Exterior view of Avenue Montaigne',
                            ],
                        ],
                    ],

                    'logo_url' => 'https://drive.google.com/thumbnail?id=1eQ_hLe9Th_2Oew3Qoew_qQKhuGBpHGZm&sz=w2000',
                    'website'  => 'https://avenuemontaigne.ng',
                ],


            ]);

            $property->channex_property_id = $propertyResponse['data']['id'];
            $property->channex_synced = true;
            $property->save();
        }

        return $property;
    }
}
