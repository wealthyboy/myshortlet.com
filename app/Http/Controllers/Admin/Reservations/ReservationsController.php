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
use Carbon\Carbon;
use Illuminate\Notifications\Notification;

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

		$reservations = Reservation::all();
		foreach ($reservations as $reservation) {
			if (null === $reservation->user_reservation) {
				$reservation->delete();
			}
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


	public function show($id)
	{
		$user_reservation = UserReservation::find($id);
		$sub_total = $user_reservation->original_amount;
		$statuses = static::order_status();
		//dd($user_reservation->reservations);
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
		$reservations = Reservation::all();
		foreach ($user_reservations as $user_reservation) {
			if (null === $reservation->user_reservation) {
				$reservation->delete();
			}
		}
		$userReservations = UserReservation::whereIn('id', $request->selected)->delete();
		return redirect()->back()->with('success', ' deleted successfully');
	}
}
