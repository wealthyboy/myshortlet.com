<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasChildren;
use App\Traits\FormatPrice;
use App\Traits\ImageFiles;

class Reservation extends Model
{
    use HasFactory,FormatPrice,ImageFiles;//,SoftDeletes,CascadeSoftDeletes;

    public $folder = 'products';

    protected $dates = ['deleted_at','sale_price_expires'];

	public $appends = [
		'image_to_show',
		'image_m',
        'image_tn',
		'image_to_show_m',
		'image_to_show_tn',
	];

    public function city(){
        return $this->belongsTo(Location::class,'city_id');
    }

    public function state(){
        return $this->belongsTo(Location::class,'state_id');
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id','asc')->where('image','!=','No Image');
	}

    public function rooms(){
        return $this->hasMany(Room::class);
    }

    public function facilities(){
        return $this->belongsToMany(Facility::class,'facility_reservation');
    }

}
