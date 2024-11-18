<?php

namespace App\Http\Controllers\DownLoad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownLoadController extends Controller
{
   
    public function index()
    {   
        $apartments = Apartment::where('allow', 1)->get();
	    return view('download.index', compact('apartments'));
    }


    public function downloadImages($id)
    {   
         
        $apartment = Apartment::find($id);
        $imageUrls = $this->convertStringToArray($apartment->image_link);
        $zipFileName = 'images.zip';
        $zipFilePath = storage_path($zipFileName);
        $zip = new ZipArchive;

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($imageUrls as $key => $url) {
                $response = Http::get($url);
                if ($response->successful()) {
                    $imageContent = $response->body();
                    $imageName = basename($url);
                    $zip->addFromString($imageName, $imageContent);
                }
            }
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create ZIP file'], 500);
        }

        // Return the ZIP file as a response for download
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    public function convertStringToArray($str)
    {
        $array = explode(',', $str);
        return $array;
    }


}
