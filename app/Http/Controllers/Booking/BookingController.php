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
use App\Services\BookingPricingService;



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

		if (!$bookings->count() || !$bookings->first()) {
			return redirect()->to('/');
		}

		$booking = $bookings->first();
		$property = Property::find($booking->property_id) ?: $property;
		$apt = $booking->apartment ?: Apartment::find($request->apartment_id);

		if (!$apt) {
			return redirect()->to('/');
		}

		$quote = $booking->pricing_snapshot;

		if (!is_array($quote) || empty($quote['nights'])) {
			$quote = app(BookingPricingService::class)->quote(
				$apt,
				$booking->checkin,
				$booking->checkout,
				$booking->exchange_rate ?: optional(Helper::rate())->rate,
				$booking->currency_code ?: Helper::getIsoCode(),
				$booking->currency_symbol ?: Helper::getCurrency()
			);

			// Freeze the quote so every later step uses the same currency/rate and
			// the same peak-period calculation, even if either changes afterwards.
			$booking->currency_code = $quote['currency_code'];
			$booking->currency_symbol = $quote['currency_symbol'];
			$booking->exchange_rate = $quote['exchange_rate'];
			$booking->pricing_snapshot = $quote;
			$booking->price = $quote['average_nightly'];
			$booking->regular_price = $quote['regular_nightly'];
			$booking->total = $quote['accommodation_total'];
			$booking->save();
		}

		$days = (int) $quote['nights'];
		$nights = [$days, $days === 1 ? 'night' : 'nights'];
		$phone_codes = Helper::phoneCodes();
		$property->load('free_services', 'facilities', 'extra_services');
		$ids = $bookings->pluck('id')->toArray();

		$from = $booking->checkin->format('l d F Y');
		$to = $booking->checkout->format('l d F Y');
		$peakPeriod = data_get($quote, 'peak_periods.0');

		$booking_details = [
			'peak_period' => $peakPeriod,
			'peak_periods' => data_get($quote, 'peak_periods', []),
			'is_peak_period_present' => (int) $quote['peak_nights'] > 0,
			'days_in_peak_period' => (int) $quote['peak_nights'],
			'days_not_in_peak_period' => (int) $quote['regular_nights'],
			'peak_period_total' => $quote['peak_total'],
			'days_not_in_peak_period_total' => $quote['regular_total'],
			'peak_price' => $quote['peak_nightly'],
			'peak_percentage' => $quote['peak_percentage'],
			'regular_price' => $quote['regular_nightly'],
			'currency' => $quote['currency_code'], // Paystack expects the ISO code.
			'currency_code' => $quote['currency_code'],
			'currency_symbol' => $quote['currency_symbol'],
			'exchange_rate' => $quote['exchange_rate'],
			'pricing_snapshot' => $quote,
			'loggedIn' => auth()->check(),
			'user' => auth()->user(),
			'days' => $days,
			'from' => $from,
			'to' => $to,
			'nights' => $nights,
			'total' => $quote['accommodation_total'],
			'booking_ids' => $ids,
			'is_agent' => optional($user)->isAgent(),
			'apt_id' => $apt->id,
			'sessionId' => session()->getId(),
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
		$apId = $request->apID ?: $request->apartment_id;

		// Some existing single-apartment forms only send the apartment as the
		// first key in apartment_quantity. Keep those forms working.
		if (!$apId && is_array($request->apartment_quantity)) {
			$first = collect($request->apartment_quantity)->first();
			if (is_array($first) && !empty($first)) {
				$apId = array_key_first($first);
			}
		}

		$apartment = Apartment::find($apId);
		$dates = Helper::toAndFromDate($request->check_in_checkout);
		$startDate = data_get($dates, 'start_date');
		$endDate = data_get($dates, 'end_date');

		if (!$apartment || !$startDate || !$endDate || !$endDate->gt($startDate)) {
			return response()->json([
				'msg' => 'Please choose a valid apartment and check-in/check-out date.',
			], 422);
		}

		$sessionRate = Helper::rate();
		$exchangeRate = is_numeric(optional($sessionRate)->rate) && (float) optional($sessionRate)->rate > 0
			? (float) optional($sessionRate)->rate
			: 1.0;
		$currencyCode = Helper::getIsoCode() ?: 'USD';
		$currencySymbol = Helper::getCurrency() ?: '$';

		$quote = app(BookingPricingService::class)->quote(
			$apartment,
			$startDate,
			$endDate,
			$exchangeRate,
			$currencyCode,
			$currencySymbol
		);

		// Keep the selected dates available to apartment price accessors on the
		// following page, but use the frozen quote for all booking totals.
		session()->put('check_in_checkout', $request->check_in_checkout);
		$value = bcrypt('^%&#*$((j1a2c3o4b5@+-40');
		session()->put('booking', $value);
		$cookie = cookie('booking', session()->get('booking'), time() + 86400);

		$booking = new BookingDetail;
		$booking->apartment_id = $apartment->id;
		$booking->quantity = 1;
		$booking->property_id = $request->propertyId ?: $request->property_id ?: $apartment->property_id;
		$booking->price = $quote['average_nightly'];
		$booking->sale_price = $apartment->discounted_price;
		$booking->regular_price = $quote['regular_nightly'];
		$booking->total = $quote['accommodation_total'];
		$booking->currency_code = $quote['currency_code'];
		$booking->currency_symbol = $quote['currency_symbol'];
		$booking->exchange_rate = $quote['exchange_rate'];
		$booking->pricing_snapshot = $quote;
		$booking->user_id = optional($request->user())->id;
		$booking->checkin = $startDate;
		$booking->checkout = $endDate;
		$booking->token = $cookie->getValue();
		$booking->save();

		return response()->json([
			'msg' => 'Reservation sucessfully added',
			'pricing' => $quote,
		], 200)->withCookie($cookie);
	}


	protected function coupon(Request $request)
	{

		$cart_total  = $request->total;

		$bookingIds = array_values(array_filter((array) $request->booking_ids));
		$frozenBooking = !empty($bookingIds)
			? BookingDetail::whereIn('id', $bookingIds)
				->where('token', \Cookie::get('booking'))
				->first()
			: null;

		$symbol = optional($frozenBooking)->currency_symbol
			?: Helper::getCurrency()
			?: optional(optional($this->settings)->currency)->symbol;

		$sessionRate = Helper::rate();
		$exchangeRate = is_numeric(optional($frozenBooking)->exchange_rate) && (float) optional($frozenBooking)->exchange_rate > 0
			? (float) optional($frozenBooking)->exchange_rate
			: (is_numeric(optional($sessionRate)->rate) && (float) optional($sessionRate)->rate > 0
				? (float) optional($sessionRate)->rate
				: 1.0);

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


		$minimumValue = round(((float) $coupon->from_value) * $exchangeRate, 0);

		if ($cart_total < $minimumValue) {
			$error['error'] = 'You can only use this coupon when your purchase is above  ' . $symbol . number_format($minimumValue);
			return response()->json($error, 422);
		}


		if ($coupon->limits && $request->limit > $coupon->limits) {
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

		if (!empty($coupon->from_value) && $cart_total >= $minimumValue) {
			$new_total = ($coupon->amount * $cart_total) / 100;
			$new_total = $cart_total - $new_total;
			$total['sub_total'] = round($new_total, 0);
			$request->session()->put(['new_total' => $new_total]);
			$request->session()->put(['coupon_total' => $new_total]);
			$request->session()->put(['coupon' => $request->coupon]);
			$total['percent'] = $coupon->amount . '%  percent off';
			return response()->json($total, 200);
		} else if (!empty($coupon->from_value) && $cart_total < $minimumValue) {
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
