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
    use HasFactory, FormatPrice, ImageFiles; //,SoftDeletes,CascadeSoftDeletes;

    public $folder = 'apartments';

    protected $dates = ['deleted_at', 'sale_price_expires'];

    public $appends = [
        'image_m',
        'image_tn',
        'country',
        'state',
        'state_description',
        'city',
        'street',
        'currency',
        'link',
        'default_discounted_price',
        'converted_price',
        'is_saved'
    ];


    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        return (new PropertiesFilter($request))->add($filters)->filter($builder);
    }


    public function variant()
    {
        return $this->hasOne(Apartment::class);
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id', 'asc');
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function is_saved()
    {
        $saved = auth()->check() ? auth()->user()->favorites->pluck('property_id')->toArray() : [];
        return in_array($this->id, $saved) ? true : false;
    }

    public function children()
    {
        return $this->hasMany(Apartment::class);
    }

    public function apartments()
    {
        return $this->hasMany(Apartment::class);
    }


    public function agentsApartments()
    {
        return $this->hasMany(ApartmentUser::class)->where('user_id', optional(auth()->user())->id);
    }

    public function extra_services()
    {
        return $this->belongsToMany(Attribute::class)
            ->where('type', 'extra services')
            ->wherePivotNotNull('price')
            ->withPivot('price');
    }


    public function free_services()
    {
        return $this->belongsToMany(Attribute::class)
            ->where('type', 'extra services')
            ->wherePivotNull('price');
    }


    public function areas()
    {
        return $this->belongsToMany(Attribute::class)
            ->wherePivot('name', 'area');
    }

    public function restaurants()
    {
        return $this->belongsToMany(Attribute::class)
            ->wherePivot('name', 'Restaurants');
    }


    public function safety_practicies()
    {
        return $this->belongsToMany(Attribute::class)
            ->wherePivot('name', 'Safety');
    }


    public function paid_services()
    {
        return $this->belongsToMany(Attribute::class)
            ->where('type', 'extra services')
            ->wherePivotNotNull('price');
    }


    public function single_room()
    {
        return $this->hasOne(Apartment::class)->where('type', 'single');
    }

    public function multiple_rooms()
    {
        return $this->hasMany(Apartment::class)->where('type', 'multiple');
    }

    public function facilities()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'facilities');
    }

    public function apartment_facilities()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'apartment facilities');
    }


    public function rules()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'rules');
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }


    public function states()
    {
        return $this->belongsToMany(Location::class)->where('location_type', 'state');
    }


    public function cities()
    {
        return $this->belongsToMany(Location::class)->where('location_type', 'city');
    }

    public function streets()
    {
        return $this->belongsToMany(Location::class)->where('location_type', 'street');
    }

    public function  locations()
    {
        return $this->belongsToMany(Location::class);
    }

    public function location($location_type, $country)
    {
        return optional($this->locations)->where($location_type, $country)->first();
    }

    public function getCountryAttribute()
    {
        return optional($this->location('location_type', 'country'))->name;
    }

    public function getStateAttribute()
    {
        return optional($this->location('location_type', 'state'))->name;
    }

    public function getStateDescriptionAttribute()
    {
        return optional($this->location('location_type', 'state'))->description;
    }

    public function getCityAttribute()
    {
        return optional($this->location('location_type', 'city'))->name;
    }

    public function getStreetAttribute()
    {
        return optional($this->location('location_type', 'street'))->name;
    }

    public function getIsSavedAttribute()
    {
        return $this->is_saved();
    }


    public function getLinkAttribute()
    {
        $rooms = request()->rooms ? "&rooms=" . request()->rooms : null;
        $check_in_checkout = request()->check_in_checkout ? "?check_in_checkout=" . request()->check_in_checkout : null;
        $children = request()->children ? "&children=" . request()->children : null;
        $adults = request()->adults ? "&adults=" . request()->adults : null;
        return  '/property/' . $this->slug . $check_in_checkout . $rooms . $children . $adults;
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
