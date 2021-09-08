<?php

namespace App\Http\Controllers\Guests;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestUser;

class GuestsController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $this->validate($request, [
            'first_name'     => 'required|max:30',
            'last_name'      => 'required|max:30',
            'phone_number'   => 'required|numeric|min:11',
            'email'          => 'required|email',
        ]); 
        
        $guest_user = new GuestUser;
        $guest_user->name                          = $request->first_name;
        $guest_user->last_name                     = $request->last_name;
        $guest_user->phone_number                  = $request->phone_number;
        $guest_user->email                         = $request->email;
        $guest_user->save();

        if ($request->ajax()){
            return response()->json([
                'msg' => 'success',
                'guest_user' => $guest_user,
                'user_type' => 'guest'
            ]);
        }
    }
}
