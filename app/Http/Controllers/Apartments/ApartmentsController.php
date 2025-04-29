<?php

namespace App\Http\Controllers\Apartments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Property;
use App\Models\Apartment;
use App\Models\Reservation;
use App\Models\SystemSetting;
use App\Models\Attribute;
use App\Http\Helper;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\PropertyFilter\AttributesFilter;
use  Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\PropertyLists;
use App\Http\Resources\ApartmentResource;







class ApartmentsController extends Controller
{

    public $settings;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apartments(Request $request)
    {
        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];


        $str = new Str;
        $date = $request->check_in_checkout;
        $property_is_not_available = null;
        $cites = [];
        $page_title =  "Book from our collection of Apartments | Avenue Montaigne";
        $page_meta_description = "All apartments  Avenue Montaigne";
        $date = explode("to", $request->check_in_checkout);
        $date = Helper::toAndFromDate($request->check_in_checkout);


        $property_is_not_available = null;
        $data = [];
        $attributes = null;
        $data['persons'] = $request->persons ?? 1;
        $data['rooms'] = $request->rooms ?? 2;
        $startDate = $date['start_date'];
        $endDate = $date['end_date'];
        $properties = null;
        $breadcrumb = null;

        $query = Apartment::query();

        if ($request->check_in_checkout) {
            // Check if apartment_id is present in the request
            if ($request->has('apartment_id')) {
                $apartmentId = $request->apartment_id;
                $query->where('id', $apartmentId)->get(); // Filter by the provided apartment ID
            }

            $query->whereDoesntHave('reservations', function ($q) use ($startDate, $endDate) {
                $q->where(function ($subQ) use ($startDate) {
                    $subQ->where('checkin', '<', $startDate)
                        ->where('checkout', '>', $startDate);
                });
            })
                ->where('apartments.max_adults', '>=',  $data['persons'])
                ->where('apartments.no_of_rooms', '>=', $data['rooms']);
        }


        if ($request->has('apartment_id')) {
            $apartments = $query->where('allow', 1)->latest()->first();
            return $apartments;
        }


        $apartments = $query->where('allow', 1)->latest()->get();
        $saved = null;
        $property = Property::first();
        $apartments->load('images', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent');


        if ($request->ajax()) {

            return PropertyLists::collection(
                $apartments
            )->additional(['attributes' => $attributes, 'params' => $request->all(), 'search' => false]);
        }

        $showResult = null;
        $apr = 0;

        if ($request->check_in_checkout && $apartments->count()) {
            $showResult = 1;
            $apartments[0]->showResult = 1;
            $apr = 1;
        }

        return  view('apartments.apartments', compact(
            'page_title',
            'breadcrumb',
            'str',
            'saved',
            'apartments',
            'property',
            'page_meta_description',
            'showResult',
            'apr'

        ));
    }


    public function index(Request $request, Location $location)
    {


        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];
        $str = new  Str;
        $date = $request->check_in_checkout;
        $property_is_not_available = null;
        $cites = [];

        $attributes = $location->attributes->groupBy('type');
        $page_title = implode(" ", explode('-', $location->slug));
        $breadcrumb = $location->name;
        $saved =  $this->saved();

        $properties = Property::where('allow', true)
            ->filter($request,  $this->getFilters($attributes))
            ->latest()->paginate(3);
        $properties->appends(request()->all());

        if ($request->ajax()) {
            return PropertyLists::collection(
                $properties

            )->additional(['attributes' => $attributes, 'search' => false]);
        }
        $next_page = [];

        $next_page[] = $properties->nextPageUrl();



