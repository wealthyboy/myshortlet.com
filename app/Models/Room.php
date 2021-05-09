<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    protected $dates = ['available_from'];


    protected $fillable = [
        'name',
        'price',
        'sale_price',
        'image', 
        'sale_price_expires',
        'slug',
        'available_from',
        'reservation_id',
    ];


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id','asc')->where('image','!=','No Image');
	}

    public function reservation(){
        return $this->belongsToMany(Reservation::class);
    }


    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }


     


}
