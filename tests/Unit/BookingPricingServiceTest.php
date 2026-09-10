<?php

namespace Tests\Unit;

use App\Models\Apartment;
use App\Models\PeakPeriod;
use App\Services\BookingPricingService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

class BookingPricingServiceTest extends TestCase
{
    public function test_full_peak_stay_uses_configured_increase_even_when_quoted_before_peak_month(): void
    {
        $quote = $this->service()->quote(
            $this->apartment(100),
            '2026-12-01',
            '2026-12-04',
            1,
            'USD',
            '$',
            collect([$this->peak('2026-12-01', '2026-12-31', 60)])
        );

        $this->assertSame(3, $quote['nights']);
        $this->assertSame(0, $quote['regular_nights']);
        $this->assertSame(3, $quote['peak_nights']);
        $this->assertSame(160.0, (float) $quote['peak_nightly']);
        $this->assertSame(480.0, (float) $quote['accommodation_total']);
        $this->assertSame(60.0, (float) $quote['peak_percentage']);
    }

    public function test_mixed_stay_prices_each_night_from_the_selected_dates(): void
    {
        $quote = $this->service()->quote(
            $this->apartment(100),
            '2026-11-30',
            '2026-12-02',
            1,
            'USD',
            '$',
            collect([$this->peak('2026-12-01', '2026-12-31', 60)])
        );

        $this->assertSame(2, $quote['nights']);
        $this->assertSame(1, $quote['regular_nights']);
        $this->assertSame(1, $quote['peak_nights']);
        $this->assertSame(100.0, (float) $quote['regular_total']);
        $this->assertSame(160.0, (float) $quote['peak_total']);
        $this->assertSame(260.0, (float) $quote['accommodation_total']);
        $this->assertSame(130.0, (float) $quote['average_nightly']);
    }

    public function test_ngn_conversion_and_peak_increase_use_one_frozen_rate(): void
    {
        $quote = $this->service()->quote(
            $this->apartment(100),
            '2026-12-01',
            '2026-12-03',
            1500,
            'NGN',
            '₦',
            collect([$this->peak('2026-12-01', '2026-12-31', 60)])
        );

        $this->assertSame('NGN', $quote['currency_code']);
        $this->assertSame('₦', $quote['currency_symbol']);
        $this->assertSame(1500.0, (float) $quote['exchange_rate']);
        $this->assertSame(240000.0, (float) $quote['peak_nightly']);
        $this->assertSame(480000.0, (float) $quote['accommodation_total']);
    }

    public function test_checkout_date_is_not_charged_as_an_extra_night(): void
    {
        $quote = $this->service()->quote(
            $this->apartment(100),
            '2026-11-30',
            '2026-12-01',
            1,
            'USD',
            '$',
            collect([$this->peak('2026-12-01', '2026-12-31', 60)])
        );

        $this->assertSame(1, $quote['nights']);
        $this->assertSame(1, $quote['regular_nights']);
        $this->assertSame(0, $quote['peak_nights']);
        $this->assertSame(100.0, (float) $quote['accommodation_total']);
    }

    public function test_overlapping_periods_apply_the_strongest_increase_only_once(): void
    {
        $periods = collect([
            $this->peak('2026-12-01', '2026-12-31', 40, 1),
            $this->peak('2026-12-20', '2026-12-27', 60, 2),
        ]);

        $quote = $this->service()->quote(
            $this->apartment(100),
            '2026-12-21',
            '2026-12-22',
            1,
            'USD',
            '$',
            $periods
        );

        $this->assertSame(1, $quote['peak_nights']);
        $this->assertSame(160.0, (float) $quote['peak_nightly']);
        $this->assertSame(160.0, (float) $quote['accommodation_total']);
        $this->assertSame(2, $quote['nightly_breakdown'][0]['peak_period_id']);
    }

    private function service(): BookingPricingService
    {
        return new BookingPricingService();
    }

    private function apartment($price): Apartment
    {
        // FormatPrice's model constructor reads SystemSetting from the database.
        // PricingService only needs the model's price, so build an in-memory
        // Eloquent instance without invoking that unrelated constructor query.
        $reflection = new ReflectionClass(Apartment::class);
        /** @var Apartment $apartment */
        $apartment = $reflection->newInstanceWithoutConstructor();
        $apartment->setRawAttributes(['price' => $price], true);

        return $apartment;
    }

    private function peak($start, $end, $percentage, $id = null): PeakPeriod
    {
        $peak = new PeakPeriod();
        $peak->setRawAttributes([
            'id' => $id,
            'start_date' => $start,
            'end_date' => $end,
            'discount' => $percentage,
        ], true);

        return $peak;
    }
}
