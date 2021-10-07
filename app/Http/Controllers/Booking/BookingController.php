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
    public function book(Request $request,Property $property)
    {   
        
		if (!$request->check_in_checkout){
            return back();
        }
        
		$bookings = BookingDetail::all_items_in_cart($property->id);
		$ids = $bookings->pluck('id')->toArray();
		$booking = $bookings[0];
		$nights = [];
		$phone_codes = Helper::phoneCodes();
        $days               = $booking->checkin->diffInDays($booking->checkout);
		$stays   = $days == 1 ? "night" : " nights";
        $nights[] = $days;
        $nights[] = $stays;
		$property->load('free_services', 'facilities','extra_services');
		$total = BookingDetail::sum_items_in_cart($property->id);
		$total = $total * $days;
        $from                 = $booking->checkin->format('l') .' '. $booking->checkin->format('d') . ' ' .$booking->checkin->format('F') .' '.$booking->checkin->isoFormat('Y');
        $to                   = $booking->checkout->format('l') .' '. $booking->checkout->format('d') . ' ' .$booking->checkout->format('F').' '.$booking->checkout->isoFormat('Y');
        $booking_details      = ['days'=>$days, 'from' => $from, 'to' => $to, 'nights' => $nights, 'total' => $total, 'booking_ids' => $ids];
		return view('book.index', compact('phone_codes','property','bookings','booking_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $booking = new BookingDetail;
		$apartment_quantity = $request->apartment_quantity;
		$date  = explode("to",$request->check_in_checkout);
        $date1 = trim($date[0]);
        $date2 = trim($date[1]);
        $data  = [];
		$nights = [];
		$start_date =null;
        if ($date1 || $date2) {
            $start_date = Carbon::createFromDate($date1);
            $end_date = Carbon::createFromDate($date2);
        } 


		$ap_ids = [];
		
        foreach ($apartment_quantity as $key => $apartments) {
			foreach ($apartments as $apartment_id => $quantity) {
				$booking = new BookingDetail;

			   $ap = Apartment::find($apartment_id);
			   $price = optional($ap)->discounted_price ??  optional($ap)->converted_price;
				if (\Cookie::get('booking') !== null) {
					$token  = \Cookie::get('booking');
					$result = $booking->updateOrCreate(
						['apartment_id' => $apartment_id,'token' => $token],
						[
							'apartment_id' => $apartment_id,
							'property_id' => $request->property_id,
							'user_id' => optional($request->user())->id,
							'quantity'   => $quantity,
							'price'      => $price,
							'total'      => $price * $quantity,
							'checkin' => $start_date,
							'checkout' => $end_date,	
						]
					);
				}  else  {

					$value = bcrypt('^%&#*$((j1a2c3o4b5@+-40');
					session()->put('booking',$value);
					$cookie = cookie('booking',session()->get('booking'), time() + 86400);
					$booking->apartment_id   = $ap->id;
					$booking->quantity   = $quantity;
					$booking->property_id = $request->property_id;
					$booking->price      = $price;
					$booking->total      = $price * $quantity;
					$booking->user_id      = optional($request->user())->id;
					$booking->checkin      = $start_date;
					$booking->checkout      = $end_date;
					$booking->token =$cookie->getValue();
					$booking->save();
				}

		    }

		}

		$cookie = \Cookie::get('booking');

		return response()->json([],200)->withCookie($cookie);
    }


    protected function coupon (Request $request) 
    { 

		$cart_total  = $request->total;

		if ( !$cart_total ){
			$error['error']='We cannot process your voucher';
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
		
		$coupon=  Voucher::
		                   where('code',$request->coupon)
		                    ->where('status',1)    
							->first();
	
		$error = array();

		if( empty( $coupon ) ) { 
			$error['error']='Coupon is invalid ';
			return response()->json($error, 422);
		}

		if( $coupon->is_coupon_expired() ){
			$error['error']='Coupon has expired';
			return response()->json($error, 422); 
		}


		if ( $cart_total < $coupon->from_value){
			$error['error']='You can only use this coupon when your purchase is above  '. $this->settings->currency->symbol .$coupon->from_value;
			return response()->json($error, 422);
		}


		if( !$coupon->is_valid() ){
			$error['error']='Coupon is invalid ';
			return response()->json($error, 422); 
		}
		//get all the infomation 
		$total = [];
		$total['currency'] = $this->settings->currency->symbol;

		if ( !empty ( $coupon->from_value ) && $cart_total >= $coupon->from_value  ) {
			$new_total = ($coupon->amount * $cart_total) /100;
			$new_total = $cart_total - $new_total;
			$total['sub_total'] = round($new_total,0);
			$request->session()->put(['new_total'=>$new_total]);
			$request->session()->put(['coupon_total'=>$new_total]);
			$request->session()->put(['coupon'=>$request->coupon]);
			$total['percent'] = $coupon->amount .'%  percent off';
			return response()->json($total, 200);
		} else if ( !empty ($coupon->from_value ) && $cart_total < $coupon->from_value  ) { 
			$error['error']='Coupon is invalid ';
			return response()->json($error, 422);
		} else  {
			$new_total = ($coupon->amount * $cart_total) /100;
			$new_total = $cart_total - $new_total; 
			$total['sub_total'] =   $new_total;
			$request->session()->put(['new_total'=>$new_total]);
			$request->session()->put(['coupon_total'=>$new_total]);
			$request->session()->put(['coupon'=>$request->coupon]);
			$total['percent'] = $coupon->amount .'%  percent off';
			return response()->json($total, 200);  
		}
					
	}



    
}
