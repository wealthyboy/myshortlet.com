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
use App\Models\ApartmentAttribute;





class WebHookController extends Controller
{

    public  $settings;

    public function __construct()
    {
        $this->settings =  SystemSetting::first();
    }


    public function payment(Request $request)
    {



        \Log::info($request->all());



        try {
            $input    =  $request->all();
            $user_reservation = new UserReservation;
            $guest = new GuestUser;
            $guest->name = $input['booking']['first_name'];
            $guest->last_name = $input['booking']['last_name'];
            $guest->email = $input['booking']['email'];
            $guest->phone_number = $input['booking']['phone_number'];
            $guest->save();
        } catch (\Throwable $th) {
            //throw $th;
        }


        $bookings = BookingDetail::find($request->booking['booking_ids']);
        $user_reservation->user_id = optional($request->user())->id;
        $user_reservation->guest_user_id = $guest->id;
        $user_reservation->currency = $request->booking['currency'];
        $user_reservation->invoice = "INV-" . date('Y') . "-" . rand(10000, time());
        $user_reservation->payment_type = 'online';
        $user_reservation->property_id = $request->booking['property_id'];
        $user_reservation->coupon = $request->booking['coupon'];
        $user_reservation->total = $request->booking['total'];
        $user_reservation->checkin = optional($bookings->first())->checkin;
        $user_reservation->checkout = optional($bookings->first())->checkout;
        $user_reservation->ip =  $request->ip();
        $user_reservation->save();

        $e_services = [];

        $services = $request->booking['services'];
        $property_extras = $request->booking['property_services'];
        $e_services = [];
        $aq = [];
        $services = $request->booking['services'];
        $property_extras = $request->booking['property_services'];

        foreach ($services as $key => $room_serices) {
            foreach ($room_serices as $key => $room_serice) {
                foreach ($room_serice as $attribute_id => $qty) {
                    $aq[$attribute_id] = $qty;
                    $e_services[$key] = $aq;
                }
            }
        }

        foreach ($bookings   as  $booking) {
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
            foreach ($e_services as $key => $attributes) {
                foreach ($attributes as $attribute_id => $qty) {
                    $extras = new Extra;
                    if ($booking->apartment_id == $key) {
                        $attribute = ApartmentAttribute::where('attribute_id', $attribute_id)->first();
                        $extras->apartment_id  = $key;
                        $extras->property_id   = $request->property_id;
                        $extras->quantity      = $qty;
                        $extras->user_id       = optional($request->user())->id;
                        $extras->reservation_id  = $reservation->id;
                        $extras->price           = $attribute->converted_price;
                        $extras->guest_user_id   = $guest->id;
                        $extras->attribute_id    = $attribute_id;
                        $extras->save();
                    }
                }
            }
        }

        foreach ($property_extras as $attribute_id) {
            $attribute = ApartmentAttribute::where('attribute_id', $attribute_id)->first();
            $extras = new Extra;
            $extras->property_id     = $request->property_id;
            $extras->user_id         = optional($request->user())->id;
            $extras->guest_user_id   = $guest->id;
            $extras->attribute_id    = $attribute_id;
            $extras->user_reservation_id  = $user_reservation->id;
            $extras->price = optional($attribute)->converted_price;
            $extras->save();
        }

        $admin_emails = explode(',', $this->settings->alert_email);

        try {
            //$when = now()->addMinutes(5); 
            \Mail::to($guest->email)
                ->bcc($admin_emails[0])
                ->send(new ReservationReceipt($user_reservation, $this->settings));
        } catch (\Throwable $th) {
            Log::error("Mail error :" . $th);
        }

        //delete cart
        if ($request->coupon) {
            $code = trim($request->coupon);
            $coupon =  Voucher::where('code', $request->coupon)->first();
            if (null !== $coupon && $coupon->type == 'specific') {
                $coupon->update(['valid' => false]);
            }
        }

        return $request->all();
    }

    public function gitHub()
    {
        $output =  shell_exec('sh /home/forge/myshortlet.com/deploy.sh');
        echo "Successfull";
        Log::info($output);
    }
}
