<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip_address',
        'user_agent',
        'visited_at',
        'apartment_id',
        'ip_address',
        'session_id',
        'action',
        'time_spent',
        'page_url',
        'visited_at',
        'first_name',
        'last_name',
        'email',
        'code',
        'phone_number',
        'services',
        'currency',
        'total',
        'property_id',
        'country',
        'coupon',
        'original_amount',
        'referer',
        'user_agent'
    ];


    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
