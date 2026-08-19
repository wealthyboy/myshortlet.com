<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrencyRateCountry extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'currency_id'
    ];
}
