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

        // Availability belongs to the room type, not to an individual rate
        // plan. Persist it on the plan-null row so later full syncs read the
        // same room capacity even when the UI submission also changes a rate.
        $availabilityUpdates = array_key_exists('availability', $updates)
            ? ['availability' => $updates['availability']]
            : [];
        $ratePlanUpdates = $updates;
        unset($ratePlanUpdates['availability']);

        $ratePlanId = isset($changes['rate_plan_id'])
            ? (int) $changes['rate_plan_id']
            : null;

        foreach (CarbonPeriod::create(Carbon::parse($dateFrom), Carbon::parse($dateTo)) as $date) {
            if (! empty($availabilityUpdates)) {
                $this->persistDailyRow($apartment, $date->toDateString(), null, $availabilityUpdates);
            }

            if (! empty($ratePlanUpdates)) {
                $this->persistDailyRow(
                    $apartment,
                    $date->toDateString(),
                    $ratePlanId,
                    $ratePlanUpdates
                );
            }
        }
    }

    protected function persistDailyRow(
        Apartment $apartment,
        string $date,
        ?int $ratePlanId,
        array $updates
    ): void {
        $dailyRate = ApartmentDailyRate::firstOrNew([
            'apartment_id' => $apartment->id,
            'channex_rate_plan_id' => $ratePlanId,
            'date' => $date,
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
