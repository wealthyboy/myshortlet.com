@php
    $serverCurrencyCode = strtoupper((string) (\App\Http\Helper::getIsoCode() ?: 'USD'));
    $serverBrowserCountryCode = strtoupper((string) session('currency_browser_country_code', ''));
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
    var serverBrowserCountry = @json($serverBrowserCountryCode);
    var syncUrl = @json(route('currency.location'));
    var cacheKey = 'avm_browser_country_v3';
    var reloadKey = 'avm_currency_reload_v3';
    var refreshParam = '_currency_refresh';
    var cacheLifetime = 5 * 60 * 1000;

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
        // Always try a live browser-side IP lookup first. This is intentional:
        // turning a VPN on/off or changing VPN country must be reflected on the
        // next page load rather than being pinned to an old NGN/USD session.
        try {
            var locationResponse = await fetch('https://ipwho.is/', {
                cache: 'no-store',
                credentials: 'omit',
                mode: 'cors'
            });

            if (locationResponse.ok) {
                var location = await locationResponse.json();
                var countryCode = String(location.country_code || '').trim().toUpperCase();
                if (location.success !== false && validCountryCode(countryCode)) {
                    cacheCountry(countryCode);
                    return countryCode;
                }
            }
        } catch (error) {
            // Try the second provider below.
        }

        try {
            var countryResponse = await fetch('https://ipapi.co/country/', {
                cache: 'no-store',
                credentials: 'omit',
                mode: 'cors'
            });

            if (countryResponse.ok) {
                var fallbackCode = (await countryResponse.text()).trim().toUpperCase();
                if (validCountryCode(fallbackCode)) {
                    cacheCountry(fallbackCode);
                    return fallbackCode;
                }
            }
        } catch (error) {
            // Use the short browser cache only if both live lookups fail.
        }

        return readCachedCountry();
    }

    async function syncCountry(countryCode) {
        if (!validCountryCode(countryCode)) {
            return;
        }

        countryCode = countryCode.trim().toUpperCase();
        var desiredCurrency = countryCode === 'NG' ? 'NGN' : 'USD';

        // Even when the rendered currency is already correct, update Laravel
        // if the browser country changed. This clears stale NGN state after a
        // VPN switches to another country (and vice versa).
        if (currentCurrency === desiredCurrency && serverBrowserCountry === countryCode) {
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

            serverBrowserCountry = countryCode;

            // Reload only when the visible currency has to change. If only the
            // stored browser country needed refreshing, no reload is necessary.
            if (currentCurrency === desiredCurrency) {
                try {
                    sessionStorage.removeItem(reloadKey);
                } catch (error) {}
                return;
            }

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
    // server has rendered the expected currency.
    try {
        var cleanUrl = new URL(window.location.href);
        if (cleanUrl.searchParams.has(refreshParam)) {
            cleanUrl.searchParams.delete(refreshParam);
            window.history.replaceState({}, document.title, cleanUrl.toString());
        }
    } catch (error) {}

    detectCountry().then(syncCountry);
})();
</script>
