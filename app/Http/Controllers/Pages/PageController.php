<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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
            'virtual-tour' => 'virtual_tour',
            'contact-us' => 'contact_us',
            'neighborhood' => 'neighborhood',
        ];

        $link_name = Str::replaceFirst('-', ' ', request()->path());
        $link_name = ucfirst($link_name);
		return view('links.'.$links[request()->path()],compact('link_name'));
    }

    
}
