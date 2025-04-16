<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Property;
use Carbon\Carbon;
use App\Models\Voucher;
use App\Models\SystemSetting;
use App\Http\Helper;
use App\Models\BookingDetail;
use App\Models\PeakPeriod;
use App\Models\UserTracking;



class BookingController extends Controller
{

	public  $settings;

	public function __construct()
	{
		$this->settings =  SystemSetting::first();
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function book(Request $request, Property $property)
	{

		if (!$request->check_in_checkout) {
			return back();
		}

		$referer = request()->headers->get('referer');
		$bookings = BookingDetail::all_items_in_cart($property->id);

		$user = auth()->user();

		if (!$bookings->count()) {
			return redirect()->to('/');
		}

		$ids = $bookings->pluck('id')->toArray();
		$ids = $ids;
		$booking = $bookings[0];


		if (!$booking) {
			return redirect()->to('/');
		}

		$days = $booking->checkin->diffInDays($booking->checkout);

		$peak_period =  PeakPeriod::first();
		$daysInPeakPeriod = $peak_period->calculateDaysWithinPeak($booking->checkin, $booking->checkout);
		$daysNotInPeakPeriod = $peak_period->calculateDaysOutsidePeak($booking->checkin, $booking->checkout);
		$daysNotInPeakPeriod = $daysNotInPeakPeriod < 0 ? 0 : $daysNotInPeakPeriod;
		$apt = Apartment::find($request->apartment_id);


		$peak_period_price = $apt->converted_peak_price > 0 ? $apt->converted_peak_price : $peak_period->increasePriceByPercentage($apt->converted_price);
		$isPeakPeriodPresent = $daysInPeakPeriod > 0 ? true : false;
		$daysInPeakPeriodTotal = $daysInPeakPeriod > 0 ? $daysInPeakPeriod * $peak_period_price : 0;
		$daysNotInPeakPeriodTotal = $daysNotInPeakPeriod > 0 ? $daysNotInPeakPeriod * $apt->converted_regular_price : 0;

		$nights = [];
		$phone_codes = Helper::phoneCodes();
		$stays = $days == 1 ? "night" : " nights";
		$nights[] = $days;
		$nights[] = $stays;
		$property->load('free_services', 'facilities', 'extra_services');
		$total = BookingDetail::sum_items_in_cart($property->id);
		$total = $daysInPeakPeriodTotal + $daysNotInPeakPeriodTotal;
		$from = $booking->checkin->format('l') . ' ' . $booking->checkin->format('d') . ' ' . $booking->checkin->format('F') . ' ' . $booking->checkin->isoFormat('Y');
		$to = $booking->checkout->format('l') . ' ' . $booking->checkout->format('d') . ' ' . $booking->checkout->format('F') . ' ' . $booking->checkout->isoFormat('Y');
		$booking_details = [
			'peak_period' => PeakPeriod::first(),
			'is_peak_period_present' => $daysInPeakPeriod > 0 ? true : false,
			'days_in_peak_period' => $daysInPeakPeriod,
			'days_not_in_peak_period' => $daysNotInPeakPeriod,
			'peak_period_total' => $daysInPeakPeriodTotal,
			'days_not_in_peak_period_total' => $daysNotInPeakPeriodTotal,
			'peak_price' => $peak_period_price,
			'regular_price' => $apt->converted_regular_price,
			'currency' => session('switch'),
			'loggedIn' => auth()->check(),
			'user' => auth()->user(),
			'days' => $days,
			'from' => $from,
			'to' => $to,
			'nights' => $nights,
			'total' => $total,
			'booking_ids' => $ids,
			'is_agent' => optional($user)->isAgent(),
			'apt_id' => optional($apt)->id,
			'sessionId' => session()->getId()
		];


		$qs = request()->all();
		return view('book.index', compact('qs', 'referer', 'phone_codes', 'property', 'bookings', 'booking_details'));
	}


	public function getDaysInDecember($startDate, $endDate)
	{
		// Convert input strings to DateTime objects
		$start = new \DateTime($startDate);
		$end = new \DateTime($endDate);

		// Ensure the end date is after the start date
		if ($end < $start) {
			return 0; // Invalid date range
		}

		// Define the start and end of December
		$decemberStart = new \DateTime($start->format('Y') . '-12-01');
		$decemberEnd = new \DateTime($start->format('Y') . '-12-31');

		// Check if the date range overlaps with December
		if ($end < $decemberStart || $start > $decemberEnd) {
			return 0; // No days in December
		}

		// Calculate the actual December start and end within the range
		$rangeStartInDecember = $start < $decemberStart ? $decemberStart : $start;
		$rangeEndInDecember = $end > $decemberEnd ? $decemberEnd : $end;

		// Calculate the number of days in December within the range
		$daysInDecember = $rangeEndInDecember->diff($rangeStartInDecember)->days + 1;

		return $daysInDecember;
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{

		//dd($request->all());
		$booking = new BookingDetail;
		$apartment_quantity = $request->apartment_quantity;
		$apId = $request->apID;
		$date  = explode("to", $request->check_in_checkout);
		$date1 = trim($date[0]);
		$date2 = trim($date[1]);
		$data  = [];
		$nights = [];
		$start_date = null;
		if ($date1 || $date2) {
			$start_date = Carbon::createFromDate($date1);
			$end_date = Carbon::createFromDate($date2);
		}

		$ap_ids = [];
		$value = bcrypt('^%&#*$((j1a2c3o4b5@+-40');
		session()->put('booking', $value);
		$cookie = null;
		$booking = new BookingDetail;
		$ap = Apartment::find($request->apID);
		$price = optional($ap)->converted_price;
		$sale_price = optional($ap)->discounted_price;
		$sp = $sale_price ?? $price;



		$value = bcrypt('^%&#*$((j1a2c3o4b5@+-40');
		session()->put('booking', $value);
		$cookie = cookie('booking', session()->get('booking'), time() + 86400);
		$booking->apartment_id = $apId;
		$booking->quantity = 1;
		$booking->property_id = $request->propertyId;
		$booking->price = $price;
		$booking->sale_price = optional($ap)->discounted_price;
		$booking->regular_price = optional($ap)->converted_regular_price;
		$booking->total = $sp * 1;
		$booking->user_id = optional($request->user())->id;
		$booking->checkin = $start_date;
		$booking->checkout = $end_date;
		$booking->token = $cookie->getValue();
		$booking->save();
		if ($cookie == null) {
			return response()->json([
				'msg' => 'Reservation sucessfully added'
			], 200);
		}
		return response()->json([
			'msg' => 'Reservation sucessfully added'
		], 200)->withCookie($cookie);
	}


	protected function coupon(Request $request)
	{

		$cart_total  = $request->total;

		$symbol = optional(optional($this->settings)->currency)->symbol;

		if (!$cart_total) {
			$error['error'] = 'We cannot process your voucher';
			return response()->json($error, 422);
		}

		$user  =  \Auth::user();
		// Build the input for validation
		$coupon = array('coupon' => $request->coupon);
		// Tell the validator that this file should be an image
		$rules = array(
			'coupon' => 'required'
		);

		// Now pass the input and rules into the validator
		$validator = \Validator::make($coupon, $rules);

		if ($validator->fails()) {
			return response()->json($validator->messages(), 422);
		}

		$coupon =  Voucher::where('code', $request->coupon)
			->where('status', 1)
			->first();

		$error = array();

		if (empty($coupon)) {
			$error['error'] = 'Coupon is invalid ';
			return response()->json($error, 422);
		}

		if ($coupon->is_coupon_expired()) {
			$error['error'] = 'Coupon has expired';
			return response()->json($error, 422);
		}


		if ($cart_total < $coupon->from_value) {
			$error['error'] = 'You can only use this coupon when your purchase is above  ' . $symbol . $coupon->from_value;
			return response()->json($error, 422);
		}


		if ($request->limit > $coupon->limits) {
			$error['error'] = 'Coupon can only be used for  ' . $coupon->limits . ' night(s)';
			return response()->json($error, 422);
		}


		if (!$coupon->is_valid()) {
			$error['error'] = 'Coupon is invalid ';
			return response()->json($error, 422);
		}
		//get all the infomation 
		$total = [];
		$total['currency'] = $symbol;

		if (!empty($coupon->from_value) && $cart_total >= $coupon->from_value) {
			$new_total = ($coupon->amount * $cart_total) / 100;
			$new_total = $cart_total - $new_total;
			$total['sub_total'] = round($new_total, 0);
			$request->session()->put(['new_total' => $new_total]);
			$request->session()->put(['coupon_total' => $new_total]);
			$request->session()->put(['coupon' => $request->coupon]);
			$total['percent'] = $coupon->amount . '%  percent off';
			return response()->json($total, 200);
		} else if (!empty($coupon->from_value) && $cart_total < $coupon->from_value) {
			$error['error'] = 'Coupon is invalid ';
			return response()->json($error, 422);
		} else {
			$new_total = ($coupon->amount * $cart_total) / 100;
			$new_total = $cart_total - $new_total;
			$total['sub_total'] =   $new_total;
			$request->session()->put(['new_total' => $new_total]);
			$request->session()->put(['coupon_total' => $new_total]);
			$request->session()->put(['coupon' => $request->coupon]);
			$total['percent'] = $coupon->amount . '%  percent off';
			return response()->json($total, 200);
		}
	}



	public function loadCart(Request $request)
	{

		$carts = Cart::all_items_in_cart();
		$sub_total =  Cart::sum_items_in_cart();
		$rate = \Cookie::get('rate');
		return  CartIndexResource::collection($carts)->additional([
			'meta' => [
				'sub_total' => $sub_total,
				'currency' => Helper::rate()->symbol ?? optional(optional($this->settings)->currency)->symbol,
				'currency_code' => Helper::rate()->iso_code3 ?? optional(optional($this->settings)->currency)->iso_code3,
				'user' => $request->user(),
				'isAdmin' => null !== $request->user() ? $request->user()->isAdmin() : false
			],
		]);
	}

	public function destroy(Request $request, $bookin_id)
	{

		if ($request->ajax()) {
			$booking =  BookingDetail::find($bookin_id);
			$booking->delete();
			$bookings = BookingDetail::all_items_in_cart($request->property_id);
			$total = BookingDetail::sum_items_in_cart($request->property_id);
			return  response()->json([
				'data' => [
					'bookings' => $bookings,
					'total' => $total
				],
			]);



			//return $this->loadBooking($request);
		}
	}
}
