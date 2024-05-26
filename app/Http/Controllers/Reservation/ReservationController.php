<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;
use App\Models\UserReservation;

class ReservationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $user = auth()->user();
        $reservations = UserReservation::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(20);
        return  view('reservations.index', compact('reservations', 'user'));
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user_reservation = UserReservation::find($id);
        $sub_total = $user_reservation->total;
        return view('reservations.show', compact('user_reservation', 'sub_total'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $apartment = UserReservation::whereIn('id', $request->selected)->delete();
        return redirect()->back()->with('success', ' deleted successfully');
    }
}
