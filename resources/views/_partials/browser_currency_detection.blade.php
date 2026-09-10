@php
    $serverCurrencyCode = strtoupper((string) (\App\Http\Helper::getIsoCode() ?: 'USD'));
    $manualCurrencySelection = (bool) session('currency_manual_selection', false);
@endphp

<script>
(function () {
    'use strict';

    // An explicit currency choice by the visitor still wins over automatic
    // location detection when the manual switcher is enabled.
    if (@json($manualCurrencySelection)) {
        return;
    }

    var currentCurrency = @json($serverCurrencyCode);
    var syncUrl = @json(route('currency.location'));
    var cacheKey = 'avm_browser_country_v2';
    var reloadKey = 'avm_currency_reload_v2';
    var refreshParam = '_currency_refresh';
    var cacheLifetime = 30 * 60 * 1000;

    function validCountryCode(value) {
        return typeof value === 'string' && /^[A-Z]{2}$/.test(value.trim().toUpperCase());
    }

    function readCachedCountry() {
        try {
            var cached = JSON.parse(localStorage.getItem(cacheKey) || 'null');
            if (
                cached &&
                validCountryCode(cached.code) &&
                Number(cached.savedAt || 0) >= Date.now() - cacheLifetime
            ) {
                return cached.code.trim().toUpperCase();
            }
        } catch (error) {
            // Storage can be unavailable in private/restricted browser modes.
        }

        return null;
    }

    function cacheCountry(code) {
        try {
            localStorage.setItem(cacheKey, JSON.stringify({
                code: code,
                savedAt: Date.now()
            }));
        } catch (error) {
            // Currency detection does not depend on browser storage.
        }
    }

    async function detectCountry() {
        var cached = readCachedCountry();
        if (cached) {
            return cached;
        }

        // This request is made by the visitor's browser, so ipapi sees the
        // visitor's public IP directly even when Laravel is behind a proxy.
        try {
            var countryResponse = await fetch('https://ipapi.co/country/', {
                cache: 'no-store',
                credentials: 'omit',
                mode: 'cors'
            });

            if (countryResponse.ok) {
                var countryCode = (await countryResponse.text()).trim().toUpperCase();
                if (validCountryCode(countryCode)) {
                    cacheCountry(countryCode);
                    return countryCode;
                }
            }
        } catch (error) {
            // Try the second provider below.
        }

        try {
            var fallbackResponse = await fetch('https://ipwho.is/', {
                cache: 'no-store',
                credentials: 'omit',
                mode: 'cors'
            });

            if (fallbackResponse.ok) {
                var location = await fallbackResponse.json();
                var fallbackCode = String(location.country_code || '').trim().toUpperCase();
                if (location.success !== false && validCountryCode(fallbackCode)) {
                    cacheCountry(fallbackCode);
                    return fallbackCode;
                }
            }
        } catch (error) {
            // Server-side CurrencyByIp remains the final fallback.
        }

        return null;
    }

    async function syncCountry(countryCode) {
        if (!validCountryCode(countryCode)) {
            return;
        }

        countryCode = countryCode.trim().toUpperCase();
        var desiredCurrency = countryCode === 'NG' ? 'NGN' : 'USD';

        if (currentCurrency === desiredCurrency) {
            try {
                sessionStorage.removeItem(reloadKey);
            } catch (error) {}
            return;
        }

        var csrf = document.querySelector('meta[name="csrf-token"]');
        if (!csrf || !csrf.content) {
            return;
        }

        try {
            var response = await fetch(syncUrl, {
                method: 'POST',
                credentials: 'same-origin',
                cache: 'no-store',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrf.content,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ country_code: countryCode })
            });

            if (!response.ok) {
                return;
            }

            var result = await response.json();
            if (String(result.currency || '').toUpperCase() !== desiredCurrency) {
                return;
            }

            // Reload exactly once so all server-rendered apartment objects are
            // serialized with the same currency. The cache-busting parameter
            // also prevents an intermediary from serving a previously cached
            // USD copy of the page to a Nigerian visitor.
            var alreadyReloaded = false;
            try {
                alreadyReloaded = sessionStorage.getItem(reloadKey) === desiredCurrency;
            } catch (error) {}

            if (!alreadyReloaded) {
                try {
                    sessionStorage.setItem(reloadKey, desiredCurrency);
                } catch (error) {}

                var url = new URL(window.location.href);
                url.searchParams.set(refreshParam, Date.now().toString());
                window.location.replace(url.toString());
            }
        } catch (error) {
            // Never break the booking page if the location helper is blocked.
        }
    }

    // Remove the internal cache-busting marker from the address bar after the
    // server has rendered the correct currency.
    try {
        var cleanUrl = new URL(window.location.href);
        if (cleanUrl.searchParams.has(refreshParam) && currentCurrency !== 'USD') {
            cleanUrl.searchParams.delete(refreshParam);
            window.history.replaceState({}, document.title, cleanUrl.toString());
        }
    } catch (error) {}

    detectCountry().then(syncCountry);
})();
</script>
