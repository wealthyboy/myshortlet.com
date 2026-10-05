<?php

namespace App\Jobs;

use App\Models\Invoice;
use App\Services\ZeptoMailDeliveryStatus;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class CheckInvoiceDeliveryStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 12;
    public $timeout = 40;

    protected $invoiceId;

    public function __construct($invoiceId)
    {
        $this->invoiceId = $invoiceId;
    }

    public function handle(ZeptoMailDeliveryStatus $deliveryStatus)
    {
        $invoice = Invoice::find($this->invoiceId);

        if (!$invoice || $invoice->invoice_mail_status === 'delivered') {
            return;
        }

        if (empty($invoice->invoice_mail_client_reference) || empty($invoice->email)) {
            return;
        }

        try {
            $result = $deliveryStatus->findByClientReference(
                $invoice->invoice_mail_client_reference,
                $invoice->email
            );
        } catch (Throwable $e) {
            $invoice->forceFill([
                'invoice_mail_checked_at' => now(),
                'invoice_mail_last_error' => $e->getMessage(),
            ])->save();

            Log::warning('AVM invoice delivery-status check failed', [
                'invoice_id' => $invoice->id,
                'invoice' => $invoice->invoice,
                'error' => $e->getMessage(),
            ]);

            if ($this->canRetry()) {
                $this->release($this->nextDelay());
            } else {
                $invoice->forceFill([
                    'invoice_mail_status' => 'tracking_error',
                ])->save();
            }

            return;
        }

        if (!$result) {
            $invoice->forceFill([
                'invoice_mail_status' => 'processing',
                'invoice_mail_checked_at' => now(),
            ])->save();

            if ($this->canRetry()) {
                $this->release($this->nextDelay());
            } else {
                $invoice->forceFill([
                    'invoice_mail_status' => 'not_found',
                    'invoice_mail_last_error' => 'ZeptoMail did not return a matching email log within the delivery-check window.',
                ])->save();
            }

            return;
        }

        $status = $this->normalizeStatus($result['status']);

        $updates = [
            'invoice_mail_status' => $status ?: 'processing',
            'zeptomail_request_id' => $result['request_id'],
            'zeptomail_email_reference' => $result['email_reference'],
            'invoice_mail_checked_at' => now(),
            'invoice_mail_last_error' => null,
        ];

        if ($status === 'delivered') {
            $updates['invoice_delivered_at'] = now();
        }

        $invoice->forceFill($updates)->save();

        if ($status === 'delivered') {
            return;
        }

        // Permanent failures should keep the Send Invoice action available so
        // an admin can correct the address and resend.
        if (in_array($status, ['hard_bounce', 'process_failed', 'failed'], true)) {
            return;
        }

        // Queued, processed, soft-bounce and other non-final states are checked
        // again for a limited period.
        if ($this->canRetry()) {
            $this->release($this->nextDelay());
        }
    }

    protected function normalizeStatus($status)
    {
        $status = strtolower(trim((string) $status));
        $status = str_replace([' ', '-'], '_', $status);

        return $status;
    }

    protected function canRetry()
    {
        return $this->attempts() < $this->tries;
    }

    protected function nextDelay()
    {
        $delays = [15, 30, 45, 60, 90, 120, 180, 300, 300, 600, 600, 900];
        $index = max(0, min(count($delays) - 1, $this->attempts() - 1));

        return $delays[$index];
    }
}
