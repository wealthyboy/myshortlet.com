<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Models\Property;
use Carbon\Carbon;
use App\Models\Voucher;
use App\Models\SystemSetting;



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
        //Check id date has expired
        if (!$request->date){
            return back();
        }

        $date  = explode("to",$request->date);
        $date1 = trim($date[0]);
        $date2 = trim($date[1]);
        $data  = [];
        if ($date1 || $date2) {
            $date = Carbon::createFromDate($date1);
            $date2 = Carbon::createFromDate($date2);
        }   
        $nights               = $date->diffInDays($date2);
        $from                 = $date->format('l') .' '. $date->format('d') . ' ' .$date->format('F') .' '.$date->isoFormat('Y');
        $to                   = $date2->format('l') .' '. $date2->format('d') . ' ' .$date2->format('F').' '.$date2->isoFormat('Y');
        $apartment_quantities = array_keys(array_filter($request->apartment_quantity));
        $apartments           = Apartment::whereIn('uuid', $apartment_quantities)->get(); 
		$apartment_ids        = Apartment::whereIn('uuid', $apartment_quantities)->pluck('id')->toarray();   
        $booking_details      = ['currency' => $property->currency, 'apartment_ids' => $apartment_ids, 'date_range' => $request->date, 'from' => $from, 'to' => $to, 'nights' => $nights, 'total' => $apartments->sum('price'), 'apartment_quantity' => $request->apartment_quantity];		
		return view('book.index', compact('property','apartments','booking_details'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
