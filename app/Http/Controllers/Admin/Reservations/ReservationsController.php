<?php

namespace App\Http\Controllers\Admin\Reservations;

use Illuminate\Http\Request;

use App\Models\UserReservation;
use App\Models\User;
use App\Models\SystemSetting;
use App\Models\OrderedProduct;
use App\Http\Controllers\Controller;
use App\Http\Helper;
use App\Models\Attribute;
use App\Models\GuestUser;
use App\Models\Apartment;
use App\Models\Property;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;



use App\Models\Reservation;
use App\Notifications\CancelledNotification;
use App\Notifications\ExtensionNotification;
use App\Notifications\ResendLink;
use App\Mail\ReservationReceipt;

use Carbon\Carbon;

class ReservationsController extends Controller
{



	public function __construct()
	{

		$this->middleware('admin');
		$this->settings = \DB::table('system_settings')->first();
	}

	public function index(Request $request)
	{


		$today = Carbon::today();
		$todaysReservations = Reservation::whereDate('checkin', $today)->get();

		//Check for the coming_from query parameter
		$comingFrom = $request->input('coming_from');
		if (!in_array($comingFrom, ['payment', 'checkin'])) {
			abort(404);
		}

		if ($request->filled('cancel')) {
			$userReservation = UserReservation::find($request->id);
			$userReservation->is_cancelled = 1;
			$userReservation->save();
		}

		//UserReservation::truncate();
		//Reservation::truncate();
		// Get query parameters
		$email = $request->input('email');
		$phoneNumber = $request->input('phone');
		$date = $request->input('date');
		$startDate = $request->input('from') ? Carbon::parse($request->input('from')) : null;
		$endDate = $request->input('to') ?  Carbon::parse($request->input('to')) : null;
		$apartment_id = $request->input('apartment_id');
		$query = UserReservation::with('guest_user');
		$apartments = Apartment::orderBy('name', 'asc')->get();
		$request->session()->put('coming_from', $request->coming_from);
		$query->whereHas('reservations', function ($q) use ($apartment_id) {
			$q->where('is_blocked', false);
		});

		// Check if any filters are provided
		if ($email || $phoneNumber || $startDate || $endDate || $apartment_id) {
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

			if ($apartment_id) {
				$query->whereHas('reservations', function ($q) use ($apartment_id) {
					$q->where('apartment_id', $apartment_id);
				});
			}

			if ($startDate && $endDate) {

				if ($startDate && $endDate) {

					$startDate = Carbon::parse($startDate)->startOfDay();
					$endDate   = Carbon::parse($endDate)->endOfDay();

					$query->whereHas('reservations', function ($q) use ($startDate, $endDate) {
						$q->whereBetween('created_at', [$startDate, $endDate]);
					});
				}
			}
		} else {
			$query->whereDate('created_at', Carbon::today());
		}

		$reservations = $query->where('coming_from', $comingFrom)->orderBy('created_at', 'desc')->paginate(50);
		return view('admin.reservations.index', compact('reservations', 'apartments'));
	}


	public static function order_status()
	{
		return [
			"Processing",
			"Refunded",
			"Booked",
		];
	}


	public function create(Request $request)
	{
		$apartments = Apartment::orderBy('name', 'asc')->get();
		return view('admin.reservations.create', compact('apartments'));
	}

