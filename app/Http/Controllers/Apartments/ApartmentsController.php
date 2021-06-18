<?php

namespace App\Http\Controllers\Apartments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Apartment;
use App\Models\SystemSetting;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\ApartmentFilter\AttributesFilter;




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
        $attributes = Attribute::parents()->get();
        $page_title = implode(" ",explode('-',$location->slug));
        $apartments = Apartment::whereHas('locations',function(Builder  $builder) use ($location){
                $builder->where('locations.slug',$location->slug);
            })->filter($request,$this->getFilters($attributes))->latest()->paginate(20);
        $apartments->appends(request()->all());
        $breadcrumb = $location->name; 
        return  view('apartments.index',compact(
            'location',
            'page_title',
            'breadcrumb',
            'apartments',
            'attributes'
        )); 
    }



    public function getFilters($attributes)
    {
        $filters = [];
        foreach ($attributes as $attribute){
           $filters[$attribute->slug] = AttributesFilter::class;
        }
        return $filters;
    }


    public function search(Request $request)
    {
        $date = explode("to",$request->check_in_check_out);
        $date1 = trim($date[0]);
        $date2 = trim($date[1]);
        $data = [];
        $attributes = Attribute::parents()->get();
        $data['location'] =  $request->location;
        $data['max_children'] = $request->no_of_children ?? 1;
        $data['max_adults'] = $request->no_of_adults ?? 1;
        $data['rooms'] = $request->rooms;
        $apartments = Apartment::whereHas('locations',function($query) use ($data){
            $query->where('locations.name','like','%' .$data['location']. '%');
        })->orWhereHas('rooms', function( $query ) use ( $data ){
            $query->where('rooms.max_adults', '<=',  $data['max_children']);
            $query->where('rooms.max_children', '<=', $data['max_adults'] );
            $query->where('rooms.no_of_rooms', '<=', $data['rooms'] );
            $query->whereDate('available_from', '>=', $date);
        })->latest()->paginate(20);
        $apartments->appends(request()->all());
        $breadcrumb = $request->name; 
        $page_title = $request->name; 
        $location = 'test'; 
        return  view('apartments.index',compact(
            'location',
            'page_title',
            'breadcrumb',
            'apartments',
            'attributes'
        ));
         
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Apartment $apartment)
    {   
        return view('apartments.show',compact('apartment'));
    }

    

    

   
}
