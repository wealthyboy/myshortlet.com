<?php

namespace App\Http\Controllers\Admin\Gallery;

use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Image;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.gallery.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $images =  $request->images;
        $input = $request->all();
        $input['is_gallery'] = 1;

        $gallery = Gallery::create($request->all());

        if (count($images)  > 0) {
            $images = array_filter($images);
            foreach ($images  as $image) {
                $imgs = new Image(['image' => $image]);
                $gallery->images()->save($imgs);
            }
        }

        return redirect()->route('admin.galleries.index');
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function show(Gallery $gallery)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function edit(Gallery $gallery)
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gallery $gallery)
    {

        $gallery->update($request->all());

        $images =  $request->images;

        if (count($images)  > 0) {
            $images = array_filter($images);
            foreach ($images  as $image) {
                $imgs = new Image(['image' => $image]);
                $gallery->images()->save($imgs);
            }
        }

        return redirect()->route('admin.galleries.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Gallery $gallery)
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
        //(new Activity)->Log("Deleted  {$count} Products");

        foreach ($request->selected as $selected) {
            $delete = Gallery::find($selected);
            $delete->delete();
        }

        return redirect()->back();
    }
}
