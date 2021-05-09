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

    public function products()
    {
        return $this->belongsToMany(Product::class)->where('allow',1);
    }


    public function link()
    {
        return "/products";
    }


    public function product_variations()
    {
        return $this->belongsToMany(ProductVariation::class);
    }


    public function product_variants()
    {
        return $this->belongsToMany(ProductVariation::class)->whereNotNull('name');
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


    // public function attribute_childrens()
    // {
    //     return $this->belongsToMany(AttributeCategoryChildren::class,'attribute_category_childrens')
    //                 ->withPivot('id');
    //     return $this->belongsToMany(AttributeCategoryChildren::class, 'attribute_category_childrens', 'user_id', 'role_id');
    // }


    public function attribute_parents()
    {
        return $this->hasMany(AttributeCategory::class)->whereNull('parent_id');
    }


    public function parent_attributes()
    {
        return $this->belongsToMany(Attribute::class)
                    ->wherePivot('parent_id',null)
                    ->withPivot('id');
    }


    public function check($collections,$id)
    {
        foreach($collections as $collection){
            if(null !== $collection->id && $collection->id == $id ){
                return $collection->id;
            }
        }
        return false;
    }



    public function getRouteKeyName(){
        return 'slug';
    }


   
}
