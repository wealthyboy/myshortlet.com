<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasChildren;
use App\Traits\FormatPrice;
use App\Traits\ImageFiles;

use App\Filters\ApartmentFilter\ApartmentsFilter;
use Illuminate\Database\Eloquent\Builder;

class Apartment extends Model
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
        'country',
        'state',
        'city',
        'street'
	];


    public function scopeFilter(Builder $builder,$request,array $filters = []){
        return (new ApartmentsFilter($request))->add($filters)->filter($builder);
    }

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
        return $this->belongsToMany(Facility::class,'apartment_facility');
    }

    public function  locations()
    {
        return $this->belongsToMany(Location::class);
    }

    public function location($location_type, $country){
		return optional($this->locations)->where($location_type, $country)->first();
	}

    public function getCountryAttribute(){
		return optional($this->location('location_type','country'))->name;
	}

    public function getStateAttribute(){
		return optional($this->location('location_type','state'))->name;
	}

    public function getCityAttribute(){
		return optional($this->location('location_type','city'))->name;
	}

    public function getStreetAttribute(){
		return optional($this->location('location_type','street'))->name;
	}


    public function getRouteKeyName()
    {
		return 'slug';
    }

}
