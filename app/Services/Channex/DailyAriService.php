<?php

namespace App\Services\Channex;

use App\Models\Apartment;
use App\Models\ApartmentDailyRate;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DailyAriService
{
    protected array $fields = [
        'rate',
        'availability',
        'min_stay_arrival',
        'min_stay_through',
        'max_stay',
        'closed_to_arrival',
        'closed_to_departure',
        'stop_sell',
    ];

    public function storeRange(Apartment $apartment, string $dateFrom, string $dateTo, array $changes): void
    {
        $updates = [];

        foreach ($this->fields as $field) {
            if (! array_key_exists($field, $changes) || $changes[$field] === '' || $changes[$field] === null) {
                continue;
            }

            $databaseField = $field === 'rate' ? 'price' : $field;
            $updates[$databaseField] = $changes[$field];
        }

        if (empty($updates)) {
            return;
        }

        foreach (CarbonPeriod::create(Carbon::parse($dateFrom), Carbon::parse($dateTo)) as $date) {
            $ratePlanId = isset($changes['rate_plan_id'])
                ? (int) $changes['rate_plan_id']
                : null;
            $dailyRate = ApartmentDailyRate::firstOrNew([
                'apartment_id' => $apartment->id,
                'channex_rate_plan_id' => $ratePlanId,
                'date' => $date->toDateString(),
            ]);

            // The legacy schema requires price even for availability-only rows.
            if (! $dailyRate->exists) {
                $defaultRate = $ratePlanId
                    ? optional($apartment->channexRatePlans()->find($ratePlanId))->default_rate
                    : null;
                $dailyRate->price = $updates['price'] ?? $defaultRate ?? $apartment->price;
            }

            $dailyRate->fill($updates);
            $dailyRate->save();
        }
    }
}