	public function store(Request $request)
	{
		//try {
		//DB::beginTransaction();
		//dd($request->all());
		$input = $request->all();
		$property = Property::first();
		$checkin = Carbon::parse($request->checkin);
		$checkout = Carbon::parse($request->checkout); // fix: you were using checkin twice
		$date_diff = $checkin->diffInDays($checkout);
		$attr = Attribute::find($request->apartment_id);
		$query = Apartment::query();
		$query->where('id', $request->apartment_id);
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

		if (!$request->filled('user_reservation_id') && $apartments === null) {
			return back()->with('error', 'Apartment not available for your selected dates');
		}

		$guest = GuestUser::firstOrNew(['id' => data_get($input, 'guest_id')]);
		$guest->name = $input['first_name'];
		$guest->last_name = $input['last_name'];
		$guest->email = $input['email'];
		$guest->phone_number = $input['phone_number'];
		$guest->image = '';
		$guest->save();

		$apartment = Apartment::find($request->apartment_id);

		if ($request->user_reservation_id) {
			$user_reservation = UserReservation::find($request->user_reservation_id);
			ProcessGuestCheckin::dispatch($guest, $user_reservation->reservation, $apartment)->delay(now()->addSeconds(5));
			DB::commit();
			return response()->json(null, 200);
		}

		$date_diff = max($checkin->diffInDays($checkout), 1);

		$rate = json_decode(session('rate'), true); // use true to get an associative array

		$discountPercentage = (float) $request->input('discount_percentage', 0); // Defaults to 0 if not provided
		$caution_fee = $request->input('caution_fee', 0); // Defaults to 0 if not provided
		$apartmentPrice = $apartment->price;
		$totalAmount = $apartmentPrice * $date_diff;
		$discountType = $request->input('discount_type', ''); // default

		// Discount handling
		$discountValue = (float) $request->input('discount', 0);
		$discountType  = $request->input('discount_type', 'percent'); // default to percent

		$apartmentPrice = $apartment->price;
		$totalAmount = $apartmentPrice * $date_diff;
		$rate = data_get($rate, 'rate', 1);


		$totalBeforeDiscount = data_get($input, 'currency') === '₦'
			? $rate * $apartmentPrice
			: $apartmentPrice;

		$totalBeforeDiscount = $totalBeforeDiscount * $date_diff;

		if ($discountType === 'fixed') {
			$discountAmount = $discountValue;
		} else {
			$discountAmount = ($discountValue / 100) * $totalBeforeDiscount;
		}

		$discountAmount = min($discountAmount, $totalBeforeDiscount);
		$totalAfterDiscount = $totalBeforeDiscount - $discountAmount;
		$cautionFee = $caution_fee;

		$user_reservation = new UserReservation;
		$user_reservation->user_id = optional($request->user())->id;
		$user_reservation->guest_user_id = $guest->id;
		$user_reservation->currency = null;
		$user_reservation->invoice = "INV-" . date('Y') . "-" . rand(10000, time());
		$user_reservation->payment_type = 'checkin';
		$user_reservation->property_id = $property->id;
		$user_reservation->currency = data_get($input, 'currency');
		$user_reservation->checked = true;
		$user_reservation->original_amount = $totalBeforeDiscount;
		$user_reservation->coupon = null;
		$user_reservation->coming_from = "checkin";
		$user_reservation->length_of_stay = $date_diff;
		$user_reservation->total = $totalAfterDiscount + $cautionFee;
		$user_reservation->caution_fee = $cautionFee;
		$user_reservation->ip = $request->ip();
		$user_reservation->save();
		$user_reservation->discount = $discountValue;

		$user_reservation->percentage_discount = $discountType === 'fixed'
			? data_get($input, 'currency') . number_format($discountValue, 2)
			: $discountValue . '%';

		$rate = data_get($input, 'currency') === '₦' ?  $rate : 1;
		$reservation = new Reservation;
		$reservation->quantity = 1;
		$reservation->apartment_id = $request->apartment_id;
		$reservation->price = $apartment->price * $rate;
		$reservation->sale_price = $apartment->sale_price;
		$reservation->user_reservation_id = $user_reservation->id;
		$reservation->property_id = $property->id;
		$reservation->checkin = $startDate;
		$reservation->checkout = $endDate;
		$reservation->length_of_stay = $date_diff;
		$reservation->rate = data_get($input, 'currency') === '₦' ?  $rate : 1;
		$reservation->save();

		// Optional PDF logic
		$guest->image = session('session_link');
		$reservation->apartment_name = optional($apartment->attribute)->name;
		$guest->apartment_name = optional($apartment->attribute)->name;
		$reservation->first_name = $request->first_name;
		$reservation->last_name = $request->last_name;
		$reservation->email = $request->email;
		$reservation->phone_number = $request->phone_number;

		$user_reservation->showCheckLink = true;



		try {
			\Mail::to($request->email)
				->bcc('avenuemontaigneconcierge@gmail.com')
				->bcc('info@thecentralavenue.ng')
				->send(new ReservationReceipt($user_reservation, $this->settings));
		} catch (\Throwable $th) {
			//dd($th->getMessage());
			\Log::error("Mail error: " . $th->getMessage());
			// optionally: continue or throw if mail failure should abort transaction
		}





		//DB::commit();
		return redirect()->to('/admin/reservations?coming_from=checkin');
		//} catch (\Throwable $th) {
		//DB::rollBack();
		dd($th->getMessage());

		\Log::error("Reservation error: " . $th->getMessage());
		\Log::error("Reservation payload: " . $request->all());

		return redirect()->back()->withErrors(['error' => 'Reservation failed. Apartment not available for those dates.']);
		//}
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

		if ($request->filled('delete') && $request->filled('id')) {
			$userReservation = UserReservation::with('reservation')->find($request->id);

			if (null === $userReservation->reservation) {
				$userReservation->reservation->delete();
			}
			$userReservation->delete();

			return redirect()->to('/admin/reservations?coming_from=' . session('coming_from'));
		}

		$user_reservation = UserReservation::find($id);

		if ($request->add_update) {
			$checkout = Carbon::createFromDate($request->checkout);
			$user_reservation = UserReservation::find($id);
			$stay = Reservation::where('user_reservation_id', $user_reservation->id)->first();
			$apartment = Apartment::find($stay->apartment_id);
			$reservation = Reservation::find($stay->id);
			$old_checkout = $reservation->checkout;
			$reservation->quantity = 1;
			$reservation->apartment_id = $stay->apartment_id;
			$reservation->price = $apartment->price;
			$reservation->sale_price = $apartment->sale_price;
			$reservation->user_reservation_id = $user_reservation->id;
			$reservation->property_id = null;
			$reservation->checkout = $checkout;
			$reservation->save();

			$reservation->extension_date = "Checkout updated from {$old_checkout->format('Y-m-d')} to {$checkout->format('Y-m-d')}.";
			$reservation->save();
		}


		if ($request->add_extension) {
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
				$userReservation->reservation->delete();
			}
			$userReservation->delete();
		}
		Reservation::doesntHave('user_reservation')->delete();
		return redirect()->back()->with('success', ' deleted successfully');
	}
}
