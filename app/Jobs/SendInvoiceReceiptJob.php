<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

use PDF;

class SendInvoiceReceiptJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    protected $user_reservation;


    /**
     * Create a new job instance.
     */
    public function __construct($invoice, $user_reservation)
    {
        $this->invoice = $invoice;

        $this->user_reservation = $user_reservation;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Generate PDF
        $pdf = PDF::loadView('admin.invoices.receipt', [
            'invoice' => $this->invoice
        ]);

        $pdfContent = $pdf->output();

        // Send Email
        Mail::send('emails.receipt', [
            'invoice' => $this->invoice,
            'user_reservation' => $this->user_reservation,
        ], function ($message) use ($pdfContent) {
            $message->to($this->invoice->email)
                ->cc([
                    'info@thecentralavenue.ng',
                    'oluwa.tosin@avenuemontaigne.ng',
                ])
                ->subject('Your Receipt from Avenue Montaigne')
                ->attachData($pdfContent, 'invoice-' . $this->invoice->invoice_number . '.pdf');
        });
    }
}
