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
use App\Models\Attribute;
use App\Models\AttributePrice;
use Illuminate\Support\Str;

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

    public function __construct()
    {	  
	  $this->settings =  SystemSetting::first();
    }

    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {   
        $properties = Property::orderBy('created_at','desc')->paginate(3);
        return view('admin.apartments.index',compact('properties'));
    }

   /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        User::canTakeAction(2);
        $counter = rand(1,500);
        $locations  = Location::parents()->get();
        $attributes = Attribute::parents()->whereIn('type' ,$this->types)->get()->groupBy('type');
        $apartment_facilities =  Attribute::parents()->where('type','apartment facilities')->orderBy('sort_order','asc')->get();
        $property_types       =  Attribute::parents()->where('type','property type')->orderBy('sort_order','asc')->get();
        $extras               =  Attribute::parents()->where('type','extra services')->orderBy('sort_order','asc')->get();
        $bedrooms             =  Attribute::parents()->where('type','bedrooms')->orderBy('sort_order','asc')->get();
        $others               =  Attribute::parents()->where('type','others')->orderBy('sort_order','asc')->get();
        $helper               =  new Helper;
        $str = new Str;
        return view('admin.apartments.create',
                compact(
                    'others',
                    'property_types',
                    'str','helper',
                    'extras',
                    'bedrooms',
                    'apartment_facilities',
                    'counter',
                    'locations',
                    'attributes'
                ));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request,[
            "apartment_name"  => "required",
            'address'=> "required",
            "description" => "required"
        ]);

        $property =  $this->property($request);
 
        /**
         * Rooms
        */
        if ($request->type == 'single' ){
            $apartment = new Apartment;  
            $this->propertyWithSingleApartments($request, $apartment, $property);
        }

        $data = [];
        if ($request->type != 'single' ){
            $this->propertyWithMultipleApartments($request, $property);
        }
  
        /**
         * Rooms with have includes
        */
        (new Activity)->Log("Created a new property {$request->apartment_name}");
        return \Redirect::to('/admin/properties');
    }

    public function property($request, $id=null, $update=false) 
    {   

        $property  = $id ?  Property::find($id) : new Property;
        $token     = mt_rand(); 
        $location_ids = array_reverse($request->location_id);
        $location_ids = Location::find($location_ids);
        $location_full_name = implode(', ', array_reverse($location_ids->pluck('name')->toArray()));
        $title     = $id ? $request->apartment_name.'-'.$property->token : $request->apartment_name.'-'.$token;
        $property->name      = $request->apartment_name;
        $property->address   = $request->address;
        $property->image     = $request->image;
        $property->type                 = $request->type;
        $property->description          = $request->description;
        $property->is_refundable        =  $request->is_refundable ? 1 : 0;
        $property->check_in_time        =  $request->check_in_time;
        $property->check_out_time       =  $request->check_out_time;
        $property->is_refundable        =  $request->is_refundable ? 1 : 0;
        $property->cancellation_message = $request->cancellation_message;
        $property->cancellation_fee     = $request->cancellation_fee;
        $property->virtual_tour         = $request->virtual_tour;
        $property->featured             = $request->featured ? 1 : 0;
        $property->allow                = $request->allow ? 1 : 0;
        $property->location_full_name   = $location_full_name;
        $property->slug                 = str_slug($title);
        $property->token                =  $id ? $property->token : $token;
        $property->save();
        $property->locations()->sync($request->location_id);
        $property->attributes()->sync($request->apartment_facilities_id);
        $property->attributes()->syncWithoutDetaching($request->attribute_id);
        $this->syncExtras($request->property_extras,  $request->property_extra_services, $property);
        $locations = Location::find($request->location_id);
        foreach($request->attribute_id as $key => $attribute ){
           if ($key && is_string($key)){
                $property->attributes()->updateExistingPivot($attribute, [
                    'name' => $key,
                ]);
           }
        }
        foreach( $locations as $location )
        {
            $location->attributes()->sync($request->attribute_id);
        }

        return $property;
    }

    public function syncExtras($extras, $extra_services_price = [],  $obj){
        $obj->attributes()->syncWithoutDetaching($extras);
        if(!empty($extra_services_price)) {
            $prices = array_filter($extra_services_price);
            if(!empty($prices)){
                foreach( $prices as $key  => $extra ) {
                    $obj->attributes()->updateExistingPivot($key, [
                        'price' => $extra,
                    ]);
                }
            }
        }
        
          
    }

    public function propertyWithMultipleApartments($request,  $property) 
    {    
        $price = implode(array_values($request->room_price));
        foreach ($request->room_price  as $key => $room) {
            $apartment = new Apartment;  
            $room_images = !empty($request->room_images[$key]) ? $request->room_images[$key] : [];
            $apartment->name = $request->room_name[$key];
            $apartment->price = $request->room_price[$key];
            $apartment->sale_price          = $request->room_sale_price[$key];
            $apartment->slug                    = str_slug($request->room_name[$key]);
            $apartment->max_adults              = $request->room_max_adults[$key];
            $apartment->quantity                = $request->room_quantity[$key];
            $apartment->type                    = $request->type;
            $apartment->max_children            = $request->room_max_children[$key];
            $apartment->no_of_rooms             = $request->room_number[$key];
            //$apartment->available_from          = Helper::getFormatedDate($request->room_avaiable_from[$key],true);
            $apartment->sale_price_expires      = Helper::getFormatedDate($request->room_sale_price_expires[$key],true);
            $apartment->property_id             = $property->id;
            $apartment->uuid                    =  time();
            $apartment->toilets                 = $request->room_toilets[$key];
            $apartment->save();
            $this->syncImages($room_images, $apartment, $property);
            $this->syncAttributes($request, $apartment, $key);
            $this->syncExtras($request->multiple_apartment_extras,  $request->multiple_apartment_extra_services, $apartment);
            
        }

        $property->price  =  $price;
        $property->save();

    }

    public function propertyWithSingleApartments($request, $apartment, $property)
    {   
        $room_images           = !empty($request->room_images) ? $request->room_images : [];
        $apartment->price      = $request->single_room_price;
        $apartment->sale_price           = $request->single_room_sale_price;
        $apartment->slug                 = str_slug($request->single_room_name);
        $apartment->max_adults           = $request->single_room_max_adults;
        $apartment->quantity             = 1;
        $apartment->type                 = $request->type;
        $apartment->max_children         = $request->single_room_max_children;
        $apartment->no_of_rooms          = $request->single_room_number;
        //$apartment->available_from     = Helper::getFormatedDate($request->single_room_avaiable_from,true);
        $apartment->sale_price_expires   = Helper::getFormatedDate($request->single_room_sale_price_expires,true);
        $apartment->property_id          = $property->id;
        $apartment->uuid                 = time();
        $apartment->toilets              = $request->single_room_toilets;
        
        $apartment->save();
        $property->price  =  $request->single_room_price;
        $property->save();

        $this->syncImages($room_images, $apartment, $property);
        $this->syncAttributes($request, $apartment);
        $this->syncExtras($request->single_apartment_extras,  $request->single_apartment_extra_services, $apartment);
    }

    public function syncAttributes($request, $apartment, $key=null){
        $beds = array_filter($this->beds($request, $key));
        $apartment->attributes()->sync($beds);
        foreach( $apartment->bedrooms  as $bed ) {
            if (!empty($request->bed_count)){
                foreach( $request->bed_count as $k  => $b ) {
                   if ($k  == $bed->id ){
                        $apartment->attributes()->updateExistingPivot($k, [
                            'bed_count' => $b,
                        ]);
                   }
                }
            }
            
        }


        $apartment->attributes()->syncWithoutDetaching($request->attribute_id);
    }

    public function syncImages($images, $attr, $property=null){
        if ( count( $images )  > 0) {
            $images = array_filter($images);
            foreach ( $images  as $image) {
                $imgs= new Image(['image' => $image,'property_id' => $property->id]);
                $attr->images()->save($imgs);
            }
        }
    }



    public function beds($request, $key=null){
        $beds = []; 
        for ($i=1; $i < 10; $i++) { 
            $input  =  $key ?  'bedroom_'.$i.'_'.$key : 'bedroom_'.$i;
            $input  =  $request->$input;
            $beds[] =  $input;
        }
        return $beds;
    }

    public function newRoom(Request $request){
        $counter = rand(1,500);
        $bedrooms =  Attribute::parents()->where('type','bedrooms')->orderBy('sort_order','asc')->get();
        $attributes = Attribute::parents()->whereIn('type' ,$this->types)->get();
        $apartment_facilities =  Attribute::parents()->where('type','apartment facilities')->orderBy('sort_order','asc')->get();
        $extras =  Attribute::parents()->where('type','extra services')->orderBy('sort_order','asc')->get();
        $helper = new Helper;
        return view('admin.apartments.variation',
                compact('extras','bedrooms','apartment_facilities','counter','attributes','helper')
            );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   
        $property   = Property::find($id);
        $locations  = Location::parents()->get();
        $helper     = new Helper();
        $counter    = rand(1,500);
        $attributes = Attribute::parents()->whereIn('type' ,$this->types)->get()->groupBy('type');
        $apartment_facilities  = Attribute::parents()->where('type','apartment facilities')->orderBy('sort_order','asc')->get();
        $counter               = rand(1,500);
        $str                   = new Str;
        $others               =  Attribute::where('type','other')->orderBy('sort_order','asc')->get()->groupBy('parent.name');
        $bedrooms              = Attribute::parents()->where('type','bedrooms')->orderBy('sort_order','asc')->get();
        $extras =  Attribute::parents()->where('type','extra services')->orderBy('sort_order','asc')->get();
        $property_types =  Attribute::parents()->where('type','property type')->orderBy('sort_order','asc')->get();
        return view('admin.apartments.edit',compact('others','property_types','extras','str','bedrooms','counter','attributes','locations','property','helper','apartment_facilities'));
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
        $this->validate($request,[
            "apartment_name"  => "required",
            'address'=> "required",
            "description" => "required"
        ]);
         
        $property = $this->property($request, $id, true);
        /**
         * Reservation Images
        */
        $data = [];

        if ( $request->type == 'single' ) {
            $apartment = $property->single_room; 
            $this->propertyWithSingleApartments($request, $apartment, $property);
        }
        

        if(!empty($request->edit_room_name) && !$request->has('new_room')){
            $price = implode(array_values($request->edit_room_price));
            $property->price  =  $price;
            $property->save();
            foreach($request->edit_room_name as $room_id => $room ){ 
                $room_images = !empty($request->edit_room_images[$room_id]) ? $request->edit_room_images[$room_id] : [];
                $apartment       =  Apartment::updateOrCreate(
                    ['id' => $room_id],
                    [
                        'name'                 => $request->edit_room_name[$room_id],
                        'price'                => $request->edit_room_price[$room_id],
                        'sale_price'           => $request->edit_room_sale_price[$room_id],
                        'sale_price_expires'   => Helper::getFormatedDate($request->edit_room_sale_price_expires[$room_id]),
                        'slug'                 => str_slug($request->edit_room_name[$room_id]),
                        'max_adults'           => $request->room_max_adults[$room_id],
                        'max_children'         => $request->room_max_children[$room_id],
                        'property_id'          => $property->id,
                        'no_of_rooms'          => $request->room_number[$room_id],
                        'toilets'              => $request->apartment_toilets[$room_id],
                        'type'                 => $request->type,             
                    ]
                );
                /**
                 * Sync Images
                */
                
                if( !empty($request->new_room_images) ){
                    foreach ( $request->new_room_images as $room_id => $images) {
                        $variation = Apartment::find($room_id);
                        $images = array_filter( $images);
                        foreach ( $images as $image) {
                            if ($image == ''){
                               continue;
                            }
                            $images = new Image(['image' => $image,'property_id' => $property->id]);
                            $variation->images()->save($images);
                        }
                    }
                }

                $this->syncAttributes($request, $apartment, $room_id);
                $this->syncExtras($request->multiple_apartment_extras,  $request->multiple_apartment_extra_services, $apartment);
            }
        }

        /**
         * New apartments
        */

        $data = [];
        if ($request->has('new_room')){
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
    public function destroy(Request $request,$id)
    {
        User::canTakeAction(5);
        $rules = array (
                '_token' => 'required' 
        );
        $validator = \Validator::make ( $request->all (), $rules );
        if (empty ( $request->selected )) {
            $validator->getMessageBag ()->add ( 'Selected', 'Nothing to Delete' );
            return \Redirect::back ()->withErrors ( $validator )->withInput ();
        }
        $count = count($request->selected);
        (new Activity)->Log("Deleted  {$count} Products");

        foreach ( $request->selected as $selected ){
            $delete = Property::find($selected);
            $delete->apartments()->delete();
            $delete->delete();
        }
        
        return redirect()->back();
    }
}
