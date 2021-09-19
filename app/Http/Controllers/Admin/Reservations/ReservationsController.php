<?php

namespace App\Http\Controllers\Admin\Reservations;

use Illuminate\Http\Request;

use App\Models\UserReservation;
use App\Models\User;
use App\Models\SystemSetting;
use App\Models\OrderedProduct;
use App\Http\Controllers\Controller;
use App\Http\Helper;




class ReservationsController extends Controller { 


  
    public function __construct()
    {

       $this->middleware('admin'); 
	   $this->settings =  \DB::table('system_settings')->first();
    }

    public function index (Request $request) 
	{ 
		$reservations = UserReservation::orderBy('created_at','desc')->paginate(20);
        return view('admin.reservations.index',compact('reservations'));
    }
    

    public static function order_status() { 
		return [
			"Processing",
			"Refunded",
			"Booked",
		];
	}


	public function show($id) { 
		$user_reservation =  UserReservation::find($id);
		$sub_total   =  $user_reservation->total;
		$statuses    =  static::order_status();
		return view('admin.reservations.show',compact('statuses','user_reservation','sub_total'));
	}
	
	
	public function updateStatus(Request $request){
		$ordered_product = OrderedProduct::findOrFail($request->ordered_product_id);
		$ordered_product->status = $request->status;
		$ordered_product->save();        
		return $ordered_product;
	}
    

    


}