<?php

namespace App\Http;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\SystemSetting;
use App\Models\Category;
use App\Models\CurrencyRate;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;
use App\Models\Apartment;




class Helper
{



    function active_link(array $url)
    {
        $path =   $_SERVER['REQUEST_URI'];
        $link = explode("/", $path);
        return array_intersect($link, $url) ? 'active' : '';
    }


    function getShippingPrice($id)
    {
        $price =  Shipping::findOfail($id);
        return $price->price;
    }


    public  static function getReversedFormatedDate($date)
    {
        /**
         * This function returns a format for month day year
         */
        if ($date) {
            $date =  explode(' ', $date);
            $date =  explode('-', $date[0]);
            $date =  $date[1] . '/' . $date[2] . '/' . $date[0];
            return $date;
        }
        return null;
    }


    public  static function getFDate($date)
    {
        if ($date) {
            $exp_date = explode('-', $date);
            $expiry_date = Carbon::createFromDate($exp_date[0], $exp_date[1], $exp_date[2]); //
        } else {
            $expiry_date = null;
        }
        return $expiry_date;
    }

    public  static function getFormatedDate($date, $changeFormat = true)
    {
        //createFromDate  $year ,$month , $day
        if ($date !== null || $date !== 1) {

            $exp_date = explode('/', $date);

            if (count($exp_date) > 1) {
                if ($changeFormat) {
                    $exp_date = explode('/', $date);
                    $month = $exp_date[0]; //Month
                    $day = $exp_date[1]; //Day
                    $year = $exp_date[2]; //YEar
                    $formarted_date = Carbon::createFromDate($year, $month, $day);
                } else {
                    $exp_date = explode('-', $date);
                    $formarted_date = Carbon::createFromDate($exp_date[0], $exp_date[1], $exp_date[2]); //
                }
                return $formarted_date;
            }
        }
        return null;
    }

    function make_active($link)
    {
        foreach ($this->my_link() as $pages) {
            if (strtolower($pages) == strtolower($link)) {
                return 'active';
            }
        }
    }

    public   static function getDate($date)
    {
        if ($date) {
            $exp_date = explode(' ', $date);
            $exp_date = $date[0];
            // $expiry_date = Carbon::createFromDate($exp_date[2], $exp_date[1], $exp_date[0]);
        } else {
            $expiry_date = null;
        }

        return $expiry_date;
    }


    public static function getTableColumns($table)
    {
        return \DB::getSchemaBuilder()->getColumnListing($table);
    }


    public function makeSlug($parent_id, $name, $model)
    {
        //Tempral solution
        $cat = $parent_id ? $model::find($parent_id) : null;
        if (null !== $cat) {
            if ($cat->parent_id) {
                $parent = $model::find($cat->parent_id);
                if ($parent->parent_id) {
                    $parent = $model::find($parent->parent_id);
                    return  str_slug($parent->name . ' ' . $cat->name . ' ' . $name);
                }
                return  str_slug($parent->name . ' ' . $cat->name . ' ' . $name);
            }
            return $slug = null !== $cat ? str_slug($cat->name . ' ' . $name) : str_slug($name);
        }
        return str_slug($name);
    }


    public static function sanitizeTags($string)
    {
        $tag = strtolower($string);
        $tag = preg_replace('/[^A-Za-z0-9-]+/', ',', $tag);
        return ltrim(rtrim($tag, ','));
    }

    public static function rate()
    {
        $rate = session('rate');
        $rate = json_decode($rate);
        return $rate;
    }

    public static function getCurrency()
    {
        return Helper::rate()->symbol ?? optional(optional(SystemSetting::first())->currency)->symbol;
    }

    public  static function getIsoCode()
    {
        return Helper::rate()->iso_code3 ?? optional(optional(SystemSetting::first())->currency)->iso_code3;
    }


    public static function check($collections, $id, $col = null)
    {
        if (null !== $collections && $col) {
            foreach ($collections as $collection) {
                if (null !== $collection->id && $collection->id === $id) {
                    return $col ? $collection->pivot->$col : $collection->id;
                }
            }
        }

        return optional($collections)->contains('id', $id) ? 'checked' : '';
    }


