<?php

namespace App\Services\Channex;

use App\Models\Apartment;
use RuntimeException;

class ApartmentSyncService
{
    public function resetMappings(Apartment $apartment): void
    {
        $apartment->forceFill([
            'channex_room_type_id' => null,
            'channex_rate_plan_id' => null,
            'channex_synced' => false,
        ])->saveQuietly();

        $apartment->channexRatePlans()->update([
            'channex_rate_plan_id' => null,
        ]);
    }

    public function sync(Apartment $apartment): void
    {
        $property = $apartment->property;

        if (! $property) {
            throw new RuntimeException('Apartment must belong to a property before syncing to Channex.');
        }

        // 1️⃣ Ensure Group + Property exist
        app(GroupPropertyService::class)->sync($property);

        // 2️⃣ Ensure Room Type exists
        app(RoomTypeService::class)->sync($apartment);

        // 3️⃣ Sync Room Type Photos (NEW – correct place)
        //app(RoomTypePhotoService::class)->sync($apartment);

        // 4️⃣ Sync Facilities (optional but recommended before rates)
        //app(FacilityService::class)->sync($apartment);

        // 5️⃣ Ensure Rate Plans exist
        app(RatePlanService::class)->sync($apartment);

        // ARI is intentionally not pushed here. Apartment create/update actions
        // write ARI events to the outbox so they are batched and rate limited.
    }
}
