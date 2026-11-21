<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ClearAvailabilityState
{
    /**
     * Availability dates are useful only while a visitor is choosing an
     * apartment or completing a booking. Clear stale dates when they return
     * to the rest of the storefront so future visits begin with a blank
     * calendar.
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('get') && ! $this->shouldPreserveDates($request)) {
            $request->session()->forget('check_in_checkout');

            foreach (['check_in_checkout', 'checkin', 'checkout', 'searchParams'] as $cookie) {
                Cookie::queue(Cookie::forget($cookie));
            }
        }

        return $next($request);
    }

    private function shouldPreserveDates(Request $request): bool
    {
        // The selected range must survive the search-results page, property
        // detail page, checkout, and booking hand-off.
        if ($request->is('apartment/*') || $request->is('property/*')
            || $request->is('checkout/*') || $request->is('book/*')) {
            return true;
        }

        // A new availability search reaches /apartments with dates in the
        // query string. A plain return to /apartments deliberately clears it.
        return ($request->is('apartments*') || $request->is('properties/*'))
            && $request->filled('check_in_checkout');
    }
}
