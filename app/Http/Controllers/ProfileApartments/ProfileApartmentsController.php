<?php

namespace App\Http\Controllers\ProfileApartments;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Property;
use App\Utils\AccountSettingsNav;
use Illuminate\Http\Request;

class ProfileApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {

        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];

        $user = $request->user();

        $user->load('properties');

        $nav = (new AccountSettingsNav())->nav();
        return  view('profiles.apartments.index', compact('nav', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function apartments(Request $request, $property_id)
    {
        $user = auth()->user();
        $nav = (new AccountSettingsNav())->nav();

        $apartments = $user->apartments()->wherePivot('property_id', $property_id)->get();
        $property =  Property::find($property_id);
        $date  = explode("to", $request->check_in_checkout);
        $nights = '1 night';
        $sub_total = null;
        $ids = $property->apartments->pluck('id')->toArray();
        $areas = $property->areas;
        $restaurants = $property->restaurants;
        $safety_practices = $property->safety_practicies;
        $amenities = $property->apartment_facilities->groupBy('parent.name');
        $property_type = $property->type == 'single' ?  $property->single_room : $property->multiple_rooms[0];
        $bedrooms = $property_type->bedrooms->groupBy('parent.name');
        $days = 0;


        $date = Helper::toAndFromDate($request->check_in_checkout);
        $data['max_children'] = $request->children ?? 0;
        $data['max_adults'] = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $start_date = !empty($date) ?  $date['start_date'] : null;
        $end_date = !empty($date) ? $date['end_date'] : null;
        $nights = Helper::nights($date);
        $apartments->load('images', 'free_services', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent');
        $saved =  false;
        $date = $request->check_in_checkout;
        return view(
            'profiles.apartments.show',
            compact(
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
                'nav'
            )
        );
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
