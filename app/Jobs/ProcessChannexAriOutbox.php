<?php

namespace App\Jobs;

use App\Models\Apartment;
use App\Models\ChannexAriOutboxEvent;
use App\Exceptions\ChannexRateLimitException;
use App\Services\Channex\AriPushService;
use App\Services\Channex\CertificationLogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUniqueUntilProcessing;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class ProcessChannexAriOutbox implements ShouldQueue, ShouldBeUniqueUntilProcessing
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;
    public int $uniqueFor = 300;

    protected array $processingEventIds = [];

    public function backoff(): array
    {
        return [60, 180, 300];
    }

    public function uniqueId(): string
    {
        return 'process-channex-ari-outbox';
    }

    public function handle(
        AriPushService $ariPushService,
        CertificationLogService $certificationLogService
    ): void
    {
        ChannexAriOutboxEvent::query()
            ->where('status', 'processing')
            ->where('updated_at', '<', now()->subMinutes(10))
            ->update(['status' => 'pending']);

        $events = ChannexAriOutboxEvent::query()
            ->where('status', 'pending')
            ->orderBy('id')
            ->limit(250)
            ->get();

        if ($events->isEmpty()) {
            return;
        }

        $eventIds = $events->pluck('id')->all();
        $this->processingEventIds = $eventIds;

        ChannexAriOutboxEvent::query()
            ->whereIn('id', $eventIds)
            ->update([
                'status' => 'processing',
            ]);

        try {
            $apartments = Apartment::query()
                ->with(['property', 'channexRatePlans'])
                ->whereIn('id', $events->pluck('apartment_id')->filter()->unique()->values())
                ->get()
                ->keyBy('id');

            $availabilityValues = [];
            $restrictionValues = [];

            foreach ($events as $event) {
                $apartment = $apartments->get($event->apartment_id);
                if (! $apartment || ! $apartment->property) {
                    throw new \RuntimeException("ARI event {$event->id} has no valid apartment/property mapping.");
                }

                if (! $apartment->property->channex_property_id || ! $apartment->channex_room_type_id) {
                    throw new \RuntimeException("Apartment {$apartment->id} is not mapped to a Channex property and room type.");
                }

                $payload = (array) ($event->payload ?? []);
                $dateFrom = $payload['date_from'] ?? now()->toDateString();
                $dateTo = $payload['date_to'] ?? $dateFrom;
                if (array_key_exists('availability', $payload)) {
                    $availabilityKey = implode('|', [
                        $apartment->property->channex_property_id,
                        $apartment->channex_room_type_id,
                        $dateFrom,
                        $dateTo,
                    ]);

                    // A later PMS save for the same range supersedes the earlier save.
                    $availabilityValues[$availabilityKey] = [
                        'property_id' => $apartment->property->channex_property_id,
                        'room_type_id' => $apartment->channex_room_type_id,
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                        'availability' => max(0, (int) $payload['availability']),
                    ];
                }

                $restrictionFields = [
                    'rate',
                    'min_stay_arrival',
                    'min_stay_through',
                    'max_stay',
                    'closed_to_arrival',
                    'closed_to_departure',
                    'stop_sell',
                ];
                $hasRestrictionChange = collect($restrictionFields)->contains(function ($field) use ($payload) {
                    return array_key_exists($field, $payload);
                });

                if (! $hasRestrictionChange) {
                    continue;
                }

                $localRatePlanId = $payload['rate_plan_id'] ?? null;
                $ratePlan = $localRatePlanId
                    ? $apartment->channexRatePlans->firstWhere('id', (int) $localRatePlanId)
                    : $apartment->channexRatePlans->firstWhere('is_default', true);
                $channexRatePlanId = $ratePlan?->channex_rate_plan_id
                    ?: $apartment->channex_rate_plan_id;

                if (! $channexRatePlanId) {
                    throw new \RuntimeException("Apartment {$apartment->id} has no Channex rate plan mapping.");
                }

                $restrictionKey = implode('|', [
                    $apartment->property->channex_property_id,
                    $channexRatePlanId,
                    $dateFrom,
                    $dateTo,
                ]);

                $restrictionValue = [
                        'property_id' => $apartment->property->channex_property_id,
                        'rate_plan_id' => $channexRatePlanId,
                        'date_from' => $dateFrom,
                        'date_to' => $dateTo,
                ];

                foreach ($restrictionFields as $field) {
                    if (! array_key_exists($field, $payload)) {
                        continue;
                    }

                    if ($field === 'rate') {
                        $restrictionValue[$field] = (int) round(((float) $payload[$field]) * 100);
                    } elseif (in_array($field, ['closed_to_arrival', 'closed_to_departure', 'stop_sell'], true)) {
                        $restrictionValue[$field] = (bool) $payload[$field];
                    } else {
                        $restrictionValue[$field] = max(0, (int) $payload[$field]);
                    }
                }

                $restrictionValues[$restrictionKey] = $restrictionValue;
            }

            $availabilityValues = array_values($availabilityValues);
            $restrictionValues = array_values($restrictionValues);

            $availabilityResponse = [];
            $restrictionsResponse = [];

            if (! empty($availabilityValues)) {
                $availabilityResponse = $ariPushService->pushAvailability($availabilityValues);
            }

            if (! empty($restrictionValues)) {
                $restrictionsResponse = $ariPushService->pushRestrictions($restrictionValues);
            }

            $propertyIds = $events->pluck('property_id')->filter()->unique()->values();
            $primaryPropertyId = $propertyIds->isNotEmpty() ? (int) $propertyIds->first() : null;

            $taskIds = array_merge(
                $this->extractTaskIds($availabilityResponse),
                $this->extractTaskIds($restrictionsResponse)
            );

            $certificationLogService->log(
                'ari_outbox',
                'success',
                null,
                $primaryPropertyId,
                null,
                $taskIds,
                [
                    'event_ids' => $eventIds,
                    'availability_count' => count($availabilityValues),
                    'restrictions_count' => count($restrictionValues),
                    'availability_values' => $availabilityValues,
                    'restriction_values' => $restrictionValues,
                ],
                [
                    'availability' => $availabilityResponse,
                    'restrictions' => $restrictionsResponse,
                ]
            );

            ChannexAriOutboxEvent::query()
                ->whereIn('id', $eventIds)
                ->update([
                    'status' => 'sent',
                    'processed_at' => Carbon::now(),
                    'last_error' => null,
                ]);
        } catch (\Throwable $e) {
            $attempts = (int) $events->max('attempts') + 1;
            $willRetry = $attempts < $this->tries;

            ChannexAriOutboxEvent::query()
                ->whereIn('id', $eventIds)
                ->update([
                    'status' => $willRetry ? 'pending' : 'failed',
                    'attempts' => \DB::raw('attempts + 1'),
                    'last_error' => $e->getMessage(),
                ]);

            $propertyIds = $events->pluck('property_id')->filter()->unique()->values();
            $primaryPropertyId = $propertyIds->isNotEmpty() ? (int) $propertyIds->first() : null;

            $certificationLogService->log(
                'ari_outbox',
                'failed',
                null,
                $primaryPropertyId,
                null,
                [],
                [
                    'event_ids' => $eventIds,
                ],
                null,
                $e->getMessage()
            );

            if ($e instanceof ChannexRateLimitException && $willRetry) {
                $this->release($e->retryAfter());
                return;
            }

            throw $e;
        }
    }

    public function failed(\Throwable $exception): void
    {
        if (empty($this->processingEventIds)) {
            return;
        }

        ChannexAriOutboxEvent::query()
            ->whereIn('id', $this->processingEventIds)
            ->whereIn('status', ['pending', 'processing'])
            ->update([
                'status' => 'failed',
                'last_error' => $exception->getMessage(),
            ]);
    }

    protected function extractTaskIds(array $response): array
    {
        $data = $response['data'] ?? [];

        if (! is_array($data)) {
            return [];
        }

        return collect($data)
            ->pluck('id')
            ->filter()
            ->values()
            ->all();
    }

}
