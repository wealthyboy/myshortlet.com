<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\HasChildren;
use App\Traits\FormatPrice;
use App\Traits\ImageFiles;

use App\Filters\PropertyFilter\PropertiesFilter;
use Illuminate\Database\Eloquent\Builder;

class Property extends Model
{
    use HasFactory,FormatPrice,ImageFiles;//,SoftDeletes,CascadeSoftDeletes;

    public $folder = 'apartments';

    protected $dates = ['deleted_at','sale_price_expires'];

	public $appends = [
		'image_m',
        'image_tn',
        'country',
        'state',
        'city',
        'street',
        'currency',
        
	];


    public function scopeFilter(Builder $builder,$request,array $filters = []){
        return (new PropertiesFilter($request))->add($filters)->filter($builder);
    }

    


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id','asc');
	}

    public function apartments(){
        return $this->hasMany(Apartment::class);
    }

    public function extra_services(){
        return $this->belongsToMany(Attribute::class)->where('type','extra_service');
    }


    public function single_room(){
        return $this->hasOne(Apartment::class)->where('type','single');
    }

    public function multiple_rooms(){
        return $this->hasMany(Apartment::class)->where('type','multiple');
    }

    public function facilities(){
        return $this->belongsToMany(Facility::class,'apartment_facility');
    }


    public function attributes(){
        return $this->belongsToMany(Attribute::class);
    }


    public function states(){
        return $this->belongsToMany(Location::class)->where('location_type', 'state');
    }


    public function cities(){
        return $this->belongsToMany(Location::class)->where('location_type', 'city');
    }

    public function streets(){
        return $this->belongsToMany(Location::class)->where('location_type', 'street');
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