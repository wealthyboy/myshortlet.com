<?php

namespace App\Services\Channex;

use App\Models\Property;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class FullSyncService
{
    protected AriPushService $ariPushService;

    public function __construct(AriPushService $ariPushService)
    {
        $this->ariPushService = $ariPushService;
    }

    public function syncProperty(Property $property, int $days = 500): array
    {
        if (! $property->channex_property_id) {
            throw new \RuntimeException("Property {$property->id} has no Channex property mapping.");
        }

        $property->load('apartments.channexRatePlans');
        $dateFrom = now()->startOfDay();
        $dateTo = now()->addDays(max(1, $days) - 1)->startOfDay();
        $availabilityValues = [];
        $restrictionValues = [];

        foreach ($property->apartments as $apartment) {
            if (! $apartment->channex_room_type_id) {
                continue;
            }

            $ratePlans = $apartment->channexRatePlans
                ->where('is_active', true)
                ->filter(fn ($plan) => ! empty($plan->channex_rate_plan_id))
                ->values();

            if ($ratePlans->isEmpty() && $apartment->channex_rate_plan_id) {
                $ratePlans = collect([(object) [
                    'id' => null,
                    'channex_rate_plan_id' => $apartment->channex_rate_plan_id,
                    'default_rate' => $apartment->price,
                ]]);
            }

            if ($ratePlans->isEmpty()) {
                continue;
            }

            $dailyRates = $apartment->dailyRates()
                ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
                ->get()
                ->keyBy(function ($rate) {
                    return ($rate->channex_rate_plan_id ?: 'room') . '|' . $rate->date->toDateString();
                });

            $reservations = $apartment->reservations()
                ->with('user_reservation')
                ->where('checkin', '<=', $dateTo->copy()->endOfDay())
                ->where('checkout', '>', $dateFrom)
                ->get()
                ->filter(function ($reservation) {
                    $header = $reservation->user_reservation;
                    if (! $header) {
                        return false;
                    }

                    return ! (bool) $header->is_cancelled
                        && ! in_array(strtolower((string) $header->status), ['cancelled', 'canceled'], true);
                });

            $availabilityStates = [];

            foreach (CarbonPeriod::create($dateFrom, $dateTo) as $date) {
                $dateString = $date->toDateString();
                $daily = $dailyRates->get('room|' . $dateString);
                $baseCapacity = $daily && $daily->availability !== null
                    ? (int) $daily->availability
                    : max(1, (int) ($apartment->quantity ?? 1));

                $reserved = (int) $reservations
                    ->filter(function ($reservation) use ($date) {
                        return Carbon::parse($reservation->checkin)->startOfDay()->lte($date)
                            && Carbon::parse($reservation->checkout)->startOfDay()->gt($date);
                    })
                    ->sum('quantity');

                $availabilityStates[$dateString] = [
                    'availability' => (bool) $apartment->allow
                        ? max(0, $baseCapacity - $reserved)
                        : 0,
                ];

            }

            $availabilityValues = array_merge(
                $availabilityValues,
                $this->compressStates($availabilityStates, [
                    'property_id' => $property->channex_property_id,
                    'room_type_id' => $apartment->channex_room_type_id,
                ])
            );

            foreach ($ratePlans as $ratePlan) {
                $restrictionStates = [];

                foreach (CarbonPeriod::create($dateFrom, $dateTo) as $date) {
                    $dateString = $date->toDateString();
                    $daily = $dailyRates->get(($ratePlan->id ?: 'room') . '|' . $dateString);
                    $roomDaily = $dailyRates->get('room|' . $dateString);

                    $state = [
                        'rate' => (int) round(((float) ($daily->price ?? $ratePlan->default_rate ?? $apartment->price)) * 100),
                        'min_stay_arrival' => (int) ($daily->min_stay_arrival ?? $roomDaily->min_stay_arrival ?? 1),
                        'min_stay_through' => (int) ($daily->min_stay_through ?? $roomDaily->min_stay_through ?? 1),
                        'max_stay' => (int) ($daily->max_stay ?? $roomDaily->max_stay ?? 0),
                        'closed_to_arrival' => (bool) ($daily->closed_to_arrival ?? $roomDaily->closed_to_arrival ?? false),
                        'closed_to_departure' => (bool) ($daily->closed_to_departure ?? $roomDaily->closed_to_departure ?? false),
                        'stop_sell' => $daily && $daily->stop_sell !== null
                            ? (bool) $daily->stop_sell
                            : ($roomDaily && $roomDaily->stop_sell !== null
                                ? (bool) $roomDaily->stop_sell
                                : ! (bool) $apartment->allow),
                    ];

                    $restrictionStates[$dateString] = $state;
                }

                $restrictionValues = array_merge(
                    $restrictionValues,
                    $this->compressStates($restrictionStates, [
                        'property_id' => $property->channex_property_id,
                        'rate_plan_id' => $ratePlan->channex_rate_plan_id,
                    ])
                );
            }
        }

        return [
            'availability' => empty($availabilityValues)
                ? []
                : $this->ariPushService->pushAvailability($availabilityValues),
            'restrictions' => empty($restrictionValues)
                ? []
                : $this->ariPushService->pushRestrictions($restrictionValues),
        ];
    }

    protected function compressStates(array $states, array $identifiers): array
    {
        $ranges = [];

        foreach ($states as $date => $state) {
            $lastIndex = count($ranges) - 1;
            if ($lastIndex >= 0
                && $ranges[$lastIndex]['state'] === $state
                && Carbon::parse($ranges[$lastIndex]['date_to'])->addDay()->toDateString() === $date) {
                $ranges[$lastIndex]['date_to'] = $date;
                continue;
            }

            $ranges[] = [
                'date_from' => $date,
                'date_to' => $date,
                'state' => $state,
            ];
        }

        return array_map(function ($range) use ($identifiers) {
            return array_merge(
                $identifiers,
                [
                    'date_from' => $range['date_from'],
                    'date_to' => $range['date_to'],
                ],
                $range['state']
            );
        }, $ranges);
    }
}
