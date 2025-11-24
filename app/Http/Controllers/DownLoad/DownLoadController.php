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
        $images = $apartment->images; // Relationship

        if ($images->isEmpty()) {
            return response()->json(['error' => 'No images found'], 404);
        }

        // Temp ZIP path
        $zipFileName = 'apartment_' . $apartment->id . '_images.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);

        // Create ZIP
        $zip = new \ZipArchive;

        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {

            foreach ($images as $img) {
                $url = $img->image; // Full DO Spaces URL

                // Download image temp file
                $tempFile = tempnam(sys_get_temp_dir(), 'img_');
                file_put_contents($tempFile, file_get_contents($url));

                // Use clean filename inside ZIP
                $fileName = basename(parse_url($url, PHP_URL_PATH));

                // Add file
                $zip->addFile($tempFile, $fileName);
            }

            $zip->close();
        }

        // Return ZIP to browser
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }



    public function convertStringToArray($str)
    {
        $array = explode(',', $str);
        return $array;
    }
}
