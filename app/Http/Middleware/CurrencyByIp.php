<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Currency;
use App\Models\CurrencyRate;
use App\Models\SystemSetting;
use App\Http\Helper;
use Stevebauman\Location\Facades\Location;
use Carbon\Carbon;
use App\Models\PriceChanged;
use App\Models\Apartment;
use App\Models\PeakPeriod;


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
        $request->session()->put('country_name', optional($position)->countryName);

        $settings = SystemSetting::first();
        $nigeria = Currency::where('country', 'Nigeria')->first();
        $usa = Currency::where('country', 'United States')->first();
        $position = Location::get(request()->ip());
        $query = request()->all();
        $currentDate = Carbon::now();
        $startDate = Carbon::createFromDate(null, 12, 1); // December 1
        $endDate = Carbon::createFromDate(null, 12, 31); // December 31
        $peak_period = PeakPeriod::first();


        $exchaange_rate = Helper::getCurrencyExchangeRate();

        if (null !==  $peak_period) {
            if ($currentDate->between($peak_period->start_date, $peak_period->end_date)) {
                Helper::updateApartmentPrices($peak_period->start_date, $peak_period->end_date, $peak_period->discount);
                $price_update = new PriceChanged;
                $price_update->is_updated = 1;
                $price_update->save();
            } else {
                $price_update = PriceChanged::first();
                if (null !== $price_update && $price_update->is_updated === true) {
                    $yesterday = Carbon::yesterday();
                    if ($yesterday->eq(Carbon::parse($peak_period->end_date))) {
                        Helper::reverseApartmentPrices($peak_period->discount);
                    }

                    $price_update = PriceChanged::first();
                    $price_update->is_updated = 0;
                    $price_update->save();
                }
            }
        }



        // dd($usa->load('rate'));
        if (optional($settings)->allow_multi_currency) {

            if (isset($query['currency']) && strtok($query['currency'], '?') === 'USD') {
                $rate = ['rate' => 1, 'country' => $usa->country, 'code' => $usa->iso_code3, 'symbol' => $usa->symbol];
                $request->session()->put('rate', json_encode(collect($rate)));
                $request->session()->put('switch', 'USD');
                return $next($request);
            }

            if (isset($query['currency']) && strtok($query['currency'], '?')  === 'NGN') {
                $rate = ['rate' => $exchaange_rate, 'country' => 'Nigeria', 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                $request->session()->put('rate', json_encode(collect($rate)));
                $request->session()->put('userLocation',  json_encode($position));
                return $next($request);
            }



            if ($request->session()->has('userLocation')) {

                if ($request->session()->has('switch') && empty($query)) {
                    return $next($request);
                }

                $user_location = json_decode(session('userLocation'));

                try {

                    $country = Currency::where('country', $position->countryName)->first();
                    $rate = null;

                    if ($position->countryName === 'Nigeria') {
                        $rate = ['rate' => $exchaange_rate, 'country' => $position->countryName, 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                        $request->session()->put('switch', 'NGN');
                    } else {
                        $rate = ['rate' => 1, 'country' => $usa->country, 'symbol' => $usa->symbol];
                        $request->session()->put('switch', 'USD');
                    }
                    $request->session()->put('rate', json_encode(collect($rate)));
                    $request->session()->put('userLocation',  json_encode($position));


                    if ($user_location && $user_location->ip !== request()->ip()) {
                        $country = Currency::where('country', $position->countryName)->first();
                        $rate = null;
                        if ($position->countryName === 'Nigeria') {
                            $rate = ['rate' => $exchaange_rate, 'country' => $position->countryName, 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                            $request->session()->put('switch', 'NGN');
                        } else {
                            $rate = ['rate' => 1, 'country' => $usa->country, 'symbol' => $usa->symbol];
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
                        $rate = ['rate' => $exchaange_rate, 'country' => $position->countryName, 'code' => $country->iso_code3,  'symbol' => $country->symbol];
                        $request->session()->put('switch', 'NGN');
                    } else {
                        $country = Currency::where('country', 'United States')->first();
                        $rate = ['rate' => 1, 'country' => $country->name, 'symbol' => $country->symbol];
                        $request->session()->put('switch', 'USD');
                    }

                    $request->session()->put('rate', json_encode(collect($rate)));
                    $request->session()->put('userLocation',  json_encode($position));
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        } else {

            // $request->session()->put('switch', 'NGN');
            $request->session()->forget(['rate']);
        }



        return $next($request);
    }
}
