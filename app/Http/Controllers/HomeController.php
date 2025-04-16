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
use App\Models\PriceChanged;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\PeakPeriod;
use App\Models\UserTracking;

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

        if ($request->check) {
            dd(
                $latestTrackings = UserTracking::latest()->take(4)->get()
            );
        }

        $user = User::create([
            'name' => 'Jacob Atam', // Assuming there's a name field
            'email' => 'jacob.atam@gmail.com',
            'password' => Hash::make('11223344'), // Hashing the password for security
        ]);

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



    public  static function generateThumbnailUrl($originalUrl)
    {
        // Extract the ID from the original URL using regular expressions
        preg_match('/\/file\/d\/(.+?)\//', $originalUrl, $matches);
        $id = $matches[1];

        // Construct the thumbnail URL
        $thumbnailUrl = "https://drive.google.com/thumbnail?id={$id}&sz=w2000";

        return $thumbnailUrl;
    }

    public  function images()
    {

        return [

            'sliders' => [
                'https://drive.google.com/file/d/17jMj4PYxnUgEa37VTw513F61Tk3WTi8a/view?usp=drive_link',
                'https://drive.google.com/file/d/1xe9lnx6RfmSpQSp_r9tSOWwV1RNmMBxY/view?usp=drive_link',
                'https://drive.google.com/file/d/196b5oHxzd5YSpldGMgzbviAeaZhJ5PB1/view?usp=drive_link',
                'https://drive.google.com/file/d/1cKLITs8-hXEqNqwWE_8BUpO1gXKJryRL/view?usp=drive_link',
                'https://drive.google.com/file/d/1R3qBwhzOU479zhtMiPxtx8sPUp4iqoMe/view?usp=drive_link',
                'https://drive.google.com/file/d/16XtNpeqCSoiPVZ4KhTRb0rq72tYosN3h/view?usp=drive_link',
                'https://drive.google.com/file/d/1Ob-RctxqUb6nmoBNl53V-vY6uSDGfY-W/view?usp=drive_link',
                'https://drive.google.com/file/d/1j0b9Hih3ozJgipUpJuAGjlENkuqndo2N/view?usp=drive_link',
                'https://drive.google.com/file/d/1C3EWAhlUIjKurP91K6fCLz5MnEFpet5c/view?usp=drive_link',
            ],

            'welcome' => [
                'https://drive.google.com/file/d/1ES6PROkjg09AnQdO2hn033mzg48dJT8S/view?usp=drive_link',
            ],
            'amenities' => [
                'https://drive.google.com/file/d/196b5oHxzd5YSpldGMgzbviAeaZhJ5PB1/view?usp=drive_link',
            ],
            'gallery' => [
                'https://drive.google.com/file/d/1Y1eaGKkZDXWkHORUQ9ID7OXAQOTTe4C_/view?usp=drive_link',
                'https://drive.google.com/file/d/1HuJi5if8Dhc7sahLf7KR5s6SFOJNpmh3/view?usp=drive_link',
                'https://drive.google.com/file/d/1prjVdTN-2iQ0VqXk974aeV9pChj56zRr/view?usp=drive_link',
                'https://drive.google.com/file/d/1v-7R-SfQsAzLb0zPzvfn147ViMVp-liJ/view?usp=drive_link',
                'https://drive.google.com/file/d/1VVLjDieMwBTHJBfcDb6lv7EOh1dHCnGW/view?usp=drive_link',
                'https://drive.google.com/file/d/1ZIlkG4pBMD8FycEtq0XLZ1jIllXA71qA/view?usp=drive_link',
                'https://drive.google.com/file/d/1EUI6dfkxfcyvdbKL_y0aZfT61sGXk6r7/view?usp=drive_link',
                'https://drive.google.com/file/d/1xe9lnx6RfmSpQSp_r9tSOWwV1RNmMBxY/view?usp=drive_link',
                'https://drive.google.com/file/d/19r4ddA9EBAlq7g37zN64N3Voz1tuglIm/view?usp=drive_link',
                'https://drive.google.com/file/d/1iVvVYIaeYqu8heqyUgSB1wkEWHettHEv/view?usp=drive_link',
            ]

        ];
    }








    public function home(Request $request)
    {
        $site_status = Live::first();
        $states = Location::where('location_type', 'state')->has('properties')->latest()->get();
        $cities = Location::where('location_type', 'city')->has('properties')->latest()->get();
        $featureds = Property::where('featured', true)->take(4)->get();
        $posts = Information::orderBy('created_at', 'DESC')->where('blog', true)->take(3)->get();
        $banners = Banner::where('type', 'banner')->orderBy('sort_order', 'asc')->get();
        $sliders = Banner::where('type', 'slider')->orderBy('sort_order', 'asc')->get();
        $property = Property::first();
        if ($request->check) {
            dd(
                $latestTrackings = UserTracking::latest()->take(4)->get()
            );
        }

        $date = explode("to", $request->check_in_checkout);
        $nights = '1 night';
        $sub_total = null;
        $ids = [];
        $areas = [];
        $restaurants = [];
        $saved =  null;
        $images = $this->images();
        $generator = new self;

        $safety_practices = [];
        $amenities = [];
        $peak_period = PeakPeriod::first();

        $peakPeriod = [
            'peak_period' => $peak_period,
            'peak_period_is_available' => $peak_period !== null ? true : false
        ];

        $bedrooms = [];
        $date = Helper::toAndFromDate($request->check_in_checkout);
        $data['max_children'] = $request->children ?? 0;
        $data['max_adults'] = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $start_date = !empty($date) ? $date['start_date'] : null;
        $end_date = !empty($date) ? $date['end_date'] : null;
        $nights = Helper::nights($date);
        $property_type = null;
        $apartments = Apartment::with('images',  'free_services', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent')
            ->where('apartments.property_id', '!=', null)
            ->where('apartments.max_adults', '>=',  $data['max_adults'])
            ->where('apartments.no_of_rooms', '>=', $data['rooms'])
            ->select('apartments.*')
            ->groupBy('apartments.id')
            ->take(4) // Limit to 4 results
            ->get();

        $date = $request->check_in_checkout;
        $days = 0;
        $filter = false;
        $saved =  auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];
        if (!optional($site_status)->make_live) {
            return view(
                'index',
                [
                    'apartments' => $apartments,
                    'sliders' => $sliders,
                    'banners' => $banners,
                    'states' => $states,
                    'posts' => $posts,
                    'featureds' => $featureds,
                    'cities' => $cities,
                    'saved' => $saved,
                    'property_type' => $property_type,
                    'date' => $date,
                    'saved' => $saved,
                    'sub_total' => $sub_total,
                    'property' => $property,
                    'days'  => $days,
                    'nights' => $nights,
                    'areas' => $areas,
                    'safety_practices' => $safety_practices,
                    'amenities' => $amenities,
                    'bedrooms' => $bedrooms,
                    'restaurants'  => $restaurants,
                    'images'  => $images,
                    'generator' => $generator,
                    'filter' => $filter,
                ]
            );
        } else {
            //Show site if admin is logged in
            if (auth()->check()  && auth()->user()->isAdmin()) {
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
                    'images',
                    'generator',
                    'days',
                    'nights',
                    'areas',
                    'safety_practices',
                    'amenities',
                    'bedrooms',
                    'restaurants',
                    'filter'
                ));
            }
            return view('underconstruction.index');
        }
    }
}