    public static function getCurrencyExchangeRate()
    {

        $currency_rate = CurrencyRate::first();
        // $apiKey = 'cur_live_vhjIPU5LPxA5neoR1kRFgUd9HrGDwRzBWJtxHJc2';
        // $url = "https://api.currencyapi.com/v3/latest";
        // try {
        //     $url = "https://api.currencyapi.com/v3/latest";
        //     $response = Http::get($url, [
        //         'apikey' => env('EXCHANGE_RATE_API_KEY'),
        //         'currencies' => 'NGN',
        //     ]);

        //     // Check if the request was successful
        //     if ($response->successful()) {
        //         $data = $response->json();
        //         // Extract the exchange rate for NGN or use a fallback value
        //         $exchangeRate = $data['data']['NGN']['value'] ?? optional($currency_rate)->rate;

        //         return round($exchangeRate - 150, 0);
        //     } else {
        //         // Handle non-200 responses
        //         return optional($currency_rate)->rate;;

        //     }
        // } catch (RequestException $e) {
        //     // Handle specific HTTP request exceptions
        //     \Log::error("Currency API request error: " . $e->getMessage());
        //     return optional($currency_rate)->rate;;
        // } catch (Exception $e) {
        //     // Handle general exceptions
        //     \Log::error("An error occurred: " . $e->getMessage());
        //     return optional($currency_rate)->rate;;
        // }
        // Make the GET request with the required parameters

        try {
            $url = "https://api.exchangerate-api.com/v4/latest/USD";
            $response = Http::get($url);

            if ($response->successful()) {
                $data = $response->json();
                $ngnRate = $data['rates']['NGN'] ?? null;
                return round($ngnRate, 0);
            } else {
                return round(optional(($currency_rate)->rate), 0);
            }
        } catch (\Exception $e) {
            \Log::error("Currency API error: " . $e->getMessage());
            return 'Unable to retrieve NGN exchange rate.';
        }

        return optional($currency_rate)->rate;;
    }

    public static function updateApartmentPrices($startDate, $endDate, $percentageIncrease = 20)
    {
        $multiplier = 1 + ($percentageIncrease / 100);
        Apartment::where('price', '>', 0)
            ->update(['december_prices' => \DB::raw("price * $multiplier")]);
    }



    public static function reverseApartmentPrices($percentageIncrease = 20)
    {
        $multiplier = 1 + ($percentageIncrease / 100);
        Apartment::where('december_prices', '>', 0)
            ->update(['december_prices' => 0]);
    }

    public static function agents()
    {
        return [
            'AM1 - ' => 'afolabi_adekoya@yahoo.com',
            'AM2 - ' => 'ikuomolaolajuwon@yahoo.com',
            'BM1 - ' => 'Ikuomolaolajuwon@yahoo.com',
            'BM2 - ' => 'afolabi_adekoya@yahoo.com',
            'BM3 - ' => 'afolabi_adekoya@yahoo.com',
            'BM4 - ' => 'wale@phoenixvibes.net',
            'BF1 - ' => 'abayomioloko89@gmail.com',
            'BF2 - ' => 'maimunatk@yahoo.com',
            'BF3 - ' => 'taiwoshote@yahoo.com',
            'BF4 - ' => 'jemimasawari@yahoo.com',
            'BF5 - ' => 'oluwa.tosin@avenuemontaigne.ng',
            'CM1 - ' => 'jemimasawari@yahoo.com',
            'CM2 - ' => 'info@licl.com.ng',
            'CM3 - ' => 'abayomioloko89@gmail.com',
            'CM4 - ' => 'jemimasawari@yahoo.com',
            'CF1 - ' => 'jemimasawari@yahoo.com',
            'CF2 - ' => 'maimunatk@yahoo.com',
            'CF3 - ' => 'taiwoshote@yahoo.com',
            'CF4 - ' => 'abayomioloko89@gmail.com',
            'CF5 - ' => 'james.anjorin@gmail.com',
            'DM1 - ' => 'oluwafemiolaoluwa01@gmail.com',
            'DM2 - ' => 'abayomioloko89@gmail.com',

            // 'AM1 - Mars'=>'afolabi_adekoya@yahoo.com',
            // 'AM2 - Nor'=>'ikuomolaolajuwon@yahoo.com',
            // 'BM1 - Ner'=>'ikuomolaolajuwon@yahoo.com',
            // 'BM2 - Mercury'=>
            // 'BM3 - Earth'=>
            // 'BM4 - BM luxury'=>
            // 'BF1 - Cannes'=>
            // 'BF2 - Gates'=>
            // 'BF3 - Mayfair'=>
            // 'BF4 - The Pearl'=>
            // 'BF5 - Eiffel'=>
            // 'CM1 - Sanctuary' =>
            // 'CM2 - Le Maison'=>
            // 'CM3 - Stanmore'=>
            // 'CM4 - The black Oynx' =>
            // 'CF1 - Elysium'=>
            // 'CF2 - Brentwood' =>
            // 'CF3 - Parklane'=>
            // 'CF4 - Senna'=>
            // 'CF5 - Ascot'=>
            // 'DM1 - Du Louvre' =>
            // 'DM2 - Theodora'=>
        ];
    }


