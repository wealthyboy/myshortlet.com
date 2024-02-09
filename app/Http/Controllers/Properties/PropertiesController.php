<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Apartment;

use App\Models\Location;
use App\Models\Attribute;
use App\Models\Room;
use App\Models\AttributePrice;
use App\Models\Category;
use App\Models\Image;
use App\Http\Helper;
use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Builder;
use App\Filters\PropertyFilter\AttributesFilter;


use Carbon\Carbon;
use App\Http\Resources\PropertyLists;
use App\Http\Resources\ApartmentResource;




use Illuminate\Support\Facades\Notification;
use App\Notifications\ApartmentUpload;
use Illuminate\Support\Facades\DB;



class PropertiesController extends Controller
{

    public function __construct()
    {
        //$this->middleware('auth'); 
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  index(Request $request, Category $category)
    {
        $page_title = $category->title;
        $meta_tag_keywords = $category->keywords;
        $page_meta_description = $category->meta_description;
        $locations = $category->states;
        $str = new  Str;
        $attributes = $category->attributes->groupBy('type');
        $properties = Property::where('allow', true)->whereHas('categories', function (Builder  $builder) use ($category) {
            $builder->where('categories.slug', $category->slug);
        })
            ->filter($request,  $this->getFilters($attributes))
            ->latest()->paginate(20);
        $properties->appends(request()->all());
        $saved =  $this->saved();
        $properties->load('categories');

        if ($request->ajax()) {
            return PropertyLists::collection(
                $properties
            )->additional(['attributes' => $attributes, 'search' => false]);
        }
        $next_page = [];

        $next_page[] = $properties->nextPageUrl();

        $total = $properties->total();

        return  view('properties.index', compact(
            'page_title',
            'attributes',
            'str',
            'saved',
            'properties',
            'next_page',
            'category',
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




        $attributes = $location->attributes->groupBy('type');
        $page_title = implode(" ", explode('-', $location->slug));
        $breadcrumb = $location->name;
        $saved =  $this->saved();
        $locations = $location->children;
        $properties = Property::where('allow', true)->whereHas('locations', function (Builder  $builder) use ($location) {
            $builder->where('locations.slug', $location->slug);
        })
            ->filter($request,  $this->getFilters($attributes))
            ->latest()->paginate(20);
        $properties->appends(request()->all());
        $total = $properties->total();



        if ($request->ajax()) {
            return PropertyLists::collection(
                $properties
            )->additional(['attributes' => $attributes, 'search' => false]);
        }
        $next_page = [];

        $next_page[] = $properties->nextPageUrl();
        $properties->load('categories');


        return  view('properties.index', compact(
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



    public function search(Request $request)
    {
        $date = explode("to", $request->check_in_checkout);
        $property_is_not_available = null;
        $data = [];
        $attributes = null;
        $data['location'] = 'lagos';
        $data['max_children'] = $request->children ?? 1;
        $data['max_adults']   = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $properties = null;
        $location   = null;


        if ($request->q) {
            // Query for available apartments in all properties
            $availablePropertyData = Property::select('properties.*', 'apartments.apartment_id')
                ->join('apartments', 'properties.id', '=', 'apartments.property_id')
                ->whereNotIn('apartments.apartment_id', function ($query) use ($startDate, $endDate) {
                    $query->select('apartment_id')
                        ->from('reservations')
                        ->where(function ($query) use ($startDate, $endDate) {
                            $query->where(function ($query) use ($startDate, $endDate) {
                                $query->whereBetween('start_date', [$startDate, $endDate])
                                    ->orWhereBetween('end_date', [$startDate, $endDate]);
                            })
                                ->orWhere(function ($query) use ($startDate, $endDate) {
                                    $query->where('start_date', '<=', $startDate)
                                        ->where('end_date', '>=', $endDate);
                                });
                        });
                })
                ->get();
        } else {
        }


        if ($request->ajax()) {
            return response()->json([
                "data" => []
            ], 200);
        }

        $breadcrumb = $request->name;
        $page_title = $request->name;
        $str        =    new  Str;
        $saved =  $this->saved();
        $date = $request->check_in_checkout;
        $next_page = [];
        $next_page[] = $properties->nextPageUrl();
        $properties->load('categories');
        return  view('properties.index', compact(
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


    public function getFilters($attributes)
    {
        $filters = [];
        if (null !== $attributes) {
            foreach ($attributes as $key => $attribute) {
                foreach ($attribute as $attr) {
                    $filters[$attr->slug] = AttributesFilter::class;
                }
            }
        }


        return $filters;
    }


    public function autoComplete(Request $request)
    {
        $categories = Category::where('name', 'like', '%' . $request->q . '%')->take(5)->get();
        $locations = Location::where('name', 'like', '%' . $request->q . '%')->take(5)->get();
        $properties = Property::where('name', 'like', '%' . $request->q . '%')->take(5)->get();

        if (!$request->q) {
            return response()->json([
                'locations' => [],
                'categories' => [],
                'properties' => []
            ]);
        }

        if ($categories->count() || $locations->count() || $properties->count()) {
            return response()->json([
                'locations' => $locations,
                'categories' => $categories,
                'properties' => $properties
            ]);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $step = $request->step;
        $type = $request->type;
        $token = $request->token;

        $apartment = null;
        if ($token) {
            $apartment =  Apartment::where('token', $token)->firstOrFail();
        }
        $locations = Location::where('location_type', 'state')->get();
        $city = Location::where('location_type', 'city')->get();
        $street = Location::where('location_type', 'street')->get();

        $counter = rand(1, 500);
        $attributes =  Attribute::parents()->where('type', null)->orderBy('sort_order', 'asc')->get();
        $rules =  Attribute::parents()->where('type', 'rules')->orderBy('sort_order', 'asc')->get();
        $bedrooms =  Attribute::parents()->where('type', 'bedroom')->orderBy('sort_order', 'asc')->get();
        $extra_services =  Attribute::parents()->where('type', 'extra_services')->orderBy('sort_order', 'asc')->get();
        $facilities =  Attribute::parents()->where('type', 'facilities')->orderBy('sort_order', 'asc')->get();
        $helper = new Helper();


        return view(
            'properties.create',
            compact(
                'type',
                'step',
                'locations',
                'facilities',
                'rules',
                'bedrooms',
                'extra_services',
                'facilities',
                'counter',
                'apartment',
                'city',
                'street',
                'helper'
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

        $user  = $request->user();



        $ap = Apartment::latest()->first();
        $token =  null !== $ap ? mt_rand() + $ap->id : mt_rand();
        $token = $request->token ? $request->token : $token;
        $apartment =  new Apartment();
        $title     =  $request->apartment_title . '-' . $token;
        if ($request->has('token')) {
            $apartment =  Apartment::where('token', $request->token)->firstOrFail();
            $title     =  $request->apartment_title . '-' . $request->token;
        }



        // if ($request->step == 'two' &&  $request->token && !$request->back_one ) {
        //     dd($request->token);
        //     $apartment = Apartment::find($request->apartment_id);  
        //     $step = $request->step;
        //     $type = $request->type;
        //     return redirect()->route('properties.create', ['step' => $step, 'type' => $type,'token' => $apartment->token]);
        // }




        if ($request->step == 'three' &&  $request->token) {
            $apartment->allow_cancellation = $request->allow_cancellation;
            $apartment->cancellation_message = $request->cancellation_message;
            $apartment->step = 'two';
            $apartment->save();
            $step = $request->step;
            $type = $request->type;
            return redirect()->route('properties.create', ['step' => $step, 'type' => $type, 'token' => $apartment->token]);
        }



        //dd($request->apartment_images);
        if ($request->step == 'finish' &&  $request->token) {
            //dd(true);
            $data = [];
            foreach ($request->price  as $key => $room) {
                $room = new Room;
                $images = !empty($request->apartment_images[$key]) ? $request->apartment_images[$key] : [];
                //$image = array_shift($images);
                $room->name         = !empty($request->apartment_name[$key]) ? $request->apartment_name[$key] : null;
                $room->price        = $request->price[$key];
                $room->slug         = !empty($request->apartment_name[$key]) ? str_slug($request->apartment_name[$key]) : str_slug($request->apartment_title);
                $room->max_adults   = $request->adults[$key];
                $room->max_children = $request->children[$key];
                $room->no_of_rooms  = $request->bedrooms[$key];
                $room->toilets      = $request->toilets[$key];
                $room->available_from = now();
                $room->apartment_id   = $apartment->id;
                $room->save();

                if (count($images)  > 0) {
                    $images = array_filter($images);
                    foreach ($images  as $image) {
                        $imgs = new Image(['image' => $image]);
                        $room->images()->save($imgs);
                    }
                }

                $beds = [];
                for ($i = 1; $i < 6; $i++) {
                    $input = 'bedroom_' . $i . '_' . $room_id;
                    $input = $request->$input;
                    $beds[] = $input;
                }


                $room->attributes()->sync(array_filter($beds));


                if (!empty($request->facility_id)) {
                    $room->attributes()->syncWithPivotValues($request->parent_id,  ['parent_id' => true]);
                    $room->attributes()->syncWithoutDetaching($request->facility_id);
                }

                $room->attributes()->syncWithoutDetaching($request->attribute_id);

                /**
                 * For filters
                 */
                $apartment->attributes()->sync($request->facility_id);
                $apartment->attributes()->syncWithoutDetaching($request->attribute_id);
            }

            foreach ($request->extra_services_price  as $key => $price) {
                $attribute_price = new AttributePrice;
                $attribute_price->attribute_id = $key;
                $attribute_price->price = $price;
                $attribute_price->save();
            }

            $apartment->status = 'Pending';
            $apartment->is_completed = 1;
            $apartment->step = 'three';
            $apartment->save();

            //Send Notification
            try {
                Notification::route('mail', $user->email)
                    ->notify(new ApartmentUpload($apartment));
                return redirect('/properties/create')->with('status', 'We have ');
            } catch (\Throwable $th) {
                //dd($th);
                return redirect('/properties/create')->with('error', 'We have ');
            }
        }



        $user = $request->user();
        $apartment =  new Apartment();
        $title     =  $request->apartment_title . '-' . $token;
        if ($request->has('token')) {
            $apartment =  Apartment::where('token', $request->token)->firstOrFail();
            $title     =  $request->apartment_title . '-' . $request->token;
        }
        $apartment->name         = $request->apartment_title;
        $apartment->address      = $request->address;
        $apartment->image        = $request->image;
        $apartment->description  = $request->description;
        $apartment->allow        = 0;
        $apartment->type         = $request->type;
        $apartment->status       = 'In complete';
        $apartment->step         = 'one';
        $apartment->slug         = str_slug($title);
        $apartment->user_id      = $user->id;
        $apartment->token        = $request->token ? $request->token : $token;
        $apartment->is_not_admin = 1;
        $apartment->save();
        $request->session()->put('apartment_id', $apartment->id);
        $apartment->locations()->sync(array_filter($request->location_id));
        //dd($apartment);

        $step = $request->step;
        $type = $request->type;
        return redirect()->route('properties.create', ['step' => $step, 'type' => $type, 'token' => $apartment->token]);
    }




    public function getLocation(Request $request, $id)
    {
        $locations =  Location::find($id);
        return view('properties.location', compact('locations'));
    }


    public function addApartment(Request $request)
    {
        $counter = rand(1, 500);
        $attributes =  Attribute::parents()->where('type', null)->orderBy('sort_order', 'asc')->get();
        $rules =  Attribute::parents()->where('type', 'rules')->orderBy('sort_order', 'asc')->get();
        $bedrooms =  Attribute::parents()->where('type', 'bedroom')->orderBy('sort_order', 'asc')->get();
        $extra_services =  Attribute::parents()->where('type', 'extra_services')->orderBy('sort_order', 'asc')->get();
        $facilities =  Attribute::parents()->where('type', 'facilities')->orderBy('sort_order', 'asc')->get();
        return view(
            'properties.variation',
            compact('bedrooms', 'extra_services', 'facilities', 'rules', 'counter', 'attributes')
        );
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Property $property)
    {
        $date  = explode("to", $request->check_in_checkout);
        $nights = '1 night';
        $sub_total = null;
        $ids = $property->apartments->pluck('id')->toArray();
        $areas = $property->areas;
        $restaurants = $property->restaurants;
        $saved =  $this->saved();

        $safety_practices = $property->safety_practicies;
        $amenities = $property->apartment_facilities->groupBy('parent.name');
        // if ($property->mode == 'shortlet'){
        $property_type = $property->type == 'single' ?  $property->single_room : $property->multiple_rooms->first();
        $bedrooms = optional($property_type->bedrooms)->groupBy('parent.name');
        $date = Helper::toAndFromDate($request->check_in_checkout);
        $data['max_children'] = $request->children ?? 0;
        $data['max_adults']   = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $start_date = !empty($date) ?  $date['start_date'] : null;
        $end_date = !empty($date) ? $date['end_date'] : null;
        $nights = Helper::nights($date);
        $apartments = Apartment::where('apartments.property_id', $property->id)
            ->where('apartments.max_adults', '>=',  $data['max_adults'])
            ->where('apartments.max_children', '>=', $data['max_children'])
            ->where('apartments.no_of_rooms', '>=', $data['rooms'])
            ->select('reservations.id as reservation_id', 'reservations.quantity as reservation_qty', 'apartments.*')
            ->leftJoin('reservations', function ($join) use ($start_date, $end_date) {
                $join->on('apartments.id', '=', 'reservations.apartment_id')
                    ->whereDate('reservations.checkin', '<=', $start_date)
                    ->whereDate('reservations.checkout', '>=', $end_date);
            })
            ->groupBy('apartments.id')
            ->get();
        $apartments->load('images', 'free_services', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent');
        $saved =  $this->saved();
        $date = $request->check_in_checkout;
        $days = 0;

        return view(
            'properties.show',
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
                'restaurants'
            )
        );
        // } 




    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(REquest $request, $id)
    {

        $step = $request->step;
        $type = $request->type;
        $update = 1;
        $apartment      =  Apartment::find($id);
        $locations      =  Location::where('location_type', 'state')->get();
        $cities      =  $apartment->states->first()->children;
        $streets      =  $cities->first()->children;

        //dd($apartment->rooms[1]->bedrooms->pluck('id')->toArray());


        $counter        =  rand(1, 500);
        $attributes     =  Attribute::parents()->where('type', null)->orderBy('sort_order', 'asc')->get();
        $rules          =  Attribute::parents()->where('type', 'rules')->orderBy('sort_order', 'asc')->get();
        $bedrooms       =  Attribute::parents()->where('type', 'bedroom')->orderBy('sort_order', 'asc')->get();
        $extra_services =  Attribute::parents()->where('type', 'extra_services')->orderBy('sort_order', 'asc')->get();
        $facilities     =  Attribute::parents()->where('type', 'facilities')->orderBy('sort_order', 'asc')->get();
        $helper  =  new Helper();

        return view(
            'properties.edit',
            compact(
                'type',
                'step',
                'locations',
                'facilities',
                'rules',
                'bedrooms',
                'extra_services',
                'facilities',
                'counter',
                'apartment',
                'update',
                'helper',
                'cities',
                'streets'
            )
        );
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

        if ($request->has('token')) {
            $apartment =  Apartment::where('token', $request->token)->firstOrFail();
            $title     =  $request->apartment_title . '-' . $request->token;
        }


        //dd($request->all());


        /**
         * Reservation Images
         */


        if ($request->step == 'three' &&  $request->token) {
            $apartment->allow_cancellation   = $request->allow_cancellation;
            $apartment->cancellation_message = $request->cancellation_message;
            $apartment->step = 'two';
            $apartment->save();
            $step = $request->step;
            $type = $request->type;
            return redirect()->route('properties.edit', ['property' => $apartment->id, 'step' => $step, 'type' => $type, 'update' => 1, 'token' => $apartment->token]);
        }



        //dd($request->apartment_images);
        if ($request->step == 'finish' &&  $request->token) {
            $data = [];
            if (!empty($request->edit_apartment_name)) {
                foreach ($request->edit_apartment_name as $room_id => $room) {
                    $room       =  Room::updateOrCreate(
                        ['id' => $room_id],
                        [
                            'name' => $request->edit_apartment_name[$room_id],
                            'price' => $request->edit_apartment_price[$room_id],
                            'slug'               => str_slug($request->edit_apartment_name[$room_id]),
                            'max_adults'         => $request->edit_apartment_adults[$room_id],
                            'max_children'       => $request->edit_apartment_children[$room_id],
                            'apartment_id'       => $apartment->id,
                            'no_of_rooms'        => $request->edit_apartment_bedrooms[$room_id],
                            'toilets'            => $request->edit_apartment_toilets[$room_id],
                        ]
                    );
                    /**
                     * Sync Images
                     */

                    if (!empty($request->new_apartment_images)) {
                        foreach ($request->new_apartment_images as $room_id => $images) {
                            $variation = Room::find($room_id);
                            $images = array_filter($images);
                            foreach ($images as $image) {
                                if ($image == '') {
                                    continue;
                                }
                                $images = new Image(['image' => $image]);
                                $variation->images()->save($images);
                            }
                        }
                    }


                    if (!empty($request->facility_id)) {
                        $room->attributes()->syncWithPivotValues($request->parent_id,  ['parent_id' => true]);
                        $room->attributes()->syncWithoutDetaching($request->facility_id);
                    }

                    $beds = [];
                    for ($i = 1; $i < 6; $i++) {
                        $input = 'bedroom_' . $i . '_' . $room_id;
                        $input = $request->$input;
                        $beds[] = $input;
                    }
                    $room->attributes()->syncWithoutDetaching(array_filter($beds));
                    $room->attributes()->syncWithoutDetaching($request->attribute_id);
                }

                /**
                 * For filters
                 */
                $apartment->attributes()->sync($request->facility_id);
                $apartment->attributes()->syncWithoutDetaching($request->attribute_id);
            }

            //dd($request->all());
            /**
             * New apartments
             */


            $data = [];
            if ($request->has('new_room')) {
                foreach ($request->price  as $key => $room) {
                    $room = new Room;
                    $images = !empty($request->apartment_images[$key]) ? $request->apartment_images[$key] : [];
                    $room->name         = !empty($request->apartment_name[$key]) ? $request->apartment_name[$key] : null;
                    $room->price        = $request->price[$key];
                    $room->slug         = !empty($request->apartment_name[$key]) ? str_slug($request->apartment_name[$key]) : str_slug($request->apartment_title);
                    $room->max_adults   = $request->adults[$key];
                    $room->max_children = $request->children[$key];
                    $room->no_of_rooms  = $request->bedrooms[$key];
                    $room->toilets      = $request->toilets[$key];
                    $room->available_from = now();
                    $room->apartment_id   = $apartment->id;
                    $room->save();

                    if (count($images)  > 0) {
                        $images = array_filter($images);
                        foreach ($images  as $image) {
                            $imgs = new Image(['image' => $image]);
                            $room->images()->save($imgs);
                        }
                    }
                }



                if (!empty($request->facility_id)) {
                    $room->attributes()->syncWithPivotValues($request->parent_id,  ['parent_id' => true]);
                    $room->attributes()->syncWithoutDetaching($request->facility_id);
                }


                $beds = [];
                for ($i = 1; $i < 6; $i++) {
                    $input = 'bedroom_' . $i . '_' . $room_id;
                    $input = $request->$input;
                    $beds[] = $input;
                }
                $room->attributes()->syncWithoutDetaching(array_filter($beds));

                $room->attributes()->syncWithoutDetaching($request->attribute_id);



                /**
                 * For filters
                 */
                $apartment->attributes()->syncWithoutDetaching($request->facility_id);
                $apartment->attributes()->syncWithoutDetaching($request->attribute_id);


                foreach ($request->extra_services_price  as $key => $price) {
                    $attribute_price = new AttributePrice;
                    $attribute_price->attribute_id = $key;
                    $attribute_price->price = $price;
                    $attribute_price->save();
                }
            }

            try {

                //     Notification::route('mail', $user->email)
                //     ->notify(new ApartmentUpload($apartment));
                return redirect('/properties/create')->with('status', 'Listing updated successfully');
            } catch (\Throwable $th) {
                return redirect('/properties/create')->with('error', 'We have ');
            }
        }



        $user = $request->user();
        $apartment->name         = $request->apartment_title;
        $apartment->address      = $request->address;
        $apartment->image        = $request->image;
        $apartment->description  = $request->description;
        $apartment->allow        = 0;
        $apartment->type         = $request->type;
        $apartment->status       = 'Updated';
        $apartment->step         = 'one';
        $apartment->slug         = str_slug($title);
        $apartment->user_id      = $user->id;
        $apartment->is_not_admin = 1;
        $apartment->save();
        $request->session()->put('apartment_id', $apartment->id);
        $apartment->locations()->sync(array_filter($request->location_id));
        $step = $request->step;
        $type = $request->type;


        return redirect()->route('properties.edit', ['property' => $apartment->id, 'step' => $step, 'type' => $type, 'token' => $apartment->token, 'update' => 1]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $apartment = Apartment::find($id)->delete();
        return redirect()->back()->with('success', 'Apartment deleted successfully');
    }
}
