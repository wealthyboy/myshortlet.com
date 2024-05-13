<?php

namespace App\Http\Controllers\Admin\Apartments;

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

class ApartmentsController extends Controller
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
        $apartments = Apartment::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.apartments.index', compact('apartments'));
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

        $property_types = Attribute::parents()->where('type', 'property type')->orderBy('sort_order', 'asc')->get();
        $properties = Property::all();

        $extras = Attribute::parents()->where('type', 'extra services')->orderBy('sort_order', 'asc')->get();
        $bedrooms = Attribute::parents()->where('type', 'bedrooms')->orderBy('sort_order', 'asc')->get();
        $others = Attribute::where('type', 'other')->orderBy('sort_order', 'asc')->get()->groupBy('parent.name');
        $room_ids = Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'asc')->get();

        $bedrooms = Attribute::parents()->where('type', 'bedrooms')->orderBy('sort_order', 'asc')->get();
        $attributes = Attribute::parents()->whereIn('type', $this->types)->get();
        $apartment_facilities = Attribute::parents()->where('type', 'apartment facilities')->orderBy('sort_order', 'asc')->get();
        $room_ids = Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'asc')->get();
        $extras = Attribute::parents()->where('type', 'extra services')->orderBy('sort_order', 'asc')->get();
        $floors = [];

        // Loop from 1 to 9 and add each floor number with the appropriate suffix to the array
        for ($i = 1; $i <= 9; $i++) {
            // Use a switch statement to determine the suffix for each number
            switch ($i) {
                case 1:
                    $suffix = 'st';
                    break;
                case 2:
                    $suffix = 'nd';
                    break;
                case 3:
                    $suffix = 'rd';
                    break;
                default:
                    $suffix = 'th';
            }

            // Concatenate the floor number with the suffix and add it to the array
            $floors[] = $i . $suffix . ' floor';
        }
        $helper =  new Helper;
        $str = new Str;
        return view(
            'admin.apartments.create',
            compact(
                'others',
                'property_types',
                'str',
                'helper',
                'extras',
                'bedrooms',
                'apartment_facilities',
                'locations',
                'attributes',
                'categories',
                'house_attributes',
                'room_ids',
                'properties',
                'floors'
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

        // $this->validate($request, [
        //     "apartment_name" => "required",
        //     'address' => "required",
        //     "description" => "required"
        // ]);
        // dd($request->all());
        $apartment = new Apartment;
        $room_images = !empty($request->images) ? $request->images : [];
        $apartment_allow = !empty($request->apartment_allow) ? $request->apartment_allow : 0;
        $apartment->name = $request->room_name;
        $apartment->price = $request->room_price;
        $apartment->sale_price = $request->room_sale_price;
        $apartment->slug = str_slug($request->room_name);
        $apartment->max_adults = $request->room_max_adults;
        $apartment->quantity = $request->room_quantity;
        $apartment->image_link = $request->room_image_links;
        $apartment->video_link = $request->room_video_links;
        $apartment->type = $request->type;
        $apartment->floor = $request->floor;
        $apartment->price_mode = $request->price_mode;
        $apartment->apartment_id = $request->apartment_id;
        $apartment->allow = $apartment_allow;
        $apartment->owner_email = $request->owner_email;
        $apartment->wifi_password = $request->wifi_password;
        $apartment->wifi_ssid = $request->wifi_ssid;
        $apartment->teaser = $request->teaser;


        $apartment->no_of_rooms = $request->room_number;
        $apartment->sale_price_expires = Helper::getFormatedDate($request->room_sale_price_expires, true);
        $apartment->property_id = $request->property_id;
        $apartment->uuid = time();
        $apartment->toilets = $request->room_toilets;
        $apartment->save();
        if (isset($request->apartment_facilities_id)) {
            $apartment->attributes()->sync(array_filter($request->apartment_facilities_id));
        }

        if (is_array($request->bed_count) && !empty($request->bed_count)) {
            $bed_count = array_filter($request->bed_count);
            $beds = [];
            if (!empty($bed_count)) {
                foreach ($bed_count as $key  => $value) {
                    $beds[$value] = ['parent_id' => $key, 'bed_count' => 1];
                }
            }
        }

        // $apartment->attributes()->syncWithoutDetaching($beds);

        $this->syncImages($room_images, $apartment);


        /**
         * Rooms with have includes
         */

        (new Activity)->Log("Created a new apartments {$request->apartment_name}");
        return \Redirect::to('/admin/apartments');
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

    public function syncImages($images, $attr, $property = null)
    {
        if (count($images)  > 0) {
            $images = array_filter($images);
            foreach ($images  as $image) {
                $imgs = new Image(['image' => $image]);
                $attr->images()->save($imgs);
            }
            if ($property) {
                foreach ($images  as $image) {
                    $imgs = new Image(['image' => $image]);
                    $property->images()->save($imgs);
                }
            }
        }
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
        $apartment = Apartment::find($id);
        $properties = Property::all();


        $bedrooms = Attribute::parents()->where('type', 'bedrooms')->orderBy('sort_order', 'asc')->get();
        $attributes = Attribute::parents()->whereIn('type', $this->types)->get();
        $apartment_facilities = Attribute::parents()->where('type', 'apartment facilities')->orderBy('sort_order', 'asc')->get();
        $room_ids = Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'asc')->get();
        $extras = Attribute::parents()->where('type', 'extra services')->orderBy('sort_order', 'asc')->get();
        $floors = [];

        // Loop from 1 to 9 and add each floor number with the appropriate suffix to the array
        for ($i = 1; $i <= 9; $i++) {
            // Use a switch statement to determine the suffix for each number
            switch ($i) {
                case 1:
                    $suffix = 'st';
                    break;
                case 2:
                    $suffix = 'nd';
                    break;
                case 3:
                    $suffix = 'rd';
                    break;
                default:
                    $suffix = 'th';
            }

            // Concatenate the floor number with the suffix and add it to the array
            $floors[] = $i . $suffix . ' floor';
        }

        // dd($property->apartments);

        return view('admin.apartments.edit', compact('floors', 'properties', 'apartment', 'room_ids', 'house_attributes', 'categories', 'others', 'property_types', 'extras', 'str', 'bedrooms', 'counter', 'attributes', 'locations', 'property', 'helper', 'apartment_facilities'));
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

        // dd($request->all());
        $apartment = Apartment::find($id);
        $room_images = !empty($request->images) ? $request->images : [];
        $apartment_allow = !empty($request->apartment_allow) ? $request->apartment_allow : 0;
        $apartment->name = $request->room_name;
        $apartment->price = $request->room_price;
        $apartment->sale_price = $request->room_sale_price;
        $apartment->slug = str_slug($request->room_name);
        $apartment->max_adults = $request->room_max_adults;
        $apartment->quantity = $request->room_quantity;
        $apartment->image_link = $request->room_image_links;
        $apartment->video_link = $request->room_video_links;
        $apartment->owner_email = $request->owner_email;
        $apartment->wifi_password = $request->wifi_password;
        $apartment->wifi_ssid = $request->wifi_ssid;
        $apartment->teaser = $request->teaser;
        $apartment->type = $request->type;
        $apartment->floor = $request->floor;
        $apartment->price_mode = $request->price_mode;
        $apartment->apartment_id = $request->apartment_id;
        $apartment->allow = $apartment_allow;
        $apartment->no_of_rooms = $request->room_number;
        $apartment->sale_price_expires = Helper::getFormatedDate($request->room_sale_price_expires, true);
        $apartment->property_id = $request->property_id;
        $apartment->uuid = time();
        $apartment->toilets = $request->room_toilets;
        $apartment->save();
        if (isset($request->apartment_facilities_id)) {
            $apartment->attributes()->sync(array_filter($request->apartment_facilities_id));
        }

        if (is_array($request->bed_count) && !empty($request->bed_count)) {
            $bed_count = array_filter($request->bed_count);
            $beds = [];
            if (!empty($bed_count)) {
                foreach ($bed_count as $key  => $value) {
                    $beds[$value] = ['parent_id' => $key, 'bed_count' => 1];
                }
            }
            $apartment->attributes()->syncWithoutDetaching($beds);
        }


        $this->syncImages($room_images, $apartment);


        /**
         * Rooms with have includes
         */

        (new Activity)->Log("Created a new apartments {$request->apartment_name}");
        return \Redirect::to('/admin/apartments');
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