    public static function EU()
    {

        return [
            "AT" => "Austria",
            "BE" => "Belgium",
            "BG" => "Bulgaria",
            "CY" => "Cyprus",
            "CZ" => "Czech Republic",
            "DK" => "Denmark",
            "EE" => "Estonia",
            "FI" => "Finland",
            "FR" => "France",
            "DE" => "Germany",
            "GR" => "Greece",
            "HU" => "Hungary",
            "IE" => "Ireland",
            "IT" => "Italy",
            "LV" => "Latvia",
            "LT" => "Lithuania",
            "LU" => "Luxembourg",
            "MT" => "Malta",
            "NL" => "Netherlands",
            "PL" => "Poland",
            "PT" => "Portugal",
            "RO" => "Romania",
            "SK" => "Slovakia (Slovak Republic)",
            "SI" => "Slovenia",
            "ES" => "Spain",
        ];
    }

    public static function sm_col_width()
    {
        return [
            'col-12',
            'col-10',
            'col-9',
            'col-8',
            'col-7',
            'col-6',
            'col-5',
            'col-4',
            'col-3',
            'col-2',
            'col-1',
        ];
    }

    public static function col_width()
    {
        return [
            'col-lg-12',
            'col-lg-10',
            'col-lg-9',
            'col-lg-8',
            'col-lg-7',
            'col-lg-6',
            'col-lg-5',
            'col-lg-4',
            'col-lg-3',
            'col-lg-2',
            'col-lg-1',
        ];
    }


    public static function attribute_types()
    {
        return [
            'bedrooms' => 'Bedrooms',
            'extra services' => 'Extra Services',
            'facilities' => 'Facilities',
            'rules' => 'Rules',
            'apartment facilities' => 'Apartment Facilities',
            'property type' => 'Property Type',
            'other' => 'other',
            'furnishing' => 'Furnishing',
            'condition' => 'Condition',
            'room_id' => 'Room id'
        ];
    }


