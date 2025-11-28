<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceReportMail extends Mailable
{
    public $reportPdf;
    public $zipPath;

    public function __construct($reportPdf, $zipPath)
    {
        $this->reportPdf = $reportPdf;
        $this->zipPath = $zipPath;
    }

    public function build()
    {
        return $this->subject("Invoice Report & Invoices ZIP")
            ->view('emails.invoice_report')
            ->attachData($this->reportPdf, "invoice-report.pdf", [
                'mime' => 'application/pdf'
            ])
            ->attach($this->zipPath, [
                'as' => basename($this->zipPath),
                'mime' => 'application/zip'
            ]);
    }
}
