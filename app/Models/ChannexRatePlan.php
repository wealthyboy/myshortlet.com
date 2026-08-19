<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChannexRatePlan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'apartment_id',
        'channex_rate_plan_id',
        'name',
        'default_rate',
        'meal_type',
        'price_mode',
        'is_default',
        'is_active',
    ];

    protected $casts = [
        'default_rate' => 'decimal:2',
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }

    public function dailyRates()
    {
        return $this->hasMany(ApartmentDailyRate::class, 'channex_rate_plan_id');
    }
}
