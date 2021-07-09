<?php

namespace App\Http\Controllers\Properties;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Location;
use App\Models\Attribute;
use App\Models\Room;



use Illuminate\Support\Facades\Notification;
use App\Notifications\ApartmentUpload;

class PropertiesController extends Controller
{   

    public function __construct()
    {	  
	    $this->middleware('auth'); 
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = \Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->latest()->simplePaginate(5);
        return view('properties.index',compact('apartments'));
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
        $locations = Location::where('location_type','state')->get();
        $counter = rand(1,500);
        $attributes =  Attribute::parents()->where('type',null)->orderBy('sort_order','asc')->get();
        $rules =  Attribute::parents()->where('type','rules')->orderBy('sort_order','asc')->get();
        $bedrooms =  Attribute::parents()->where('type','bedroom')->orderBy('sort_order','asc')->get();
        $extra_services =  Attribute::parents()->where('type','extra_services')->orderBy('sort_order','asc')->get();
        $facilities =  Attribute::parents()->where('type','facilities')->orderBy('sort_order','asc')->get();

        return view('properties.create',
                    compact(
                            'type',
                            'step',
                            'locations',
                            'facilities',
                            'rules',
                            'bedrooms',
                            'extra_services',
                            'facilities',
                            'counter'
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
        
         $user = $request->user();

        if ($request->step == 'two' &&  $request->apartment_id) {
            $apartment = Apartment::find($request->apartment_id);  
            $apartment->attributes()->sync($request->facility_id);
            $step = $request->step;
            $type = $request->type;
            return redirect()->route('properties.create', ['step' => $step, 'type' => $type,'apartment_id' => $apartment->id]);
        }


        if ($request->step == 'three' &&  $request->apartment_id) {
            $apartment = Apartment::find($request->apartment_id);  
            $apartment->attributes()->sync($request->facility_id);
            $step = $request->step;
            $type = $request->type;
            return redirect()->route('properties.create', ['step' => $step, 'type' => $type,'apartment_id' => $apartment->id]);
        }


        if ($request->step == 'finish' &&  $request->apartment_id) {
            $data = [];
            $apartment =  Apartment::find(session('apartment_id'));

            //dd($request->apartment_name);
            foreach ($request->apartment_name  as $key => $room) {
                $room = new Room;  
                $images = !empty($request->apartment_images[$key]) ? $request->apartment_images[$key] : [];
                $image = array_shift($images);
                $room->name         = $request->apartment_name[$key];
                $room->price        = $request->price[$key];
                $room->slug         = str_slug($request->apartment_name[$key]);
                $room->max_adults   = $request->adults[$key];
                $room->max_children = $request->children[$key];
                $room->no_of_rooms  = $request->bedrooms[$key];
                $room->toilets      = $request->toilets[$key];
                $room->image        = $image;
                $room->available_from = now();
                $room->apartment_id   = $apartment->id;
                $room->save();
                if ( count( $images )  > 0 ) {
                    $images = array_filter($images);
                    foreach ( $images  as $image) {
                        $imgs= new Image(['image' => $image]);
                        $room->images()->save($imgs);
                    }
                }

                if (!empty($request->attribute_ids)){
                    foreach ($request->attribute_ids as $attributeId) {
                        $data[1] = ['parent_id'=>null]; 
                        $data[$attributeId] = ['parent_id'=>1];  
                    }
                    $room->attributes()->sync($data);
                }
                
            }

            //Send Notification

            try {
                Notification::route('mail', $user->email)
                ->notify(new ApartmentUpload($request));
                return back()->with("success", "Done");
            } catch (\Throwable $th) {
                return back()->with("error", "We could not create the apartment");
            }

            
        } 

        //dd($request->all());

        $user = $request->user();
        $apartment =  new Apartment();
        $uid = uniqid(true);
        $title =  $request->apartment_title.$uid;
        $apartment->name      = $title;
        $apartment->address   = $request->address;
        $apartment->image     = $request->image;
        $apartment->description  = $request->description;
        $apartment->allow        = 0;
        $apartment->status       = 'Pending';
        $apartment->step         = 'one';
        $apartment->slug         = str_slug($title);
        $apartment->user_id      = $user->id;
        $apartment->save();
        $request->session()->put('apartment_id', $apartment->id);
        $apartment->locations()->sync($request->location_id);
        $step = $request->step;
        $type = $request->type;

        return redirect()->route('properties.create', ['step' => $step, 'type' => $type,'apartment_id' => $apartment->id]);
    }




    public function getLocation(Request $request, $id)
    { 
        $locations =  Location::find($id);
        return view('properties.location',compact('locations'));
    }



    public function addApartment(Request $request){
        $counter = rand(1,500);
        $attributes =  Attribute::parents()->where('type',null)->orderBy('sort_order','asc')->get();
        $rules =  Attribute::parents()->where('type','rules')->orderBy('sort_order','asc')->get();
        $bedrooms =  Attribute::parents()->where('type','bedroom')->orderBy('sort_order','asc')->get();
        $extra_services =  Attribute::parents()->where('type','extra_services')->orderBy('sort_order','asc')->get();
        $facilities =  Attribute::parents()->where('type','facilities')->orderBy('sort_order','asc')->get();
        return view('properties.variation',
                        compact('bedrooms','extra_services','facilities','rules','counter','attributes')
                    );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd($id);
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
        dd($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {   
        $apartment = Apartment::find($id)->delete();
        return redirect()->back()->with('success', 'Apartment deleted successfully');
    }
}
