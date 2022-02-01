<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\FormatPrice;

class ApartmentAttribute extends Model
{
    use HasFactory,FormatPrice;
    
    protected $table = 'apartment_attribute';

	public $appends = [
        'converted_price',
	];

    public function attribute(){
        return $this->belongsTo(Attribute::class);
    }
}
