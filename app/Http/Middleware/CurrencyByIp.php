<?php

namespace App\Http\Middleware;

use App\Http\Helper;
use App\Models\Apartment;
use App\Models\Currency;
use App\Models\PeakPeriod;
use App\Models\PriceChanged;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Closure;
use Stevebauman\Location\Facades\Location;

class CurrencyByIp
{
    /**
     * Handle an incoming request.
     *
     * Currency rules:
     * - Visitors detected in Nigeria default to NGN.
     * - Visitors outside Nigeria default to USD.
     * - An explicit ?currency=NGN/USD choice always wins and remains in session.
     * - If location lookup fails, fall back safely to USD instead of the system currency.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $position = null;
        $ip = $request->ip();

        // A local/private address cannot be geolocated by a public IP service.
        // Avoid blocking the request if location detection is unavailable.
        $isPublicIp = filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;

        if (! app()->environment('local') && $isPublicIp) {
            try {
                $position = Location::get($ip) ?: null;
            } catch (\Throwable $exception) {
                report($exception);
            }
        }

        $request->session()->put('country_name', optional($position)->countryName);

        /*
         * Keep the existing peak-period behaviour unchanged. Peak prices are based
         * on the requested stay dates elsewhere in the app; this block only keeps
         * the legacy December price snapshot in sync during the configured period.
         */
        $currentDate = Carbon::now();
        $peakPeriod = PeakPeriod::first();

        if (null !== $peakPeriod) {
            if ($currentDate->between($peakPeriod->start_date, $peakPeriod->end_date)) {
                Helper::updateApartmentPrices(
                    $peakPeriod->start_date,
                    $peakPeriod->end_date,
                    $peakPeriod->discount
                );

                $priceUpdate = new PriceChanged;
                $priceUpdate->is_updated = 1;
                $priceUpdate->save();
            } else {
                $priceUpdate = PriceChanged::first();

                if (null !== $priceUpdate && $priceUpdate->is_updated === true) {
                    $yesterday = Carbon::yesterday();

                    if ($yesterday->eq(Carbon::parse($peakPeriod->end_date))) {
                        Helper::reverseApartmentPrices($peakPeriod->discount);
                    }

                    $priceUpdate = PriceChanged::first();
                    $priceUpdate->is_updated = 0;
                    $priceUpdate->save();
                }
            }
        }

        $settings = SystemSetting::first();

        if (! optional($settings)->allow_multi_currency) {
            $request->session()->forget([
                'rate',
                'switch',
                'currency_manual_selection',
                'currency_detected_ip',
                'userLocation',
            ]);

            return $next($request);
        }

        $nigeria = Currency::where('country', 'Nigeria')->first();
        $usa = Currency::where('country', 'United States')->first();

        // A direct currency selection is a user preference and must override IP.
        $requestedCurrency = strtoupper((string) $request->query('currency', ''));
        $requestedCurrency = strtok($requestedCurrency, '?');

        if (in_array($requestedCurrency, ['USD', 'NGN'], true)) {
            $this->applyCurrency($request, $requestedCurrency, $nigeria, $usa, $position, $ip);
            $request->session()->put('currency_manual_selection', true);

            return $next($request);
        }

        // Once the visitor chooses a currency manually, do not fight that choice
        // with IP detection on every subsequent page request.
        if (
            $request->session()->boolean('currency_manual_selection')
            && $request->session()->has('rate')
            && $request->session()->has('switch')
        ) {
            return $next($request);
        }

        // If this session has already been auto-detected for the same IP, keep it.
        // This also avoids making a geolocation/rate request on every page load.
        if (
            $request->session()->has('rate')
            && $request->session()->has('switch')
            && $request->session()->get('currency_detected_ip') === $ip
        ) {
            return $next($request);
        }

        $countryCode = strtoupper((string) optional($position)->countryCode);
        $countryName = strtolower(trim((string) optional($position)->countryName));
        $isNigeria = $countryCode === 'NG' || $countryName === 'nigeria';

        // USD is intentionally the safe fallback when geolocation fails.
        $defaultCurrency = $isNigeria ? 'NGN' : 'USD';

        $this->applyCurrency($request, $defaultCurrency, $nigeria, $usa, $position, $ip);
        $request->session()->forget('currency_manual_selection');

        return $next($request);
    }

    /**
     * Store a complete, consistent currency payload in the session.
     */
    private function applyCurrency($request, $currency, $nigeria, $usa, $position, $ip)
    {
        if ($currency === 'NGN') {
            $exchangeRate = Helper::getCurrencyExchangeRate();
            $exchangeRate = is_numeric($exchangeRate) && (float) $exchangeRate > 0
                ? (float) $exchangeRate
                : 1.0;

            $isoCode = optional($nigeria)->iso_code3 ?: 'NGN';
            $rate = [
                'rate' => $exchangeRate,
                'country' => 'Nigeria',
                'code' => $isoCode,
                'iso_code3' => $isoCode,
                'symbol' => optional($nigeria)->symbol ?: '₦',
            ];
        } else {
            $isoCode = optional($usa)->iso_code3 ?: 'USD';
            $rate = [
                'rate' => 1,
                'country' => optional($usa)->country ?: 'United States',
                'code' => $isoCode,
                'iso_code3' => $isoCode,
                'symbol' => optional($usa)->symbol ?: '$',
            ];
        }

        $request->session()->put('rate', json_encode(collect($rate)));
        $request->session()->put('switch', $currency);
        $request->session()->put('currency_detected_ip', $ip);

        if ($position) {
            $request->session()->put('userLocation', json_encode($position));
        } else {
            $request->session()->forget('userLocation');
        }
    }
}
