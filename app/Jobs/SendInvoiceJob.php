<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use PDF;
use Throwable;

class SendInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function handle(): void
    {
        $this->invoice->refresh();

        $clientReference = 'avm-invoice-' . $this->invoice->id . '-' . (string) Str::uuid();

        $this->invoice->forceFill([
            'invoice_mail_status' => 'sending',
            'invoice_mail_client_reference' => $clientReference,
            'zeptomail_request_id' => null,
            'zeptomail_email_reference' => null,
            'invoice_mail_sent_at' => null,
            'invoice_delivered_at' => null,
            'invoice_mail_checked_at' => null,
            'invoice_mail_last_error' => null,
        ])->save();

        try {
            // Keep using the current invoice PDF template. This job does not
            // alter resources/views/admin/invoices/pdf.blade.php.
            $pdf = PDF::loadView('admin.invoices.pdf', ['invoice' => $this->invoice]);
            $pdfContent = $pdf->output();

            Mail::send('emails.invoice', ['invoice' => $this->invoice], function ($message) use ($pdfContent, $clientReference) {
                $message->to($this->invoice->email)
                    ->cc([
                        'info@avenuemontaigne.ng',
                        'frontdesk@avenuemontaigne.ng'
                    ])
                    ->subject('Your Invoice from Avenue Montaigne')
                    ->attachData($pdfContent, 'invoice-' . $this->invoice->invoice . '.pdf');

                // The custom ZeptoMail transport maps this header to
                // ZeptoMail's client_reference field. It lets the delivery
                // checker identify this exact invoice email even when other
                // emails are sent to the same recipient.
                $message->getSwiftMessage()
                    ->getHeaders()
                    ->addTextHeader('X-TM-CLIENT-REF', $clientReference);
            });

            $this->invoice->forceFill([
                'invoice_mail_status' => 'processing',
                'invoice_mail_sent_at' => now(),
                'invoice_mail_last_error' => null,
            ])->save();

            CheckInvoiceDeliveryStatusJob::dispatch($this->invoice->id)
                ->delay(now()->addSeconds(15));
        } catch (Throwable $e) {
            $this->invoice->forceFill([
                'invoice_mail_status' => 'failed',
                'invoice_mail_checked_at' => now(),
                'invoice_mail_last_error' => $e->getMessage(),
            ])->save();

            throw $e;
        }
    }
}
