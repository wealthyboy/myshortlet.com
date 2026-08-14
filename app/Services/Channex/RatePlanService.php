<?php

namespace App\Services\Channex;

use App\Models\Apartment;
use App\Models\ChannexRatePlan;
use Illuminate\Http\Client\RequestException;

class RatePlanService extends ChannexClient
{
    public function sync(Apartment $apartment): void
    {
        $plans = $apartment->channexRatePlans()->where('is_active', true)->get();

        if ($plans->isEmpty()) {
            $plans = collect([
                $apartment->channexRatePlans()->create([
                    'name' => 'Best Available Rate',
                    'default_rate' => $apartment->price,
                    'meal_type' => 'room_only',
                    'price_mode' => 'nightly',
                    'is_default' => true,
                    'is_active' => true,
                ]),
            ]);
        }

        foreach ($plans as $plan) {
            $this->syncPlan($apartment, $plan);
        }

        $defaultPlan = $apartment->channexRatePlans()
            ->where('is_active', true)
            ->orderByDesc('is_default')
            ->oldest('id')
            ->first();

        if ($defaultPlan && $defaultPlan->channex_rate_plan_id) {
            $apartment->updateQuietly([
                'channex_rate_plan_id' => $defaultPlan->channex_rate_plan_id,
            ]);
        }
    }

    protected function syncPlan(Apartment $apartment, ChannexRatePlan $plan): void
    {
        $title = $this->apiTitle($apartment, $plan);
        $payload = [
            'rate_plan' => [
                'title' => $title,
                'property_id' => $apartment->property->channex_property_id,
                'room_type_id' => $apartment->channex_room_type_id,
                'sell_mode' => 'per_room',
                'rate_mode' => 'manual',
                'meal_type' => $plan->meal_type ?: 'room_only',
                'options' => [[
                    'occupancy' => max(1, (int) ($apartment->max_adults ?: 2)),
                    'is_primary' => true,
                ]],
                'currency' => 'USD',
            ],
        ];

        if ($plan->channex_rate_plan_id) {
            try {
                $this->put('/rate_plans/' . $plan->channex_rate_plan_id, $payload);
                return;
            } catch (RequestException $exception) {
                if ($exception->response?->status() !== 404) {
                    throw $exception;
                }

                $plan->update(['channex_rate_plan_id' => null]);
            }
        }

        try {
            $response = $this->post('/rate_plans', $payload);
            $ratePlanId = data_get($response, 'data.id') ?: data_get($response, 'data.attributes.id');
        } catch (RequestException $exception) {
            if ($exception->response?->status() !== 422) {
                throw $exception;
            }

            $ratePlanId = $this->findExistingRatePlanId($apartment->channex_room_type_id, $title);
            if (! $ratePlanId) {
                throw $exception;
            }
        }

        if (! $ratePlanId) {
            throw new \RuntimeException("Channex did not return an ID for rate plan {$title}.");
        }

        $plan->update(['channex_rate_plan_id' => $ratePlanId]);
    }

    protected function apiTitle(Apartment $apartment, ChannexRatePlan $plan): string
    {
        // Channex requires rate-plan titles to be unique within a property.
        return mb_substr($apartment->name . ' - ' . $plan->name, 0, 255);
    }

    protected function findExistingRatePlanId(string $roomTypeId, string $title): ?string
    {
        $response = $this->get('/rate_plans', [
            'filter[room_type_id]' => $roomTypeId,
            'pagination[limit]' => 100,
        ]);

        foreach (($response['data'] ?? []) as $plan) {
            if (data_get($plan, 'attributes.title') === $title) {
                return $plan['id'] ?? data_get($plan, 'attributes.id');
            }
        }

        return null;
    }
}
