<?php

namespace App\Services\Channex;

use App\Models\Apartment;
use App\Models\ChannexAriOutboxEvent;
use App\Models\ChannexRatePlan;

class AriOutboxService
{
    public function queueApartmentChange(
        Apartment $apartment,
        array $payload = [],
        ?string $scenario = null
    ): ChannexAriOutboxEvent
    {
        return ChannexAriOutboxEvent::create([
            'property_id' => $apartment->property_id,
            'apartment_id' => $apartment->id,
            'event_type' => 'apartment_updated',
            'scenario' => $scenario,
            'payload' => $payload,
            'status' => 'pending',
        ]);
    }

    public function queueBaseAriChange(
        Apartment $apartment,
        array $changedFields = ['price', 'quantity', 'allow'],
        int $days = 500
    ): ?ChannexAriOutboxEvent {
        $payload = [
            'date_from' => now()->toDateString(),
            'date_to' => now()->addDays(max(1, $days) - 1)->toDateString(),
        ];

        if (in_array('price', $changedFields, true)) {
            $payload['rate'] = (float) $apartment->price;
            $defaultPlan = $apartment->channexRatePlans()
                ->where('is_active', true)
                ->orderByDesc('is_default')
                ->oldest('id')
                ->first();

            if ($defaultPlan) {
                $payload['rate_plan_id'] = $defaultPlan->id;
            }
        }

        if (array_intersect(['quantity', 'allow'], $changedFields)) {
            $payload['availability'] = (int) ($apartment->allow ? ($apartment->quantity ?: 1) : 0);
            $payload['stop_sell'] = ! (bool) $apartment->allow;
        }

        if (count($payload) === 2) {
            return null;
        }

        return $this->queueApartmentChange($apartment, $payload);
    }

    public function queueRatePlanChange(
        Apartment $apartment,
        ChannexRatePlan $ratePlan,
        int $days = 500
    ): ChannexAriOutboxEvent {
        return $this->queueApartmentChange($apartment, [
            'date_from' => now()->toDateString(),
            'date_to' => now()->addDays(max(1, $days) - 1)->toDateString(),
            'rate_plan_id' => $ratePlan->id,
            'rate' => (float) $ratePlan->default_rate,
        ]);
    }
}
