<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $dates = ['checkin', 'checkout'];


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

    public function extras()
    {
        return $this->hasMany(Extra::class);
    }
}
