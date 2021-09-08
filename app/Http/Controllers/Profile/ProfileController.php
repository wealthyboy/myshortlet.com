<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
     
    public function __construct()
    {	  
	    $this->middleware('auth'); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $user = \Auth::user();
        return view('profile.index',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
    public function update(Request $request, $id)
    {
        $user = \Auth::user();

        $this->validate($request, [
            'first_name'     => 'required|max:30',
            'last_name'      => 'required|max:30',
            'phone_number'   => 'required|numeric|min:11|unique:users,phone_number,'.$user->id,
            'email'          => 'required|email|unique:users,email,'.$user->id,
        ]); 

        $user->name                          = $request->first_name;
        $user->last_name                     = $request->last_name;
        $user->phone_number                  = $request->phone_number;
        $user->email                         = $request->email;
        $user->company_title                 = $request->phone_number;
        $user->image                         = $request->image;
        $user->bio                           = $request->bio;
        $user->save();

        if ($request->ajax()){
            return response()->json([
                'msg' => 'success',
                'user' => $user
            ]);
        }


        return redirect()->back()->with('success','Your profile has been updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
