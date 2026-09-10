<?php

namespace App\Traits;

use App\Models\SystemSetting;
use App\Models\Apartment;
use App\Services\BookingPricingService;
use App\Http\Helper;



trait FormatPrice
{


  protected $setting;


  public function __construct(array $attributes = [])
  {
    parent::__construct($attributes);
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
    // Peak pricing belongs to the requested stay dates, never to today's
    // calendar date. Only apartments are date-priced; Property, Voucher and
    // extra-service models that share this trait keep their normal conversion.
    if ($this instanceof Apartment) {
      $checkInOut = request()->get('check_in_checkout') ?: session('check_in_checkout');

      if ($checkInOut) {
        try {
          $dates = Helper::toAndFromDate($checkInOut);
          $startDate = data_get($dates, 'start_date');
          $endDate = data_get($dates, 'end_date');

          if ($startDate && $endDate && $endDate->gt($startDate)) {
            $quote = app(BookingPricingService::class)->quote(
              $this,
              $startDate,
              $endDate,
              $this->getExchangeRateAttribute(),
              Helper::getIsoCode(),
              Helper::getCurrency()
            );

            return $quote['average_nightly'];
          }
        } catch (\Throwable $e) {
          // A malformed search range must never break listing serialization.
          report($e);
        }
      }
    }

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
    if (! ($this instanceof Apartment)) {
      return 0;
    }

    $checkInOut = request()->get('check_in_checkout') ?: session('check_in_checkout');

    if (! $checkInOut) {
      return 0;
    }

    try {
      $dates = Helper::toAndFromDate($checkInOut);
      $startDate = data_get($dates, 'start_date');
      $endDate = data_get($dates, 'end_date');

      if ($startDate && $endDate && $endDate->gt($startDate)) {
        $quote = app(BookingPricingService::class)->quote(
          $this,
          $startDate,
          $endDate,
          $this->getExchangeRateAttribute(),
          Helper::getIsoCode(),
          Helper::getCurrency()
        );

        return $quote['peak_nights'] > 0 ? $quote['peak_nightly'] : 0;
      }
    } catch (\Throwable $e) {
      report($e);
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
