<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Traits\FormatPrice;
use App\Traits\ImageFiles;

class Apartment extends Model
{
    use HasFactory,FormatPrice,ImageFiles;//,SoftDeletes,CascadeSoftDeletes;


    protected $dates = ['available_from','sale_price_expires'];


    public $folder = 'apartments';


    public $appends = [
        'discounted_price',
		'currency',
		'converted_price',
		'percentage_off',
		'image_m',
        'image_tn',
        'guests',
        'display_price',
        'percentage_off'
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
        'toilets',
        'type'
    ];


    public function attribute_prices()
    {
        return $this->hasMany(AttributePrice::class,'room_id');
    }


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id','asc');
    }


    public function reservations(){
        return $this->hasMany(Reservation::class);
    }


    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }


    public function free_services(){
        return $this->belongsToMany(Attribute::class)
        ->where('type','extra services')                
        ->wherePivotNull('price');
    }


    public function extra_services(){
        return $this->belongsToMany(Attribute::class)->where('type','extra services')->wherePivotNotNull('price')->withPivot('price');
    }


    public function getRouteKeyName()
    {
		return 'slug';
    }


    public function bedrooms(){
        return $this->belongsToMany(Attribute::class)->where('type', 'bedrooms')->withPivot('bed_count');
    }


    public function getGuestsAttribute(){
       return $this->max_children + $this->max_adults;
    }

    public function getImageMAttribute(){
        $image = basename($this->images[0]->image);
        return asset('images/'.$this->folder.'/'. 'm' .'/'.$image);
    }
    


    


}
