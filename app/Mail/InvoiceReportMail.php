<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;

    public function __construct($pdf)
    {
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Invoice Report')
            ->view('emails.invoice-report')
            ->attachData($this->pdf, 'invoice-report.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
