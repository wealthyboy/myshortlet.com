<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Traits\HasChildren;
use App\AttributeCategory;



class Attribute extends Model
{

    use HasChildren;

    protected $fillable = [
		'name','parent_id',
    ];

    public $appends = [
        
    ];

    public function values()
    {
        return $this->hasMany(AttributeProduct::class,'parent_id','id');
    }

    public function children()
    {
        return $this->hasMany(Attribute::class,'parent_id','id');
    }

    public function parent()
    {
        return $this->belongsTo(Attribute::class,'parent_id','id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)
                    ->groupBy('attribute_id');
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class)->withPivot('category_id');
    }


    public function information()
    {
        return $this->belongsToMany(Information::class)->withPivot('information_id');
    }

    public function variation_value()
    {
        return $this->hasOne(ProductVariationValue::class,'attribute_parent_id');
    }

    

  
    
    
   


}
