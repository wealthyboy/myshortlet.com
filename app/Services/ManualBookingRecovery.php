<?php

namespace App\Services;

use App\Models\Apartment;
use App\Models\BookingDetail;
use App\Models\Reservation;
use App\Models\UserReservation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use RuntimeException;

/** Explicit operator recovery; never verifies, initiates or refunds a payment. */
class ManualBookingRecovery
{
    public function prepare(int $headerId, int $quoteId, array $retryQuoteIds, float $rate): UserReservation
    {
        if (!is_finite($rate) || $rate <= 0 || !in_array($quoteId, $retryQuoteIds, true)) {
            throw new RuntimeException('A positive frozen rate and the source quote ID are required.');
        }

        return DB::transaction(function () use ($headerId, $quoteId, $retryQuoteIds, $rate) {
            $header = UserReservation::lockForUpdate()->findOrFail($headerId);
            if (data_get($header->pricing_snapshot, 'manual_recovery')) {
                $recovery = $header->pricing_snapshot['manual_recovery'];
                if ($recovery['source_quote_id'] !== $quoteId || (float) $recovery['rate'] !== $rate) {
                    throw new RuntimeException('Recovery already prepared with different parameters.');
                }
                return $header;
            }
            $quote = BookingDetail::findOrFail($quoteId);
            if ($header->reservations()->exists() || $header->extras()->exists()
                || $header->coupon || $header->is_cancelled || (float) $header->caution_fee > 0
                || $header->currency_code !== 'USD' || $quote->currency_code !== 'USD'
                || (int) $header->property_id !== (int) $quote->property_id
                || abs((float) $header->total - (float) $quote->total) > 0.001
                || abs((float) $quote->total - (float) $quote->price * (int) $quote->quantity
                    * (int) data_get($quote->pricing_snapshot, 'nights')) > 0.001) {
                throw new RuntimeException('Recovery requires an empty, matching USD booking without extras or discounts.');
            }
            foreach (BookingDetail::whereIn('id', $retryQuoteIds)->get() as $retry) {
                foreach (['apartment_id', 'property_id', 'quantity', 'price', 'total', 'currency_code', 'checkin', 'checkout'] as $field) {
                    if ((string) $retry->$field !== (string) $quote->$field) {
                        throw new RuntimeException('Retry quotes must describe exactly the same stay.');
                    }
                }
            }
            if (BookingDetail::whereIn('id', $retryQuoteIds)->count() !== count($retryQuoteIds)) {
                throw new RuntimeException('A retry quote is missing.');
            }
            $snapshot = $header->pricing_snapshot ?: [];
            $snapshot['manual_recovery'] = [
                'state' => 'prepared',
                'prepared_at' => now()->toIso8601String(),
                'payment_confirmation' => 'operator_confirmed_paid',
                'gateway_verification' => 'deferred',
                'gateway_reference' => null,
                'source_quote_id' => $quoteId,
                'retry_quote_ids' => array_values($retryQuoteIds),
                'rate' => $rate,
                'source_header' => collect($header->getAttributes())->only([
                    'currency', 'currency_code', 'exchange_rate', 'total', 'original_amount', 'checked', 'status',
                ])->all(),
                'source_snapshot' => $snapshot,
                'quote_snapshot' => $quote->pricing_snapshot,
                'quote' => collect($quote->getAttributes())->only([
                    'apartment_id', 'property_id', 'quantity', 'price', 'sale_price', 'total', 'checkin', 'checkout',
                ])->all(),
            ];
            $header->pricing_snapshot = $snapshot;
            $header->save();
            return $header;
        });
    }

    /** Acknowledge only explicitly recorded retry carts; other payments are untouched. */
    public function matchingCallback(array $input, array $quoteIds): ?UserReservation
    {
        $email = strtolower(trim((string) data_get($input, 'email')));
        if ($email === '' || $quoteIds === []) {
            return null;
        }
        $headers = UserReservation::whereHas('guest_user', function ($query) use ($email) {
            $query->whereRaw('LOWER(email) = ?', [$email]);
        })->whereNotNull('pricing_snapshot')->get();
        foreach ($headers as $header) {
            $knownIds = (array) data_get($header->pricing_snapshot, 'manual_recovery.retry_quote_ids', []);
            if ($knownIds !== [] && array_diff(array_map('intval', $quoteIds), $knownIds) === []) {
                return $header;
            }
        }
        return null;
    }

