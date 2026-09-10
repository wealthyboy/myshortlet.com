<?php

namespace App\Services;

use App\Http\Helper;
use App\Models\Apartment;
use App\Models\PeakPeriod;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class BookingPricingService
{
    /**
     * Build one authoritative accommodation quote for the requested stay.
     *
     * Apartment prices are stored in the application's base currency (USD).
     * Peak pricing is applied to the stay dates, not to today's date, and the
     * complete result is then converted using one frozen exchange rate.
     */
    public function quote(
        Apartment $apartment,
        $checkIn,
        $checkOut,
        $exchangeRate = null,
        $currencyCode = null,
        $currencySymbol = null,
        Collection $peakPeriods = null
    ) {
        $start = $this->asDate($checkIn);
        $end = $this->asDate($checkOut);

        if (! $end->gt($start)) {
            throw new InvalidArgumentException('Check-out must be after check-in.');
        }

        $rate = $this->normaliseRate($exchangeRate);
        $currencyCode = strtoupper((string) ($currencyCode ?: Helper::getIsoCode() ?: 'USD'));
        $currencySymbol = (string) ($currencySymbol ?: Helper::getCurrency() ?: '$');

        $baseRegularPrice = (float) ($apartment->price ?: 0);
        $regularNightly = $this->convert($baseRegularPrice, $rate);

        if ($peakPeriods === null) {
            $lastNight = $end->copy()->subDay();
            $peakPeriods = PeakPeriod::query()
                ->whereDate('end_date', '>=', $start->toDateString())
                ->whereDate('start_date', '<=', $lastNight->toDateString())
                ->orderBy('start_date')
                ->get();
        }

        $nights = [];
        $regularNights = 0;
        $peakNights = 0;
        $baseTotal = 0;
        $convertedTotal = 0;
        $peakPercentages = [];
        $peakNightlyPrices = [];

        for ($night = $start->copy(); $night->lt($end); $night->addDay()) {
            $peak = $this->peakForNight($night, $peakPeriods);
            $percentage = $peak ? max(0, (float) $peak->discount) : 0;
            $baseNightPrice = $baseRegularPrice;

            if ($percentage > 0) {
                $baseNightPrice = $baseRegularPrice * (1 + ($percentage / 100));
                $peakNights++;
                $peakPercentages[] = $percentage;
            } else {
                $regularNights++;
            }

            $convertedNightPrice = $this->convert($baseNightPrice, $rate);

            if ($percentage > 0) {
                $peakNightlyPrices[] = $convertedNightPrice;
            }

            $baseTotal += $baseNightPrice;
            $convertedTotal += $convertedNightPrice;

            $nights[] = [
                'date' => $night->toDateString(),
                'base_price' => round($baseNightPrice, 2),
                'price' => $convertedNightPrice,
                'is_peak' => $percentage > 0,
                'peak_percentage' => $percentage,
                'peak_period_id' => $peak ? $peak->id : null,
            ];
        }

        $nightCount = count($nights);
        $peakPercentage = empty($peakPercentages) ? 0 : max($peakPercentages);
        $peakNightly = empty($peakNightlyPrices) ? 0 : max($peakNightlyPrices);

        $usedPeakIds = collect($nights)
            ->pluck('peak_period_id')
            ->filter()
            ->unique()
            ->values();

        $peakPeriodSnapshots = $peakPeriods
            ->filter(function ($period) use ($usedPeakIds, $nights) {
                if ($period->id) {
                    return $usedPeakIds->contains($period->id);
                }

                // Tests or in-memory periods may not have an ID yet.
                return collect($nights)->contains(function ($night) use ($period) {
                    return $night['is_peak']
                        && Carbon::parse($night['date'])->between(
                            Carbon::parse($period->start_date)->startOfDay(),
                            Carbon::parse($period->end_date)->endOfDay()
                        );
                });
            })
            ->map(function ($period) {
                $start = Carbon::parse($period->start_date);
                $end = Carbon::parse($period->end_date);

                return [
                    'id' => $period->id,
                    'start_date' => $start->toDateString(),
                    'end_date' => $end->toDateString(),
                    'from_date' => $start->format('l d F Y'),
                    'to_date' => $end->format('l d F Y'),
                    'percentage' => max(0, (float) $period->discount),
                ];
            })
            ->values()
            ->all();

        return [
            'currency_code' => $currencyCode,
            'currency_symbol' => $currencySymbol,
            'exchange_rate' => $rate,
            'nights' => $nightCount,
            'regular_nights' => $regularNights,
            'peak_nights' => $peakNights,
            'peak_percentage' => $peakPercentage,
            'regular_nightly' => $regularNightly,
            'peak_nightly' => $peakNightly,
            'regular_total' => collect($nights)->where('is_peak', false)->sum('price'),
            'peak_total' => collect($nights)->where('is_peak', true)->sum('price'),
            'accommodation_total' => round($convertedTotal, 0),
            'average_nightly' => $nightCount > 0 ? round($convertedTotal / $nightCount, 0) : $regularNightly,
            'base_regular_nightly' => round($baseRegularPrice, 2),
            'base_accommodation_total' => round($baseTotal, 2),
            'peak_periods' => $peakPeriodSnapshots,
            'nightly_breakdown' => $nights,
        ];
    }

    /**
     * Return the effective per-night listing price for a selected date range.
     * For mixed regular/peak stays this is the average nightly price, while a
     * stay wholly inside a peak period naturally returns the full peak rate.
     */
    public function listingPrice(Apartment $apartment, $checkIn, $checkOut)
    {
        return $this->quote($apartment, $checkIn, $checkOut)['average_nightly'];
    }

    protected function peakForNight(Carbon $night, Collection $peakPeriods)
    {
        return $peakPeriods
            ->filter(function ($period) use ($night) {
                if (! $period->start_date || ! $period->end_date) {
                    return false;
                }

                return $night->between(
                    Carbon::parse($period->start_date)->startOfDay(),
                    Carbon::parse($period->end_date)->endOfDay()
                );
            })
            // If periods overlap, apply the strongest configured increase once.
            ->sortByDesc(function ($period) {
                return (float) $period->discount;
            })
            ->first();
    }

    protected function normaliseRate($exchangeRate)
    {
        if (is_numeric($exchangeRate) && (float) $exchangeRate > 0) {
            return (float) $exchangeRate;
        }

        $sessionRate = optional(Helper::rate())->rate;

        return is_numeric($sessionRate) && (float) $sessionRate > 0
            ? (float) $sessionRate
            : 1.0;
    }

    protected function convert($amount, $rate)
    {
        // Existing booking tables store whole monetary units. Keep one rounding
        // rule everywhere so list, checkout, payment, reservation and receipt agree.
        return round(((float) $amount) * ((float) $rate), 0);
    }

    protected function asDate($value)
    {
        if ($value instanceof Carbon) {
            return $value->copy()->startOfDay();
        }

        return Carbon::parse($value)->startOfDay();
    }
}
