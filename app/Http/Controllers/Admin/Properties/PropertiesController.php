<?php

namespace App\Http\Controllers\Admin\Properties;



use App\Models\User;

use App\Models\Image;
use App\Models\Property;
use App\Models\Activity;
use App\Http\Helper;
use App\Models\SystemSetting;
use App\Models\Service;
use App\Models\Facility;
use App\Models\Requirement;
use App\Models\Location;
use App\Models\Apartment;
use App\Models\Category;
use App\Models\Attribute;

use App\Models\AttributePrice;
use Illuminate\Support\Str;
use App\Models\ApartmentAttribute;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PropertiesController extends Controller
{
    protected $settings;

    public $types =  [
        'facilities',
        'rules',
    ];

    public $house_attrs =  [
        'property type',
        'furnishing',
        'condition'
    ];

    public function __construct()
    {
        $this->settings =  SystemSetting::first();
    }

    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // dd(ApartmentAttribute::truncate());
        $properties = Property::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.properties.index', compact('properties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        User::canTakeAction(2);
        $counter = rand(1, 500);
        $locations = Location::parents()->get();
        $categories = Category::parents()->get();
        $attributes = Attribute::parents()->whereIn('type', $this->types)->get()->groupBy('type');
        $house_attributes = null;
        if ($request->mode == 'house') {
            $house_attributes = Attribute::parents()->whereIn('type', $this->house_attrs)->get()->groupBy('type');
        }

        $apartment_facilities = Attribute::parents()->where('type', 'apartment facilities')->orderBy('sort_order', 'asc')->get();
        $property_types = Attribute::parents()->where('type', 'property type')->orderBy('sort_order', 'asc')->get();
        $extras = Attribute::parents()->where('type', 'extra services')->orderBy('sort_order', 'asc')->get();
        $bedrooms = Attribute::parents()->where('type', 'bedrooms')->orderBy('sort_order', 'asc')->get();
        $others = Attribute::where('type', 'other')->orderBy('sort_order', 'asc')->get()->groupBy('parent.name');
        $room_ids = Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'asc')->get();


        $helper =  new Helper;
        $str = new Str;
        return view(
            'admin.properties.create',
            compact(
                'others',
                'property_types',
                'str',
                'helper',
                'extras',
                'bedrooms',
                'apartment_facilities',
                'counter',
                'locations',
                'attributes',
                'categories',
                'house_attributes',
                'room_ids'
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

        $this->validate($request, [
            "apartment_name" => "required",
            'address' => "required",
            "description" => "required"
        ]);

        $property =  $this->property($request);

        /**
         * Rooms
         */
        if ($request->mode == 'shortlet' &&  $request->type == 'single') {
            $apartment = new Apartment;
            $this->propertyWithSingleApartments($request, $apartment, $property);
        }

        $data = [];
        if ($request->mode == 'shortlet' && $request->type != 'single') {
            $this->propertyWithMultipleApartments($request, $property);
        }

        /**
         * Rooms with have includes
         */

        (new Activity)->Log("Created a new property {$request->apartment_name}");
        return \Redirect::to('/admin/properties');
    }

    public function property($request, $id = null, $update = false)
    {

        $property  = $id ?  Property::find($id) : new Property;
        $token     = mt_rand();
        $images = !empty($request->images) ? $request->images : [];
        $location_full_name = null;
        if (!empty($request->location_id)) {
            $location_ids = array_reverse($request->location_id);
            $location_ids = Location::find($location_ids);
            $location_full_name = implode(', ', array_reverse($location_ids->pluck('name')->toArray()));
        }

        $title = $id ? $request->apartment_name . '-' . $property->token : $request->apartment_name . '-' . $token;
        $property->name = $request->apartment_name;
        $property->address = $request->address;
        $property->image = $request->image;
        $property->type  = $request->type;
        $property->mode  = $request->mode;
        $property->price = $request->price;
        $property->size  = $request->size;

        $property->description = $request->description;
        $property->is_refundable = $request->is_refundable ? 1 : 0;
        $property->check_in_time = $request->check_in_time;
        $property->check_out_time = $request->check_out_time;
        $property->is_refundable = $request->is_refundable ? 1 : 0;
        $property->cancellation_message  = $request->cancellation_message;
        $property->cancellation_fee = $request->cancellation_fee;
        $property->virtual_tour = $request->virtual_tour;
        $property->featured = $request->featured ? 1 : 0;
        $property->allow = $request->allow ? 1 : 0;
        $property->is_price_negotiable = $request->is_price_negotiable ? 1 : 0;
        $property->is_shortlet = $request->is_shortlet ? 1 : 1;
        $property->bedrooms = $request->bedrooms;
        $property->toilets = $request->toilets;
        $property->location_full_name  = $location_full_name;
        $property->slug = str_slug($title);
        $property->token =  $id ? $property->token : $token;
        $property->save();

        if (!empty($request->location_id)) {
            $property->locations()->sync($request->location_id);
        }

        $property->attributes()->sync($request->attribute_id);
        $property->categories()->sync($request->category_id);
        $locations = Location::find($request->location_id);

        if (!empty($request->attribute_id)) {
            foreach ($request->attribute_id as $key => $attribute) {
                if ($key && is_string($key)) {
                    $property->attributes()->updateExistingPivot($attribute, [
                        'name' => $key,
                    ]);
                }
            }
        }


        if (!empty($request->location_id)) {
            foreach ($locations as $location) {
                $location->attributes()->sync($request->attribute_id);
            }
        }



        if ($request->mode == 'shortlet') {
            if (!empty($request->property_extra_services)) {
                $prices = array_filter($request->property_extra_services);
                if (!empty($prices)) {
                    foreach ($prices as $key  => $extra) {
                        $property->attributes()->updateExistingPivot($key, [
                            'price' => $extra,
                        ]);
                    }
                }
            }

            $this->syncExtras($request->property_extras,  $request->property_extra_services, $property);
            if (!empty($request->apartment_facilities_id)) {
                foreach ($request->apartment_facilities_id as $key  => $apartment_facility_id) {
                    $property->attributes()->syncWithoutDetaching($apartment_facility_id);
                }
            }
        }


        return $property;
    }

    public function propertyWithMultipleApartments($request,  $property)
    {

        //  $price = implode(array_values($request->room_price));
        // dd($request->all());

        foreach ($request->room_price  as $key => $room) {

            $apartment = new Apartment;
            $room_images = !empty($request->images[$key]) ? $request->images[$key] : [];
            $apartment_allow = !empty($request->apartment_allow) ? $request->apartment_allow[$key] : 0;
            $apartment->name = $request->room_name[$key];
            $apartment->price = $request->room_price[$key];
            $apartment->sale_price = $request->room_sale_price[$key];
            $apartment->slug = str_slug($request->room_name[$key]);
            $apartment->max_adults = $request->room_max_adults[$key];
            $apartment->quantity = $request->room_quantity[$key];
            $apartment->image_link = $request->room_image_links[$key];
            $apartment->video_link = $request->room_video_links[$key];
            $apartment->type = $request->type;
            $apartment->price_mode = $request->price_mode[$key];
            $apartment->apartment_id = $request->apartment_id[$key];
            $apartment->allow = $apartment_allow;
            $apartment->no_of_rooms = $request->room_number[$key];
            $apartment->sale_price_expires = Helper::getFormatedDate($request->room_sale_price_expires[$key], true);
            $apartment->property_id = $property->id;
            $apartment->uuid = time();
            $apartment->toilets = $request->room_toilets[$key];
            $apartment->save();
            if (isset($request->apartment_facilities_id[$key])) {
                $apartment->attributes()->sync(array_filter($request->apartment_facilities_id[$key]));
            }

            if (isset($request->multiple_apartment_extras[$key])) {
                // $this->syncExtras($request->multiple_apartment_extras[$key],  $request->multiple_apartment_extra_services[$key], $apartment);
            }

            $this->syncImages($room_images, $apartment, $property);
            //  $this->syncAttributes($request, $apartment, $key);
        }

        // $property->price  =  $price;
        $property->save();
    }

    public function propertyWithSingleApartments($request, $apartment, $property)
    {

        $room_images = !empty($request->images) ? $request->images : [];
        $apartment->price = $request->single_room_price;
        $apartment->sale_price = $request->single_room_sale_price;
        $apartment->slug = str_slug($request->single_room_name);
        $apartment->max_adults = $request->single_room_max_adults;
        $apartment->quantity = 1;
        $apartment->price_mode = $request->sinble_price_mode;
        $apartment->type = $request->type;
        // $apartment->max_children = $request->single_room_max_children;
        $apartment->no_of_rooms = $request->single_room_number;
        $apartment->size = $request->size;
        $apartment->sale_price_expires = Helper::getFormatedDate($request->single_room_sale_price_expires, true);
        $apartment->property_id = $property->id;
        $apartment->uuid = time();
        $apartment->toilets = $request->single_room_toilets;
        $apartment->save();
        $property->price = $request->single_room_price;
        $property->save();
        $apartment->attributes()->sync(array_filter($request->attribute_id));

        if (!$request->land) {
            if (isset($request->single_apartment_extras[212])) {
                $this->syncExtras($request->single_apartment_extras[212],  $request->single_apartment_extra_services[212], $apartment);
            }

            $this->syncImages($room_images, $apartment, $property);
            $this->syncAttributes($request, $apartment, 212);
        }
    }

    public function syncExtras($extras, $extra_services_price,  $obj)
    {
        $obj->attributes()->syncWithoutDetaching($extras);
        if (!empty($extra_services_price)) {
            $prices = array_filter($extra_services_price);
            if (!empty($prices)) {
                foreach ($prices as $key  => $extra) {
                    $obj->attributes()->updateExistingPivot($key, [
                        'price' => $extra,
                    ]);
                }
            }
        }
    }

    public function syncAttributes($request, $apartment, $key = null)
    {
        //  $apartment->attributes()->truncate();


        if (is_array($request->bed_count) && !empty($request->bed_count)) {
            //dd($request->bed_count);
            $bed_count = array_filter($request->bed_count);
            $beds = [];
            if (!empty($bed_count)) {
                foreach ($bed_count as $ky  => $value) {
                    $value = array_filter($value);
                    foreach ($value as $k  => $v) {
                        $beds[$ky][$k] = ['bed_count' => $v];
                    }
                }
            }

            // dd($beds);

            if (in_array($key, array_keys($beds))) {
                $apartment->attributes()->syncWithoutDetaching($beds[$key]);
            }



            // dd($apartment->attributes, $beds[$key], ApartmentAttribute::all());
        }
    }

    public function syncImages($images, $attr, $property = null)
    {
        if (count($images)  > 0) {
            $images = array_filter($images);
            foreach ($images  as $image) {
                $imgs = new Image(['image' => $image]);
                $attr->images()->save($imgs);
            }

            foreach ($images  as $image) {
                $imgs = new Image(['image' => $image]);
                $property->images()->save($imgs);
            }
        }
    }

    public function beds($request, $key = null)
    {
        $beds = [];
        for ($i = 1; $i < 10; $i++) {
            $input  =  $key ?  'bedroom_' . $i . '_' . $key : 'bedroom_' . $i;
            $input  =  $request->$input;
            $beds[] =  $input;
        }
        return $beds;
    }

    public function newRoom(Request $request)
    {
        $counter = rand(1, 500);
        $bedrooms =  Attribute::parents()->where('type', 'bedrooms')->orderBy('sort_order', 'asc')->get();
        $attributes = Attribute::parents()->whereIn('type', $this->types)->get();
        $apartment_facilities =  Attribute::parents()->where('type', 'apartment facilities')->orderBy('sort_order', 'asc')->get();
        $room_ids =  Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'asc')->get();

        $extras =  Attribute::parents()->where('type', 'extra services')->orderBy('sort_order', 'asc')->get();
        $helper = new Helper;
        return view(
            'admin.apartments.variation',
            compact('extras', 'room_ids', 'bedrooms', 'apartment_facilities', 'counter', 'attributes', 'helper')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $property   = Property::find($id);
        $locations  = Location::parents()->get();
        $helper     = new Helper();
        $counter    = rand(1, 500);
        $house_attributes = null;
        if ($request->mode == 'house') {
            $house_attributes = Attribute::parents()->whereIn('type', $this->house_attrs)->get()->groupBy('type');
        }

        $attributes = Attribute::parents()->whereIn('type', $this->types)->get()->groupBy('type');
        $apartment_facilities  = Attribute::parents()->where('type', 'apartment facilities')->orderBy('sort_order', 'asc')->get();
        $counter = rand(1, 500);
        $str = new Str;
        $others = Attribute::where('type', 'other')->orderBy('sort_order', 'asc')->get()->groupBy('parent.name');
        $bedrooms = Attribute::parents()->where('type', 'bedrooms')->orderBy('sort_order', 'asc')->get();
        $extras = Attribute::parents()->where('type', 'extra services')->orderBy('sort_order', 'asc')->get();
        $property_types = Attribute::parents()->where('type', 'property type')->orderBy('sort_order', 'asc')->get();
        $room_ids = Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'asc')->get();
        $categories = Category::parents()->get();


        return view('admin.properties.edit', compact('room_ids', 'house_attributes', 'categories', 'others', 'property_types', 'extras', 'str', 'bedrooms', 'counter', 'attributes', 'locations', 'property', 'helper', 'apartment_facilities'));
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
        $this->validate($request, [
            "apartment_name"  => "required",
            'address' => "required",
            "description" => "required"
        ]);

        // ini_set('max_input_vars', 200000); // Set max_input_vars to 5000



        $apartment_facilities = Apartment::find(27);

        // foreach ($apartment_facilities as  $apartment_facilitie) {
        //     $apartment_facilitie->delete();
        // }

        $property = $this->property($request, $id, true);
        $apartment_facilities_id = $request->apartment_facilities_id;

        /**
         * Reservation Images
         */
        $data = [];

        if ($request->mode == 'shortlet' &&  $request->type == 'single') {
            $apartment = $property->single_room;
            $this->propertyWithSingleApartments($request, $apartment, $property);
        }


        if (!empty($request->edit_room_name) && !$request->has('new_room')) {
            $price = implode(array_values($request->edit_room_price));
            $property->price  =  $price;
            $property->save();
            foreach ($request->edit_room_name as $room_id => $room) {
                $room_images = !empty($request->edit_room_images[$room_id]) ? $request->edit_room_images[$room_id] : [];
                $allow = !empty($request->edit_allow)  &&  isset($request->edit_allow[$room_id]) ? $request->edit_allow[$room_id] : 0;
                $video_links = !empty($request->edit_video_links)  &&  isset($request->edit_video_links[$room_id]) ? $request->edit_video_links[$room_id] : null;
                $edit_image_links = !empty($request->edit_image_links)  &&  isset($request->edit_image_links[$room_id]) ? $request->edit_image_links[$room_id] : null;
                $edit_room_price = !empty($request->edit_room_price)  &&  isset($request->edit_room_price[$room_id]) ? $request->edit_room_price[$room_id] : null;
                $edit_room_sale_price = !empty($request->edit_room_sale_price)  &&  isset($request->edit_room_sale_price[$room_id]) ? $request->edit_room_sale_price[$room_id] : null;
                $edit_room_max_adults = !empty($request->edit_room_max_adults)  &&  isset($request->edit_room_max_adults[$room_id]) ? $request->edit_room_max_adults[$room_id] : null;
                $edit_room_number = !empty($request->edit_room_number)  &&  isset($request->edit_room_number[$room_id]) ? $request->edit_room_number[$room_id] : null;
                $edit_room_toilets = !empty($request->edit_room_toilets)  &&  isset($request->edit_room_toilets[$room_id]) ? $request->edit_room_toilets[$room_id] : null;






                $apartment = Apartment::updateOrCreate(
                    ['id' => $room_id],
                    [
                        'name' => $request->edit_room_name[$room_id],
                        'price' => $edit_room_price,
                        'sale_price' => $edit_room_sale_price,
                        'price_mode' => $request->edit_room_price_mode[$room_id],
                        'sale_price_expires' => !empty($request->edit_room_sale_price_expires)  &&  isset($request->edit_room_sale_price_expires[$room_id]) ? Helper::getFormatedDate($request->edit_room_sale_price_expires[$room_id]) : null,
                        'slug' => str_slug($request->edit_room_name[$room_id]),
                        'max_adults' => $edit_room_max_adults,
                        'allow' => $allow,
                        'apartment_id' => $request->edit_apartment_id[$room_id],
                        'image_link' => $edit_image_links,
                        'video_link' => $video_links,
                        'property_id'  => $property->id,
                        'no_of_rooms' => $edit_room_number,
                        'toilets'  => $edit_room_toilets,
                        'type' => $request->type,
                    ]
                );
                /**
                 * Sync Images
                 */

                if (!empty($request->new_room_images)) {
                    foreach ($request->new_room_images as $room_id => $images) {
                        $variation = Apartment::find($room_id);
                        $images = array_filter($images);
                        foreach ($images as $image) {
                            if ($image == '') {
                                continue;
                            }
                            $images = new Image(['image' => $image, 'property_id' => $property->id]);
                            $variation->images()->save($images);
                        }
                    }
                }

                // dd($request->apartment_facilities_id[$room_id]);



                if (!isset($apartment_facilities_id[$room_id])) {
                    $apartment_facilities_id[$room_id] = [];
                }

                $apartment->attributes()->sync(
                    array_filter(
                        $apartment_facilities_id[$room_id]
                    )
                );


                if (isset($request->multiple_apartment_extras[$room_id])) {
                    $this->syncExtras($request->multiple_apartment_extras[$room_id],  $request->multiple_apartment_extra_services[$room_id], $apartment);
                }

                $this->syncImages($room_images, $apartment, $property);
                $this->syncAttributes($request, $apartment, $room_id);
            }
        }

        /**
         * New apartments
         */

        $data = [];
        if ($request->has('new_room')) {
            $this->propertyWithMultipleApartments($request, $property);
        }

        (new Activity)->Log("Edited a  property ");
        return \Redirect::to('/admin/properties');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        User::canTakeAction(5);
        $rules = array(
            '_token' => 'required'
        );
        $validator = \Validator::make($request->all(), $rules);
        if (empty($request->selected)) {
            $validator->getMessageBag()->add('Selected', 'Nothing to Delete');
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        $count = count($request->selected);
        (new Activity)->Log("Deleted  {$count} Products");

        foreach ($request->selected as $selected) {
            $delete = Property::find($selected);
            $delete->apartments()->delete();
            $delete->delete();
        }

        return redirect()->back();
    }
}
