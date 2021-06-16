<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Live;
use App\Models\Location;
use App\Models\Information;
use App\Models\Apartment;

use App\Models\Currency;
use App\Models\SystemSetting;
use App\Models\Http\Helper;


class HomeController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {    
        $site_status = Live::first();

        if (!$site_status->make_live ) {
            return view('index'); 
        } else {
            //Show site if admin is logged in
            if ( auth()->check()  && auth()->user()->isAdmin()){
                return view('index'); 
            }
            return view('underconstruction.index');
        }
    }




    public function home()
    {
        $site_status = Live::first();
        $states      = Location::where('location_type', 'state')->has('apartments')->latest()->get();
        $featureds   = Apartment::where('featured',true)->skip(1)->take(10)->get();
        $featured    = Apartment::where('featured',true)->first();
        $posts       = Information::orderBy('created_at','DESC')->where('blog',true)->take(3)->get();

        $currencies = array(
            array('id' => '19','created_at' => '2020-02-15 11:02:16','updated_at' => '2020-02-15 11:02:16','country' => 'Australian','symbol' => '$','iso_code2' => NULL,'iso_code3' => 'AUD'),
            array('id' => '20','created_at' => '2020-02-15 11:02:16','updated_at' => '2020-02-15 11:02:16','country' => 'Nigeria','symbol' => '₦','iso_code2' => NULL,'iso_code3' => 'NGR'),
            array('id' => '21','created_at' => '2020-02-15 11:02:16','updated_at' => '2020-02-15 11:02:16','country' => 'United States','symbol' => '$','iso_code2' => NULL,'iso_code3' => 'USD'),
            array('id' => '22','created_at' => '2020-02-15 11:02:16','updated_at' => '2020-02-15 11:02:16','country' => 'Europe','symbol' => '€','iso_code2' => NULL,'iso_code3' => 'EUR'),
            array('id' => '23','created_at' => '2020-02-15 11:02:16','updated_at' => '2020-02-15 11:02:16','country' => 'United Kingdom','symbol' => '£','iso_code2' => NULL,'iso_code3' => 'GBP')
        );

        foreach (array_shift($currencies) as $currency ) {
            $currency            = new Currency;
            $currency->country   = $currency['country'];
            $currency->symbol    = $currency['symbol'];
            $currency->iso_code2 = $currency['iso_code2'];
            $currency->iso_code3 = $currency['iso_code3'];
            $currency->save();
        }
          
        return view('index',compact('states','posts','featureds','featured')); 
    }




    
}
