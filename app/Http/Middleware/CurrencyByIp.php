<?php

namespace App\Http\Middleware;

use App\Http\Helper;
use App\Models\Currency;
use App\Models\SystemSetting;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Stevebauman\Location\Facades\Location;

class CurrencyByIp
{
    /**
     * Bump this whenever the automatic-location rules change. Old browser
     * sessions are then re-detected instead of remaining pinned to a country
     * or currency resolved by older middleware code.
     */
    private const DETECTION_VERSION = '20260910-v5';

    /**
     * Resolve storefront currency before Apartment accessors serialize prices.
     *
     * Business rule:
     * - Nigeria => NGN automatically.
     * - Other resolved countries => USD.
     * - An explicit supported currency selection wins for the current session
     *   when manual multi-currency is enabled.
     *
     * Automatic location pricing is intentionally independent from the legacy
     * allow_multi_currency flag. That flag controls the manual switcher only.
     */
    public function handle($request, Closure $next)
    {
        $settings = SystemSetting::first();
        $allowManualCurrency = $settings ? (bool) $settings->allow_multi_currency : false;
        $ip = $this->resolveVisitorIp($request);

        // Currency state written by earlier versions of this middleware must
        // not survive a deployment and keep a Nigerian visitor stuck on USD.
        if ($request->session()->get('currency_detection_version') !== self::DETECTION_VERSION) {
            $request->session()->forget([
                'rate',
                'switch',
                'userLocation',
                'country_name',
                'currency_manual_selection',
                'currency_manual_ip',
                'currency_manual_selected_at',
                'currency_detected_ip',
                'currency_detected_country_code',
                'currency_detected_at',
                'currency_detection_source',
                'currency_browser_country_code',
                'currency_browser_detected_at',
            ]);
        }

        $requestedCurrency = strtoupper(trim((string) $request->query('currency', '')));
        $requestedCurrency = strtok($requestedCurrency, '?');

        if (
            $allowManualCurrency
            && $requestedCurrency
            && $this->currencyExists($requestedCurrency)
        ) {
            $country = $this->resolveCountry($request, $ip);
            $this->applyCurrency(
                $request,
                $requestedCurrency,
                $country['name'] ?? null,
                $country['code'] ?? null,
                $ip
            );

            $request->session()->put('currency_detection_version', self::DETECTION_VERSION);
            $request->session()->put('currency_manual_selection', true);
            $request->session()->put('currency_manual_ip', $ip);
            $request->session()->put('currency_manual_selected_at', now()->timestamp);
            $request->session()->put('currency_detection_source', 'manual');

            return $this->continueRequest($request, $next);
        }

        // Preserve only a manual selection created by this version. This is
        // deliberately checked after the version reset above.
        if (
            (bool) $request->session()->get('currency_manual_selection', false)
            && $request->session()->get('currency_detection_version') === self::DETECTION_VERSION
            && $request->session()->get('currency_manual_ip') === $ip
            && $request->session()->has('rate')
            && $request->session()->has('switch')
        ) {
            return $this->continueRequest($request, $next);
        }

        $request->session()->forget([
            'currency_manual_selection',
            'currency_manual_ip',
            'currency_manual_selected_at',
        ]);

        // A request-specific edge country is the strongest automatic signal.
        // It must win over any browser country saved before a VPN/proxy change.
        $edgeCountryCode = strtoupper(trim((string) $request->header('CF-IPCountry', '')));
        if ($this->isCountryCode($edgeCountryCode)) {
            $this->applyDetectedCurrency($request, $settings, [
                'code' => $edgeCountryCode,
                'name' => $edgeCountryCode === 'NG' ? 'Nigeria' : null,
                'source' => 'cloudflare',
            ], $ip);

            return $this->continueRequest($request, $next);
        }

        // Reuse a successful server-side detection only while the apparent
        // visitor IP is unchanged. Switching a VPN changes the IP and forces
        // an immediate country/currency re-evaluation.
        $detectedAt = (int) $request->session()->get('currency_detected_at', 0);
        $detectedRecently = $detectedAt > 0 && $detectedAt >= now()->subMinutes(30)->timestamp;

        if (
            $request->session()->get('currency_detection_version') === self::DETECTION_VERSION
            && $request->session()->has('rate')
            && $request->session()->has('switch')
            && $request->session()->get('currency_detected_ip') === $ip
            && $request->session()->has('currency_detected_country_code')
            && $detectedRecently
        ) {
            return $this->continueRequest($request, $next);
        }

        // Prefer server-side lookup for a real public visitor IP. This keeps
        // the browser fallback from pinning a currency after the visitor turns
        // a VPN on/off or changes VPN country.
        $country = $this->resolveCountry($request, $ip);
        if ($this->isCountryCode($country['code'] ?? null)) {
            $this->applyDetectedCurrency($request, $settings, $country, $ip);

            return $this->continueRequest($request, $next);
        }

        // Browser detection is only a fallback when the origin cannot resolve
        // the visitor. Keep it short-lived because a VPN can change the
        // browser's apparent country without changing the Laravel session.
        $browserCountryCode = strtoupper(trim((string) $request->session()->get('currency_browser_country_code', '')));
        $browserDetectedAt = (int) $request->session()->get('currency_browser_detected_at', 0);
        $browserDetectionIsFresh = $browserDetectedAt > 0
            && $browserDetectedAt >= now()->subMinutes(5)->timestamp;

        if ($browserDetectionIsFresh && $this->isCountryCode($browserCountryCode)) {
            $this->applyDetectedCurrency($request, $settings, [
                'code' => $browserCountryCode,
                'name' => $browserCountryCode === 'NG' ? 'Nigeria' : null,
                'source' => 'browser',
            ], $ip);

            return $this->continueRequest($request, $next);
        }

        // No reliable location is available. Preserve the configured/base
        // currency rather than guessing NGN.
        $this->applyDetectedCurrency($request, $settings, [
            'code' => null,
            'name' => null,
            'source' => 'unresolved',
        ], $ip);

        return $this->continueRequest($request, $next);
    }

