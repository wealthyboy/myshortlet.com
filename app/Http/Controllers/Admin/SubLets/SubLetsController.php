<?php

namespace App\Http\Controllers\Admin\SubLets;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use App\Models\SubLet;
use Illuminate\Validation\Rule;

class SubLetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sublets = SubLet::get();
        return  view('admin.sublets.index', compact('sublets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $agents = (new User())->agents()->latest()->get();
        $properties = Property::with('children')->get();
        return  view('admin.sublets.create', compact('agents', 'properties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('sub_lets'),
            ],
        ]);

        $user = User::find($request->user_id);
        $data = [];
        $user->user_apartments()->sync($this->apartmentsId($request));

        $user->properties()->sync($request->property_id);
        $sublet = new SubLet;
        $sublet->user_id = $request->user_id;
        $sublet->save();

        return redirect()->route('admin.sublets.index');
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


    public function apartmentsId($request)
    {
        $data = [];
        $apartments =  Apartment::find($request->apartment_id);
        if (null !== $apartments) {
            foreach ($apartments as $apartment) {
                $data[$apartment->id] = ['property_id' => $apartment->property_id];
            }
        }

        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sublet = SubLet::find($id);
        $agents = (new User())->agents()->latest()->get();
        $properties = Property::with('children')->get();
        $helper = new Helper;
        return  view('admin.sublets.edit', compact('helper', 'sublet', 'agents', 'properties'));
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

        $request->validate([
            'user_id' => [
                'required',
                Rule::unique('sub_lets')->ignore($id),
            ],
        ]);


        $user = User::find($request->user_id);
        $apartments = Apartment::find($request->apartment_id);

        $user->user_apartments()->sync($this->apartmentsId($request));

        $user->properties()->sync($request->property_id);
        $sublet = SubLet::find($id);
        $sublet->user_id = $request->user_id;
        $sublet->save();

        return redirect()->route('admin.sublets.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $rules = array(
            '_token' => 'required'
        );

        $validator = \Validator::make($request->all(), $rules);
        if (empty($request->selected)) {
            $validator->getMessageBag()->add('Selected', 'Nothing to Delete');
            return \Redirect::back()->withErrors($validator)->withInput();
        }
        $count = count($request->selected);
        // (new Activity)->Log("Deleted  {$count} Products");

        SubLet::destroy($request->selected);

        return redirect()->back();
    }
}
