<?php

namespace App\Jobs;

use App\Models\Property;
use App\Services\Channex\GroupPropertyService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Throwable;

class SyncPropertyToChannex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 120;
    public int $tries = 3;

    protected int $propertyId;

    public function __construct(int $propertyId)
    {
        $this->propertyId = $propertyId;
    }

    public function handle(): void
    {
        $property = Property::with('apartments')->findOrFail($this->propertyId);

        app(GroupPropertyService::class)->sync($property);
        $this->queueApartmentSyncs($property);
    }

    protected function queueApartmentSyncs(Property $property): void
    {
        foreach ($property->apartments as $apartment) {
            SyncApartmentToChannex::dispatch($apartment->id);
        }
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Property Channex sync failed', [
            'property_id' => $this->propertyId,
            'error'       => $exception->getMessage(),
        ]);
    }
}
