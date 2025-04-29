<?php

namespace App\Http\Controllers\SignUp;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Attribute;
use App\Models\GuestUser;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\UserReservation;
use App\Notifications\AgentCheckingNotification;
use App\Notifications\CheckinNotification;
use App\Notifications\NewGuest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use App\Jobs\ProcessGuestCheckin;





class SignUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        $reservation = null;
        $rooms = Apartment::orderBy('name', 'asc')->get();
        // dd($rooms);
        if ($request->id) {
            $user_reservation = UserReservation::findOrFail($request->id);
            $reservation = isset($user_reservation->reservations[0]) && !empty($user_reservation->reservations[0]) ? $user_reservation->reservations[0] : null;
            $user_reservation->apartment_id = $reservation->apartment_id;
            $user_reservation->checkin = $reservation->apartment_id;
            $user_reservation->checkout = $reservation->apartment_id;
            //dd($user_reservation);
            if ($user_reservation->checkout->isPast()) {
                // abort(404);
            }

            return view('checkin.checkin', compact('rooms', 'user_reservation'));
        }


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

            $user_reservation = UserReservation::find($request->user_reservation_id);

            if ($request->filled('user_reservation_id')  && null !== $user_reservation && $user_reservation->checked) {
                response()->json(null, 200);
            }


            $input = $request->all();
            $property = Property::first();
            $checkin = Carbon::parse($request->checkin);
            $checkout = Carbon::parse($request->checkin);
            $date_diff = $checkin->diffInDays($checkout);
            $user_reservation = new UserReservation;
            $attr = Attribute::find($request->apartment_id);
            $apartment = Apartment::where('apartment_id', $request->apartment_id)->first();
            $attr = Attribute::find($request->apartment_id);
            $query = Apartment::query();
            $apartmentId = $request->apartment_id;
            $query->where('id', $apartmentId);
            $startDate = Carbon::createFromDate($request->checkin);
            $endDate = Carbon::createFromDate($request->checkout);
            $query->whereDoesntHave('reservations', function ($q) use ($startDate, $endDate) {
                $q->where(function ($subQ) use ($startDate) {
                    $subQ->where('checkin', '<', $startDate)
                        ->where('reservations.is_blocked', false)
                        ->where('checkout', '>', $startDate);
                });
            });


            $apartments = $query->latest()->first();

            if (!$request->filled('user_reservation_id')  && null ===  $apartments) {
                return response()->json(["message" => $apartments], 400);
            }

            $guest = GuestUser::firstOrNew(['id' => data_get($input, 'guest_id')]);
            $guest->name = $input['first_name'];
            $guest->last_name = $input['last_name'];
            $guest->email = $input['email'];
            $guest->phone_number = $input['phone_number'];
            $guest->image = session('session_link');
            $guest->save();

            $apartment = Apartment::find($request->apartment_id);

            if ($request->user_reservation_id) {
                $user_reservation = UserReservation::find($request->user_reservation_id);
                ProcessGuestCheckin::dispatch($guest, $user_reservation->reservation, $apartment)->delay(now()->addSeconds(5));
                return response()->json(null, 200);
            }

            $user_reservation->user_id = optional($request->user())->id;
            $user_reservation->guest_user_id = $guest->id;
            $user_reservation->currency = null;
            $user_reservation->invoice = "INV-" . date('Y') . "-" . rand(10000, time());
            $user_reservation->payment_type = 'checkin';
            $user_reservation->property_id = $property->id;
            $user_reservation->checked = true;
            $user_reservation->coupon = null;
            $user_reservation->coming_from = "checkin";
            $user_reservation->total = (optional($apartment)->price || 0) * $date_diff;
            $user_reservation->ip = $request->ip();
            $user_reservation->save();

            $reservation = new Reservation;
            $reservation->quantity = 1;
            $reservation->apartment_id = $request->apartment_id;
            $reservation->price = $apartment->price;
            $reservation->sale_price = $apartment->sale_price;
            $reservation->user_reservation_id = $user_reservation->id;
            $reservation->property_id = $property->id;
            $reservation->checkin = $startDate;
            $reservation->checkout = $endDate;
            $reservation->save();
            $fileName = 'guest_' . $guest->name . '_' . $guest->id . '.pdf';
            $fileContent = '';

            $directory = public_path('pdf');
            $visitor = $request;
            $guest->image = session('session_link');
            $reservation->apartment_name = optional($apartment->attribute)->name;
            $guest->apartment_name = optional($apartment->attribute)->name;
            $reservation->first_name = $request->first_name;
            $reservation->last_name = $request->last_name;
            $reservation->email = $request->email;
            $reservation->phone_number = $request->phone_number;
            ProcessGuestCheckin::dispatch($guest, $reservation, $apartment)->delay(now()->addSeconds(5));

            return response()->json("Success", 200);
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
        }
    }

    public function block(Request $request)
    {
        try {

            $input = $request->all();
            $property = Property::first();
            $checkin = Carbon::parse($request->checkin);
            $checkout = Carbon::parse($request->checkin);
            $date_diff = $checkin->diffInDays($checkout);
            $user_reservation = new UserReservation;
            $attr = Attribute::find($request->apartment_id);
            $apartment = Apartment::where('apartment_id', $request->apartment_id)->first();
            $attr = Attribute::find($request->apartment_id);
            $query = Apartment::query();
            $apartmentId = $request->apartment_id;
            $query->where('id', $apartmentId);
            $startDate = Carbon::createFromDate($request->checkin);
            $endDate = Carbon::createFromDate($request->checkout);

            $apartments = $query->latest()->first();
            $guest = GuestUser::firstOrNew(['id' => data_get($input, 'guest_id')]);
            $guest->name = "Block";
            $guest->last_name = "Blocked";
            $guest->email = "blocked@blocked";
            $guest->phone_number = "082394839384";
            $guest->image = "kkk.jpg";
            $guest->save();

            $apartment = Apartment::find($request->apartment_id);
            $user_reservation->user_id = optional($request->user())->id;
            $user_reservation->guest_user_id = $guest->id;
            $user_reservation->currency = null;
            $user_reservation->invoice = "INV-" . date('Y') . "-" . rand(10000, time());
            $user_reservation->payment_type = 'block';
            $user_reservation->property_id = $property->id;
            $user_reservation->checked = true;
            $user_reservation->coupon = null;
            $user_reservation->coming_from = "checkin";
            $user_reservation->total = (optional($apartment)->price || 0) * $date_diff;
            $user_reservation->ip = $request->ip();
            $user_reservation->save();

            $reservation = new Reservation;
            $reservation->quantity = 1;
            $reservation->apartment_id = $request->apartment_id;
            $reservation->price = $apartment->price;
            $reservation->sale_price = $apartment->sale_price;
            $reservation->user_reservation_id = $user_reservation->id;
            $reservation->property_id = $property->id;
            $reservation->checkin = $startDate;
            $reservation->is_blocked = true;
            $reservation->checkout = $endDate;
            $reservation->save();

            $guest->image = "kkkkk.jpg";
            $reservation->apartment_name = optional($apartment->attribute)->name;
            $guest->apartment_name = optional($apartment->attribute)->name;
            $reservation->first_name = "block";
            $reservation->last_name = $request->last_name;
            $reservation->email = "block@block.com";
            $reservation->phone_number = "block";
            return response()->json("Success", 200);
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
