<?php

namespace App\Jobs;

use App\Models\Property;
use App\Services\Channex\CertificationLogService;
use App\Services\Channex\FullSyncService;
use App\Support\ChannexTaskIds;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class RunChannexFullSync implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 240;
    public int $tries = 3;

    public function backoff(): array
    {
        return [60, 180];
    }

    protected int $propertyId;
    protected int $days;

    public function __construct(int $propertyId, int $days = 500)
    {
        $this->propertyId = $propertyId;
        $this->days = $days;
    }

    public function handle(
        FullSyncService $fullSyncService,
        CertificationLogService $certificationLogService
    ): void
    {
        $property = Property::with('apartments')->findOrFail($this->propertyId);

        $result = $fullSyncService->syncProperty($property, $this->days);

        logger()->info('Channex full sync completed', [
            'property_id' => $this->propertyId,
            'days' => $this->days,
            'availability_task_ids' => $this->extractTaskIds($result['availability'] ?? []),
            'restrictions_task_ids' => $this->extractTaskIds($result['restrictions'] ?? []),
        ]);

        $taskIds = array_merge(
            $this->extractTaskIds($result['availability'] ?? []),
            $this->extractTaskIds($result['restrictions'] ?? [])
        );

        $certificationLogService->log(
            'full_sync',
            'success',
            'test_1_full_sync',
            (int) $property->id,
            null,
            $taskIds,
            [
                'days' => $this->days,
                'property_channex_id' => $property->channex_property_id,
            ],
            $result
        );
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Channex full sync failed', [
            'property_id' => $this->propertyId,
            'days' => $this->days,
            'error' => $exception->getMessage(),
        ]);

        app(CertificationLogService::class)->log(
            'full_sync',
            'failed',
            'test_1_full_sync',
            $this->propertyId,
            null,
            [],
            [
                'days' => $this->days,
            ],
            null,
            $exception->getMessage()
        );
    }

    protected function extractTaskIds(array $response): array
    {
        return ChannexTaskIds::extract($response);
    }
}
