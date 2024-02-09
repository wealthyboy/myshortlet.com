<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Live;
use App\Models\Location;
use App\Models\Information;
use App\Models\Property;

use App\Models\Currency;
use App\Models\Banner;

use App\Models\SystemSetting;
use App\Http\Helper;
use App\Models\Apartment;
use App\Models\User;

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
        $banners =  Banner::banners()->get();



        if (!$site_status->make_live) {
            return view('index', compact(
                'banners',

            ));
        } else {
            //Show site if admin is logged in
            if (auth()->check()  && auth()->user()->isAdmin()) {
                return view('index', compact('banners'));
            }
            return view('underconstruction.index');
        }
    }




    public function home(Request $request)
    {
        $site_status = Live::first();
        // $user  = User::where('email', 'jacob.atam@gmail.com')->first();
        // $user->password = bcrypt('11223344');
        // $user->save();
        $states = Location::where('location_type', 'state')->has('properties')->latest()->get();
        $cities = Location::where('location_type', 'city')->has('properties')->latest()->get();
        $featureds = Property::where('featured', true)->take(4)->get();
        $posts = Information::orderBy('created_at', 'DESC')->where('blog', true)->take(3)->get();
        $banners = Banner::where('type', 'banner')->orderBy('sort_order', 'asc')->get();
        $sliders = Banner::where('type', 'slider')->orderBy('sort_order', 'asc')->get();
        $property = null;

        $date  = explode("to", $request->check_in_checkout);
        $nights = '1 night';
        $sub_total = null;
        $ids = [];
        $areas = [];
        $restaurants = [];
        $saved =  null;

        $safety_practices = [];
        $amenities = [];

        $bedrooms = [];
        $date = Helper::toAndFromDate($request->check_in_checkout);
        $data['max_children'] = $request->children ?? 0;
        $data['max_adults'] = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $start_date = !empty($date) ? $date['start_date'] : null;
        $end_date = !empty($date) ? $date['end_date'] : null;
        $nights = Helper::nights($date);
        $property_type = null;
        $apartments = Apartment::where('apartments.property_id', '!=', null)
            ->where('apartments.max_adults', '>=',  $data['max_adults'])
            ->where('apartments.max_children', '>=', $data['max_children'])
            ->where('apartments.no_of_rooms', '>=', $data['rooms'])
            ->select('apartments.*')
            ->groupBy('apartments.id')
            ->get();
        $apartments->load('images', 'free_services', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent');
        $date = $request->check_in_checkout;
        $days = 0;


        $saved =  auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];
        if (!optional($site_status)->make_live) {
            return view('index', compact(
                'sliders',
                'banners',
                'states',
                'posts',
                'featureds',
                'cities',
                'saved',
                'apartments',
                'property_type',
                'date',
                'saved',
                'sub_total',
                'property',
                'days',
                'nights',
                'areas',
                'safety_practices',
                'amenities',
                'bedrooms',
                'restaurants',
            ));
        } else {
            //Show site if admin is logged in
            if (auth()->check()  && auth()->user()->isAdmin()) {
                return view('index', compact('sliders', 'banners', 'states', 'posts', 'featureds', 'cities', 'saved'));
            }
            return view('underconstruction.index');
        }
    }
}