    private function applyDetectedCurrency($request, $settings, array $country, $ip)
    {
        $countryCode = strtoupper((string) ($country['code'] ?? ''));
        $countryName = strtolower(trim((string) ($country['name'] ?? '')));
        $isNigeria = $countryCode === 'NG' || $countryName === 'nigeria';

        $currencyCode = $isNigeria
            ? 'NGN'
            : ($countryCode !== '' ? 'USD' : $this->defaultCurrencyCode($settings));

        $rate = $this->applyCurrency(
            $request,
            $currencyCode,
            $country['name'] ?? null,
            $country['code'] ?? null,
            $ip
        );

        $request->session()->put('currency_detection_version', self::DETECTION_VERSION);
        $request->session()->put('currency_detection_source', $country['source'] ?? 'unknown');

        // Mark the country lookup as reusable only when geolocation really
        // succeeded and the requested country currency was safely applied.
        if ($countryCode !== '' && strtoupper((string) $rate['iso_code3']) === $currencyCode) {
            $request->session()->put('currency_detected_ip', $ip);
            $request->session()->put('currency_detected_country_code', $countryCode);
            $request->session()->put('currency_detected_at', now()->timestamp);
        } else {
            $request->session()->forget([
                'currency_detected_ip',
                'currency_detected_country_code',
                'currency_detected_at',
            ]);
        }
    }

