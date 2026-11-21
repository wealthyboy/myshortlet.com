<?php

namespace App\Services;

use App\Http\Controllers\InvoicePaymentController;
use App\Mail\ReservationReceipt;
use App\Models\Apartment;
use App\Models\GuestUser;
use App\Models\Invoice;
use App\Models\Property;
use App\Models\Reservation;
use App\Models\SystemSetting;
use App\Models\UserReservation;
use App\Services\Channex\InventorySyncService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class InvoicePaymentFulfillmentService
{
    /**
     * Converts a verified paid invoice into a confirmed stay exactly once.
     * Creating Reservation models triggers the existing ChannexPro observer;
     * the explicit inventory call also queues native Channex ARI updates.
     */
    public function fulfill(Invoice $invoice, ?string $ip = null): UserReservation
    {
        $invoice->loadMissing('invoice_items');

        $userReservation = DB::transaction(function () use ($invoice, $ip) {
            $invoice = Invoice::lockForUpdate()->findOrFail($invoice->id);
            $invoice->load('invoice_items');

            $nameParts = preg_split('/\s+/', trim((string) $invoice->full_name), 2);
            $guest = GuestUser::firstOrCreate(
                ['invoice_id' => $invoice->id],
                [
                    'name' => $nameParts[0] ?? '',
                    'last_name' => $nameParts[1] ?? '',
                    'email' => $invoice->email,
                    'phone_number' => $invoice->phone ?? '',
                    'image' => '',
                ]
            );

            $firstApartmentItem = $invoice->invoice_items->first(function ($item) {
                return ! empty($item->apartment_id);
            });
            $propertyId = optional(optional($firstApartmentItem)->apartment)->property_id
                ?: optional(Property::first())->id;

            $currencyCode = InvoicePaymentController::currencyCode($invoice->currency);
            $rate = is_numeric($invoice->rate) && (float) $invoice->rate > 0
                ? (float) $invoice->rate
                : 1;

            $userReservation = UserReservation::firstOrCreate(
                ['invoice_id' => $invoice->id],
                [
                    'user_id' => 1,
                    'guest_user_id' => $guest->id,
                    'invoice' => $invoice->invoice,
                    'payment_type' => 'online',
                    'property_id' => $propertyId,
                    'currency' => $invoice->currency,
                    'currency_code' => $currencyCode,
                    'exchange_rate' => $rate,
                    'checked' => true,
                    'original_amount' => $invoice->subtotal,
                    'coupon' => $invoice->discount ?? 0,
                    'coming_from' => 'invoice_card_payment',
                    'length_of_stay' => 1,
                    'total' => $invoice->total,
                    'caution_fee' => $invoice->caution_fee ?? 0,
                    'status' => 'confirmed',
                    'ip' => $ip,
                ]
            );

            if (! $userReservation->wasRecentlyCreated) {
                $userReservation->forceFill([
                    'guest_user_id' => $guest->id,
                    'payment_type' => 'online',
                    'currency' => $invoice->currency,
                    'currency_code' => $currencyCode,
                    'exchange_rate' => $rate,
                    'checked' => true,
                    'total' => $invoice->total,
                    'status' => 'confirmed',
                ])->save();
            }

            foreach ($invoice->invoice_items->whereNotNull('apartment_id') as $item) {
                $apartment = $item->apartment ?: Apartment::find($item->apartment_id);
                if (! $apartment || ! $item->checkin || ! $item->checkout) {
                    Log::warning('Paid invoice item could not create a reservation', [
                        'invoice_id' => $invoice->id,
                        'invoice_item_id' => $item->id,
                    ]);
                    continue;
                }

                Reservation::firstOrCreate(
                    [
                        'user_reservation_id' => $userReservation->id,
                        'apartment_id' => $apartment->id,
                    ],
                    [
                        'quantity' => $item->quantity,
                        'price' => $item->price,
                        'property_id' => $apartment->property_id,
                        'description' => $item->name,
                        'length_of_stay' => $item->quantity,
                        'checkin' => Carbon::parse($item->checkin),
                        'checkout' => Carbon::parse($item->checkout),
                        'currency' => $invoice->currency,
                        'currency_code' => $currencyCode,
                        'rate' => $rate,
                    ]
                );
            }

            return $userReservation;
        });

        // Reservation observers queue the ChannexPro event. This queues the
        // separate calculated ARI availability update for native Channex.
        app(InventorySyncService::class)->queueUserReservation($userReservation);

        $this->sendReceipt($invoice, $userReservation);

        return $userReservation;
    }

    private function sendReceipt(Invoice $invoice, UserReservation $userReservation): void
    {
        if (empty($invoice->email)) {
            return;
        }

        try {
            $userReservation->load('reservation', 'reservations');
            $userReservation->discount = $invoice->discount_type === 'fixed'
                ? '-' . $invoice->currency . number_format($invoice->discount)
                : '-' . number_format($invoice->discount) . '%';
            $userReservation->payment_type = 'online';
            $userReservation->showCheckLink = $userReservation->reservations->count() <= 1;

            Mail::to($invoice->email)
                ->bcc('frontdesk@avenuemontaigne.ng')
                ->cc('info@avenuemontaigne.ng')
                ->send(new ReservationReceipt($userReservation, SystemSetting::first()));
        } catch (\Throwable $exception) {
            // Payment confirmation must not be rolled back merely because the
            // mail provider is temporarily unavailable.
            Log::error('Invoice payment receipt email failed', [
                'invoice_id' => $invoice->id,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
