<?php

namespace App\Http\Controllers\Admin\Block;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Reservation;

class BlockApartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {  
        $apartments = Apartment::with(['reservations' => function ($query) {
            $query->where('is_blocked', true);
        }])->whereHas('reservations', function ($query) {
            $query->where('is_blocked', true);
        })->get();

        return view('admin.block.index', compact('apartments'));
    }


    public function block()
    {  
        $rooms = Apartment::orderBy('name', 'asc')->get();
        return view('checkin.block', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
        $request = request();

        if (!empty($request->selected)) {
            Reservation::whereIn('apartment_id', $request->selected)
                ->where('is_blocked', true)
                ->delete(); 
    
                return redirect()->back();
            }
    }
}
