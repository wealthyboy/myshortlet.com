<?php

namespace App\Services\Channex;

class BookingRevisionService extends ChannexClient
{
    public function fetchFeed(?string $propertyId = null): ?array
    {
        $params = [
            'order' => [
                'inserted_at' => 'asc',
            ],
            // Channex defaults collection responses to 10 rows. Request a
            // larger single page so one property trigger can drain a normal
            // booking backlog without making another feed request.
            'pagination[limit]' => 100,
        ];

        if (! empty($propertyId)) {
            $params['filter'] = [
                'property_id' => $propertyId,
            ];
        }

        try {
            return $this->get('/booking_revisions/feed', $params);
        } catch (\Throwable $e) {
            logger()->warning('Channex booking revisions feed fetch failed', [
                'property_id' => $propertyId,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    public function acknowledge(string $revisionId): ?array
    {
        try {
            $url = rtrim((string) config('services.channex.base_url'), '/')
                . '/booking_revisions/' . $revisionId . '/ack';
            $response = $this->client()->post($url, []);

            if ($response->status() !== 200) {
                logger()->warning('Channex booking acknowledge failed', [
                    'revision_id' => $revisionId,
                    'status' => $response->status(),
                ]);

                return null;
            }

            // Channex defines acknowledgement success by HTTP 200 and may
            // return an empty response body.
            return [
                'acknowledged' => true,
                'http_status' => $response->status(),
            ];
        } catch (\Throwable $e) {
            logger()->warning('Channex booking acknowledge failed', [
                'revision_id' => $revisionId,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }
}
