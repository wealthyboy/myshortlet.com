<?php

namespace App\Http\Middleware;

use App\Http\Helper;
use App\Models\Currency;
use App\Models\SystemSetting;
use Closure;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Facades\Location;

class CurrencyByIp
{
    /**
     * Resolve the storefront currency before prices are serialized.
     *
     * Location-aware pricing and manual multi-currency switching are two
     * different concerns. A visitor in Nigeria must still be shown NGN when
     * location awareness is enabled, even when allow_multi_currency is false.
     */
    public function handle($request, Closure $next)
    {
        $settings = SystemSetting::first();
        $locationAware = $settings ? (bool) $settings->location_aware : true;
        $allowManualCurrency = $settings ? (bool) $settings->allow_multi_currency : false;

        $ip = $this->resolveVisitorIp($request);

        // Do not let an accidentally enabled local testing IP override a real
        // production visitor. The config can still be used while developing.
        if (! app()->environment('local') && config('location.testing.enabled')) {
            config(['location.testing.enabled' => false]);
        }

        $requestedCurrency = strtoupper(trim((string) $request->query('currency', '')));
        $requestedCurrency = strtok($requestedCurrency, '?');

        // An explicit currency choice is respected when multi-currency is
        // enabled. Mark it with the IP and timestamp so old/stale session flags
        // from previous code cannot permanently pin a visitor to USD.
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

            $request->session()->put('currency_manual_selection', true);
            $request->session()->put('currency_manual_ip', $ip);
            $request->session()->put('currency_manual_selected_at', now()->timestamp);

            return $next($request);
        }

        // If location awareness is disabled, preserve an already selected
        // currency but do not perform automatic geolocation.
        if (! $locationAware) {
            return $next($request);
        }

        // Preserve a genuine current-session manual choice. Legacy manual flags
        // (which did not store an IP/timestamp) are deliberately ignored once
        // so automatic country detection can repair stale USD sessions.
        if (
            (bool) $request->session()->get('currency_manual_selection', false)
            && $request->session()->has('currency_manual_selected_at')
            && $request->session()->get('currency_manual_ip') === $ip
            && $request->session()->has('rate')
            && $request->session()->has('switch')
        ) {
            return $next($request);
        }

        $request->session()->forget([
            'currency_manual_selection',
            'currency_manual_ip',
            'currency_manual_selected_at',
        ]);

        // Reuse only a successful country detection. The previous implementation
        // also cached an unresolved lookup as USD, which could leave a Nigerian
        // visitor stuck in dollars for the rest of the session.
        if (
            $request->session()->has('rate')
            && $request->session()->has('switch')
            && $request->session()->get('currency_detected_ip') === $ip
            && $request->session()->has('currency_detected_country_code')
        ) {
            return $next($request);
        }

        $country = $this->resolveCountry($request, $ip);
        $countryCode = strtoupper((string) ($country['code'] ?? ''));
        $countryName = strtolower(trim((string) ($country['name'] ?? '')));
        $isNigeria = $countryCode === 'NG' || $countryName === 'nigeria';

        // The present business rule is Nigeria => NGN, everywhere else => USD.
        // If country lookup is temporarily unavailable, use the configured
        // default but do not mark detection as successful; a later request can
        // retry and correct the currency automatically.
        $currencyCode = $isNigeria
            ? 'NGN'
            : ($countryCode !== '' ? 'USD' : $this->defaultCurrencyCode($settings));

        $this->applyCurrency(
            $request,
            $currencyCode,
            $country['name'] ?? null,
            $country['code'] ?? null,
            $ip
        );

        if ($countryCode !== '') {
            $request->session()->put('currency_detected_ip', $ip);
            $request->session()->put('currency_detected_country_code', $countryCode);
        } else {
            $request->session()->forget([
                'currency_detected_ip',
                'currency_detected_country_code',
            ]);
        }

