<?php

namespace App\Http\Controllers\Uploads;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\UploadFile;

class UploadsController extends Controller
{
    public function upload(Request $request)
    {


        $files = $request->file('file');

        foreach ($files as $file) {
            $path = $file->store('images/uploads');
            $file = basename($path);
            $path =  public_path('images/uploads/' . $file);
            $path = asset('images/uploads/' . $file);
            $request->session()->put('session_link', $path);
        }
        return  response()->json([
            'mes' => 'done'
        ], 200);
    }

    public function uploadVideos(Request $request)
    {
        $path = $request->file('file')->store('videos', 's3_videos');
        $file = basename($path);
        $path =  public_path('images/uploads/' . $file);
        $path = asset('images/uploads/' . $file);
        $request->session()->put('session_id', uniqid(true));
        $upload = new UploadFile;
        $upload->link = $path;
        $upload->session_id = session('session_id');
        $upload->type = 'image';
        $upload->save();
        return $path = asset('images/uploads/' . $file);
    }
}
