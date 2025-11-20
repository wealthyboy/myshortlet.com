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



    public function userinvoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id', 'id');
    }


    public function reservation()
    {
        return $this->hasOne(Reservation::class, 'user_reservation_id')->whereNotNull('apartment_id');
    }


    public function extra_reservations()
    {
        return $this->hasMany(Reservation::class, 'user_reservation_id')
            ->where(function ($q) {
                $q->whereNull('apartment_id')
                    ->orWhere('apartment_id', '')
                    ->orWhere('apartment_id', 0);
            });
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'user_reservation_id')->whereNotNull('apartment_id');
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
