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
        try {
            return $this->get('/booking_revisions/' . $revisionId);
        } catch (\Throwable $e) {
            logger()->warning('Channex booking revision fetch failed', [
                'revision_id' => $revisionId,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }

    public function acknowledge(string $revisionId): ?array
    {
        try {
            return $this->post('/booking_revisions/' . $revisionId . '/ack', []);
        } catch (\Throwable $e) {
            logger()->warning('Channex booking acknowledge failed', [
                'revision_id' => $revisionId,
                'error' => $e->getMessage(),
            ]);
        }

        return null;
    }
}
