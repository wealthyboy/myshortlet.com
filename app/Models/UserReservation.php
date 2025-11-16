<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReservation extends Model
{
    use HasFactory;


    protected $dates = ['checkin', 'checkout'];


    protected $fillable = [
        'invoice_id',
        'user_id',
        'invoice',
        'payment_type',
        'property_id',
        'currency',
        'checked',
        'original_amount',
        'coupon',
        'coming_from',
        'length_of_stay',
        'total',
        'caution_fee',
        'ip',
        'guest_user_id'
    ];




    public function registered_user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }


    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'user_reservation_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_reservation_id')->whereNotNull('apartment_id');
    }


    public function additional_reservations()
    {
        return $this->hasMany(Reservation::class, 'user_reservation_id')->whereNull('apartment_id');
    }


    public function guest_user()
    {
        return $this->belongsTo(GuestUser::class);
    }


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function user()
    {
        if ($this->user_id) {
            return $this->belongsTo(User::class, 'user_id');
        } else {
            return $this->belongsTo(GuestUser::class, 'guest_user_id');
        }
    }





    public function get_total()
    {
        // if ($this->order_type == 'admin'){
        // 	return number_format(optional($this->shipping)->price + $this->total);
        // }
        return number_format($this->total);
    }


    public  function voucher()
    {
        $voucher = Voucher::where('code', $this->coupon)->first();
        if (null !== $voucher) {
            return $voucher;
        }
        return null;
    }
}
