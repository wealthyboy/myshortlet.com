<?php

namespace App\Filters\PropertyFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\AbstractFilter;


class MetaFieldFilter  extends AbstractFilter
{
    public function filter(Builder $builder,$value){
        return $builder->whereHas('attributes',function(Builder  $builder) use ($value){
            $builder->where('attributes.name',$value);
        });
    }
    
}
