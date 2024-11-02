<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Apartment;
use App\Models\Gallery;
use App\Models\Property;
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
        $request = request();
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

        $types =  [
            'extra_services',
            'facilities',
            'rules',
            'room_facilities',
            'other' => 'other'
        ];

        $str = new  Str;
        $date = $request->check_in_checkout;
        $property_is_not_available = null;
        $cites = [];
        $page_title = null;

        $date = explode("to", $request->check_in_checkout);
        $date = Helper::toAndFromDate($request->check_in_checkout);
        $property_is_not_available = null;
        $data = [];
        $attributes = null;
        $data['max_children'] = $request->children ?? 1;
        $data['max_adults'] = $request->adults ?? 1;
        $data['rooms'] = $request->rooms ?? 1;
        $startDate = $date['start_date'];
        $endDate = $date['end_date'];
        $properties = null;
        $breadcrumb = null;

        $query = Apartment::query();

        if ($request->check_in_checkout) {
            // Check if apartment_id is present in the request
            if ($request->has('apartment_id')) {
                $apartmentId = $request->apartment_id;

                $query->where('id', $apartmentId); // Filter by the provided apartment ID
            }
            $query->whereDoesntHave('reservations', function ($query) use ($startDate, $endDate) {
                $query->where(function ($q) use ($startDate, $endDate) {
                    $q->where('checkin', '<', $endDate)
                        ->where('checkout', '>', $startDate);
                });
            })
                ->where('apartments.max_adults', '>=',  $data['max_adults'])
                ->where('apartments.max_children', '>=', $data['max_children'])
                ->where('apartments.no_of_rooms', '>=', $data['rooms']);
        }




        $apartments = $query->where('allow', 1)->latest()->get();
        $saved = null;
        $property = Property::first();

        $galleries = Gallery::all();
        $galleries->load('images');
        $apartments->load('images', 'bedrooms', 'bedrooms.parent', 'property', 'apartment_facilities', 'apartment_facilities.parent');
        foreach ($apartments as $apartment) {
            $apartment->is_gallery = 1;
        }



        $isGallery = false;
        return view('links.' . $links[request()->path()], compact('isGallery', 'apartments', 'galleries', 'property', 'images', 'generator', 'files', 'link_name'));
    }


    public function gallery(Request $request) {
        $apartments = Apartment::where('allow', true)->get();
       return view('pages.gallery', compact('apartments'));
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
                'https://drive.google.com/file/d/1v-7R-SfQsAzLb0zPzvfn147ViMVp-liJ/view?usp=drive_link',
                'https://drive.google.com/file/d/1RzsrCOIEuV9dZSCL2r4TeYN9jK1dm5A4/view?usp=drive_link',
                'https://drive.google.com/file/d/1VVLjDieMwBTHJBfcDb6lv7EOh1dHCnGW/view?usp=drive_link',
                'https://drive.google.com/file/d/1EUI6dfkxfcyvdbKL_y0aZfT61sGXk6r7/view?usp=drive_link',
                'https://drive.google.com/file/d/1ZIlkG4pBMD8FycEtq0XLZ1jIllXA71qA/view?usp=drive_link',
                'https://drive.google.com/file/d/1hw7i_IpvKuALzlJcJDm4Dcb5fyV4ExsN/view?usp=drive_link',
                'https://drive.google.com/file/d/1xe9lnx6RfmSpQSp_r9tSOWwV1RNmMBxY/view?usp=drive_link',
                'https://drive.google.com/file/d/1TC5cOTsxA5h7YnjY0NJkvvCOVPrzTxGY/view?usp=drive_link',
                'https://drive.google.com/file/d/1nSFx6fjbtbhtugr6L3h00TdlqOgHlJ7q/view?usp=drive_link',
                'https://drive.google.com/file/d/1SberdfVKwB_MCQnO1zOsEiFCJ6ZFcI_2/view?usp=drive_link',
                'https://drive.google.com/file/d/1iVvVYIaeYqu8heqyUgSB1wkEWHettHEv/view?usp=drive_link',
                'https://drive.google.com/file/d/1sZqQUvUmj-hs0rh8u_MoMHb6ldMtvhjP/view?usp=drive_link',
                'https://drive.google.com/file/d/1dG4yq-xF7X4A8LchRBmymYNaygiIg5tg/view?usp=drive_link',
                'https://drive.google.com/file/d/17Q7VVil2pSVfCUMIGjpPd8_KRxvTbq3G/view?usp=drive_link',
                'https://drive.google.com/file/d/1iFlKwt-LtCc11KkjPndzUiiXlMG-LvUL/view?usp=drive_link',
                'https://drive.google.com/file/d/1EUI6dfkxfcyvdbKL_y0aZfT61sGXk6r7/view?usp=drive_link',
                'https://drive.google.com/file/d/1Rr5JVlFUg62HHYpBokrfORs0A9eRBXAQ/view?usp=drive_link',
                'https://drive.google.com/file/d/1bOCz16X5_GjfRblDoRJzoi_R3cl1rFS2/view?usp=drive_link',
                'https://drive.google.com/file/d/1Wd0OcGVZSVEEGxciOqy352RaKBE_LOrQ/view?usp=drive_link',
                'https://drive.google.com/file/d/1jr3i7vnw6vEOXxdbytxQXAbPBWh-Cftz/view?usp=drive_link',

            ],
            'galleries' => [
                'https://drive.google.com/file/d/14Cs_EverqoXZzrULmISAY4gob8H-FmIf/view?usp=drive_link',
                'https://drive.google.com/file/d/1GlZ6VnD1-5X-v2F3t6aOURj6_NglHntq/view?usp=drive_link',
                'https://drive.google.com/file/d/1PkWq5ywzQFtfgSWS6upURACNZqpNPA7S/view?usp=drive_link',
                'https://drive.google.com/file/d/1GnVcGa_0a3bUK3XSwslR5897WuKQ-sND/view?usp=drive_link',
                'https://drive.google.com/file/d/10ZKxqrPiNluPxctigzKySsmD7SQZt2cp/view?usp=drive_link',
                'https://drive.google.com/file/d/1XVifwFHzqCiUj_1lCJN5DtbHfOBE-UBZ/view?usp=drive_link',
                'https://drive.google.com/file/d/1zNFmNAksuagR1nyF5CQo_x26dkn8_Yc-/view?usp=drive_link',
                'https://drive.google.com/file/d/1SberdfVKwB_MCQnO1zOsEiFCJ6ZFcI_2/view?usp=drive_link',
                'https://drive.google.com/file/d/1FxsMs7v4d9uOxhJGmoL2fIvdKS-QHy-N/view?usp=drive_link',
                'https://drive.google.com/file/d/1M1pi3oGiUN0ciiKaCPwBJ2N2XcCKdWAf/view?usp=drive_link',
                'https://drive.google.com/file/d/14VGbmfRmEPtusD84d-6Zw_IJw-UB_EZc/view?usp=drive_link',
                'https://drive.google.com/file/d/1AjClj5aRqMngQUU9NNUt2xR95uEcPWr3/view?usp=drive_link',
                'https://drive.google.com/file/d/1LjRlygtC70SROpF8DKIzdC1ym_R8r9lr/view?usp=drive_link',
                'https://drive.google.com/file/d/1DcONL43ul4K6A_yLalXfI7biTh8UkUAg/view?usp=drive_link',
                'https://drive.google.com/file/d/1BfQGo1rL8_KmMMwU9omFj_pQkx9XhviK/view?usp=drive_link',
                'https://drive.google.com/file/d/1-o52fTQW99uJyqiDo9hOkWJPqNzXU0At/view?usp=drive_link',
                'https://drive.google.com/file/d/1QiqukG1hcCTLi300QSwjxRxIzkTxm83A/view?usp=drive_link',
                'https://drive.google.com/file/d/1joBhWMIO5NYdV7nhSfURfzosjiDEv8z7/view?usp=drive_link',
                'https://drive.google.com/file/d/1TeNIT9ydTc1nPfs_FWUYbumI2ikhnACS/view?usp=drive_link',
                'https://drive.google.com/file/d/1aYGyeo8uhS7Jw_fLNWckCslsC2W7z6C3/view?usp=drive_link',
                'https://drive.google.com/file/d/1_SPzG3pprhP_mDlyUzwrknufoeWE72nf/view?usp=drive_link',
                'https://drive.google.com/file/d/1vd5gcqLSGwdG6vjvXJMm-YxqFQcWPuP3/view?usp=drive_link',
                'https://drive.google.com/file/d/1DdpoYhuhulyZuzvJq7Ctkc9lM1qFz0yI/view?usp=drive_link',
                'https://drive.google.com/file/d/1hDHQEmZDplmSqdo3LX5gl3EaBovq7J-D/view?usp=drive_link',
                'https://drive.google.com/file/d/1huYWcFZsQT0EeBGdYUR9ynbSmDipadmo/view?usp=drive_link',
                'https://drive.google.com/file/d/1zE4REN5O3ybiHXggPz6O5JeO0eovtYM8/view?usp=drive_link',
                'https://drive.google.com/file/d/1N38OQ1Gu-_ELxSGBnTUOFAHdwKdAL3Ru/view?usp=drive_link',
                'https://drive.google.com/file/d/1Eteqnrz67hN5RhujY0j16KuGwMbnp-ab/view?usp=drive_link',
                'https://drive.google.com/file/d/1Eteqnrz67hN5RhujY0j16KuGwMbnp-ab/view?usp=drive_link',
                'https://drive.google.com/file/d/1iRRLFOwNJOFb-rWhYqYTBkNopia8sU81/view?usp=drive_link',
                'https://drive.google.com/file/d/1Jfxv5dOuRER7_QNUMq5iyYGZGYeTUkL7/view?usp=drive_link',
                'https://drive.google.com/file/d/1TC5cOTsxA5h7YnjY0NJkvvCOVPrzTxGY/view?usp=drive_link',
                'https://drive.google.com/file/d/11sjx2H0ttuxvvv6U5GckFeIgnFXWEFZ7/view?usp=drive_link',
                'https://drive.google.com/file/d/1YJJW8_G_uE9Q-utCMcZhvR2KPEOinRyd/view?usp=drive_link',
                'https://drive.google.com/file/d/1EeTjdt6hW8MsKD2mWjO4tKLIrScvFf4S/view?usp=drive_link',
                'https://drive.google.com/file/d/1aajAHSLxJEIrzL6yCRoDgH2VBqFmQhyG/view?usp=drive_link',
                'https://drive.google.com/file/d/1Tl6DLdUTwCHnRi2SKDc_N0zjuoZOaEhm/view?usp=drive_link',
                'https://drive.google.com/file/d/1oS-knA1bJ9QSrVhQlELPoFW9hsdS4vST/view?usp=drive_link',
                'https://drive.google.com/file/d/16-YY0qkk9jfHl3wPOCHGcGiJVYcgZBD2/view?usp=drive_link',
                'https://drive.google.com/file/d/1czwyuBjx4mH6osJ-l7ByukyWbX_FkOXk/view?usp=drive_link',
                'https://drive.google.com/file/d/163xt3IYiyd_qNSlG7UCScOBWtbmozBuz/view?usp=drive_link',
                'https://drive.google.com/file/d/13r6DNnKl5q77krE7lizIM2-vAfnfBkl3/view?usp=drive_link',
                'https://drive.google.com/file/d/1lhO6n3IMGfbCLxAHi_dvw6MLFJhTqaBe/view?usp=drive_link',
                'https://drive.google.com/file/d/1sUI9TlwVaT3TgsxmKctEJWWKpVQ_-Ljn/view?usp=drive_link',
                'https://drive.google.com/file/d/1P2RmFp6gyFGTmMg40ED4V6M-b2s6loMc/view?usp=drive_link',
                'https://drive.google.com/file/d/1PCGq8p62CS2AirALS5dh7kbL4YuIzVJF/view?usp=drive_link',
                'https://drive.google.com/file/d/13T7Q6WSG9G9XbKAv0aWXAarhc3chqQYh/view?usp=drive_link',
                'https://drive.google.com/file/d/1vCoc9znRfuhVGBJoBerYHr6A7V5BGnU5/view?usp=drive_link',
                'https://drive.google.com/file/d/1nSJGqLgMzdD-HS5qFrY6VTsv0nbTf_lt/view?usp=drive_link',
                'https://drive.google.com/file/d/1iVvVYIaeYqu8heqyUgSB1wkEWHettHEv/view?usp=drive_link',
                'https://drive.google.com/file/d/1IJ9_EzjT-4IR6G2rGSg4RgmyoVsjWXCp/view?usp=drive_link',
                'https://drive.google.com/file/d/1HQjJf18jNqgRMynI2yegtF3bltip3xoJ/view?usp=drive_link',
                'https://drive.google.com/file/d/1Y1eaGKkZDXWkHORUQ9ID7OXAQOTTe4C_/view?usp=drive_link',
                'https://drive.google.com/file/d/1PrPEgb_6WwgNHXjP7wkm5IHbFNj4Wzvr/view?usp=drive_link',
                'https://drive.google.com/file/d/1ES6PROkjg09AnQdO2hn033mzg48dJT8S/view?usp=drive_link',
                'https://drive.google.com/file/d/1feyYGrefEpOu6UVhShJtZJjTNV3QZ5Jb/view?usp=drive_link',
                'https://drive.google.com/file/d/1WEO2VwcOvKZe9KQEQutnY17nvtljf6Qu/view?usp=drive_link',
                'https://drive.google.com/file/d/1iY6wAU0sA6tT5vNLWlFc4Os0GMsWzy5x/view?usp=drive_link',
                'https://drive.google.com/file/d/1v-7R-SfQsAzLb0zPzvfn147ViMVp-liJ/view?usp=drive_link',
                'https://drive.google.com/file/d/1nSFx6fjbtbhtugr6L3h00TdlqOgHlJ7q/view?usp=drive_link',
                'https://drive.google.com/file/d/1cwRvwqmaS16WhDKz4oDBs3Fay6kXWyz4/view?usp=drive_link',
                'https://drive.google.com/file/d/1L1UetRRSJdgfFdBzIbdkhVXXt9AkgI9q/view?usp=drive_link',
                'https://drive.google.com/file/d/17Q7VVil2pSVfCUMIGjpPd8_KRxvTbq3G/view?usp=drive_link',
                'https://drive.google.com/file/d/1iFlKwt-LtCc11KkjPndzUiiXlMG-LvUL/view?usp=drive_link',
                'https://drive.google.com/file/d/1EUI6dfkxfcyvdbKL_y0aZfT61sGXk6r7/view?usp=drive_link',
                'https://drive.google.com/file/d/1Rr5JVlFUg62HHYpBokrfORs0A9eRBXAQ/view?usp=drive_link',
                'https://drive.google.com/file/d/1bOCz16X5_GjfRblDoRJzoi_R3cl1rFS2/view?usp=drive_link',
                'https://drive.google.com/file/d/1Wd0OcGVZSVEEGxciOqy352RaKBE_LOrQ/view?usp=drive_link',
                'https://drive.google.com/file/d/1jr3i7vnw6vEOXxdbytxQXAbPBWh-Cftz/view?usp=drive_link',


            ]

        ];
    }
}
