<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use App\Models\SystemSetting;
use App\Http\Helper;
use App\Models\BookingDetail;
use App\Models\Property;
use App\Models\PeakPeriod;
use Carbon\Carbon;



trait FormatPrice
{


  protected $setting;


  public function __construct()
  {
    $this->setting = SystemSetting::first();
  }

  /***
   * Returns the sale price of a product
   */
  public function formatted_discount_price()
  {
    if ($this->type == 'multiple' && optional(optional($this->variant)->sale_price_expires)->isFuture()) {
      return  null !== $this->variant  &&  null !== $this->variant->sale_price
        ? $this->ConvertCurrencyRate(optional($this->variant)->sale_price)
        : null;
    } else {
      return null !== optional($this->single_room)->sale_price  &&  optional(optional($this->single_room)->sale_price_expires)->isFuture()
        ? $this->ConvertCurrencyRate(optional($this->single_room)->sale_price)
        : null;
    }
    return null;
  }

  public function display_price()
  {

    if ($this->formatted_discount_price() !== null) {
      if ($this->type == 'multiple') {
        echo "<i style='text-decoration: line-through;'>" . $this->variant->price . "</i>" . '  ' . $this->variant->sale_price;
      } else {
        echo  "<i style='text-decoration: line-through;'>" . $this->single_room->price . "</i>" . '  ' . $this->single_room->sale_price;
      }
    } else {
      if ($this->type == 'multiple') {
        echo  optional($this->variant)->price;
      }
      echo  $this->price;
    }
  }

  public function getDefaultPercentageOffAttribute()
  {
    if ($this->formatted_discount_price() !== null) {
      if (null !== !empty($this->variant)  &&  null !== $this->variant->sale_price) {
        return $this->calPercentageOff($this->variant->price, $this->variant->sale_price);
      } else {
        return $this->calPercentageOff($this->single_room->price, $this->single_room->sale_price);
      }
    }
    return null;
  }

  public function percentageOff()
  {
    return $this->calPercentageOff($this->price, $this->sale_price);
  }

  public function calPercentageOff($price, $sale_price)
  {
    if ($price && $sale_price) {
      $discount = (($price - $sale_price) * 100) / $price;
      return round($discount);
    }
    return null;
  }

  public function getPercentageOffAttribute()
  {
    return $this->percentageOff();
  }

  public function getDiscountedPriceAttribute()
  {
    if (null !== $this->sale_price &&  optional($this->sale_price_expires)->isFuture()) {
      return $this->ConvertCurrencyRate($this->sale_price);
    }
  }

  public function getDisplayPriceAttribute()
  {
    return $this->discounted_price ?? $this->converted_price;
  }

  public function getDefaultDiscountedPriceAttribute()
  {
    return $this->formatted_discount_price();
  }

  public function getCurrencyAttribute()
  {
    $query = request()->all();

    if (isset($query['currency']) && $query['currency'] === 'USD') {
      return "$";
    }
    $rate = Helper::rate();

    if ($rate) {
      return $rate->symbol;
    }
    return  optional($this->setting->currency)->symbol;
  }


  public function avgPrice()
  {
    return optional($this->apartments)->first()->price;
  }



  public function getConvertedPriceAttribute()
  {
    $currentDate = Carbon::now();
    $peak_period = PeakPeriod::first();

    if ($peak_period) {
      // Get check_in_checkout from request or session
      $checkInOut = request()->check_in_checkout ?? session('check_in_checkout');


      if ($checkInOut) {
        $dates = explode("to", $checkInOut);

        if (count($dates) > 1) {
          $date      = Helper::toAndFromDate($checkInOut);
          $peakStart = Carbon::parse($peak_period->start_date);
          $peakEnd   = Carbon::parse($peak_period->end_date);



          if (data_get($date, 'end_date') &&  data_get($date, 'start_date')) {
            $startDate = $date['start_date'];
            $endDate   = $date['end_date'];


            // Check if booking overlaps with peak period
            $overlapsPeak = (
              $startDate->between($peakStart, $peakEnd) ||
              $endDate->between($peakStart, $peakEnd) ||
              ($startDate->lt($peakStart) && $endDate->gt($peakEnd))
            );

            if ($overlapsPeak) {
              Helper::updateApartmentPrices(
                $peak_period->start_date,
                $peak_period->end_date,
                $peak_period->discount
              );
              return $this->ConvertCurrencyRate($this->december_prices);
            }
          }
        }
      }

      // If today itself falls in peak period
      if ($currentDate->between($peak_period->start_date, $peak_period->end_date)) {
        Helper::updateApartmentPrices(
          $peak_period->start_date,
          $peak_period->end_date,
          $peak_period->discount
        );
        return $this->ConvertCurrencyRate($this->december_prices);
      }
    }

    // Default: normal price
    return $this->ConvertCurrencyRate($this->price);
  }



  public function getConvertedRegularPriceAttribute()
  {
    // if ($this instanceof Property) {
    //   return $this->ConvertCurrencyRate(optional(optional($this->apartments)->first())->price);
    // }





    return $this->ConvertCurrencyRate($this->price);
  }


  public function getConvertedPeakPriceAttribute()
  {
    $currentDate = Carbon::now();
    $peak_period = PeakPeriod::first();
    if (null !==  $peak_period) {
      if ($currentDate->between($peak_period->start_date, $peak_period->end_date)) {
        if ($this->december_prices > 0) {
          return $this->ConvertCurrencyRate($this->december_prices);
        }
      }
    }



    if (null !==  $peak_period) {
      if ($currentDate->between($peak_period->start_date, $peak_period->end_date)) {
        if ($this->december_prices > 0) {
          return $this->ConvertCurrencyRate($this->december_prices);
        }
      }
    }

    return 0;
  }





  public function getExchangePriceAttribute()
  {
    // if ($this instanceof Property) {
    //   return $this->ConvertCurrencyRate(optional(optional($this->apartments)->first())->price);
    // }

    return $this->price;
  }


  public function getExchangeRateAttribute()
  {

    $rate = Helper::rate();
    if ($rate) {
      return $rate->rate;
    }
    return 1;
  }

  public function ConvertCurrencyRate($price)
  {

    $rate = Helper::rate();
    if ($rate) {

      return round(($price * $rate->rate), 0);
    }
    return round($price, 0);
  }
}
