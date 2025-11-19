<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $dates = ['checkin', 'checkout'];

    protected $casts = [
        'checkin' => 'datetime:Y-m-d',
        'checkout' => 'datetime:Y-m-d',

    ];

    protected $fillable = [
        'user_reservation_id',
        'apartment_id',
        'quantity',
        'price',
        'property_id',
        'description',
        'checkin',
        'checkout',
        'rate',
        'length_of_stay'
    ];

    protected $appends = [
        'checkin_date',
        'checkout_date'
    ];


    public function user_reservation()
    {
        return $this->belongsTo(UserReservation::class);
    }



    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'apartment_id');
    }

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }


    public function getCheckinDateAttribute()
    {
        return optional($this->checkin)->isoFormat('dddd, MMMM Do YYYY');
    }

    public function getCheckoutDateAttribute()
    {
        return optional($this->checkout)->isoFormat('dddd, MMMM Do YYYY');
    }
}
