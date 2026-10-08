<?php

namespace App\Services\ChannexPro;

use App\Models\Property;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use RuntimeException;

class AriExportService
{
    public function export(Property $property, Carbon $dateFrom, Carbon $dateTo): array
    {
        $property->load([
            'apartments' => function ($query) {
                $query->orderBy('id');
            },
            'apartments.channexRatePlans',
        ]);

        $availabilityValues = [];
        $restrictionValues = [];

        foreach ($property->apartments as $apartment) {
            $dailyRates = $apartment->dailyRates()
                ->whereBetween('date', [$dateFrom->toDateString(), $dateTo->toDateString()])
                ->get()
                ->keyBy(function ($rate) {
                    return ($rate->channex_rate_plan_id ?: 'room') . '|' . $rate->date->toDateString();
                });

            $reservations = $apartment->reservations()
                ->with('user_reservation')
                ->where('checkin', '<=', $dateTo->copy()->endOfDay())
                ->where('checkout', '>', $dateFrom->copy()->startOfDay())
                ->get()
                ->filter(function ($reservation) {
                    $header = $reservation->user_reservation;

                    if (! $header) {
                        return false;
                    }

                    return ! (bool) ($header->is_cancelled ?? false)
                        && ! in_array(strtolower((string) $header->status), ['cancelled', 'canceled'], true);
                });

            $defaultRatePlan = $apartment->channexRatePlans
                ->where('is_active', true)
                ->sortByDesc('is_default')
                ->first();

            $availabilityStates = [];
            $restrictionStates = [];

            foreach (CarbonPeriod::create($dateFrom, $dateTo) as $date) {
                $dateString = $date->toDateString();
                $roomDaily = $dailyRates->get('room|' . $dateString);
                $planDaily = $defaultRatePlan
                    ? $dailyRates->get($defaultRatePlan->id . '|' . $dateString)
                    : null;

                $baseCapacity = $roomDaily && $roomDaily->availability !== null
                    ? (int) $roomDaily->availability
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

                $rate = (float) (
                    $planDaily->price
                    ?? $defaultRatePlan->default_rate
                    ?? $apartment->price
                    ?? 0
                );

                if ($rate <= 0) {
                    throw new RuntimeException(
                        "Apartment {$apartment->id} has no valid rate for {$dateString}."
                    );
                }

                $restrictionStates[$dateString] = [
                    // ChannexPro source ARI uses major currency units. ChannexPro
                    // converts this to Channex minor units when it publishes.
                    'rate' => round($rate, 2),
                    'min_stay_arrival' => (int) ($planDaily->min_stay_arrival ?? $roomDaily->min_stay_arrival ?? 1),
                    'min_stay_through' => (int) ($planDaily->min_stay_through ?? $roomDaily->min_stay_through ?? 1),
                    'max_stay' => (int) ($planDaily->max_stay ?? $roomDaily->max_stay ?? 0),
                    'closed_to_arrival' => (bool) ($planDaily->closed_to_arrival ?? $roomDaily->closed_to_arrival ?? false),
                    'closed_to_departure' => (bool) ($planDaily->closed_to_departure ?? $roomDaily->closed_to_departure ?? false),
                    'stop_sell' => $planDaily && $planDaily->stop_sell !== null
                        ? (bool) $planDaily->stop_sell
                        : ($roomDaily && $roomDaily->stop_sell !== null
                            ? (bool) $roomDaily->stop_sell
                            : ! (bool) $apartment->allow),
                ];
            }

            $availabilityValues = array_merge(
                $availabilityValues,
                $this->compressStates($availabilityStates, [
                    'room_type_id' => (string) $apartment->id,
                ])
            );

            $restrictionValues = array_merge(
                $restrictionValues,
                $this->compressStates($restrictionStates, [
                    // Must match the source rate-plan id exposed by the inventory feed.
                    'rate_plan_id' => 'standard:' . $apartment->id,
                ])
            );
        }

        return [
            'availability' => $availabilityValues,
            'restrictions' => $restrictionValues,
        ];
    }

    private function compressStates(array $states, array $identifiers): array
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
