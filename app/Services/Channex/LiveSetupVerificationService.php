<?php

namespace App\Services\Channex;

use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;

class LiveSetupVerificationService
{
    public function verify(Property $property, bool $checkRemote = true): array
    {
        $property->load(['apartments.channexRatePlans']);

        $checks = [];
        $this->check($checks, filled(config('services.channex.base_url')), 'Channex API URL is configured.', 'Channex API URL is missing.');
        $this->check($checks, filled(config('services.channex.key')), 'Channex API credentials are configured.', 'Channex API credentials are missing.');
        $this->check($checks, filled(config('services.channex.webhook_secret')), 'Webhook secret is configured.', 'Webhook secret is missing.');
        $this->check(
            $checks,
            config('services.channex.webhook_secret_header') === 'X-Channex-Webhook-Secret',
            'Webhook authentication header is correct.',
            'Webhook header must be X-Channex-Webhook-Secret.'
        );
        $this->check($checks, ! (bool) $property->allow, 'Test property is hidden from the public website.', 'Test property is currently visible on the public website.');

        if (Schema::hasColumn('properties', 'featured')) {
            $this->check($checks, ! (bool) $property->featured, 'Test property is not featured.', 'Test property is still featured.');
        }

        $this->check($checks, $this->isUuid($property->channex_property_id), 'Property has a valid Channex UUID.', 'Property Channex UUID is missing or invalid.');
        $this->check($checks, $this->isUuid($property->channex_group_id), 'Property has a valid Channex group UUID.', 'Property Channex group UUID is missing or invalid.');
        $this->check($checks, (bool) $property->channex_synced, 'Property is marked as synced.', 'Property is not marked as synced.');

        $rooms = $property->apartments->sortBy('name')->values();
        $this->check($checks, $rooms->isNotEmpty(), $rooms->count() . ' room type(s) found.', 'No room types were found under this property.');

        foreach ($rooms as $room) {
            $prefix = $room->name . ': ';
            $this->check($checks, (bool) $room->allow, $prefix . 'active for inventory sync.', $prefix . 'Allow is OFF, so availability may be sent as zero.');
            $this->check($checks, $this->isUuid($room->channex_room_type_id), $prefix . 'room UUID is valid.', $prefix . 'room UUID is missing or invalid.');
            $this->check($checks, (bool) $room->channex_synced, $prefix . 'marked as synced.', $prefix . 'not marked as synced.');

            $plans = $room->channexRatePlans->where('is_active', true);
            $this->check($checks, $plans->isNotEmpty(), $prefix . $plans->count() . ' active rate plan(s) found.', $prefix . 'has no active rate plans.');

            foreach ($plans as $plan) {
                $this->check(
                    $checks,
                    $this->isUuid($plan->channex_rate_plan_id),
                    $prefix . $plan->name . ' UUID is valid.',
                    $prefix . $plan->name . ' UUID is missing or invalid.'
                );
            }
        }

        $queue = $this->queueStatus($checks);
        $remote = [];

        if ($checkRemote) {
            $remote = $this->remoteStatus($property, $rooms, $checks);
        }

        $failures = collect($checks)->where('status', 'fail')->count();
        $warnings = collect($checks)->where('status', 'warning')->count();

        return [
            'ready' => $failures === 0,
            'failures' => $failures,
            'warnings' => $warnings,
            'checks' => $checks,
            'rooms' => $rooms,
            'queue' => $queue,
            'remote' => $remote,
            'email' => $this->buildEmail($property, $rooms),
            'checked_at' => now(),
        ];
    }

    protected function queueStatus(array &$checks): array
    {
        $connection = config('queue.default');
        $this->check($checks, $connection !== 'sync', 'Queue connection is ' . $connection . '.', 'Queue connection is sync; use a persistent live queue.');

        $pending = null;
        $failed = null;

        if ($connection === 'database' && Schema::hasTable('jobs')) {
            $pending = DB::table('jobs')->count();
            if ($pending > 0) {
                $this->warning($checks, $pending . ' queued job(s) are waiting. Confirm the worker is running.');
            }
        }

        if (Schema::hasTable('failed_jobs')) {
            $failed = DB::table('failed_jobs')->count();
            if ($failed > 0) {
                $this->warning($checks, $failed . ' failed queue job(s) exist and should be reviewed.');
            }
        }

        return compact('connection', 'pending', 'failed');
    }