    public function complete(int $headerId): UserReservation
    {
        if (!Schema::hasColumn('reservations', 'currency')) {
            throw new RuntimeException('Apply the targeted reservation currency migration first.');
        }
        return DB::transaction(function () use ($headerId) {
            $header = UserReservation::lockForUpdate()->findOrFail($headerId);
            $recovery = data_get($header->pricing_snapshot, 'manual_recovery');
            if (!$recovery) {
                throw new RuntimeException('Prepare recovery and retry protection first.');
            }
            if ($recovery['state'] === 'completed') {
                $expectedCurrency = data_get($recovery, 'currency_correction.to_currency', 'NGN');
                if ($header->reservations()->count() !== 1 || $header->currency_code !== $expectedCurrency) {
                    throw new RuntimeException('Completed recovery is inconsistent; inspect manually.');
                }
                return $header;
            }
            $quote = $recovery['quote'];
            Apartment::lockForUpdate()->findOrFail($quote['apartment_id']);
            if ($header->reservations()->exists() || Reservation::where('apartment_id', $quote['apartment_id'])
                ->where('checkin', '<', $quote['checkout'])->where('checkout', '>', $quote['checkin'])
                ->where('is_active', 1)->exists()) {
                throw new RuntimeException('Reservation already exists or the apartment is no longer available.');
            }
            $snapshot = $recovery['source_snapshot'];
            $rate = (float) $recovery['rate'];
            foreach (['regular_nightly', 'peak_nightly', 'regular_total', 'peak_total', 'accommodation_total',
                'average_nightly', 'payment_total', 'original_amount'] as $field) {
                if (isset($snapshot[$field])) {
                    $snapshot[$field] = round((float) $snapshot[$field] * $rate, 2);
                }
            }
            foreach ($snapshot['nightly_breakdown'] ?? [] as $i => $night) {
                $snapshot['nightly_breakdown'][$i]['price'] = round((float) $night['price'] * $rate, 2);
            }
            $snapshot['currency_code'] = 'NGN';
            $snapshot['currency_symbol'] = '₦';
            $snapshot['exchange_rate'] = $rate;
            $snapshot['payment_total'] = round((float) $recovery['source_header']['total'] * $rate, 2);
            $snapshot['original_amount'] = round((float) $recovery['source_header']['original_amount'] * $rate, 2);
            $recovery['state'] = 'completed';
            $recovery['completed_at'] = now()->toIso8601String();
            // Legacy price columns are whole-number BIGINTs; the snapshot is the
            // precise nightly price, also used by the recovered booking receipt.
            $snapshot['average_nightly'] = round((float) $quote['price'] * $rate, 2);
            $snapshot['manual_recovery'] = $recovery;
            $header->currency = '₦';
            $header->currency_code = 'NGN';
            $header->exchange_rate = $rate;
            $header->total = $snapshot['payment_total'];
            $header->original_amount = $snapshot['original_amount'];
            $header->pricing_snapshot = $snapshot;
            $header->checkin = $quote['checkin'];
            $header->checkout = $quote['checkout'];
            $header->length_of_stay = (int) $snapshot['nights'];
            $header->status = 'confirmed';
            // 'checked' also controls guest check-in. Preserve it; payment
            // confirmation is recorded separately in the recovery audit.
            $header->checked = $recovery['source_header']['checked'];
            $header->save();
            $reservation = new Reservation;
            $reservation->user_reservation_id = $header->id;
            $reservation->apartment_id = $quote['apartment_id'];
            $reservation->property_id = $quote['property_id'];
            $reservation->quantity = $quote['quantity'];
            $reservation->price = round($snapshot['average_nightly']);
            $reservation->sale_price = isset($quote['sale_price']) ? round((float) $quote['sale_price'] * $rate) : null;
            $reservation->currency = '₦';
            $reservation->currency_code = 'NGN';
            $reservation->rate = $rate;
            $reservation->pricing_snapshot = $snapshot;
            $reservation->checkin = $quote['checkin'];
            $reservation->checkout = $quote['checkout'];
            $reservation->length_of_stay = (int) $snapshot['nights'];
            $reservation->save(); // Normal inventory observer runs after commit.
            return $header;
        });
    }

