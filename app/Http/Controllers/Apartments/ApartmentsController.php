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
        $codes = Helper::phoneCodes();

        $date = $request->check_in_checkout;
        $property_is_not_available = null;

        $cites = [];

        $attributes = $location->attributes->groupBy('type'); 
        $page_title = implode(" ",explode('-',$location->slug));
        $properties = Property::where('allow',true)->whereHas('locations',function(Builder  $builder) use ($location){
                $builder->where('locations.slug',$location->slug);
            })->filter($request,  $this->getFilters($attributes))->latest()->paginate(5);
        $properties->appends(request()->all());
        $breadcrumb = $location->name; 
        $saved =  $this->saved();
        if( $request->ajax() ) { 
            $properties->load('facilities','single_room');

            return response()->json([
                'properties' => $properties->toArray(),
                'attributes' => $attributes->count()
            ]); 
        }

        return  view('apartments.index',compact(
            'location',
            'page_title',
            'breadcrumb',
            'properties',
            'attributes',
            'str',
            'saved',
            'codes',
            'date',
            'property_is_not_available'
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

        $date = explode("to",$request->date);
        $property_is_not_available = null;

        $data = [];
        $attributes = Attribute::parents()->get();
        $data['location']     =  $request->going_to;
        $data['max_children'] = $request->no_of_children ?? 1;
        $data['max_adults']   = $request->no_of_adults ?? 1;
        $data['rooms'] = $request->rooms;
        $cities        = Property::where('location_full_name','like','%' .$data['location']. '%')->first();

        $attributes = $cities->attributes()->where('type','!=','apartment_facilities')->get()->groupBy('type'); 
        $location = $cities->locations()->where('locations.name','like','%' .$data['location']. '%')->first();
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
        $breadcrumb = $request->name; 
        $page_title = $request->name; 
        $str        =    new  Str;
        $saved =  $this->saved();

        if( $request->ajax() ) { 
            return response()->json([
                'properties' => $properties->toArray(),
                'attributes' => $attributes->count()
            ]); 
        }

        $date = $request->check_in_checkout;

        return  view('apartments.index',compact(
            'location',
            'page_title',
            'breadcrumb',
            'properties',
            'attributes',
            'str',
            'saved',
            'date',
            'property_is_not_available'
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
        $date  = explode("-",$request->check_in_checkout);
        $property_is_not_available = null;
        $nights = '1 night';
        $sub_total = null;
        $days = null;
        $ids = $property->apartments->pluck('id')->toArray();
        $days = 1;
        if ($request->check_in_checkout && !empty($date)) {
            $date1 = trim($date[0]);
            $date2 = trim($date[1]);
            $data  = [];
            if ($date1 || $date2) {
                $date = Carbon::createFromDate($date1);
                $date2 = Carbon::createFromDate($date2);
            } 
            $property_is_not_available = Reservation::whereDate('checkout', '>=', $date )
            ->whereIn('apartment_id', $ids)
            ->orderBy('created_at','desc')->first();
            $days   = $date->diffInDays($date2);
            $nights   = $days == 1 ? "1 night" : $days." nights";
        }
        
        $saved =  $this->saved();
        $date = $request->check_in_checkout;
        return view('apartments.show',compact('property_is_not_available','date','saved','sub_total','property','days','nights'));
    }

    

    

   
}
