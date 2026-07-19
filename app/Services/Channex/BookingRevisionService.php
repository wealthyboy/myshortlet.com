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

    public function fetch(string $revisionId): ?array
    {
        $paths = [
            '/booking_revisions/' . $revisionId,
            '/booking_revisions/' . $revisionId . '?include=booking',
        ];

        foreach ($paths as $path) {
            try {
                return $this->get($path);
            } catch (\Throwable $e) {
                logger()->warning('Channex booking revision fetch attempt failed', [
                    'revision_id' => $revisionId,
                    'path' => $path,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return null;
    }

    public function acknowledge(string $revisionId): ?array
    {
        $paths = [
            '/booking_revisions/' . $revisionId . '/acknowledge',
            '/booking_revisions/' . $revisionId . '/ack',
        ];

        foreach ($paths as $path) {
            try {
                return $this->post($path, []);
            } catch (\Throwable $e) {
                logger()->warning('Channex booking acknowledge attempt failed', [
                    'revision_id' => $revisionId,
                    'path' => $path,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return null;
    }
}
