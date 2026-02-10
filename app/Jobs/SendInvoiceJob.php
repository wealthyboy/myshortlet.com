<?php

namespace App\Jobs;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use PDF;

class SendInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoice;

    /**
     * Create a new job instance.
     */
    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

        // Generate PDF from your Blade view



        $pdf = PDF::loadView('admin.invoices.pdf', ['invoice' => $this->invoice]);
        $pdfContent = $pdf->output();

        // Send the mail with PDF attachment
        Mail::send('emails.invoice', ['invoice' => $this->invoice], function ($message) use ($pdfContent) {
            $message->to($this->invoice->email)
                ->cc([
                    'info@avenuemontaigne.ng',
                    'frontdesk@avenuemontaigne.ng'
                ])
                ->subject('Your Invoice from Avenue Montaigne')
                ->attachData($pdfContent, 'invoice-' . $this->invoice->invoice . '.pdf');
        });
    }
}
