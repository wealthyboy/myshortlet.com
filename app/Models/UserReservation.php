<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReservation extends Model
{
    use HasFactory;


    protected $dates = ['checkin', 'checkout'];



    public function registered_user()
    {
        return $this->belongsTo(User::class,'user_id');
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    public function guest_user()
    {
        return $this->belongsTo(User::class,'guest_user_id');
    }


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function user()
    {  
        if ($this->user_id){
            return $this->belongsTo(User::class,'user_id');
        } else {
            return $this->belongsTo(GuestUser::class,'guest_user_id');
        }
    }


    public function get_total(){
		// if ($this->order_type == 'admin'){
		// 	return number_format(optional($this->shipping)->price + $this->total);
		// }
		return number_format($this->total);
	}


    public  function voucher(){
		$voucher = Voucher::where('code',$this->coupon)->first();
		if(null !== $voucher ){
			return $voucher;
		}
		return null;
	}
}
