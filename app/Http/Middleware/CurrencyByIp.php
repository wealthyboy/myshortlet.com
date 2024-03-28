<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\SystemSetting;
use App\Http\Helper;
use Stevebauman\Location\Facades\Location;




class CurrencyByIp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $rate = [];

        $position = '';

        $position = Location::get(request()->ip());

        $settings = SystemSetting::first();

        if ($settings->allow_multi_currency) {


            $request->session()->forget(['userLocation', 'rate']);


            if ($request->session()->has('switch')) {
                return $next($request);
            }






            if ($request->session()->has('userLocation')) {

                $user_location =  json_decode(session('userLocation'));
                try {
                    if ($user_location && $user_location->ip !== request()->ip()) {
                        $position = Location::get(request()->ip());
                        $country = Currency::where('country', $position->countryName)->first();

                        $rate = null;
                        if ($position->countryName === 'Nigeria') {
                            $rate = ['rate' => 1, 'country' => $position->countryName, 'code' => $country->iso_code3,  'symbol' => $country->symbol];
                        } else {
                            $country = Currency::where('country', 'United States')->first();
                            $rate = ['rate' => optional($country->rate)->rate, 'country' => $country->name, 'symbol' => $country->symbol];
                        }

                        $request->session()->put('rate', json_encode(collect($rate)));
                        $request->session()->put('userLocation',  json_encode($position));
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            } else {

                try {
                    $position = Location::get(request()->ip());
                    $country = Currency::where('country', $position->countryName)->first();

                    $rate = null;
                    if ($position->countryName === 'Nigeria') {
                        $rate = ['rate' => 1, 'country' => $position->countryName, 'code' => $country->iso_code3,  'symbol' => $country->symbol];
                    } else {
                        $country = Currency::where('country', 'United States')->first();
                        $rate = ['rate' => optional($country->rate)->rate, 'country' => $country->name, 'symbol' => $country->symbol];
                    }

                    $request->session()->put('rate', json_encode(collect($rate)));
                    $request->session()->put('userLocation',  json_encode($position));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        } else {
            $request->session()->forget(['switch', 'rate']);
        }



        return $next($request);
    }
}
