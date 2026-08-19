<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyRate extends Model
{
    use SoftDeletes;

    public function currency_rate_countries()
    {
        return $this->hasMany(CurrencyRateCountry::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class,'currency2_id');
    }
}
