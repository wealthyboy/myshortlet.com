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
     * Keep the storefront currency tied to the visitor, while preserving a
     * manual currency choice for the rest of the session.
     *
     * Nigeria => NGN. Other locations => USD. The exchange rate is stored in
     * session and is later frozen onto a booking so checkout, payment,
     * reservation and receipt cannot drift if the live rate changes.
     */
    public function handle($request, Closure $next)
    {
        $settings = SystemSetting::first();

        if (! optional($settings)->allow_multi_currency) {
            $request->session()->forget([
                'rate',
                'switch',
                'currency_manual_selection',
                'currency_detected_ip',
                'userLocation',
                'country_name',
            ]);

            return $next($request);
        }

        $ip = $this->resolveVisitorIp($request);
        $position = $this->resolvePosition($request, $ip);
        $request->session()->put('country_name', optional($position)->countryName);

        // A direct currency selection is a user preference and must win over IP.
        $requestedCurrency = strtoupper(trim((string) $request->query('currency', '')));
        $requestedCurrency = strtok($requestedCurrency, '?');

        if ($requestedCurrency && $this->currencyExists($requestedCurrency)) {
            $this->applyCurrency($request, $requestedCurrency, $position, $ip);
            $request->session()->put('currency_manual_selection', true);

            return $next($request);
        }

        // Never overwrite an explicit choice with automatic IP detection.
        if (
            (bool) $request->session()->get('currency_manual_selection', false)
            && $request->session()->has('rate')
            && $request->session()->has('switch')
        ) {
            return $next($request);
        }

        // Do not call the location and exchange-rate services on every request.
        if (
            $request->session()->has('rate')
            && $request->session()->has('switch')
            && $request->session()->get('currency_detected_ip') === $ip
        ) {
            return $next($request);
        }

        $countryCode = strtoupper((string) (
            $request->header('CF-IPCountry')
            ?: optional($position)->countryCode
        ));
        $countryName = strtolower(trim((string) optional($position)->countryName));
        $isNigeria = $countryCode === 'NG' || $countryName === 'nigeria';

        $this->applyCurrency($request, $isNigeria ? 'NGN' : 'USD', $position, $ip);
        $request->session()->forget('currency_manual_selection');

        return $next($request);
    }

    /**
     * Prefer the original client address supplied by common trusted edge
     * proxies. This fixes currency detection when Laravel sees a private proxy
     * address instead of the visitor's public address.
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

        // On a developer machine request()->ip() is normally 127.0.0.1. In
        // that case only, resolve the machine's public IP so Nigeria can still
        // be tested locally. Never do this fallback in production because it
        // would detect the web server rather than the visitor.
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

    private function resolvePosition($request, $ip)
    {
        // Cloudflare already supplies an ISO country header when enabled. We
        // still run the existing Location package where possible for the
        // country name and non-Cloudflare deployments.
        if (! $this->isPublicIp($ip)) {
            return null;
        }

        try {
            return Location::get($ip) ?: null;
        } catch (\Throwable $exception) {
            report($exception);

            return null;
        }
    }

    private function isPublicIp($ip)
    {
        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) !== false;
    }

    private function currencyExists($code)
    {
        // Preserve USD/NGN even on an installation whose seed data is missing,
        // while allowing any other configured ISO currency in future.
        return in_array($code, ['USD', 'NGN'], true)
            || Currency::where('iso_code3', $code)->exists();
    }

    private function applyCurrency($request, $currencyCode, $position, $ip)
    {
        $currencyCode = strtoupper((string) $currencyCode);
        $currency = Currency::where('iso_code3', $currencyCode)->first();

        $fallbacks = [
            'NGN' => ['country' => 'Nigeria', 'symbol' => '₦'],
            'USD' => ['country' => 'United States', 'symbol' => '$'],
        ];
        $fallback = $fallbacks[$currencyCode] ?? [
            'country' => optional($position)->countryName ?: $currencyCode,
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
        $request->session()->put('currency_detected_ip', $ip);

        if ($position) {
            $request->session()->put('userLocation', json_encode($position));
        } else {
            $request->session()->forget('userLocation');
        }
    }
}
