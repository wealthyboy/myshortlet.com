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
        $generator = new self;
        $images = $this->images();
        return view('links.' . $links[request()->path()], compact('images', 'generator', 'files', 'link_name'));
    }


    public  static function generateThumbnailUrl($originalUrl)
    {
        // Extract the ID from the original URL using regular expressions
        preg_match('/\/file\/d\/(.+?)\//', $originalUrl, $matches);
        $id = $matches[1];

        // Construct the thumbnail URL
        $thumbnailUrl = "https://drive.google.com/thumbnail?id={$id}&sz=w2000";

        return $thumbnailUrl;
    }

    public  function images()
    {

        return [

            'sliders' => [
                'https://drive.google.com/file/d/17jMj4PYxnUgEa37VTw513F61Tk3WTi8a/view?usp=drive_link',
                'https://drive.google.com/file/d/1xe9lnx6RfmSpQSp_r9tSOWwV1RNmMBxY/view?usp=drive_link',
                'https://drive.google.com/file/d/1R3qBwhzOU479zhtMiPxtx8sPUp4iqoMe/view?usp=drive_link',
                'https://drive.google.com/file/d/16XtNpeqCSoiPVZ4KhTRb0rq72tYosN3h/view?usp=drive_link',
                'https://drive.google.com/file/d/1Ob-RctxqUb6nmoBNl53V-vY6uSDGfY-W/view?usp=drive_link',
                'https://drive.google.com/file/d/1j0b9Hih3ozJgipUpJuAGjlENkuqndo2N/view?usp=drive_link',
                'https://drive.google.com/file/d/1C3EWAhlUIjKurP91K6fCLz5MnEFpet5c/view?usp=drive_link',
            ],

            'welcome' => [
                'https://drive.google.com/file/d/1ES6PROkjg09AnQdO2hn033mzg48dJT8S/view?usp=drive_link',
            ],
            'amenities' => [
                'https://drive.google.com/file/d/1objnfLxXO6ui1XncszCPhF9skQMbnM8t/view?usp=drive_link',
            ],
            'gallery' => [
                'https://drive.google.com/file/d/1iS_70GjTLThz4NGdPDYUbLneEq8z5ev9/view?usp=drive_link',
                'https://drive.google.com/file/d/1VVLjDieMwBTHJBfcDb6lv7EOh1dHCnGW/view?usp=drive_link',
                'https://drive.google.com/file/d/1EUI6dfkxfcyvdbKL_y0aZfT61sGXk6r7/view?usp=drive_link',
                'https://drive.google.com/file/d/1hw7i_IpvKuALzlJcJDm4Dcb5fyV4ExsN/view?usp=drive_link',
                'https://drive.google.com/file/d/1objnfLxXO6ui1XncszCPhF9skQMbnM8t/view?usp=drive_link',
                'https://drive.google.com/file/d/1xe9lnx6RfmSpQSp_r9tSOWwV1RNmMBxY/view?usp=drive_link',
                'https://drive.google.com/file/d/1V1SRVA1JQEUaFHwCsqTpvQkKr1d6vOAI/view?usp=drive_link',
                'https://drive.google.com/file/d/1TC5cOTsxA5h7YnjY0NJkvvCOVPrzTxGY/view?usp=drive_link',
                'https://drive.google.com/file/d/1SberdfVKwB_MCQnO1zOsEiFCJ6ZFcI_2/view?usp=drive_link',
                'https://drive.google.com/file/d/19r4ddA9EBAlq7g37zN64N3Voz1tuglIm/view?usp=drive_link',
                'https://drive.google.com/file/d/1ozt2otCY9XmxbjQMtAjcU0YKXJcapqke/view?usp=drive_link',
                'https://drive.google.com/file/d/1iVvVYIaeYqu8heqyUgSB1wkEWHettHEv/view?usp=drive_link',
                'https://drive.google.com/file/d/1sZqQUvUmj-hs0rh8u_MoMHb6ldMtvhjP/view?usp=drive_link',
                'https://drive.google.com/file/d/1dG4yq-xF7X4A8LchRBmymYNaygiIg5tg/view?usp=drive_link'

            ]

        ];
    }
}
