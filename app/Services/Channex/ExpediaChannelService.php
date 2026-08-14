<?php

namespace App\Services\Channex;

use Illuminate\Http\Client\RequestException;

class ExpediaChannelService extends ChannexClient
{
    /**
     * Step 1: Test connection to Expedia
     */
    public function testConnection(string $hotelId): bool
    {
        try {
            $response = $this->post('/channels/test_connection', [
                'channel'  => 'Expedia',
                'settings' => [
                    'hotel_id' => $hotelId,
                ],
            ]);

            return $response['data']['success'] ?? false;
        } catch (RequestException $e) {
            logger()->error('Expedia test connection failed', [
                'hotel_id'       => $hotelId,
                'status'         => $e->response->status(),
                'error_response' => $e->response->body(),
            ]);

            return false;
        }
    }

    /**
     * Step 2: Get Expedia rooms and rates for the hotel
     */
    public function getMappingDetails(string $hotelId): ?array
    {
        try {
            $response = $this->post('/channels/mapping_details', [
                'channel'  => 'Expedia',
                'settings' => [
                    'hotel_id' => $hotelId,
                ],
            ]);

            return $response['data'] ?? null;
        } catch (RequestException $e) {
            logger()->error('Failed to get Expedia mapping details', [
                'hotel_id'       => $hotelId,
                'status'         => $e->response->status(),
                'error_response' => $e->response->body(),
            ]);

            return null;
        }
    }

    /**
     * Step 3: Get connection details (currency info)
     */
    public function getConnectionDetails(string $hotelId): ?array
    {
        try {
            $response = $this->post('/channels/connection_details', [
                'channel'  => 'Expedia',
                'settings' => [
                    'hotel_id' => $hotelId,
                ],
            ]);

            return $response['data'] ?? null;
        } catch (RequestException $e) {
            logger()->error('Failed to get Expedia connection details', [
                'hotel_id'       => $hotelId,
                'status'         => $e->response->status(),
                'error_response' => $e->response->body(),
            ]);

            return null;
        }
    }

    /**
     * Step 4: Save/Create the channel with mappings
     */
    public function createChannel(array $channelData): ?array
    {
        try {
            $response = $this->post('/channels', [
                'channel' => $channelData,
            ]);

            return $response['data'] ?? null;
        } catch (RequestException $e) {
            logger()->error('Failed to create Expedia channel', [
                'error_response' => $e->response->body(),
            ]);

            return null;
        }
    }

    /**
     * Format mapping entry for Expedia
     * Maps a Channex rate plan to Expedia room/rate codes
     */
    public static function buildRateMapping(
        string $ratePlanId,
        int $expediaRoomCode,
        int $expediaRateCode,
        int $occupancy,
        string $pricingType,
        bool $primaryOccupancy = false
    ): array {
        return [
            'rate_plan_id' => $ratePlanId,
            'settings'     => [
                'room_type_code' => $expediaRoomCode,
                'rate_plan_code' => $expediaRateCode,
                'occupancy'      => $occupancy,
                'pricing_type'   => $pricingType,
                'primary_occ'    => $primaryOccupancy,
            ],
        ];
    }
}