        return  view('apartments.index', compact(
            'location',
            'page_title',
            'breadcrumb',
            'attributes',
            'str',
            'saved',
            'properties',
            'next_page'
        ));
    }

    public function apartmentsIndex(Request $request)
    {


        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];
        $str = new  Str;
        $date = $request->check_in_checkout;
        $property_is_not_available = null;
        $cites = [];

        $date = explode("to", $request->check_in_checkout);
        $date = Helper::toAndFromDate($request->check_in_checkout);

        $property_is_not_available = null;
        $data = [];
        $attributes = null;
        $data['persons'] = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $properties = null;


        $attributes = $location->attributes->groupBy('type');
        $page_title = implode(" ", explode('-', $location->slug));
        $breadcrumb = $location->name;
        $saved =  $this->saved();
        $locations = $location->children;
        $query = Property::where('allow', true)->whereHas('locations', function (Builder  $builder) use ($location, $date) {
            $builder->where('locations.slug', $location->slug);
        });


        if ($request->check_in_checkout) {
            $query->whereHas('apartments', function ($query) use ($data, $date) {
                $query->where('apartments.max_adults', '>=',  $data['persons']);
                $query->where('apartments.no_of_rooms', '>=', $data['rooms']);
            })
                ->select('reservations.id as reservation_id', 'reservations.quantity as reservation_qty', 'properties.*')
                ->leftJoin('reservations', function ($join) use ($date) {
                    $join->on('properties.id', '=', 'reservations.property_id')
                        ->whereDate('reservations.checkin', '<=', $date['start_date'])
                        ->whereDate('reservations.checkout', '>=', $date['end_date']);
                })

                ->filter($request,  $this->getFilters($attributes))
                ->groupBy('properties.id')
                ->latest()->paginate(5);
        }


        $properties = $query->filter($request, $this->getFilters($attributes))
            ->latest()->paginate(20);

        $properties  = $properties->appends(request()->all());
        $total = $properties->total();

        $properties->load('images');

        if ($request->ajax()) {

            return PropertyLists::collection(
                $properties
            )->additional(['attributes' => $attributes, 'search' => false]);
        }
        $next_page = [];

        $next_page[] = $properties->nextPageUrl();
        $properties->load('categories');

        return  view('apartments.index', compact(
            'location',
            'page_title',
            'breadcrumb',
            'attributes',
            'str',
            'saved',
            'properties',
            'next_page',
            'locations',
            'total'

        ));
    }

    public function location(Request $request, Location $location)
    {


        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];
        $str = new  Str;
        $date = $request->check_in_checkout;
        $property_is_not_available = null;
        $cites = [];

        $date = explode("to", $request->check_in_checkout);
        $date = Helper::toAndFromDate($request->check_in_checkout);

        $property_is_not_available = null;
        $data = [];
        $attributes = null;
        $data['max_children'] = $request->children ?? 1;
        $data['max_adults'] = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $properties = null;


        $attributes = $location->attributes->groupBy('type');
        $page_title = implode(" ", explode('-', $location->slug));
        $breadcrumb = $location->name;
        $saved =  $this->saved();
        $locations = $location->children;
        $query = Property::where('allow', true)->whereHas('locations', function (Builder  $builder) use ($location, $date) {
            $builder->where('locations.slug', $location->slug);
        });


        if ($request->check_in_checkout) {
            $query->whereHas('apartments', function ($query) use ($data, $date) {
                $query->where('apartments.max_adults', '>=',  $data['persons']);
                $query->where('apartments.no_of_rooms', '>=', $data['rooms']);
            })
                ->select('reservations.id as reservation_id', 'reservations.quantity as reservation_qty', 'properties.*')
                ->leftJoin('reservations', function ($join) use ($date) {
                    $join->on('properties.id', '=', 'reservations.property_id')
                        ->whereDate('reservations.checkin', '<=', $date['start_date'])
                        ->whereDate('reservations.checkout', '>=', $date['end_date']);
                })

                ->filter($request,  $this->getFilters($attributes))
                ->groupBy('properties.id')
                ->latest()->paginate(5);
        }


        $properties = $query->filter($request,  $this->getFilters($attributes))
            ->latest()->paginate(20);

        $properties  = $properties->appends(request()->all());
        $total = $properties->total();

        $properties->load('images');

        if ($request->ajax()) {
            return PropertyLists::collection(
                $properties
            )->additional(['attributes' => $attributes, 'search' => false]);
        }
        $next_page = [];

        $next_page[] = $properties->nextPageUrl();
        $properties->load('categories');


        return  view('apartments.index', compact(
            'location',
            'page_title',
            'breadcrumb',
            'attributes',
            'str',
            'saved',
            'properties',
            'next_page',
            'locations',
            'total'

        ));
    }

    public function getFilters($attributes)
    {
        $filters = [];
        foreach ($attributes as $key => $attribute) {
            foreach ($attribute as $attr) {
                $filters[$attr->slug] = AttributesFilter::class;
            }
        }

        return $filters;
    }

    public function checkAvailability(Request $request)
    {
        $property = Property::find($request->property_id);
        $date = Helper::toAndFromDate($request->check_in_checkout);

        if (count($date) == 2) {
            $apartmentIds = $property->apartments->pluck('id')->toArray();
            $property_is_not_available = null;
            $days = 0;
            $stays = null;
            $data['max_children'] = $request->children ?? 0;
            $data['max_adults']   = $request->adults ?? 1;
            $data['rooms'] = $request->rooms ?? 1;
            $startDate = $date['start_date'];
            $endDate = $date['end_date'];
            $nights = Helper::nights($date);
            $availableApartments = Apartment::whereIn('id', $apartmentIds)
                ->whereDoesntHave('reservations', function ($query) use ($startDate, $endDate) {
                    $query->where(function ($q) use ($startDate, $endDate) {
                        $q->where('checkin', '<', $endDate)
                            ->where('checkout', '>', $startDate);
                    });
                })
                ->where('apartments.max_adults', '>=',  $data['persons'])
                ->where('apartments.no_of_rooms', '>=', $data['rooms'])
                ->get();

            if ($request->ajax()) {
                return response()->json([
                    "data" => $availableApartments->load('images', 'free_services', 'bedrooms', 'bedrooms.parent', 'property'),
                    "nights" => $nights,
                ], 200);
            }
        }


        return response()->json([
            "data" => [],
            "nights" => [],
        ], 200);
    }


    public function search(Request $request)
    {

        $date = explode("to", $request->check_in_checkout);
        $property_is_not_available = null;
        $data = [];
        $attributes = null;
        $data['location'] = 'lagos';
        $data['max_adults'] = $request->persons ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $cities = Property::where('location_full_name', 'like', '%' . $data['location'] . '%')->get();
        $properties = null;
        $location = null;

        if ($cities->count() !== 0) {

            if ($request->check_in_checkout && !empty($date)) {
                $date1 = trim($date[0]);
                $date2 = trim($date[1]);
                $start_date = Carbon::createFromDate($date1);
                $end_date = Carbon::createFromDate($date2);
            }
            $cities = $cities->first();
            $attributes = $cities->attributes()->where('type', '!=', 'apartment_facilities')->get()->groupBy('type');
            $location = optional($cities->locations()->where('locations.name', 'like', '%' . $data['location'] . '%'))->first();
            if ($location) {
                $location->load('children');
            }
            $properties = Property::whereHas('locations', function ($query) use ($data) {
                $query->where('locations.name', 'like', '%' . $data['location'] . '%');
            })->whereHas('apartments', function ($query) use ($data) {
                $query->where('apartments.max_adults', '>=',  $data['persons']);
                $query->where('apartments.no_of_rooms', '>=', $data['rooms']);
            })
                ->select('reservations.id as reservation_id', 'reservations.quantity as reservation_qty', 'properties.*')
                ->leftJoin('reservations', function ($join) use ($start_date, $end_date) {
                    $join->on('properties.id', '=', 'reservations.property_id')
                        ->whereDate('reservations.checkin', '<=', $start_date)
                        ->whereDate('reservations.checkout', '>=', $end_date);
                })

                ->filter($request,  $this->getFilters($attributes))
                ->groupBy('properties.id')
                ->latest()->paginate(5);
            $properties->appends(request()->all());
            if ($request->ajax()) {
                return  PropertyLists::collection(
                    $properties
                )->additional(['attributes' => $attributes, 'search' => true]);
            }
        }

        if ($request->ajax()) {
            return response()->json([
                "data" => []
            ], 200);
        }
        $breadcrumb = $request->name;
        $page_title = $request->name;
        $str  =  new  Str;
        $saved =  $this->saved();
        $date = $request->check_in_checkout;
        $next_page = [];
        $next_page[] = $properties->nextPageUrl();
        return  view('apartments.index', compact(
            'location',
            'page_title',
            'breadcrumb',
            'properties',
            'attributes',
            'str',
            'saved',
            'date',
            'property_is_not_available',
            'next_page'
        ));
    }


    public function saved()
    {
        return auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Apartment $apartment)
    {

        $apartment->load('images', 'free_services', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent');

        $date  = explode("to", $request->check_in_checkout);
        $nights = '1 night';
        $sub_total = null;
        $ids = $apartment->property->apartments->pluck('id')->toArray();
        $areas = $apartment->property->areas;
        $restaurants = $apartment->property->restaurants;
        $safety_practices = $apartment->property->safety_practicies;
        $amenities = $apartment->property->apartment_facilities->groupBy('parent.name');
        $property_type = "single";
        $bedrooms = "";
        $days = 0;
        $property = $apartment->property;
        $date = Helper::toAndFromDate($request->check_in_checkout);
        $data['max_children'] = $request->children ?? 0;
        $data['max_adults']   = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $start_date = !empty($date) ?  $date['start_date'] : null;
        $end_date = !empty($date) ? $date['end_date'] : null;
        $nights = Helper::nights($date);

        return view(
            'apartments.show',
            compact(
                'apartment',
                'property'
            )
        );
    }
}
