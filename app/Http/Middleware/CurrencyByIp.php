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
        $nigeria = Currency::where('country', 'Nigeria')->first();
        $usa = Currency::where('country', 'United States')->first();
        $position = Location::get(request()->ip());
        $query = request()->all();


        if ($settings->allow_multi_currency) {



            if (isset($query['currency']) && $query['currency'] === 'USD') {
                $rate = ['rate' => optional($usa->rate)->rate, 'country' => $usa->name, 'code' => $nigeria->iso_code3, 'symbol' => $usa->symbol];
                $request->session()->put('rate', json_encode(collect($rate)));
                $request->session()->put('switch', 'USD');
                return $next($request);
            }

            if (isset($query['currency']) && $query['currency'] === 'NGN') {
                $rate = ['rate' => 1, 'country' => 'Nigeria', 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                $request->session()->put('rate', json_encode(collect($rate)));
                $request->session()->put('switch', 'NGN');
                return $next($request);
            }


            if ($request->session()->has('userLocation')) {

                if ($request->session()->has('switch') && empty($query)) {
                    return $next($request);
                }

                $user_location = json_decode(session('userLocation'));
                try {
                    if ($user_location && $user_location->ip !== request()->ip()) {
                        $country = Currency::where('country', $position->countryName)->first();
                        $rate = null;
                        if ($position->countryName === 'Nigeria') {
                            $rate = ['rate' => 1, 'country' => $position->countryName, 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                            $request->session()->put('switch', 'NGN');
                        } else {
                            $rate = ['rate' => optional($usa->rate)->rate, 'country' => $usa->name, 'symbol' => $usa->symbol];
                            $request->session()->put('switch', 'USD');
                        }

                        $request->session()->put('rate', json_encode(collect($rate)));
                        $request->session()->put('userLocation',  json_encode($position));
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                }
            } else {

                try {
                    $country = Currency::where('country', $position->countryName)->first();
                    $rate = null;
                    if ($position->countryName === 'Nigeria') {
                        $rate = ['rate' => 1, 'country' => $position->countryName, 'code' => $country->iso_code3,  'symbol' => $country->symbol];
                        $request->session()->put('switch', 'NGN');
                    } else {
                        $country = Currency::where('country', 'United States')->first();
                        $rate = ['rate' => optional($country->rate)->rate, 'country' => $country->name, 'symbol' => $country->symbol];
                        $request->session()->put('switch', 'USD');
                    }

                    $request->session()->put('rate', json_encode(collect($rate)));
                    $request->session()->put('userLocation',  json_encode($position));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        } else {
            $request->session()->put('switch', 'NGN');
            $request->session()->forget(['rate']);
        }


        return $next($request);
    }
}
