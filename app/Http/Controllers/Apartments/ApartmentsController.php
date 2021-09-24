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

        $cites = [];

        $attributes = $location->attributes->groupBy('type'); 
        $page_title = implode(" ",explode('-',$location->slug));
        $properties = Property::where('allow',true)->whereHas('locations',function(Builder  $builder) use ($location){
                $builder->where('locations.slug',$location->slug);
            })->filter($request,$this->getFilters($attributes))->latest()->paginate(5);
        $properties->appends(request()->all());
        $breadcrumb = $location->name; 
        $saved =  auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];

        return  view('apartments.index',compact(
            'location',
            'page_title',
            'breadcrumb',
            'properties',
            'attributes',
            'str',
            'saved',
            'codes'
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

        //dd($request->all());
        $date = explode("to",$request->check_in_check_out);
        $data = [];
        $attributes = Attribute::parents()->get();
        $data['location'] =  $request->location;
        $data['max_children'] = $request->no_of_children ?? 1;
        $data['max_adults'] = $request->no_of_adults ?? 1;
        $data['rooms'] = $request->rooms;
        $properties = Property::whereHas('locations',function($query) use ($data){
            $query->where('locations.name','like','%' .$data['location']. '%');
        })->orWhereHas('apartments', function( $query ) use ( $data ){
            $query->where('apartments.max_adults', '<=',  $data['max_children']);
            $query->where('apartments.max_children', '<=', $data['max_adults'] );
            $query->where('apartments.no_of_rooms', '<=', $data['rooms'] );
            //$query->whereDate('available_from', '>=', $date);
        })->latest()->paginate(20);
        $properties->appends(request()->all());
        $breadcrumb = $request->name; 
        $page_title = $request->name; 
        $location = 'test'; 
        $str =new  Str;
        $saved =  auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];


        return  view('apartments.index',compact(
            'location',
            'page_title',
            'breadcrumb',
            'properties',
            'attributes',
            'str',
            'saved'
        ));
         
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Property $property)
    {    
        return view('apartments.show',compact('property'));
    }

    

    

   
}
