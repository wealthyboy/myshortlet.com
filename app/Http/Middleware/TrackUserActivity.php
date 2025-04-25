<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserTracking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;


class TrackUserActivity
{
    public function handle(Request $request, Closure $next)
    {

        $response = $next($request);
        $sessionId = session()->getId();
        $path = $request->fullUrl();



        UserTracking::updateOrInsert(
            ['session_id' => $sessionId,  'page_url' => $path],
            [
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'referer' => $request->headers->get('referer'),

                'user_id' => optional(auth()->user())->id,
                'visited_at' => now(),
                'method' => $request->method(),
                'apartment_id' =>  $request->routeIs('apartments.show') ? optional($request->route('apartment'))->id : null,
                'ip_address' => $request->ip(),
                'action' => $request->getQueryString() ? 'search' : "viewed",
                'time_spent' =>  now(),
                'page_url' => $request->fullUrl(),
                'visited_at' =>  now(),
            ]
        );

        if (!Session::has('tracking_id')) {
            $last_id = UserTracking::latest('id')->value('id');

            if ($last_id) {
                Session::put('tracking_id', $last_id);
            }
        }

        return $response;
    }
}
