<?php

namespace App\Http\Controllers\CurrencyLocation;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyLocationController extends Controller
{
    /**
     * Persist the country detected by the visitor's browser.
     *
     * Only the country code is accepted from the browser. The server decides
     * the currency and obtains the exchange rate itself, so a visitor cannot
     * submit a price or exchange rate that affects what is charged.
     */
    public function store(Request $request)
    {
        $request->validate([
            'country_code' => 'required|string|size:2',
        ]);

        $countryCode = strtoupper(trim((string) $request->input('country_code')));

        if (! preg_match('/^[A-Z]{2}$/', $countryCode)) {
            return response()->json(['message' => 'Invalid country code.'], 422);
        }

        $currencyCode = $countryCode === 'NG' ? 'NGN' : 'USD';
        $currentCurrency = strtoupper((string) (optional(Helper::rate())->iso_code3 ?: Helper::getIsoCode() ?: 'USD'));

        if ($currencyCode === 'NGN') {
            $exchangeRate = Helper::getCurrencyExchangeRate('NGN', 'USD');

            if (! is_numeric($exchangeRate) || (float) $exchangeRate <= 1) {
                return response()->json([
                    'message' => 'NGN exchange rate is currently unavailable.',
                    'currency' => $currentCurrency,
                ], 503);
            }

            $currency = Currency::where('iso_code3', 'NGN')->first();
            $rate = [
                'rate' => (float) $exchangeRate,
                'country' => optional($currency)->country ?: 'Nigeria',
                'code' => optional($currency)->iso_code3 ?: 'NGN',
                'iso_code3' => optional($currency)->iso_code3 ?: 'NGN',
                'symbol' => optional($currency)->symbol ?: '₦',
            ];
        } else {
            $currency = Currency::where('iso_code3', 'USD')->first();
            $rate = [
                'rate' => 1.0,
                'country' => optional($currency)->country ?: 'United States',
                'code' => optional($currency)->iso_code3 ?: 'USD',
                'iso_code3' => optional($currency)->iso_code3 ?: 'USD',
                'symbol' => optional($currency)->symbol ?: '$',
            ];
        }

        $request->session()->put('rate', json_encode($rate));
        $request->session()->put('switch', $rate['iso_code3']);
        $request->session()->put('country_name', $countryCode === 'NG' ? 'Nigeria' : $countryCode);
        $request->session()->put('currency_browser_country_code', $countryCode);
        $request->session()->put('currency_browser_detected_at', now()->timestamp);
        $request->session()->put('currency_detection_source', 'browser');
        $request->session()->put('userLocation', json_encode([
            'countryCode' => $countryCode,
            'countryName' => $countryCode === 'NG' ? 'Nigeria' : null,
            'source' => 'browser',
        ]));

        // Automatic location detection should not be mistaken for an explicit
        // manual switcher selection.
        $request->session()->forget([
            'currency_manual_selection',
            'currency_manual_ip',
            'currency_manual_selected_at',
        ]);

        return response()->json([
            'country_code' => $countryCode,
            'currency' => $rate['iso_code3'],
            'symbol' => $rate['symbol'],
            'rate' => $rate['rate'],
            'changed' => $currentCurrency !== $rate['iso_code3'],
        ])->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0');
    }
}
