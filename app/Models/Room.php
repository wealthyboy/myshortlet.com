<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Traits\FormatPrice;
use App\Traits\ImageFiles;

class Room extends Model
{
    use HasFactory,FormatPrice,ImageFiles;//,SoftDeletes,CascadeSoftDeletes;


    protected $dates = ['available_from','sale_price_expires'];


    public $folder = 'apartments';


    public $appends = [
        'discounted_price',
		'default_discounted_price',
		'currency',
		'converted_price',
		'customer_price',
		'default_percentage_off',
		'image_m',
        'image_tn',
	];


    protected $fillable = [
        'name',
        'price',
        'sale_price',
        'image', 
        'sale_price_expires',
        'slug',
        'available_from',
        'reservation_id',
        'max_adults',
        'max_children',
        'no_of_rooms',
        'toilets'
    ];


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id','asc');
	}

    public function reservation(){
        return $this->belongsToMany(Reservation::class);
    }


    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }


    public function getRouteKeyName()
    {
		return 'slug';
    }

    public function bedrooms(){
        return $this->belongsToMany(Attribute::class)->where('type', 'bedroom');
    }

     


}
