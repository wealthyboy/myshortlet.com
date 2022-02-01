<?php

namespace App\Filters\PropertyFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\AbstractFilter;


class TotalFilter  extends AbstractFilter
{
    public function filter(Builder $builder,$value)
    {
        $data = [];
        foreach ($value as $key => $price) {
            $prices = explode('-', $price);
            foreach ($prices as $key => $price) {
              $data[] = $price; 
            }
        }
        return $builder->whereBetween('price', [min($data), max($data)]);
    } 
    
}
