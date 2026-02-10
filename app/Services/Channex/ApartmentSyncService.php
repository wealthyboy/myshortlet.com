<?php

namespace App\Services\Channex;

use App\Models\Apartment;

class ApartmentSyncService
{
    public function sync(Apartment $apartment): void
    {
        $property = $apartment->property;

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

        // 6️⃣ Push Availability
        app(AvailabilityService::class)->sync($apartment);

        // 7️⃣ Push Prices
        app(PricingService::class)->sync($apartment);
    }
}
