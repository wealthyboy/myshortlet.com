<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;



class PageController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $links = [
            'contact-us' => 'contact_us',
            'experience' => 'experience',
            'about-us' => 'about',
            'gallery' => 'gallery',
        ];

        // Path to the folder containing the images
        $folderPath = public_path('images/apartments'); // Adjust the folder path as needed

        // Get a list of files in the folder
        $files = File::allFiles($folderPath);

        $link_name = Str::replaceFirst('-', ' ', request()->path());
        $link_name = ucfirst($link_name);
        return view('links.' . $links[request()->path()], compact('files', 'link_name'));
    }
}