    /**
     * Prefer original-client headers used by common reverse proxies, then
     * Laravel's request address. The public-IP check prevents private proxy
     * addresses from being sent to a geolocation provider.
     */
    private function resolveVisitorIp($request)
    {
        $candidates = [
            $request->header('CF-Connecting-IP'),
            $request->header('True-Client-IP'),
            $request->header('X-Real-IP'),
        ];

        $forwardedFor = (string) $request->header('X-Forwarded-For', '');
        if ($forwardedFor !== '') {
            foreach (explode(',', $forwardedFor) as $forwardedIp) {
                $candidates[] = trim($forwardedIp);
            }
        }

        $candidates[] = $request->ip();

        foreach ($candidates as $candidate) {
            if ($this->isPublicIp($candidate)) {
                return $candidate;
            }
        }

        // LOCATION_TEST_IP is development-only. A production request must
        // never inherit a configured test country when the real client IP is
        // hidden by a proxy.
        $testingIp = app()->environment('local', 'testing') && config('location.testing.enabled')
            ? config('location.testing.ip')
            : null;

        if ($this->isPublicIp($testingIp)) {
            return $testingIp;
        }

        return $request->ip();
    }

    /**
     * Country resolution order:
     * 1. Cloudflare country header.
     * 2. Versioned local cache.
     * 3. Existing Stevebauman/MaxMind location stack.
     * 4. ipwho.is.
     * 5. ipapi.co.
     *
     * The package testing override is disabled while resolving a real public
     * visitor IP. This matters even if a production .env accidentally has
     * APP_ENV=local or LOCATION_TESTING=true.
     */
    private function resolveCountry($request, $ip)
    {
        $cloudflareCode = strtoupper(trim((string) $request->header('CF-IPCountry', '')));
        if ($this->isCountryCode($cloudflareCode)) {
            return [
                'code' => $cloudflareCode,
                'name' => $cloudflareCode === 'NG' ? 'Nigeria' : null,
                'source' => 'cloudflare',
            ];
        }

        if (! $this->isPublicIp($ip)) {
            return ['code' => null, 'name' => null, 'source' => 'unresolved'];
        }

        $cacheKey = 'visitor-country:' . self::DETECTION_VERSION . ':' . sha1((string) $ip);
        $cached = Cache::get($cacheKey);
        if (is_array($cached) && $this->isCountryCode($cached['code'] ?? null)) {
            return $cached + ['source' => 'cache'];
        }

        $testingWasEnabled = (bool) config('location.testing.enabled');

        try {
            // Always honor the public IP passed to Location::get(). The package
            // test address must never replace an actual visitor address.
            if ($testingWasEnabled) {
                config(['location.testing.enabled' => false]);
            }

            $position = Location::get($ip) ?: null;
            $positionCode = strtoupper(trim((string) optional($position)->countryCode));
            $positionName = trim((string) optional($position)->countryName);

            if (! $this->isCountryCode($positionCode) && strtolower($positionName) === 'nigeria') {
                $positionCode = 'NG';
            }

            if ($this->isCountryCode($positionCode)) {
                return $this->cacheCountry($cacheKey, [
                    'code' => $positionCode,
                    'name' => $positionName !== '' ? $positionName : null,
                    'source' => 'location',
                ]);
            }
        } catch (\Throwable $exception) {
            report($exception);
        } finally {
            if ($testingWasEnabled) {
                config(['location.testing.enabled' => true]);
            }
        }

        try {
            $response = Http::timeout(5)
                ->acceptJson()
                ->get('https://ipwho.is/' . rawurlencode((string) $ip));

            if ($response->successful() && data_get($response->json(), 'success', true) !== false) {
                $apiCode = strtoupper(trim((string) data_get($response->json(), 'country_code')));
                $apiName = trim((string) data_get($response->json(), 'country'));

                if ($this->isCountryCode($apiCode)) {
                    return $this->cacheCountry($cacheKey, [
                        'code' => $apiCode,
                        'name' => $apiName !== '' ? $apiName : null,
                        'source' => 'ipwho.is',
                    ]);
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        try {
            $response = Http::timeout(5)
                ->acceptJson()
                ->get('https://ipapi.co/' . rawurlencode((string) $ip) . '/json/');

            if ($response->successful() && ! data_get($response->json(), 'error', false)) {
                $apiCode = strtoupper(trim((string) data_get($response->json(), 'country_code')));
                $apiName = trim((string) data_get($response->json(), 'country_name'));

                if ($this->isCountryCode($apiCode)) {
                    return $this->cacheCountry($cacheKey, [
                        'code' => $apiCode,
                        'name' => $apiName !== '' ? $apiName : null,
                        'source' => 'ipapi.co',
                    ]);
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        Log::warning('Storefront country detection failed', [
            'ip' => $ip,
        ]);

        return ['code' => null, 'name' => null, 'source' => 'unresolved'];
    }

    private function cacheCountry($cacheKey, array $country)
    {
        Cache::put($cacheKey, $country, now()->addHours(6));

        return $country;
    }

    private function isPublicIp($ip)
    {
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }

    private function isCountryCode($code)
    {
        return is_string($code)
            && preg_match('/^[A-Z]{2}$/', $code) === 1
            && ! in_array($code, ['XX'], true);
    }

    private function currencyExists($code)
    {
        return in_array($code, ['USD', 'NGN'], true)
            || Currency::where('iso_code3', $code)->exists();
    }

    private function defaultCurrencyCode($settings)
    {
        $configured = strtoupper((string) optional(optional($settings)->currency)->iso_code3);

        return $configured !== '' ? $configured : 'USD';
    }

    /**
     * Store one canonical rate object used by FormatPrice, checkout and the
     * booking-price snapshot. For a non-USD currency, never use a fake 1:1
     * exchange rate: falling back to USD is safer than undercharging.
     */
    private function applyCurrency($request, $currencyCode, $countryName, $countryCode, $ip)
    {
        $currencyCode = strtoupper((string) $currencyCode);
        $currency = Currency::where('iso_code3', $currencyCode)->first();

        $fallbacks = [
            'NGN' => ['country' => 'Nigeria', 'symbol' => '₦'],
            'USD' => ['country' => 'United States', 'symbol' => '$'],
        ];

        $exchangeRate = $currencyCode === 'USD'
            ? 1.0
            : Helper::getCurrencyExchangeRate($currencyCode, 'USD');

        if (
            $currencyCode !== 'USD'
            && (! is_numeric($exchangeRate) || (float) $exchangeRate <= 1)
        ) {
            Log::warning('Storefront exchange rate unavailable; using USD safely', [
                'requested_currency' => $currencyCode,
                'rate' => $exchangeRate,
            ]);

            $currencyCode = 'USD';
            $currency = Currency::where('iso_code3', 'USD')->first();
            $exchangeRate = 1.0;
        }

        $fallback = $fallbacks[$currencyCode] ?? [
            'country' => $countryName ?: $currencyCode,
            'symbol' => $currencyCode . ' ',
        ];

        $rate = [
            'rate' => (float) $exchangeRate,
            'country' => optional($currency)->country ?: $fallback['country'],
            'code' => optional($currency)->iso_code3 ?: $currencyCode,
            'iso_code3' => optional($currency)->iso_code3 ?: $currencyCode,
            'symbol' => optional($currency)->symbol ?: $fallback['symbol'],
        ];

        $request->session()->put('rate', json_encode($rate));
        $request->session()->put('switch', $rate['iso_code3']);
        $request->session()->put('country_name', $countryName ?: ($countryCode ?: $rate['country']));
        $request->session()->put('userLocation', json_encode([
            'ip' => $ip,
            'countryName' => $countryName,
            'countryCode' => $countryCode,
        ]));

        return $rate;
    }
    /**
     * Currency-specific pages must not be shared from an intermediary cache.
     * The displayed price depends on the visitor session/country.
     */
    private function continueRequest($request, Closure $next)
    {
        $response = $next($request);

        if (isset($response->headers)) {
            $response->headers->set('Cache-Control', 'private, no-store, no-cache, must-revalidate, max-age=0');
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');
        }

        return $response;
    }

}
