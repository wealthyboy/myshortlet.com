<?php

namespace App\Http\Controllers\WebHook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\GuestUser;
use App\Models\Currency;
use App\Models\Reservation;
use App\Models\UserReservation;

use Carbon\Carbon;

use App\Models\Apartment;
use App\Models\Voucher;
use App\Mail\ReservationReceipt;
use App\Models\SystemSetting;
use App\Models\BookingDetail;
use App\Models\Extra;





class WebHookController extends Controller
{

	public  $settings;

	public function __construct()
	{
		$this->settings =  SystemSetting::first();
    }
    

    public function payment(Request $request)
    {   
        // if ( !array_key_exists('x-paystack-signature', $_SERVER) ) {
        //     return;
        // } 

        \Log::info($request->all());



        $user_reservation = new UserReservation;
        $guest = new GuestUser;
        $guest->name      =  $request->booking['first_name'];
        $guest->last_name        =  $request->booking['last_name'];
        $guest->email   =  $request->booking['email'];
        $guest->phone_number    = $request->booking['phone_number'];
        $guest->save();

        $bookings = BookingDetail::find($request->booking['booking_ids']);


        $user_reservation->user_id        =  optional($request->user())->id;
        $user_reservation->guest_user_id  =  $guest->id;
        $user_reservation->currency       =  $request->booking['currency'];
        $user_reservation->invoice        =  "INV-".date('Y')."-".rand(10000,time());
        $user_reservation->payment_type   =  'online';
        $user_reservation->property_id    =  $request->booking['property_id'];
        $user_reservation->coupon         =  $request->booking['coupon'];
        $user_reservation->total          =  $request->booking['total'];
        $user_reservation->checkin        =  optional($bookings->first())->checkin;
        $user_reservation->checkout       =  optional($bookings->first())->checkout;
        $user_reservation->ip             =  $request->ip();
        $user_reservation->save();

        foreach ( $bookings   as  $booking ){
            $reservation = new Reservation;
            $reservation->quantity       =  $booking->quantity;
            $reservation->apartment_id   =  $booking->apartment_id;
            $reservation->price   =  $booking->price;
            $reservation->sale_price   =  $booking->sale_price;
            $reservation->user_reservation_id   =  $user_reservation->id;
            $reservation->property_id    =  $booking->property_id;
            $reservation->checkin        =  $booking->checkin;
            $reservation->checkout       =  $booking->checkout;
            $reservation->save();
        }

        $services = $request->booking['services'];
        $property_extras = $request->booking['property_services'];


        foreach($services as $key => $service) {
            foreach($service as $k => $services) {
                foreach($services as $attribute_id => $qty) {
                    $extras = new Extra;
                    $extras->apartment_id  = $k;
                    $extras->property_id   = $request->property_id;
                    $extras->quantity      = $qty;
                    $extras->user_id       = optional($request->user())->id;
                    $extras->guest_user_id = $guest->id;
                    $extras->attribute_id  = $attribute_id;
                    $extras->save();
                }
            }
        } 


        foreach($property_extras as $attribute_id ) {
            $extras = new Extra;
            $extras->property_id   = $request->property_id;
            $extras->user_id       = optional($request->user())->id;
            $extras->guest_user_id = $guest->id;
            $extras->attribute_id  = $attribute_id;
            $extras->save();
        }
        

        $admin_emails = explode(',',$this->settings->alert_email);
            
        try {
            //$when = now()->addMinutes(5); 
            \Mail::to($guest->email)
            ->bcc($admin_emails[0])
            ->cc(optional(optional($user_reservation->property)->user)->email ?? "jacob.atam@gmail.com")
            ->send(new ReservationReceipt($user_reservation,$this->settings));
        } catch (\Throwable $th) {
            Log::error("Mail error :". $th);
        }

        //delete cart
        if ( $request->coupon ) {
            $code = trim($request->coupon);
            $coupon =  Voucher::where('code', $request->coupon)->first();
            if(null !== $coupon && $coupon->type == 'specific'){
                $coupon->update(['valid'=>false]);
            }
        }

        


        return $request->all();

        // try {
        //     $input    =  $request->data['metadata']['custom_fields'][0];

        //     foreach ( $input['apartment_quantity']   as $key =>  $apartment_quantity ){
        //         $reservation->address_id     =  optional($user->active_address)->id;
        //         $reservation->coupon         =  $input['coupon'];
        //         $reservation->status         = 'Processing';
        //         $reservation->currency       =  optional($currency)->symbol ?? '₦';
        //         $reservation->invoice        =  "INV-".date('Y')."-".rand(10000,39999);
        //         $reservation->payment_type   =  $request->data['authorization']['channel'];
        //         $reservation->type   =  $input['type'];
        //         $reservation->delivery_note   =  $input['delivery_note'];
        //         $reservation->total          =  $input['total'];
        //         $reservation->ip             =  $request->data['ip_address'];
        //         $reservation->save();
        //     }

        //     if (isset($input['user_type']) && $input['user_type'] == 'guest' ){
        //        $user = UserGuest::find($input['user_id']);
        //        $reservation->user_id = $user->id;

        //     } else {
        //        $user = User::find($input['user_id']);
        //        $reservation->user_id = $user->id;
        //     }

        //     foreach ( $carts   as $cart){
        //         $insert = [
        //             'order_id'=>$order->id,
        //             'product_variation_id'=>$cart->product_variation_id,
        //             'quantity'=>$cart->quantity,
        //             'status'=>"Processing",
        //             'price'=>$cart->ConvertCurrencyRate($cart->price),
        //             'total'=>$cart->ConvertCurrencyRate($cart->quantity * $cart->price),
        //             'created_at'=>\Carbon\Carbon::now()
        //         ];
        //         OrderedProduct::Insert($insert);
        //         $product_variation = ProductVariation::find($cart->product_variation_id);
        //         $qty  = $product_variation->quantity - $cart->quantity;
        //         $product_variation->quantity =  $qty < 1 ? 0 : $qty;
        //         $product_variation->save();
        //         //Delete all the cart
        //         $cart->remember_token = null;
        //         $cart->status = 'paid';
        //         $cart->save();
        //     }
        //     $admin_emails = explode(',',$this->settings->alert_email);
        //     $symbol = optional($currency)->symbol  ;
            
        //     try {
        //         $when = now()->addMinutes(5); 
                
        //         \Mail::to($user->email)
        //         ->bcc($admin_emails[0])
        //         ->send(new OrderReceipt($order,$this->settings,$symbol));
        //     } catch (\Throwable $th) {
        //         Log::error("Mail error :". $th);
        //     }

        //     //delete cart
        //     if ( $input['coupon'] ) {
        //         $code = trim($input['coupon']);
        //         $coupon =  Voucher::where('code', $input['coupon'])->first();
        //         if(null !== $coupon && $coupon->type == 'specific'){
        //             $coupon->update(['valid'=>false]);
        //         }
        //     }
        // } catch (\Throwable $th) {
        //     Log::info("Custom error :".$th);

        // }

        // return http_response_code(200); 
    }

    public function gitHub()
    {
        $output =  shell_exec('sh /home/forge/myshortlet.com/deploy.sh');
        echo "Successfull";
        Log::info($output);
    }

   
}