    protected function remoteStatus(Property $property, $rooms, array &$checks): array
    {
        if (! filled(config('services.channex.base_url')) || ! filled(config('services.channex.key'))) {
            return [];
        }

        $entities = [];

        if ($this->isUuid($property->channex_property_id)) {
            $entities[] = ['type' => 'Property', 'name' => $property->name, 'uuid' => $property->channex_property_id, 'uri' => '/properties/' . $property->channex_property_id];
        }

        foreach ($rooms as $room) {
            if ($this->isUuid($room->channex_room_type_id)) {
                $entities[] = ['type' => 'Room type', 'name' => $room->name, 'uuid' => $room->channex_room_type_id, 'uri' => '/room_types/' . $room->channex_room_type_id];
            }

            foreach ($room->channexRatePlans->where('is_active', true) as $plan) {
                if ($this->isUuid($plan->channex_rate_plan_id)) {
                    $entities[] = ['type' => 'Rate plan', 'name' => $room->name . ' — ' . $plan->name, 'uuid' => $plan->channex_rate_plan_id, 'uri' => '/rate_plans/' . $plan->channex_rate_plan_id];
                }
            }
        }

        return collect($entities)->map(function ($entity) use (&$checks) {
            try {
                $response = Http::withHeaders([
                    'user-api-key' => config('services.channex.key'),
                    'Accept' => 'application/json',
                ])->timeout(20)->get(rtrim(config('services.channex.base_url'), '/') . $entity['uri']);

                $entity['http_status'] = $response->status();
                $entity['exists'] = $response->successful() && filled(data_get($response->json(), 'data.id'));
                $this->check(
                    $checks,
                    $entity['exists'],
                    'Remote ' . strtolower($entity['type']) . ' exists: ' . $entity['name'] . '.',
                    'Remote ' . strtolower($entity['type']) . ' could not be confirmed: ' . $entity['name'] . ' (HTTP ' . $response->status() . ').'
                );
            } catch (\Throwable $exception) {
                $entity['exists'] = false;
                $entity['http_status'] = null;
                $entity['error'] = 'Connection failed';
                $this->check($checks, false, '', 'Remote check failed for ' . $entity['name'] . '.');
            }

            unset($entity['uri']);
            return $entity;
        })->all();
    }

    protected function buildEmail(Property $property, $rooms): string
    {
        $lines = [
            'Subject: Channex live test property details and test video',
            '',
            'Dear Channex Team,',
            '',
            'Thank you. I have completed the requested live test setup and recorded the test video.',
            '',
            'Property: ' . $property->name,
            'Local Property ID: ' . $property->id,
            'Channex Property UUID: ' . ($property->channex_property_id ?: 'Not mapped'),
            'Channex Group UUID: ' . ($property->channex_group_id ?: 'Not mapped'),
            '',
            'Mapped room types and rate plans:',
        ];

        foreach ($rooms as $room) {
            $lines[] = '- ' . $room->name . ' — Room Type UUID: ' . ($room->channex_room_type_id ?: 'Not mapped');
            foreach ($room->channexRatePlans->where('is_active', true) as $plan) {
                $lines[] = '  - ' . $plan->name . ' (' . number_format((float) $plan->default_rate, 2) . ' USD) — Rate Plan UUID: ' . ($plan->channex_rate_plan_id ?: 'Not mapped');
            }
        }

        return implode("\n", array_merge($lines, [
            '',
            'The test property is hidden from the public website while remaining active for Channex integration testing.',
            '',
            'Video: [PASTE VIDEO LINK HERE]',
            '',
            'Kind regards,',
            'Jacob Atam',
            'Avenue Montaigne',
        ]));
    }

    protected function check(array &$checks, bool $condition, string $success, string $failure): void
    {
        $checks[] = ['status' => $condition ? 'pass' : 'fail', 'message' => $condition ? $success : $failure];
    }

    protected function warning(array &$checks, string $message): void
    {
        $checks[] = ['status' => 'warning', 'message' => $message];
    }

    protected function isUuid($value): bool
    {
        return is_string($value)
            && preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[1-5][0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}$/i', $value) === 1;
    }
}
