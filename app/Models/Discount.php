<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{   
    protected $fillable = [
        'category_id',
        'percentage_off',
        'expires',
    ];

    protected $dates = ['expires'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function discount_products(){
        return $this->hasMany(DiscountProduct::class);
    }
}
