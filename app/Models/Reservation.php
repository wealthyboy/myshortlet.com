<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public function user_reservation()
    {
        return $this->belongsTo(UserReservation::class);
    }

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}