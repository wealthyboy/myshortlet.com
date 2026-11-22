<?php

namespace App\Services;

use App\Http\Controllers\InvoicePaymentController;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvoiceInstallmentService
{
    /**
     * Return the next charge for an invoice. The amount is calculated only
     * from the invoice held on the server, never from the browser.
     */
    public function nextPayment(Invoice $invoice): ?InvoicePayment
    {
        return DB::transaction(function () use ($invoice) {
            $invoice = Invoice::lockForUpdate()->findOrFail($invoice->id);

            if ($invoice->paystack_paid_at || $invoice->user_reservation()->exists()) {
                return null;
            }

            $currency = InvoicePaymentController::currencyCode($invoice->currency);
            $totalMinor = $this->totalMinor($invoice);
            $paidMinor = (int) InvoicePayment::where('invoice_id', $invoice->id)
                ->where('status', 'paid')
                ->sum('amount_minor');

            if ($paidMinor >= $totalMinor) {
                return null;
            }

            $pending = InvoicePayment::where('invoice_id', $invoice->id)
                ->where('status', 'pending')
                ->orderBy('sequence')
                ->first();

            if ($pending) {
                return $pending;
            }

            $sequence = (int) InvoicePayment::where('invoice_id', $invoice->id)->max('sequence') + 1;
            $amountMinor = min($this->maximumMinor($currency), $totalMinor - $paidMinor);

            return InvoicePayment::create([
                'invoice_id' => $invoice->id,
                'sequence' => $sequence,
                'reference' => sprintf('invoice-%d-part-%d-%s', $invoice->id, $sequence, Str::lower(Str::random(18))),
                'currency' => $currency,
                'amount_minor' => $amountMinor,
            ]);
        });
    }

    public function summary(Invoice $invoice): array
    {
        $currency = InvoicePaymentController::currencyCode($invoice->currency);
        $totalMinor = $this->totalMinor($invoice);
        $limitMinor = $this->maximumMinor($currency);
        $paidMinor = (int) InvoicePayment::where('invoice_id', $invoice->id)
            ->where('status', 'paid')
            ->sum('amount_minor');

        return [
            'total_minor' => $totalMinor,
            'paid_minor' => min($paidMinor, $totalMinor),
            'remaining_minor' => max(0, $totalMinor - $paidMinor),
            'installment_count' => (int) ceil($totalMinor / $limitMinor),
            'paid_count' => (int) InvoicePayment::where('invoice_id', $invoice->id)
                ->where('status', 'paid')
                ->count(),
            'requires_installments' => $totalMinor > $limitMinor,
        ];
    }

    public function totalMinor(Invoice $invoice): int
    {
        return (int) round(((float) $invoice->total) * 100);
    }

    public function maximumMinor(string $currency): int
    {
        $maximum = (array) config('services.paystack.invoice_installment_limits', []);
        $majorAmount = $maximum[strtoupper($currency)] ?? null;

        // A currency without a configured threshold remains a single payment.
        return $majorAmount === null
            ? PHP_INT_MAX
            : (int) round(((float) $majorAmount) * 100);
    }
}
