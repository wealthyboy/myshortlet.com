<?php

namespace App\Http\Controllers\Admin\Image;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Image;
use App\Models\SystemSetting;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Facades\Image as Img;



class ImagesController extends Controller
{
    protected $settings;

    protected $folders = ['attributes', 'category', 'reviews', 'banners', 'blog', 'uploads', 'apartments', 'locations'];

    public function __construct()
    {
        $this->settings =  SystemSetting::first();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //All the apps image goes  to the image table
        if ($request->filled('image_id') && $request->image_id !== 'undefined') {
            $this->update($request);
        }
        $path = $this->uploadImage($request);
        return response()->json(['path' => $path]);
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $path =  $this->uploadImage($request);
        $image = Image::find($request->image_id);
        $image->image = $path;
        $image->save();
        return 'Image Updated';
    }




    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,webp,jpg,gif',
            'folder' => 'required'
        ]);

        if (!in_array($request->folder, $this->folders)) {
            return response()->json(['error' => $request->folder . ' not allowed'], 403);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $folder = $request->folder;

        // Original
        $originalPath = 'images/' . $folder . '/' . $fileName;
        Storage::disk('spaces')->put($originalPath, file_get_contents($file), 'public');

        // Medium (400x400)
        $mediumImage = Img::make($file)->fit(400, 400)->encode();
        $mediumPath = 'images/' . $folder . '/m/' . $fileName;
        Storage::disk('spaces')->put($mediumPath, $mediumImage, 'public');

        // Thumbnail (106x145 canvas)
        $canvas = Img::canvas(106, 145);
        $thumbImage = Img::make($file)->resize(150, 250, function ($constraint) {
            $constraint->aspectRatio();
        });
        $canvas->insert($thumbImage, 'center');
        $thumbnailPath = 'images/' . $folder . '/tn/' . $fileName;
        Storage::disk('spaces')->put($thumbnailPath, $canvas->encode(), 'public');

        $path = Storage::disk('spaces')->url($originalPath);

        return  $path;
    }



    public static function undo(Request $request)
    {
        $file = basename($request->image_url);

        $class = '\\App\\Models\\' . $request->model;


        $folder = $request->folder;

        // Build paths for DO Spaces
        $original = "images/{$folder}/{$file}";
        $medium = "images/{$folder}/m/{$file}";
        $thumbnail = "images/{$folder}/tn/{$file}";
        Storage::disk('spaces')->delete([$original, $medium, $thumbnail]);


        // Delete from Spaces

        if ($request->filled('model')) {

            if ($request->image_id && $request->filled('type')) {
                $model = $class::find($request->image_id);
                if ($model) {
                    $model->delete();
                }
                return response(null, 200);
            } else {
                $model = $class::find($request->image_id);
                if ($model) {
                    $model->image = null;
                    $model->save();
                }
                return response(null, 200);
            }
        }
        return response(null, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if ($request->filled('image_url')) {
            if (self::undo($request)  == true) {
                return response('deleted', 200);
            }
        }
    }
}
