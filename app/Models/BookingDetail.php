<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingDetail extends Model
{
  use HasFactory;

  protected $dates = ['checkin', 'checkout'];


  protected $fillable = [
    'id',
    'apartment_id',
    'property_id',
    'quantity',
    'user_id',
    'price',
    'total',
    'token',
    'checkin',
    'checkout',
    'sale_price'
  ];

  public static function all_items_in_cart($property_id)
  {
    $cookie = \Cookie::get('booking');
    $booking = BookingDetail::with(["apartment", 'apartment.free_services', 'apartment.bedrooms', 'apartment.bedrooms.parent', 'apartment.property', 'apartment.extra_services'])
      ->where(['token' => $cookie, 'property_id' => $property_id])
      ->whereDate('checkin', '>=', now())
      ->latest()->first();

    $booking = collect([$booking]);
    static::sync($booking);
    return $booking;
  }

  public static function sum_items_in_cart($property_id)
  {
    $cookie = \Cookie::get('booking');
    $total = \DB::table('booking_details')
      ->select(\DB::raw('SUM(booking_details.total) as items_total'))
      ->where(['token' => $cookie, 'property_id' => $property_id])
      ->where('quantity', '>=', 1)
      ->whereDate('checkin', '>=', now())
      ->latest()->first();
    return   $total = $total->items_total;
  }

  public static function sum_booking($property_id)
  {
    $cookie = \Cookie::get('booking');
    $total = \DB::table('booking_details')
    ->selectRaw('SUM(regular_price + peak_period_price) as total_sum')
      ->where(['token' => $cookie, 'property_id' => $property_id])
      ->where('quantity', '>=', 1)
      ->whereDate('checkin', '>=', now())
      ->value('total_sum');
      return   $total;
  }


  public  static function sync($bookings)
  {
    if (null == $bookings) return null;


    foreach ($bookings as $booking) {

      if (null !== $booking) {
        if (null === optional($booking)->apartment) {
          $booking->delete();
        }

        if (null !== $booking->apartment && $booking->apartment->quantity  == 0) {
          $booking->update([
            'quantity' => 0,
          ]);
        }

        $booking->update([
          'user_id' => optional(auth()->user())->id
        ]);
      }
    }
  }


  public function property()
  {
    return $this->belongsTo(Property::class);
  }

  public function apartment()
  {
    return $this->belongsTo(Apartment::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
