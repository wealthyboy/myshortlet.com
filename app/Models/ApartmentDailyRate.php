<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentDailyRate extends Model
{
    protected $fillable = [
        'apartment_id',
        'channex_rate_plan_id',
        'date',
        'price',
        'sale_price',
        'availability',
        'min_stay_arrival',
        'min_stay_through',
        'max_stay',
        'closed_to_arrival',
        'closed_to_departure',
        'stop_sell',
    ];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'availability' => 'integer',
        'min_stay_arrival' => 'integer',
        'min_stay_through' => 'integer',
        'max_stay' => 'integer',
        'closed_to_arrival' => 'boolean',
        'closed_to_departure' => 'boolean',
        'stop_sell' => 'boolean',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function ratePlan()
    {
        return $this->belongsTo(ChannexRatePlan::class, 'channex_rate_plan_id');
    }
}
