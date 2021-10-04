<?php

namespace App\Filters\PropertyFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\AbstractFilter;


class TotalFilter  extends AbstractFilter
{
    // public function filter(Builder $builder,$value)
    // {
    //     if(count($value) == 1){
    //         $value  =  array_shift($value);
    //         return $builder->where('price','<=' ,$value);
    //     }
    //     return $builder->whereBetween('price', [min($value), max($value)]);
    // }

    public function filter(Builder $builder,$value){
   
        return  $builder->whereHas('apartments',function(Builder  $builder) use ($value){
            $builder->whereBetween('price', [min($value), max($value)]);
         }); 
    } 
    
}
