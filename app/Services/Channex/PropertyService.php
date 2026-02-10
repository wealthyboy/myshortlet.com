<?php

namespace App\Services\Channex;

class PropertyService extends ChannexClient
{
    public function create(array $property)
    {
        return $this->post('/properties', [
            'data' => [
                'type' => 'property',
                'attributes' => [
                    'title'    => $property['name'],
                    'currency' => 'NGN',
                    'timezone' => 'Africa/Lagos',
                ],
            ],
        ]);
    }
}
