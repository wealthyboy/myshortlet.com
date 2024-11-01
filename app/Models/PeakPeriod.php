<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeakPeriod extends Model
{
    use HasFactory;

    protected $dates = ['start_date', 'end_date'];

}
