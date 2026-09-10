<?php

namespace App\Http\Controllers\WebHook;

use App\Http\Controllers\Controller;
use App\Http\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\GuestUser;
use App\Models\Currency;
use App\Models\Reservation;
use App\Models\UserReservation;
use App\Models\UserTracking;
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
        Log::info('Paystack payment webhook received', ['event' => $request->input('event')]);

        try {
            $payload = $request->all();
            $input = (array) data_get($payload, 'data.metadata.custom_fields.0.booking', []);
            $tracking_id = data_get($payload, 'data.metadata.custom_fields.0.tracking_id');
            $bookingIds = array_values(array_filter((array) data_get($input, 'booking_ids', [])));
            $bookings = BookingDetail::whereIn('id', $bookingIds)->get();

            if ($bookings->isEmpty()) {
                Log::warning('Paystack webhook could not find booking details', [
                    'booking_ids' => $bookingIds,
                ]);

                return response()->json(['status' => 'booking_not_found'], 404);
            }

            $firstBooking = $bookings->first();
            $snapshot = is_array($firstBooking->pricing_snapshot)
                ? $firstBooking->pricing_snapshot
                : [];

            $currencyCode = strtoupper((string) (
                data_get($snapshot, 'currency_code')
                ?: $firstBooking->currency_code
                ?: data_get($input, 'currency')
                ?: data_get($payload, 'data.currency')
                ?: 'USD'
            ));
            $paidCurrency = strtoupper((string) data_get($payload, 'data.currency', $currencyCode));

            // A booking quote is frozen before Paystack opens. A successful
            // payment returning in another currency must not be turned into a
            // reservation with mismatched figures.
            if ($paidCurrency && $currencyCode && $paidCurrency !== $currencyCode) {
                Log::error('Paystack currency does not match frozen booking currency', [
                    'booking_currency' => $currencyCode,
                    'payment_currency' => $paidCurrency,
                    'booking_ids' => $bookingIds,
                ]);

                return response()->json(['status' => 'currency_mismatch'], 422);
            }

            $currency = Currency::where('iso_code3', $currencyCode)->first();
            $currencySymbol = (string) (
                data_get($snapshot, 'currency_symbol')
                ?: $firstBooking->currency_symbol
                ?: optional($currency)->symbol
                ?: ($currencyCode === 'NGN' ? '₦' : ($currencyCode === 'USD' ? '$' : $currencyCode . ' '))
            );
            $exchangeRate = data_get($snapshot, 'exchange_rate') ?: $firstBooking->exchange_rate;

            if (!is_numeric($exchangeRate) || (float) $exchangeRate <= 0) {
                $exchangeRate = $currencyCode === 'USD'
                    ? 1.0
                    : Helper::getCurrencyExchangeRate($currencyCode, 'USD');
            }
            $exchangeRate = is_numeric($exchangeRate) && (float) $exchangeRate > 0
                ? (float) $exchangeRate
                : 1.0;

            $metadataTotal = (float) data_get($input, 'total', 0);
            $paidMinorAmount = data_get($payload, 'data.amount');
            $paidTotal = is_numeric($paidMinorAmount)
                ? round(((float) $paidMinorAmount) / 100, 2)
                : $metadataTotal;

            if ($metadataTotal > 0 && abs($metadataTotal - $paidTotal) > 1) {
                Log::warning('Paystack paid amount differs from booking metadata total', [
                    'metadata_total' => $metadataTotal,
                    'paid_total' => $paidTotal,
                    'currency' => $currencyCode,
                ]);
            }

            $apartment = Apartment::find(data_get($input, 'apartment_id')) ?: $firstBooking->apartment;
            $guest = new GuestUser;
            $guest->name = data_get($input, 'first_name');
            $guest->last_name = data_get($input, 'last_name');
            $guest->email = data_get($input, 'email');

            if (!empty(data_get($input, 'code'))) {
                $guest->phone_number = '+' . data_get($input, 'code') . ' ' . data_get($input, 'phone_number');
            } else {
                $guest->phone_number = data_get($input, 'phone_number');
            }
            $guest->save();

            $receiptSnapshot = $snapshot;
            $receiptSnapshot['currency_code'] = $currencyCode;
            $receiptSnapshot['currency_symbol'] = $currencySymbol;
            $receiptSnapshot['exchange_rate'] = $exchangeRate;
            $receiptSnapshot['payment_total'] = $paidTotal;
            $receiptSnapshot['original_amount'] = (float) data_get($input, 'original_amount', $metadataTotal);

            $user_reservation = new UserReservation;
            $user_reservation->user_id = optional($request->user())->id;
            $user_reservation->guest_user_id = $guest->id;
            $user_reservation->currency = $currencySymbol;
            $user_reservation->currency_code = $currencyCode;
            $user_reservation->exchange_rate = $exchangeRate;
            $user_reservation->pricing_snapshot = $receiptSnapshot;
            $user_reservation->invoice = 'INV-' . date('Y') . '-' . rand(10000, time());
            $user_reservation->payment_type = 'online';
            $user_reservation->property_id = data_get($input, 'property_id') ?: $firstBooking->property_id;
            $user_reservation->coupon = data_get($input, 'coupon');
            $user_reservation->total = $paidTotal;
            $user_reservation->length_of_stay = data_get($snapshot, 'nights') ?: data_get($input, 'length_of_stay');
            $user_reservation->original_amount = data_get($input, 'original_amount', $metadataTotal);
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
                    foreach ($room_serices as $room_serice) {
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
                if ($user_tracking) {
                    $user_tracking->action = 'completed';
                    $user_tracking->save();
                }
            }

            foreach ($bookings as $booking) {
                $bookingSnapshot = is_array($booking->pricing_snapshot)
                    ? $booking->pricing_snapshot
                    : $snapshot;
                $bookingRate = data_get($bookingSnapshot, 'exchange_rate') ?: $booking->exchange_rate ?: $exchangeRate;
                $bookingSymbol = data_get($bookingSnapshot, 'currency_symbol') ?: $booking->currency_symbol ?: $currencySymbol;

                $reservation = new Reservation;
                $reservation->quantity = $booking->quantity;
                $reservation->apartment_id = $booking->apartment_id;
                $reservation->price = $booking->price;
                $reservation->currency = $bookingSymbol;
                $reservation->currency_code = data_get($bookingSnapshot, 'currency_code') ?: $booking->currency_code ?: $currencyCode;
                $reservation->rate = (float) $bookingRate;
                $reservation->pricing_snapshot = $bookingSnapshot;
                $reservation->sale_price = $booking->sale_price;
                $reservation->user_reservation_id = $user_reservation->id;
                $reservation->property_id = $booking->property_id;
                $reservation->checkin = $booking->checkin;
                $reservation->checkout = $booking->checkout;
                $reservation->length_of_stay = data_get($bookingSnapshot, 'nights') ?: data_get($input, 'length_of_stay');
                $reservation->save();

                if (!empty($e_services)) {
                    foreach ($e_services as $key => $attributes) {
                        foreach ($attributes as $attribute_id => $qty) {
                            if ((int) $booking->apartment_id !== (int) $key) {
                                continue;
                            }

                            $attribute = ApartmentAttribute::where('attribute_id', $attribute_id)
                                ->where('apartment_id', $booking->apartment_id)
                                ->first();

                            if (!$attribute) {
                                continue;
                            }

                            $extras = new Extra;
                            $extras->apartment_id = $key;
                            $extras->property_id = $booking->property_id;
                            $extras->quantity = $qty;
                            $extras->user_id = optional($request->user())->id;
                            $extras->reservation_id = $reservation->id;
                            $extras->price = $this->convertBaseAmount($attribute->price, $bookingRate);
                            $extras->guest_user_id = $guest->id;
                            $extras->attribute_id = $attribute_id;
                            $extras->save();
                        }
                    }
                }

                $booking->delete();
            }

            foreach ($property_extras as $attribute_id) {
                $propertyAttribute = AttributeProperty::where('attribute_id', $attribute_id)
                    ->where('property_id', $user_reservation->property_id)
                    ->first();

                if (!$propertyAttribute) {
                    continue;
                }

                $extras = new Extra;
                $extras->property_id = $user_reservation->property_id;
                $extras->user_id = optional($request->user())->id;
                $extras->guest_user_id = $guest->id;
                $extras->attribute_id = $attribute_id;
                $extras->user_reservation_id = $user_reservation->id;
                $extras->price = $this->convertBaseAmount($propertyAttribute->price, $exchangeRate);
                $extras->save();
            }

            try {
                Mail::to($guest->email)
                    ->bcc('frontdesk@avenuemontaigne.ng')
                    ->cc('info@avenuemontaigne.ng')
                    ->send(new ReservationReceipt($user_reservation, $this->settings));

                $user_reservation->agent = 1;
                $user_reservation->apname = optional($apartment)->name;
            } catch (\Throwable $th) {
                Log::error('Mail error :' . $th->getMessage());
            }

            if (data_get($input, 'coupon')) {
                $code = trim((string) data_get($input, 'coupon'));
                $coupon = Voucher::where('code', $code)->first();
                if ($coupon && $coupon->type === 'specific') {
                    $coupon->update(['valid' => false]);
                }
            }

            return response()->json(['status' => 'ok'], 200);
        } catch (\Throwable $th) {
            Log::error('Paystack webhook error', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
            ]);

            return response()->json(['status' => 'error'], 500);
        }
    }

    private function convertBaseAmount($amount, $exchangeRate)
    {
        return round(((float) $amount) * ((float) $exchangeRate), 0);
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
        $connectionEvents = [
            '',
            'connection_test',
            'ping',
            'test',
            'webhook_test',
        ];

        if (in_array($event, $connectionEvents, true)) {
            Log::info('Channex webhook connection test accepted', [
                'event' => $event ?: '(empty)',
                'ip' => $request->ip(),
            ]);

            return response()->json(['status' => 'ok'], 200);
        }

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

        // A webhook is only a signal that the property's ordered revisions
        // feed has work. The worker pulls that feed once and routes each row by
        // its actual status, so duplicate/out-of-order webhooks cannot make us
        // fetch the same revision again by ID.
        ProcessChannexBookingWebhook::dispatch('feed', $payload);

        return response()->json(['status' => 'accepted'], 200);
    }
}
