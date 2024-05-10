<?php

namespace App\Http\Controllers\Admin\Attributes;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
use App\Http\Helper;
use App\Models\Activity;
use App\Models\User;
use App\Models\Attribute;
use  Illuminate\Support\Str;


class AttributesController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $attributes = Attribute::parents()->get()->groupBy('type');
        $parents = Attribute::parents()->get();
        $helper = new Helper();
        $str = new  Str;

        return view('admin.attributes.index', compact('str', 'attributes', 'parents', 'helper'));
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
                    Rule::unique('attributes')->where(function ($query) use ($request) {
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
                    Rule::unique('attributes')->where(function ($query) {
                        $query->where('parent_id', '=', null);
                    })

                ],
            ]);
        }
        $attribute = new Attribute;
        $attribute->name = $request->name;
        $attribute->sort_order = $request->sort_order;
        $attribute->color_code = $request->color_code;
        $attribute->image = $request->image;
        $attribute->apartment_owner = $request->apartment_owner;

        $attribute->svg = $request->svg;
        $attribute->slug = str_slug($request->name, '_');
        $attribute->parent_id  = $request->parent_id ? $request->parent_id : null;
        $attribute->type  = $request->type ? $request->type : null;
        $attribute->save();
        (new Activity)->Log("Created a new attribute called {$request->name}");
        return redirect()->back();
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        User::canTakeAction(4);
        $attr = Attribute::find($id);
        $attributes = Attribute::parents()->get();
        $helper = new Helper();
        return view('admin.attributes.edit', compact('attributes', 'attr', 'helper'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $attribute = Attribute::find($id);
        if ($request->filled('parent_id')) {
            $this->validate($request, [
                'name' => [
                    'required',
                    Rule::unique('attributes')->where(function ($query) use ($request) {
                        $query->where('parent_id', '=', $request->parent_id);
                    })->ignore($id)
                ],
            ]);
        }
        $this->validate($request, [
            'name' => [
                'required',
                Rule::unique('attributes')->ignore($id)
            ],
        ]);

        $attribute->name =        $request->name;
        $attribute->sort_order = $request->sort_order;
        $attribute->parent_id  = $request->parent_id ? $request->parent_id : null;
        $attribute->color_code = $request->color_code;
        $attribute->image      = $request->image;
        $attribute->apartment_owner = $request->apartment_owner;
        $attribute->svg = $request->svg;

        $attribute->slug       = str_slug($request->name, '_');
        $attribute->type       = $request->type;
        $attribute->save();
        //Log Activity
        (new Activity)->Log("Updated  Attribute {$request->name} ");
        return redirect()->route('attributes.index', ['type' => $attribute->type]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
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
        Attribute::destroy($request->selected);
        return redirect()->back();
    }
}
