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
        $currentDate = Carbon::now();
        $startDate = Carbon::createFromDate(null, 12, 1); // December 1
        $endDate = Carbon::createFromDate(null, 12, 31); // December 31
        $price_update = PriceChanged::first();

        if (null === $price_update && $currentDate->between($startDate, $endDate)) {
            Apartment::where('price', '>', 0)
                ->update(['price' => \DB::raw('price * 1.40')]);
            PriceChanged::update(['is_updated' => true]);
        }

        if (null !== $price_update && $price_update->is_updated) {
             if ($currentDate->isAfter($endDate)) {
                Apartment::where('price', '>', 0) 
                    ->update(['price' => \DB::raw('price / 1.40')]);
                    PriceChanged::update([
                        'is_updated' => 0
                    ]);
            } 
        }
   


       // dd($usa->load('rate'));
        if (optional($settings)->allow_multi_currency) {


            if (isset($query['currency']) && $query['currency'] === 'USD') {
                $rate = ['rate' => 1, 'country' => $usa->name, 'code' => $nigeria->iso_code3, 'symbol' => $usa->symbol];
                $request->session()->put('rate', json_encode(collect($rate)));
                $request->session()->put('switch', 'USD');
                dd(session('rate'), json_decode(session('userLocation')), 1);

                return $next($request);
            }

            if (isset($query['currency']) && $query['currency'] === 'NGN') {
                $rate = ['rate' => 1700, 'country' => 'Nigeria', 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                $request->session()->put('rate', json_encode(collect($rate)));
                $request->session()->put('switch', 'NGN');
                dd(session('rate'), json_decode(session('userLocation')), 2);

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
                            $rate = ['rate' => 1700, 'country' => $position->countryName, 'code' => $nigeria->iso_code3,  'symbol' => $nigeria->symbol];
                            $request->session()->put('switch', 'NGN');
                        } else {
                            $rate = ['rate' => 1, 'country' => $usa->name, 'symbol' => $usa->symbol];
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
                        $rate = ['rate' => 1700, 'country' => $position->countryName, 'code' => $country->iso_code3,  'symbol' => $country->symbol];
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
            dd(session('rate'), json_decode(session('userLocation')), 1);

           // $request->session()->put('switch', 'NGN');
            $request->session()->forget(['rate']);
        }



        return $next($request);
    }
}
