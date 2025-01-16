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
use App\Models\UserReservation;

use App\Models\AttributePrice;
use Illuminate\Support\Str;
use App\Models\ApartmentAttribute;
use Carbon\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
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
        //$this->updateBedrooms();
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
        $apartment->bedroom_1 = $request->bedroom_1;
        $apartment->bedroom_2 = $request->bedroom_2;
        $apartment->bedroom_3 = $request->bedroom_3;
        $apartment->bedroom_4 = $request->bedroom_4;
        $apartment->bedroom_5 = $request->bedroom_5;
        $apartment->bedroom_6 = $request->bedroom_6;
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

        


        $this->syncImages($room_images, $apartment);


        /**
         * Rooms with have includes
         */

        (new Activity)->Log("Created a new apartments {$request->apartment_name}");
        return \Redirect::to('/admin/apartments');
    }


    public function updateBedrooms()
    {
        // Fetch all apartments
        $apartments = Apartment::all();

        foreach ($apartments as $apartment) {
            // Get the number of rooms for the current apartment
            $no_of_rooms = $apartment->no_of_rooms;

            // Loop through the number of rooms and update bedroom_X fields
            for ($count = 1; $count <= $no_of_rooms; $count++) {
                $bedroom_field = 'bedroom_' . $count; // Dynamic field name

                // Update the field with a default value
                $apartment->$bedroom_field = 'Extra-large double bed';
            }

            // Save the updated apartment
            $apartment->save();
        }

        return 'Bedrooms updated successfully!';
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $property = Property::find($id);
        $locations = Location::parents()->get();
        $helper = new Helper();
        $counter = rand(1, 500);
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
        $apartment->bedroom_1 = $request->bedroom_1;
        $apartment->bedroom_2 = $request->bedroom_2;
        $apartment->bedroom_3 = $request->bedroom_3;
        $apartment->bedroom_4 = $request->bedroom_4;
        $apartment->bedroom_5 = $request->bedroom_5;
        $apartment->bedroom_6 = $request->bedroom_6;
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
            $delete = Apartment::find($selected);
            $delete->delete();
        }

        return redirect()->back();
    }
}
