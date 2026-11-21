<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    /**
     * Public, signed invoice payment page. The amount and currency are read
     * exclusively from the saved invoice, never from browser input.
     */
    public function show(Request $request, Invoice $invoice)
    {
        $currency = $this->currencyCode($invoice->currency);

        if (! in_array($currency, ['NGN', 'USD', 'GHS', 'ZAR', 'KES'], true)) {
            abort(422, 'This invoice currency is not available for Paystack payment.');
        }

        return view('invoices.paystack', [
            'invoice' => $invoice,
            'currency' => $currency,
            'amountInMinor' => (int) round(((float) $invoice->total) * 100),
            'paystackPublicKey' => config('services.paystack.public_key'),
            'alreadyPaid' => (bool) $invoice->paystack_paid_at || (bool) $invoice->sent,
        ]);
    }

    public static function currencyCode($currency)
    {
        $currency = strtoupper(trim((string) $currency));

        return [
            '₦' => 'NGN',
            'NGN' => 'NGN',
            '$' => 'USD',
            'USD' => 'USD',
            'GH₵' => 'GHS',
            'GHS' => 'GHS',
            'R' => 'ZAR',
            'ZAR' => 'ZAR',
            'KSH' => 'KES',
            'KES' => 'KES',
        ][$currency] ?? $currency;
    }
}
