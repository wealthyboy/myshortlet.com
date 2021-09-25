<?php

namespace App\Filters\PropertyFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\AbstractFilter;


class AttributesFilter  extends AbstractFilter
{
    public function filter(Builder $builder,$value){
        
        return $builder->whereHas('attributes',function(Builder  $builder) use ($value){
            $builder->whereIn('slug', $value);
        });
    }  
}
