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
use App\Models\UserTracking;
use Carbon\Carbon;

use App\Models\Apartment;
use App\Models\Voucher;
use App\Mail\ReservationReceipt;
use App\Models\SystemSetting;
use App\Models\BookingDetail;
use App\Models\Extra;
use App\Models\ApartmentAttribute;
use App\Models\Attribute;
use App\Models\AttributeProperty;
use Illuminate\Support\Facades\Mail;
use App\Jobs\ProcessChannexBookingWebhook;

class WebHookController extends Controller
{

    public  $settings;

    public function payment(Request $request)
    {
        $this->settings = SystemSetting::first();

        Log::info($request->all());

        try {


            $payload = $request->all();
            $data = $payload['data']['metadata']['custom_fields'][0];
            $input = $data['booking'];
            $tracking_id = $data['tracking_id'];
            $apartment = Apartment::find(data_get($input, 'apartment_id'));
            $user_reservation = new UserReservation;
            $guest = new GuestUser;
            $guest->name = data_get($input, 'first_name');
            $guest->last_name = data_get($input, 'last_name');
            $guest->email = data_get($input, 'email');
            $sessionId = data_get($input, 'sessionId');

            if (!empty(data_get($input, 'code'))) {
                $guest->phone_number = '+' . data_get($input, 'code') . ' ' . data_get($input, 'phone_number');
            } else {
                $guest->phone_number = data_get($input, 'phone_number');
            }
            $guest->save();

            $bookings = BookingDetail::find(data_get($input, 'booking_ids'));

            $user_reservation->user_id = optional($request->user())->id;
            $user_reservation->guest_user_id = $guest->id;
            $user_reservation->currency = data_get($input, 'currency') === 'NGN' ? '₦' : '$';
            $user_reservation->invoice = "INV-" . date('Y') . "-" . rand(10000, time());
            $user_reservation->payment_type = 'online';
            $user_reservation->property_id = data_get($input, 'property_id');
            $user_reservation->coupon = data_get($input, 'coupon');
            $user_reservation->total = data_get($input, 'total');
            $user_reservation->length_of_stay = data_get($input, 'length_of_stay');;
            $user_reservation->original_amount = data_get($input, 'original_amount');
            $user_reservation->coming_from = 'payment';
            $user_reservation->ip = $request->ip();
            $user_reservation->save();

            $user_reservation->showCheckLink = true;

            $e_services = [];
            $services = data_get($input, 'services', []);
            $aq = [];
            $property_extras = data_get($input, 'property_services', []);

            if (!empty($services)) {
                foreach ($services as $key => $room_serices) {
                    foreach ($room_serices as $key => $room_serice) {
                        foreach ($room_serice as $attribute_id => $qty) {
                            $aq[$attribute_id] = $qty;
                            $e_services[$key] = $aq;
                        }
                    }
                }
            }

            $attr = Attribute::find(optional($apartment)->apartment_id);

            if ($tracking_id) {
                $user_tracking = UserTracking::find($tracking_id);
                $user_tracking->action = 'completed';
                $user_tracking->save();
            }

            foreach ($bookings as $booking) {
                $reservation = new Reservation;
                $reservation->quantity = $booking->quantity;
                $reservation->apartment_id = $booking->apartment_id;
                $reservation->price = $booking->price;
                $reservation->rate = 1;
                $reservation->sale_price = $booking->sale_price;
                $reservation->user_reservation_id = $user_reservation->id;
                $reservation->property_id = $booking->property_id;
                $reservation->checkin = $booking->checkin;
                $reservation->checkout = $booking->checkout;
                $reservation->length_of_stay = data_get($input, 'length_of_stay');;
                $reservation->save();

                if (!empty($e_services)) {
                    foreach ($e_services as $key => $attributes) {
                        foreach ($attributes as $attribute_id => $qty) {
                            $extras = new Extra;
                            if ($booking->apartment_id == $key) {
                                $attribute = ApartmentAttribute::where('attribute_id', $attribute_id)->first();
                                $extras->apartment_id = $key;
                                $extras->property_id = $request->property_id;
                                $extras->quantity = $qty;
                                $extras->user_id = optional($request->user())->id;
                                $extras->reservation_id = $reservation->id;
                                $extras->price = $attribute->converted_price;
                                $extras->guest_user_id = $guest->id;
                                $extras->attribute_id = $attribute_id;
                                $extras->save();
                            }
                        }
                    }
                }

                $booking->delete();
            }



            foreach ($property_extras as $attribute_id) {
                $attribute = ApartmentAttribute::where('attribute_id', $attribute_id)->first();
                $attr = AttributeProperty::where('attribute_id', $attribute_id)->first();
                $extras = new Extra;
                $extras->property_id = $request->property_id;
                $extras->user_id = optional($request->user())->id;
                $extras->guest_user_id = $guest->id;
                $extras->attribute_id = $attribute_id;
                $extras->user_reservation_id = $user_reservation->id;
                $extras->price = optional($attr)->price;
                $extras->save();
            }

            $admin_emails = explode(',', $this->settings->alert_email);
            try {
                //$when = now()->addMinutes(5); 
                Mail::to($guest->email)
                    ->bcc('frontdesk@avenuemontaigne.ng')
                    ->cc('info@avenuemontaigne.ng')
                    ->send(new ReservationReceipt($user_reservation, $this->settings));

                $user_reservation->agent = 1;
                $user_reservation->apname = optional($apartment)->name;

                if (null !== $attr && $attr->apartment_owner) {
                }
            } catch (\Throwable $th) {
                //dd($th);
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
        } catch (\Throwable $th) {
            Log::error($th);
        }
    }

    public function gitHub()
    {
        $output = shell_exec('sh /home/forge/avenuemontaigne.ng/deploy.sh');
        echo "Successfull";
        Log::info($output);
    }

    public function handleChannex(Request $request)
    {
        $expectedSecret = trim((string) config('services.channex.webhook_secret', ''));
        $secretHeaderName = (string) config('services.channex.webhook_secret_header', 'X-Channex-Webhook-Secret');
        $providedSecret = (string) $request->header($secretHeaderName, '');

        if ($expectedSecret === '') {
            Log::critical('Channex webhook is disabled because its secret is not configured');

            return response()->json(['status' => 'webhook_unavailable'], 503);
        }

        if (! hash_equals($expectedSecret, $providedSecret)) {
            Log::warning('Channex Webhook Rejected: invalid secret', [
                'event' => $request->input('event'),
                'property_id' => $request->input('property_id'),
                'ip' => $request->ip(),
                'header' => $secretHeaderName,
            ]);

            return response()->json(['status' => 'unauthorized'], 401);
        }

        $event = strtolower(trim((string) $request->input('event')));
        $supportedEvents = [
            'booking',
            'booking_new',
            'booking_modification',
            'booking_cancellation',
            'booking.created',
            'booking.modified',
            'booking.cancelled',
            'booking.canceled',
            'booking_cancelled',
            'booking_canceled',
        ];

        if (! in_array($event, $supportedEvents, true)) {
            Log::warning('Channex webhook ignored: unsupported event', [
                'event' => $event,
                'property_id' => $request->input('property_id'),
                'ip' => $request->ip(),
            ]);

            return response()->json(['status' => 'unsupported_event'], 422);
        }

        $payload = (array) $request->input('payload', []);

        // Backward compatibility for any legacy sender that still posts data.
        if (empty($payload)) {
            $payload = (array) $request->input('data', []);
        }

        // Some senders wrap booking details in data.attributes (docs examples).
        if (is_array(data_get($payload, 'data.attributes'))) {
            $payload = (array) data_get($payload, 'data.attributes', []);
        } elseif (is_array(data_get($payload, 'attributes'))) {
            $payload = (array) data_get($payload, 'attributes', []);
        }

        // With send_data disabled Channex deliberately sends only event,
        // user_id and property_id. Preserve those trigger fields so the
        // queued worker can pull the oldest unacknowledged revision.
        foreach (['property_id', 'user_id', 'booking_revision_id', 'revision_id'] as $field) {
            if (! array_key_exists($field, $payload) && $request->filled($field)) {
                $payload[$field] = $request->input($field);
            }
        }

        Log::info('Channex webhook accepted', [
            'event' => $event,
            'property_id' => data_get($payload, 'property_id'),
            'revision_id' => data_get($payload, 'booking_revision_id')
                ?? data_get($payload, 'revision_id'),
            'booking_id' => data_get($payload, 'booking_id'),
        ]);

        $status = strtolower((string) data_get($payload, 'status', ''));

        if ($event === 'booking') {
            if (in_array($status, ['cancelled', 'canceled'], true)) {
                ProcessChannexBookingWebhook::dispatch('cancel', $payload);
            } else {
                ProcessChannexBookingWebhook::dispatch('upsert', $payload);
            }

            return response()->json(['status' => 'accepted'], 200);
        }

        if (in_array($event, ['booking_new', 'booking_modification', 'booking.created', 'booking.modified'], true)) {
            ProcessChannexBookingWebhook::dispatch('upsert', $payload);
        }

        if (in_array($event, ['booking_cancellation', 'booking.cancelled', 'booking.canceled', 'booking_cancelled', 'booking_canceled'], true)) {
            ProcessChannexBookingWebhook::dispatch('cancel', $payload);
        }

        return response()->json(['status' => 'accepted'], 200);
    }
}
