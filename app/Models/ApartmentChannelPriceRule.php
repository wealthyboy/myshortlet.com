<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApartmentChannelPriceRule extends Model
{
    protected $guarded = ['id'];
    protected $casts = ['percent' => 'float', 'amount' => 'float'];
}
