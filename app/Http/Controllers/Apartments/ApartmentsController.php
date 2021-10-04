<?php

namespace App\Http\Controllers\Apartments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\SystemSetting;
use App\Models\Attribute;
use App\Http\Helper;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\PropertyFilter\AttributesFilter;
use  Illuminate\Support\Str;
use Carbon\Carbon;
use App\Http\Resources\PropertyLists;






class ApartmentsController extends Controller
{   

    public $settings;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Location $location)
    {   

        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];
        $str =new  Str;
        $date = $request->check_in_checkout;
        $property_is_not_available = null;

        $cites = [];

        $attributes = $location->attributes->groupBy('type'); 
        $page_title = implode(" ",explode('-',$location->slug));
        $breadcrumb = $location->name; 
        $saved =  $this->saved();

        $properties = Property::where('allow',true)->whereHas('locations',function(Builder  $builder) use ($location){
            $builder->where('locations.slug',$location->slug);
        })
        ->filter($request,  $this->getFilters($attributes))
        ->latest()->paginate(3);
        $properties->appends(request()->all());
        if( $request->ajax() ) { 
            return PropertyLists::collection(
                $properties
            )->additional(['attributes' => $attributes]);
        }
        $next_page= [];

        $next_page[] = $properties->nextPageUrl();

        return  view('apartments.index',compact(
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



    public function getFilters($attributes)
    {
        $filters = [];
        foreach ($attributes as $key => $attribute){
            foreach ($attribute as $attr){
               $filters[$attr->slug] = AttributesFilter::class;
            }
        }

        return $filters;
    }
    
    public function checkAvailability(Request $request)
    {   
        $property = Property::find($request->property_id);
        $avalability = Reservation::whereIn('id', [1, 2, 3]);
    }


    public function search(Request $request)
    {   

        $date = explode("to",$request->check_in_checkout);
        $property_is_not_available = null;


        $data = [];
        $attributes = null;
        $data['location']     =  $request->going_to;
        $data['max_children'] = $request->no_of_children ?? 1;
        $data['max_adults']   = $request->no_of_adults ?? 1;
        $data['rooms'] = $request->rooms;
        $cities        = Property::where('location_full_name','like','%' .$data['location']. '%')->get();
        $properties = null;
        $location = null;


        if ($cities->count() !== 0) {

            $cities = $cities->first();
            $attributes = $cities->attributes()->where('type','!=','apartment_facilities')->get()->groupBy('type'); 
            $location = optional($cities->locations()->where('locations.name','like','%' .$data['location']. '%'))->first();
            if ($location){
               $location->load('children');
            }


            $properties = Property::whereHas('locations',function($query) use ($data){
                $query->where('locations.name','like','%' .$data['location']. '%');
            })->orWhereHas('apartments', function( $query ) use ( $data ){
                $query->where('apartments.max_adults', '<=',  $data['max_children']);
                $query->where('apartments.max_children', '<=', $data['max_adults'] );
                $query->where('apartments.no_of_rooms', '<=', $data['rooms'] );
            })->filter($request,  $this->getFilters($attributes))->latest()->paginate(5);
            $properties->appends(request()->all());
            if( $request->ajax() ) { 
                return  PropertyLists::collection(
                    $properties
                )->additional(['attributes' => $attributes]);
            }
            
        }

        if( $request->ajax() ) { 
            return response()->json([
                "data" => []
            ],200);
        }

        

        


        $breadcrumb = $request->name; 
        $page_title = $request->name; 
        $str        =    new  Str;
        $saved =  $this->saved();

        

        $date = $request->check_in_checkout;
        $next_page= [];

        $next_page[] = $properties->nextPageUrl();


        return  view('apartments.index',compact(
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


    public function saved(){
       return   auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Property $property)
    {   
        $date  = explode("to",$request->check_in_checkout);
       // dd($from = date('2018-01-01')    );
        $property_is_not_available = null;
        $nights = '1 night';
        $sub_total = null;
        $days = null;
        $ids = $property->apartments->pluck('id')->toArray();
        $areas= $property->areas; 
        $safety_practices = $property->safety_practicies;
        $amenities = $property->apartment_facilities->groupBy('parent.name');
        $property_type = $property->type == 'single' ?  $property->single_room : $property->multiple_rooms[0];
        $bedrooms = $property_type->bedrooms->groupBy('parent.name');

        $days = 1;
        if ($request->check_in_checkout && !empty($date)) {
            $date1 = trim($date[0]);
            $date2 = trim($date[1]);
            $data  = [];
            $start_date = Carbon::createFromDate($date1);
            $end_date = Carbon::createFromDate($date2);
            
            $property_is_not_available = Reservation::whereIn('apartment_id', $ids)
                                                       ->whereDate('checkin', '<=', $start_date)
                                                        ->whereDate('checkout', '>=', $end_date)
                                                       ->pluck('apartment_id')->toArray();

              
            $days   = $start_date->diffInDays($end_date);
            $nights   = $days == 1 ? "1 night" : $days." nights";
        }
        //dd($property_is_not_available);
        $saved =  $this->saved();
        $date = $request->check_in_checkout;
        return view('apartments.show',
                   compact(
                    'property_type',
                    'property_is_not_available',
                    'date',
                    'saved',
                    'sub_total',
                    'property',
                    'days',
                    'nights',
                    'areas',
                    'safety_practices',
                    'amenities',
                    'bedrooms'
                ));
    }
   
}
