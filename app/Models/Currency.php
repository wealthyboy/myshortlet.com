<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    public function rate()
    {
        return $this->hasOne(CurrencyRate::class,'currency2_id');
    }
}
