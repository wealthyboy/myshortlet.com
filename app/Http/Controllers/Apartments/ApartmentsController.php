<?php

namespace App\Http\Controllers\Apartments;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Apartment;
use App\Models\SystemSetting;
use App\Models\Attribute;
use Illuminate\Database\Eloquent\Builder;



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

    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
