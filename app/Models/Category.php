<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasChildren;

class Category extends Model
{
    use HasChildren;
	
	protected $fillable = ['category_name','description','slug','parent_id','sort_order','allow'];
	

    public function children()
    {
        return $this->hasMany(Category::class,'parent_id','id')->orderBy('sort_order','asc');
    }

    public function images()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class)->where('allow',1);
    }

    public function locations()
    {
        return $this->belongsToMany(Location::class);
    }


    public function states()
    {
        return $this->belongsToMany(Location::class)->where('location_type','state');
    }


    public function link()
    {
        return "/property";
    }

    
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }


    public function isCategoryHaveMultipleChildren()
    {   
        $names = [];
        if ( $this->children->count()) {
            foreach (  $this->children as $children){
                if ( $children->children->count()) {
                    foreach (  $children->children as $children){
                       $names[] = $children->name;
                    }
                }
            }
        }

        return !empty($names) ? true : false;
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)
                    ->withPivot('id');
    }



    public function attribute_parents()
    {
        return $this->hasMany(AttributeCategory::class)->whereNull('parent_id');
    }


    public function getRouteKeyName(){
        return 'slug';
    }


   
}
