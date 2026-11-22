<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Services\InvoiceInstallmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

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

        $installments = app(InvoiceInstallmentService::class);
        $alreadyPaid = (bool) $invoice->paystack_paid_at || $invoice->user_reservation()->exists();
        $submittedPayment = null;

        if ($request->query('payment') === 'processing' && $request->query('reference')) {
            $submittedPayment = InvoicePayment::where('invoice_id', $invoice->id)
                ->where('reference', $request->query('reference'))
                ->first();
        }

        $installment = $alreadyPaid ? null : $installments->nextPayment($invoice);
        $summary = $installments->summary($invoice);

        return view('invoices.paystack', [
            'invoice' => $invoice,
            'currency' => $currency,
            'installment' => $installment,
            'summary' => $summary,
            'amountInMinor' => optional($installment)->amount_minor,
            'paystackPublicKey' => config('services.paystack.public_key'),
            'alreadyPaid' => $alreadyPaid,
            'paymentSubmitted' => $submittedPayment && $submittedPayment->status !== 'paid',
            'confirmationUrl' => $installment ? URL::temporarySignedRoute(
                'invoices.paystack.pay',
                now()->addDays(30),
                [
                    'invoice' => $invoice->id,
                    'payment' => 'processing',
                    'reference' => $installment->reference,
                ]
            ) : null,
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
