<?php

namespace App\Http\Controllers\Admin\Reservations;

use Illuminate\Http\Request;

use App\Models\UserReservation;
use App\Models\User;
use App\Models\SystemSetting;
use App\Models\OrderedProduct;
use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Apartment;
use App\Models\Reservation;
use App\Notifications\CancelledNotification;
use App\Notifications\ExtensionNotification;
use App\Notifications\ResendLink;
use Carbon\Carbon;

class ReservationsController extends Controller
{



	public function __construct()
	{

		$this->middleware('admin');
		$this->settings =  \DB::table('system_settings')->first();
	}

	public function index(Request $request)
	{

		// Check for the coming_from query parameter
		$comingFrom = $request->input('coming_from');
		if (!in_array($comingFrom, ['payment', 'checkin'])) {
			abort(404);
		}


		if ($request->filled('cancel')) {
			$userReservation = UserReservation::find($request->id);
			$userReservation->is_cancelled = 1;
			$userReservation->save();
			//CancelledNotification::not
			//Notification::notify();
		}

		//UserReservation::truncate();
		//Reservation::truncate();
		// Get query parameters
		$email = $request->input('email');
		$phoneNumber = $request->input('phone');
		$date = $request->input('date');

		$query = UserReservation::with('guest_user');

		// Check if any filters are provided
		if ($email || $phoneNumber || $date) {
			// Apply filters
			if ($email) {
				$query->whereHas('guest_user', function ($q) use ($email) {
					$q->where('email', $email);
				});
			}

			if ($phoneNumber) {
				$query->whereHas('guest_user', function ($q) use ($phoneNumber) {
					$q->where('phone_number', $phoneNumber);
				});
			}

			if ($date) {
				$query->whereDate('created_at', $date);
			}
		} else {
			// Default to today's reservations if no filters are provided
			$query->whereDate('created_at', Carbon::today());
		}

		$reservations = $query->where('coming_from', $comingFrom)->orderBy('created_at', 'desc')->paginate(50);

		//dd($reservations);
		return view('admin.reservations.index', compact('reservations'));
	}


	public static function order_status()
	{
		return [
			"Processing",
			"Refunded",
			"Booked",
		];
	}


	public function resendLink(Request $request)
	{

		$user = UserReservation::find($request->id);
		\Notification::route('mail', optional($user->guest_user)->email)
			->notify(new ResendLink($user));
		return response()->json(null, 200);
	}


	public function show($id)
	{

		$request = request();
		$user_reservation = UserReservation::find($id);

		if (!empty($request->query())) {
			$checkin = Carbon::createFromDate($request->checkin);
			$checkout = Carbon::createFromDate($request->checkout);
			$user_reservation = UserReservation::find($id);
			$stay = Reservation::where('user_reservation_id', $user_reservation->id)->first();
			$apartment = Apartment::find($stay->apartment_id);


			$query = Apartment::query();
			$query->where('id', $stay->apartment_id); // Filter by the provided apartment ID
			$query->whereDoesntHave('reservations', function ($query) use ($checkin, $checkout) {
				$query->where(function ($q) use ($checkin, $checkout) {
					$q->where('checkin', '<', $checkout)
						->where('checkout', '>', $checkin);
				});
			});


			$apartments = $query->latest()->first();
			if (null ===  $apartments) {
				return response()->json(["message" => $apartments], 400);
			}



			$reservation = new Reservation;
			$reservation->quantity = 1;
			$reservation->apartment_id = $stay->apartment_id;
			$reservation->price = $apartment->price;
			$reservation->sale_price = $apartment->sale_price;
			$reservation->user_reservation_id = $user_reservation->id;
			$reservation->property_id = null;
			$reservation->checkin = $checkin;
			$reservation->checkout = $checkout;
			$reservation->save();

			\Notification::route('mail', 'avenuemontaigneconcierge@gmail.com')
				->notify(new ExtensionNotification($reservation, $user_reservation->guest_user, $apartment));
		}


		$sub_total = $user_reservation->original_amount;
		$statuses = static::order_status();


		return view('admin.reservations.show', compact('statuses', 'user_reservation', 'sub_total'));
	}


	public function updateStatus(Request $request)
	{
		$ordered_product = OrderedProduct::findOrFail($request->ordered_product_id);
		$ordered_product->status = $request->status;
		$ordered_product->save();
		return $ordered_product;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Request $request, $id)
	{

		$userReservations = UserReservation::with('reservation')->whereIn('id', $request->selected)->get();

		foreach ($userReservations as $userReservation) {
			if (null === $userReservation->reservation) {
				$userReservation->reservation()->delete();
			}
			$userReservation->delete();
		}
		return redirect()->back()->with('success', ' deleted successfully');
	}
}
