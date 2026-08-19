<?php

namespace App\Jobs;

use App\Models\Apartment;
use App\Models\ChannexAriOutboxEvent;
use App\Exceptions\ChannexRateLimitException;
use App\Services\Channex\AriPushService;
use App\Services\Channex\ApartmentSyncService;
use App\Services\Channex\CertificationLogService;
use App\Services\Channex\GroupPropertyService;
use App\Support\ChannexTaskIds;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProcessChannexAriOutbox implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 20;
    public int $uniqueFor = 300;

    protected array $processingEventIds = [];
    protected int $maxDeliveryAttempts = 3;

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

        $events = DB::transaction(function () {
            $events = ChannexAriOutboxEvent::query()
                ->where('status', 'pending')
                ->orderBy('id')
                ->limit(250)
                ->lockForUpdate()
                ->get();

            if ($events->isNotEmpty()) {
                ChannexAriOutboxEvent::query()
                    ->whereIn('id', $events->pluck('id'))
                    ->where('status', 'pending')
                    ->update(['status' => 'processing']);
            }

            return $events;
        });

        if ($events->isEmpty()) {
            return;
        }

        $eventIds = $events->pluck('id')->all();
        $this->processingEventIds = $eventIds;
        $scenarios = $events->pluck('scenario')->filter()->unique()->values();
        $scenario = $scenarios->count() === 1
            ? (string) $scenarios->first()
            : ($scenarios->count() > 1 ? 'mixed_ari_batch' : null);

        try {
            $apartments = Apartment::query()
                ->with(['property', 'channexRatePlans'])
                ->whereIn('id', $events->pluck('apartment_id')->filter()->unique()->values())
                ->get()
                ->keyBy('id');

            $this->repairDeletedMappings($apartments);
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

                if ($localRatePlanId && (! $ratePlan || ! $ratePlan->channex_rate_plan_id)) {
                    throw new \RuntimeException(
                        "Selected local rate plan {$localRatePlanId} is not mapped to Channex."
                    );
                }

                $channexRatePlanId = $ratePlan?->channex_rate_plan_id;
                if (! $localRatePlanId && ! $channexRatePlanId) {
                    $channexRatePlanId = $apartment->channex_rate_plan_id;
                }

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
            $availabilityTaskIds = $this->extractTaskIds($availabilityResponse);
            $restrictionTaskIds = $this->extractTaskIds($restrictionsResponse);

            if ((! empty($availabilityValues) && empty($availabilityTaskIds))
                || (! empty($restrictionValues) && empty($restrictionTaskIds))) {
                throw new \RuntimeException('Channex accepted an ARI update without returning every required task ID.');
            }

            $taskIds = array_merge($availabilityTaskIds, $restrictionTaskIds);

            $certificationLogService->log(
                'ari_outbox',
                'success',
                $scenario,
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
            if ($e instanceof ChannexRateLimitException) {
                ChannexAriOutboxEvent::query()
                    ->whereIn('id', $eventIds)
                    ->update([
                        'status' => 'pending',
                        'last_error' => $e->getMessage(),
                    ]);

                // A local throttle is a deferral, not a failed Channex delivery.
                // Do not consume the event's three real delivery attempts.
                $this->processingEventIds = [];
                $this->release($e->retryAfter());
                return;
            }

            $attempts = (int) $events->max('attempts') + 1;
            $willRetry = $attempts < $this->maxDeliveryAttempts;

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
                $scenario,
                $primaryPropertyId,
                null,
                [],
                [
                    'event_ids' => $eventIds,
                ],
                [
                    'availability' => $availabilityResponse ?? [],
                    'restrictions' => $restrictionsResponse ?? [],
                ],
                $e->getMessage()
            );

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
        return ChannexTaskIds::extract($response);
    }

    protected function repairDeletedMappings($apartments): void
    {
        foreach ($apartments->pluck('property')->filter()->unique('id') as $property) {
            $oldPropertyId = $property->channex_property_id;
            app(GroupPropertyService::class)->sync($property);

            if ($oldPropertyId === $property->channex_property_id) {
                continue;
            }

            foreach ($apartments->where('property_id', $property->id) as $apartment) {
                $apartment->setRelation('property', $property);
                app(ApartmentSyncService::class)->sync($apartment);
            }
        }
    }

}
