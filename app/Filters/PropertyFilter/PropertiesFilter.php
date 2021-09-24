<?php

namespace App\Filters\PropertyFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\AbstractFilters;
use App\Filters\PropertyFilter\CategoryFilter;
use App\Filters\PropertyFilter\PriceFromFilter;
use App\Filters\PropertyFilter\PriceToFilter;
use App\Filters\PropertyFilter\TotalFilter;
use App\Filters\PropertyFilter\AttributesFilter;
use App\Filters\PropertyFilter\SortByFilter;







class PropertiesFilter extends AbstractFilters
{
    
    protected $filters = [
        'price_from'=>PriceFromFilter::class,
        'price_to'=>PriceToFilter::class, 
        'sort_by'=>SortByFilter::class,
        'prices' => TotalFilter::class,
        'strap_type' =>AttributesFilter::class,
        'hprices' => PriceFromFilter::class
    ];

    
    
}
