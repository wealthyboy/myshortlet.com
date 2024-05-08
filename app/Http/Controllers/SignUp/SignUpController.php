<?php

namespace App\Http\Controllers\SignUp;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Attribute;
use App\Models\GuestUser;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use App\Notifications\CheckinNotification;
use App\Notifications\NewGuest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;




class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms =  Attribute::parents()->where('type', 'room_id')->orderBy('sort_order', 'desc')->get();
        return view('checkin.index', compact('rooms'));
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
        try {

            $input = $request->all();
            //dd($input);
            $property = Property::first();

            $checkin = Carbon::parse($request->checkin);
            $checkout = Carbon::parse($request->checkin);
            $date_diff = $checkin->diffInDays($checkout);

            $user_reservation = new UserReservation;
            $apartment = Apartment::where('apartment_id', $request->apartment_id)->first();

            $guest = new GuestUser;
            $guest->name = $input['first_name'];
            $guest->last_name = $input['last_name'];
            $guest->email = $input['email'];
            $guest->phone_number = $input['phone_number'];
            $guest->image = session('session_link');

            $guest->save();

            $user_reservation->user_id = optional($request->user())->id;
            $user_reservation->guest_user_id = $guest->id;
            $user_reservation->currency = null;
            $user_reservation->invoice = "INV-" . date('Y') . "-" . rand(10000, time());
            $user_reservation->payment_type = 'checkin';
            $user_reservation->property_id = $property->id;
            $user_reservation->coupon = null;
            $user_reservation->total = (optional($apartment)->price || 0) * $date_diff;
            $user_reservation->ip = $request->ip();
            $user_reservation->save();

            $reservation = new Reservation;
            $reservation->quantity = 1;
            $reservation->apartment_id = $apartment->apartment_id;
            $reservation->price = $apartment->price;
            $reservation->sale_price = $apartment->sale_price;
            $reservation->user_reservation_id = $user_reservation->id;
            $reservation->property_id = $property->id;
            $reservation->checkin = $request->checkin;
            $reservation->checkout = $request->checkout;
            $reservation->save();

            // Create a file name
            $fileName = 'guest_' . $guest->name . '_' . $guest->id . '.pdf';

            // Generate some content for the file
            $fileContent = '';

            // Specify the directory where you want to save the file
            $directory = public_path('pdf');

            $visitor = $request;
            $visitor->image = session('session_link');


            // Check if the directory exists, if not create it
            if (!File::exists($directory)) {
                File::makeDirectory($directory);
            }


            // Save the file to the specified directory
            File::put($directory . '/' . $fileName, $fileContent);


            $pdf = PDF::loadView('pdf.index', compact('visitor'));
            $pdf->save(public_path('pdf/guest_' . $guest->name . '_' . $guest->id . '.pdf'));


            try {

                Notification::route('mail', $guest->email)
                    ->notify(new  NewGuest($guest));

                Notification::route('mail', 'oluwa.tosin@avenuemontaigne.ng')
                    ->notify(new CheckinNotification($guest));
            } catch (\Throwable $th) {
                dd($th);
                //  Log::error("Mail error :" . $th);
            }


            return back()->with('success', 'Your message goes here.');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }
}
