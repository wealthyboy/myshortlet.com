<?php

namespace App\Http\Controllers\Admin\Location;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\User;
use App\Models\Location;
use App\Models\Activity;
use Illuminate\Validation\Rule;




class LocationController extends Controller
{

    public function __construct()
    {
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $locations = Location::parents()->get();
        return view('admin.location.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        User::canTakeAction(2);
        return view('admin.location.create');
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
        if ($request->filled('parent_id')) {
            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('locations')->where(function ($query) use ($request) {
                        $query->where('parent_id', '!=', null)
                            ->where('parent_id', $request->parent_id);
                    })

                ],
            ]);
        } else {
            //define validation 
            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('locations')->where(function ($query) {
                        $query->where('parent_id', '=', null);
                    })

                ],
            ]);
        }

        $location = new Location;
        $location->name = $request->name;
        $location->image = $request->image;
        $location->description = $request->description;
        $location->location_type = $request->location_type;
        $location->slug = $this->makeSlug($request->parent_id, $request->name);
        $location->location_full_name = $this->makeSlug($request->parent_id, $request->name, ', ');
        $location->parent_id  = $request->parent_id;
        $location->save();

        (new Activity)->Log("Created a new Location called {$request->name}");
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        User::canTakeAction(4);
        $location = Location::find($id);
        $locations = Location::parents()->get();
        return view('admin.location.edit', compact('location', 'locations'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $location = Location::find($id);
        if ($request->filled('parent_id')) {
            $locationId = Location::find($request->parent_id);
            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('locations')->where(function ($query) use ($request, $location) {
                        $query->where('parent_id', '=', $request->parent_id);
                    })->ignore($id)

                ],
            ]);
        }
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('locations')->where(function ($query) use ($id) {
                    $query->where('parent_id', '=', null);
                })->ignore($id)

            ],
        ]);
        $location->name = $request->name;
        $location->image = $request->image;
        $location->description = $request->description;
        $location->location_type = $request->location_type;
        $location->slug = $this->makeSlug($request->parent_id, $request->name,);
        $location->location_full_name = $this->makeSlug($request->parent_id, $request->name, ', ');

        $location->parent_id  = $request->parent_id;
        $location->save();
        //Log Activity
        (new Activity)->Log("Updated  Location {$request->name} ");
        return redirect()->action('Admin\Location\LocationController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
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
        Location::destroy($request->selected);
        return redirect()->back();
    }



    public function makeSlug($parent_id, $name, $format = '-')
    {
        $cat = $parent_id ? Location::find($parent_id) : null;
        if (null !== $cat) {
            if ($cat->parent_id) {
                $parent = Location::find($cat->parent_id);
                if ($parent->parent_id) {
                    $parent = Location::find($parent->parent_id);
                    return  str_slug($name . ' ' . $cat->name . ' ' . $parent->name, $format);
                }
                return  str_slug($name . ' ' . $cat->name . ' ' . $parent->name, $format);
            }
            return $slug = null !== $cat ? str_slug($name . ' ' . $cat->name, $format) : str_slug($name, $format);
        }
        return str_slug($name, $format);
    }
}