    public static function toAndFromDate($date)
    {

        $date  = $date ?  explode("to", $date)  : explode("to", "2012-10-21 to 2012-10-23");

        try {
            if (isset($date[0]) && $date[0]) {
                if ($date) {
                    $date1 = trim($date[0]);
                    $date2 = trim($date[1]);
                    $start_date = Carbon::createFromDate($date1);
                    $end_date = Carbon::createFromDate($date2);
                    return ['start_date' => $start_date, 'end_date' => $end_date];
                }
                return [];
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public static function nights($date = [])
    {
        if (count($date) > 1) {

            $nights = [];
            if ($date['start_date'] == Carbon::createFromDate('2012-10-21')) {
                return $nights;
            }


            $start_date = $date['start_date'];
            $end_date   = $date['end_date'];
            $days   = $start_date->diffInDays($end_date);
            $stays   = $days == 1 ? "night" : " nights";
            $nights[] = $days;
            $nights[] = $stays;
            return $nights;
        }
        return [];
    }


    public static function getPercentageDiscount($percentage_value, $fee)
    {
        $var = ($percentage_value / 100) * $fee;
        $new_fee = $fee - $var;
        return $new_fee;
    }

    function display_html($link, $html)
    {

        if ($pages) {
            return $html;
        } else {
            return '';
        }
    }

    public static function phoneCodes()
    {

        $array = [
            '44' => 'UK (+44)',
            '1' => 'USA (+1)',
            '213' => 'Algeria (+213)',
            '376' => 'Andorra (+376)',
            '244' => 'Angola (+244)',
            '1264' => 'Anguilla (+1264)',
            '1268' => 'Antigua & Barbuda (+1268)',
            '54' => 'Argentina (+54)',
            '374' => 'Armenia (+374)',
            '297' => 'Aruba (+297)',
            '61' => 'Australia (+61)',
            '43' => 'Austria (+43)',
            '994' => 'Azerbaijan (+994)',
            '1242' => 'Bahamas (+1242)',
            '973' => 'Bahrain (+973)',
            '880' => 'Bangladesh (+880)',
            '1246' => 'Barbados (+1246)',
            '375' => 'Belarus (+375)',
            '32' => 'Belgium (+32)',
            '501' => 'Belize (+501)',
            '229' => 'Benin (+229)',
            '1441' => 'Bermuda (+1441)',
            '975' => 'Bhutan (+975)',
            '591' => 'Bolivia (+591)',
            '387' => 'Bosnia Herzegovina (+387)',
            '267' => 'Botswana (+267)',
            '55' => 'Brazil (+55)',
            '673' => 'Brunei (+673)',
            '359' => 'Bulgaria (+359)',
            '226' => 'Burkina Faso (+226)',
            '257' => 'Burundi (+257)',
            '855' => 'Cambodia (+855)',
            '237' => 'Cameroon (+237)',
            '1' => 'Canada (+1)',
            '238' => 'Cape Verde Islands (+238)',
            '1345' => 'Cayman Islands (+1345)',
            '236' => 'Central African Republic (+236)',
            '56' => 'Chile (+56)',
            '86' => 'China (+86)',
            '57' => 'Colombia (+57)',
            '269' => 'Comoros (+269)',
            '242' => 'Congo (+242)',
            '682' => 'Cook Islands (+682)',
            '506' => 'Costa Rica (+506)',
            '385' => 'Croatia (+385)',
            '53' => 'Cuba (+53)',
            '90392' => 'Cyprus North (+90392)',
            '357' => 'Cyprus South (+357)',
            '42' => 'Czech Republic (+42)',
            '45' => 'Denmark (+45)',
            '253' => 'Djibouti (+253)',
            '1809' => 'Dominica (+1809)',
            '1809' => 'Dominican Republic (+1809)',
            '593' => 'Ecuador (+593)',
            '20' => 'Egypt (+20)',
            '503' => 'El Salvador (+503)',
            '240' => 'Equatorial Guinea (+240)',
            '291' => 'Eritrea (+291)',
            '372' => 'Estonia (+372)',
            '251' => 'Ethiopia (+251)',
            '500' => 'Falkland Islands (+500)',
            '298' => 'Faroe Islands (+298)',
            '679' => 'Fiji (+679)',
            '358' => 'Finland (+358)',
            '33' => 'France (+33)',
            '594' => 'French Guiana (+594)',
            '689' => 'French Polynesia (+689)',
            '241' => 'Gabon (+241)',
            '220' => 'Gambia (+220)',
            '7880' => 'Georgia (+7880)',
            '49' => 'Germany (+49)',
            '233' => 'Ghana (+233)',
            '350' => 'Gibraltar (+350)',
            '30' => 'Greece (+30)',
            '299' => 'Greenland (+299)',
            '1473' => 'Grenada (+1473)',
            '590' => 'Guadeloupe (+590)',
            '671' => 'Guam (+671)',
            '502' => 'Guatemala (+502)',
            '224' => 'Guinea (+224)',
            '245' => 'Guinea - Bissau (+245)',
            '592' => 'Guyana (+592)',
            '509' => 'Haiti (+509)',
            '504' => 'Honduras (+504)',
            '852' => 'Hong Kong (+852)',
            '36' => 'Hungary (+36)',
            '354' => 'Iceland (+354)',
            '91' => 'India (+91)',
            '62' => 'Indonesia (+62)',
            '98' => 'Iran (+98)',
            '964' => 'Iraq (+964)',
            '353' => 'Ireland (+353)',
            '972' => 'Israel (+972)',
            '39' => 'Italy (+39)',
            '1876' => 'Jamaica (+1876)',
            '81' => 'Japan (+81)',
            '962' => 'Jordan (+962)',
            '7' => 'Kazakhstan (+7)',
            '254' => 'Kenya (+254)',
            '686' => 'Kiribati (+686)',
            '850' => 'Korea North (+850)',
            '82' => 'Korea South (+82)',
            '965' => 'Kuwait (+965)',
            '996' => 'Kyrgyzstan (+996)',
            '856' => 'Laos (+856)',
            '371' => 'Latvia (+371)',
            '961' => 'Lebanon (+961)',
            '266' => 'Lesotho (+266)',
            '231' => 'Liberia (+231)',
            '218' => 'Libya (+218)',
            '417' => 'Liechtenstein (+417)',
            '370' => 'Lithuania (+370)',
            '352' => 'Luxembourg (+352)',
            '853' => 'Macao (+853)',
            '389' => 'Macedonia (+389)',
            '261' => 'Madagascar (+261)',
            '265' => 'Malawi (+265)',
            '60' => 'Malaysia (+60)',
            '960' => 'Maldives (+960)',
            '223' => 'Mali (+223)',
            '356' => 'Malta (+356)',
            '692' => 'Marshall Islands (+692)',
            '596' => 'Martinique (+596)',
            '222' => 'Mauritania (+222)',
            '269' => 'Mayotte (+269)',
            '52' => 'Mexico (+52)',
            '691' => 'Micronesia (+691)',
            '373' => 'Moldova (+373)',
            '377' => 'Monaco (+377)',
            '976' => 'Mongolia (+976)',
            '1664' => 'Montserrat (+1664)',
            '212' => 'Morocco (+212)',
            '258' => 'Mozambique (+258)',
            '95' => 'Myanmar (+95)',
            '264' => 'Namibia (+264)',
            '674' => 'Nauru (+674)',
            '977' => 'Nepal (+977)',
            '31' => 'Netherlands (+31)',
            '687' => 'New Caledonia (+687)',
            '64' => 'New Zealand (+64)',
            '505' => 'Nicaragua (+505)',
            '227' => 'Niger (+227)',
            '234' => 'Nigeria (+234)',
            '683' => 'Niue (+683)',
            '672' => 'Norfolk Islands (+672)',
            '670' => 'Northern Marianas (+670)',
            '47' => 'Norway (+47)',
            '968' => 'Oman (+968)',
            '680' => 'Palau (+680)',
            '507' => 'Panama (+507)',
            '675' => 'Papua New Guinea (+675)',
            '595' => 'Paraguay (+595)',
            '51' => 'Peru (+51)',
            '63' => 'Philippines (+63)',
            '48' => 'Poland (+48)',
            '351' => 'Portugal (+351)',
            '1787' => 'Puerto Rico (+1787)',
            '974' => 'Qatar (+974)',
            '262' => 'Reunion (+262)',
            '40' => 'Romania (+40)',
            '7' => 'Russia (+7)',
            '250' => 'Rwanda (+250)',
            '378' => 'San Marino (+378)',
            '239' => 'Sao Tome & Principe (+239)',
            '966' => 'Saudi Arabia (+966)',
            '221' => 'Senegal (+221)',
            '381' => 'Serbia (+381)',
            '248' => 'Seychelles (+248)',
            '232' => 'Sierra Leone (+232)',
            '65' => 'Singapore (+65)',
            '421' => 'Slovak Republic (+421)',
            '386' => 'Slovenia (+386)',
            '677' => 'Solomon Islands (+677)',
            '252' => 'Somalia (+252)',
            '27' => 'South Africa (+27)',
            '34' => 'Spain (+34)',
            '94' => 'Sri Lanka (+94)',
            '290' => 'St. Helena (+290)',
            '1869' => 'St. Kitts (+1869)',
            '1758' => 'St. Lucia (+1758)',
            '249' => 'Sudan (+249)',
            '597' => 'Suriname (+597)',
            '268' => 'Swaziland (+268)',
            '46' => 'Sweden (+46)',
            '41' => 'Switzerland (+41)',
            '963' => 'Syria (+963)',
            '886' => 'Taiwan (+886)',
            '7' => 'Tajikstan (+7)',
            '66' => 'Thailand (+66)',
            '228' => 'Togo (+228)',
            '676' => 'Tonga (+676)',
            '1868' => 'Trinidad & Tobago (+1868)',
            '216' => 'Tunisia (+216)',
            '90' => 'Turkey (+90)',
            '7' => 'Turkmenistan (+7)',
            '993' => 'Turkmenistan (+993)',
            '1649' => 'Turks & Caicos Islands (+1649)',
            '688' => 'Tuvalu (+688)',
            '256' => 'Uganda (+256)',
            '380' => 'Ukraine (+380)',
            '971' => 'United Arab Emirates (+971)',
            '598' => 'Uruguay (+598)',
            '7' => 'Uzbekistan (+7)',
            '678' => 'Vanuatu (+678)',
            '379' => 'Vatican City (+379)',
            '58' => 'Venezuela (+58)',
            '84' => 'Vietnam (+84)',
            '84' => 'Virgin Islands - British (+1284)',
            '84' => 'Virgin Islands - US (+1340)',
            '681' => 'Wallis & Futuna (+681)',
            '969' => 'Yemen (North)(+969)',
            '967' => 'Yemen (South)(+967)',
            '260' => 'Zambia (+260)',
            '263' => 'Zimbabwe (+263)',
        ];

        return $array;
    }

    public static function Countries()
    {

        return  $countries = array(
            "Afghanistan",
            "Albania",
            "Algeria",
            "American Samoa",
            "Andorra",
            "Angola",
            "Anguilla",
            "Antarctica",
            "Antigua and Barbuda",
            "Argentina",
            "Armenia",
            "Aruba",
            "Australia",
            "Austria",
            "Azerbaijan",
            "Bahamas",
            "Bahrain",
            "Bangladesh",
            "Barbados",
            "Belarus",
            "Belgium",
            "Belize",
            "Benin",
            "Bermuda",
            "Bhutan",
            "Bolivia",
            "Bosnia and Herzegowina",
            "Botswana",
            "Bouvet Island",
            "Brazil",
            "British Indian Ocean Territory",
            "Brunei Darussalam",
            "Bulgaria",
            "Burkina Faso",
            "Burundi",
            "Cambodia",
            "Cameroon",
            "Canada",
            "Cape Verde",
            "Cayman Islands",
            "Central African Republic",
            "Chad",
            "Chile",
            "China",
            "Christmas Island",
            "Cocos (Keeling) Islands",
            "Colombia",
            "Comoros",
            "Congo",
            "Congo, the Democratic Republic of the",
            "Cook Islands",
            "Costa Rica",
            "Cote d'Ivoire",
            "Croatia (Hrvatska)",
            "Cuba",
            "Cyprus",
            "Czech Republic",
            "Denmark",
            "Djibouti",
            "Dominica",
            "Dominican Republic",
            "East Timor",
            "Ecuador",
            "Egypt",
            "El Salvador",
            "Equatorial Guinea",
            "Eritrea",
            "Estonia",
            "Ethiopia",
            "Falkland Islands (Malvinas)",
            "Faroe Islands",
            "Fiji",
            "Finland",
            "France",
            "France Metropolitan",
            "French Guiana",
            "French Polynesia",
            "French Southern Territories",
            "Gabon",
            "Gambia",
            "Georgia",
            "Germany",
            "Ghana",
            "Gibraltar",
            "Greece",
            "Greenland",
            "Grenada",
            "Guadeloupe",
            "Guam",
            "Guatemala",
            "Guinea",
            "Guinea-Bissau",
            "Guyana",
            "Haiti",
            "Heard and Mc Donald Islands",
            "Holy See (Vatican City State)",
            "Honduras",
            "Hong Kong",
            "Hungary",
            "Iceland",
            "India",
            "Indonesia",
            "Iran (Islamic Republic of)",
            "Iraq",
            "Ireland",
            "Israel",
            "Italy",
            "Jamaica",
            "Japan",
            "Jordan",
            "Kazakhstan",
            "Kenya",
            "Kiribati",
            "Korea, Democratic People's Republic of",
            "Korea, Republic of",
            "Kuwait",
            "Kyrgyzstan",
            "Lao, People's Democratic Republic",
            "Latvia",
            "Lebanon",
            "Lesotho",
            "Liberia",
            "Libyan Arab Jamahiriya",
            "Liechtenstein",
            "Lithuania",
            "Luxembourg",
            "Macau",
            "Macedonia, The Former Yugoslav Republic of",
            "Madagascar",
            "Malawi",
            "Malaysia",
            "Maldives",
            "Mali",
            "Malta",
            "Marshall Islands",
            "Martinique",
            "Mauritania",
            "Mauritius",
            "Mayotte",
            "Mexico",
            "Micronesia, Federated States of",
            "Moldova, Republic of",
            "Monaco",
            "Mongolia",
            "Montserrat",
            "Morocco",
            "Mozambique",
            "Myanmar",
            "Namibia",
            "Nauru",
            "Nepal",
            "Netherlands",
            "Netherlands Antilles",
            "New Caledonia",
            "New Zealand",
            "Nicaragua",
            "Niger",
            "Nigeria",
            "Niue",
            "Norfolk Island",
            "Northern Mariana Islands",
            "Norway",
            "Oman",
            "Pakistan",
            "Palau",
            "Panama",
            "Papua New Guinea",
            "Paraguay",
            "Peru",
            "Philippines",
            "Pitcairn",
            "Poland",
            "Portugal",
            "Puerto Rico",
            "Qatar",
            "Reunion",
            "Romania",
            "Russian Federation",
            "Rwanda",
            "Saint Kitts and Nevis",
            "Saint Lucia",
            "Saint Vincent and the Grenadines",
            "Samoa",
            "San Marino",
            "Sao Tome and Principe",
            "Saudi Arabia",
            "Senegal",
            "Seychelles",
            "Sierra Leone",
            "Singapore",
            "Slovakia (Slovak Republic)",
            "Slovenia",
            "Solomon Islands",
            "Somalia",
            "South Africa",
            "South Georgia and the South Sandwich Islands",
            "Spain",
            "Sri Lanka",
            "St. Helena",
            "St. Pierre and Miquelon",
            "Sudan",
            "Suriname",
            "Svalbard and Jan Mayen Islands",
            "Swaziland",
            "Sweden",
            "Switzerland",
            "Syrian Arab Republic",
            "Taiwan, Province of China",
            "Tajikistan",
            "Tanzania, United Republic of",
            "Thailand",
            "Togo",
            "Tokelau",
            "Tonga",
            "Trinidad and Tobago",
            "Tunisia",
            "Turkey",
            "Turkmenistan",
            "Turks and Caicos Islands",
            "Tuvalu",
            "Uganda",
            "Ukraine",
            "United Arab Emirates",
            "United Kingdom",
            "United States",
            "United States Minor Outlying Islands",
            "Uruguay",
            "Uzbekistan",
            "Vanuatu",
            "Venezuela",
            "Vietnam",
            "Virgin Islands (British)",
            "Virgin Islands (U.S.)",
            "Wallis and Futuna Islands",
            "Western Sahara",
            "Yemen",
            "Yugoslavia",
            "Zambia",
            "Zimbabwe"
        );
    }
}
