<?php

namespace App\Filters\ApartmentFilter;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Filters\AbstractFilters;
use App\Filters\ProductsFilter\CategoryFilter;
use App\Filters\ProductsFilter\PriceFromFilter;
use App\Filters\ProductsFilter\PriceToFilter;
use App\Filters\ProductsFilter\TotalFilter;
use App\Filters\ApartmentFilter\AttributesFilter;
use App\Filters\ApartmentFilter\SortByFilter;







class ApartmentsFilter extends AbstractFilters
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