    /** Restore the frozen payment-currency quote on the SAME completed booking. */
    public function restoreOriginalCurrency(int $headerId): UserReservation
    {
        return DB::transaction(function () use ($headerId) {
            $header = UserReservation::lockForUpdate()->findOrFail($headerId);
            $recovery = data_get($header->pricing_snapshot, 'manual_recovery');
            $lines = $header->reservations()->lockForUpdate()->get();
            if (data_get($recovery, 'state') !== 'completed' || $lines->count() !== 1
                || data_get($recovery, 'source_header.currency_code') !== 'USD') {
                throw new RuntimeException('Correction requires one completed recovered booking with a frozen USD source quote.');
            }
            $line = $lines->first();
            $source = $recovery['source_header'];
            $quote = $recovery['quote'];
            if (data_get($recovery, 'currency_correction.state') === 'restored_to_source') {
                if ($header->currency_code !== 'USD' || $line->currency_code !== 'USD'
                    || abs((float) $header->total - (float) $source['total']) > 0.001) {
                    throw new RuntimeException('Previously corrected booking is inconsistent; inspect manually.');
                }
                return $header;
            }
            if ($header->currency_code !== 'NGN' || $line->currency_code !== 'NGN'
                || (int) $line->apartment_id !== (int) $quote['apartment_id']
                || (int) $line->quantity !== (int) $quote['quantity']
                || $line->checkin->toDateString() !== substr($quote['checkin'], 0, 10)
                || $line->checkout->toDateString() !== substr($quote['checkout'], 0, 10)
                || $header->extras()->exists() || $line->extras()->exists()
                || abs((float) $header->total - round((float) $source['total'] * (float) $recovery['rate'], 2)) > 0.001) {
                throw new RuntimeException('Recovered booking changed; do not overwrite newer booking details.');
            }
            $previousSnapshot = $header->pricing_snapshot;
            unset($previousSnapshot['manual_recovery']);
            $recovery['currency_correction'] = [
                'state' => 'restored_to_source',
                'corrected_at' => now()->toIso8601String(),
                'reason' => 'operator_confirmed_payment_in_original_currency',
                'from_currency' => 'NGN',
                'to_currency' => 'USD',
                'reservation_id' => $line->id,
                'previous_header' => collect($header->getAttributes())->only([
                    'currency', 'currency_code', 'exchange_rate', 'total', 'original_amount',
                ])->all(),
                'previous_snapshot' => $previousSnapshot,
                'previous_line' => collect($line->getAttributes())->only([
                    'currency', 'currency_code', 'rate', 'price', 'sale_price',
                ])->all(),
                'supersedes_receipt_reference' => data_get($recovery, 'receipt.client_reference'),
            ];
            $snapshot = $recovery['source_snapshot'];
            $snapshot['currency_code'] = 'USD';
            $snapshot['currency_symbol'] = '$';
            $snapshot['exchange_rate'] = 1.0;
            $snapshot['payment_total'] = (float) $source['total'];
            $snapshot['original_amount'] = (float) $source['original_amount'];
            $snapshot['average_nightly'] = (float) $quote['price'];
            $snapshot['manual_recovery'] = $recovery;
            $header->currency = '$';
            $header->currency_code = 'USD';
            $header->exchange_rate = 1.0;
            $header->total = $source['total'];
            $header->original_amount = $source['original_amount'];
            $header->pricing_snapshot = $snapshot;
            $header->save();
            $line->currency = '$';
            $line->currency_code = 'USD';
            $line->rate = 1.0;
            $line->price = $quote['price'];
            $line->sale_price = $quote['sale_price'] ?? null;
            $line->pricing_snapshot = $snapshot;
            $line->save();

            // Refresh the existing source reservation downstream, never create
            // another local booking or change its guest check-in state.
            app(\App\Services\ChannexPro\ReservationEventService::class)->statusChanged($header->fresh());
            return $header;
        });
    }
}