        return $next($request);
    }

    /**
     * Prefer the original client address supplied by the common edge proxies
     * used by the application, then fall back to Laravel's request address.
     */
    private function resolveVisitorIp($request)
    {
        $candidates = [
            $request->header('CF-Connecting-IP'),
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

        // Localhost has no public client address. This fallback is restricted
        // to the local environment so production never geolocates the server.
        if (app()->environment('local')) {
            return Cache::remember('local-public-ip', now()->addMinutes(10), function () use ($request) {
                try {
                    $response = Http::timeout(3)->get('https://api64.ipify.org', [
                        'format' => 'json',
                    ]);
                    $publicIp = $response->successful() ? data_get($response->json(), 'ip') : null;

                    return $this->isPublicIp($publicIp) ? $publicIp : $request->ip();
                } catch (\Throwable $e) {
                    return $request->ip();
                }
            });
        }

        return $request->ip();
    }

    /**
     * Resolve country from Cloudflare first, then the installed Location
     * package / MaxMind database, with an HTTPS IP API as the final fallback.
     * Only successful results are cached as a country detection.
     */
    private function resolveCountry($request, $ip)
    {
        $cloudflareCode = strtoupper(trim((string) $request->header('CF-IPCountry', '')));
        if ($this->isCountryCode($cloudflareCode)) {
            return [
                'code' => $cloudflareCode,
                'name' => $cloudflareCode === 'NG' ? 'Nigeria' : null,
                'position' => null,
            ];
        }

        if (! $this->isPublicIp($ip)) {
            return ['code' => null, 'name' => null, 'position' => null];
        }

        $cacheKey = 'visitor-country:' . sha1((string) $ip);
        $cached = Cache::get($cacheKey);
        if (is_array($cached) && $this->isCountryCode($cached['code'] ?? null)) {
            return $cached + ['position' => null];
        }

        try {
            $position = Location::get($ip) ?: null;
            $positionCode = strtoupper(trim((string) optional($position)->countryCode));
            $positionName = trim((string) optional($position)->countryName);

            if ($this->isCountryCode($positionCode) || $positionName !== '') {
                $result = [
                    'code' => $this->isCountryCode($positionCode) ? $positionCode : null,
                    'name' => $positionName !== '' ? $positionName : null,
                    'position' => $position,
                ];

                // Nigeria can also be identified safely by country name if an
                // older MaxMind database does not populate countryCode.
                if (! $result['code'] && strtolower($positionName) === 'nigeria') {
                    $result['code'] = 'NG';
                }

                if ($result['code']) {
                    Cache::put($cacheKey, [
                        'code' => $result['code'],
                        'name' => $result['name'],
                    ], now()->addHours(6));
                }

                return $result;
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        // Final provider fallback. This prevents one failed/stale local GeoIP
        // lookup from silently becoming a permanent USD session.
        try {
            $response = Http::timeout(5)
                ->acceptJson()
                ->get('https://ipwho.is/' . rawurlencode((string) $ip));

            if ($response->successful() && data_get($response->json(), 'success', true) !== false) {
                $apiCode = strtoupper(trim((string) data_get($response->json(), 'country_code')));
                $apiName = trim((string) data_get($response->json(), 'country'));

                if ($this->isCountryCode($apiCode)) {
                    $result = [
                        'code' => $apiCode,
                        'name' => $apiName !== '' ? $apiName : null,
                        'position' => null,
                    ];

                    Cache::put($cacheKey, [
                        'code' => $result['code'],
                        'name' => $result['name'],
                    ], now()->addHours(6));

                    return $result;
                }
            }
        } catch (\Throwable $exception) {
            report($exception);
        }

        return ['code' => null, 'name' => null, 'position' => null];
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

    private function applyCurrency($request, $currencyCode, $countryName, $countryCode, $ip)
    {
        $currencyCode = strtoupper((string) $currencyCode);
        $currency = Currency::where('iso_code3', $currencyCode)->first();

        $fallbacks = [
            'NGN' => ['country' => 'Nigeria', 'symbol' => '₦'],
            'USD' => ['country' => 'United States', 'symbol' => '$'],
        ];
        $fallback = $fallbacks[$currencyCode] ?? [
            'country' => $countryName ?: $currencyCode,
            'symbol' => $currencyCode . ' ',
        ];

        $exchangeRate = $currencyCode === 'USD'
            ? 1.0
            : Helper::getCurrencyExchangeRate($currencyCode, 'USD');

        if (! is_numeric($exchangeRate) || (float) $exchangeRate <= 0) {
            $exchangeRate = 1.0;
        }

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

        $location = [
            'ip' => $ip,
            'countryName' => $countryName,
            'countryCode' => $countryCode,
        ];
        $request->session()->put('userLocation', json_encode($location));
    }
}
