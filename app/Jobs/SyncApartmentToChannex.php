<?php

namespace App\Jobs;

use App\Models\Apartment;
use App\Services\Channex\ApartmentSyncService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldBeUnique;

use Throwable;

class SyncApartmentToChannex implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    protected int $apartmentId;
    public int $tries = 3;

    public function backoff(): array
    {
        return [60, 180];
    }

    public function __construct(int $apartmentId)
    {
        $this->apartmentId = $apartmentId;
    }

    public function uniqueId(): string
    {
        return 'apartment-' . $this->apartmentId;
    }

    public function handle(): void
    {
        $apartment = Apartment::with([
            'property',
            'images',
            'attributes',
            'apartmentfacilities',
            'channexRatePlans',
        ])->find($this->apartmentId);

        if (! $apartment) {
            return;
        }

        app(ApartmentSyncService::class)->sync($apartment);

        // ARI events can only be processed after the property, room type and
        // rate plans have received their Channex IDs.
        ProcessChannexAriOutbox::dispatch()->delay(now()->addSeconds(5));
    }

    public function failed(Throwable $exception): void
    {
        logger()->error('Apartment Channex sync failed', [
            'apartment_id' => $this->apartmentId,
            'error' => $exception->getMessage(),
        ]);
    }
}
