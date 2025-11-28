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
        $subject = $this->zipPath !== null ? "Invoice Report & Invoices ZIP" : "Invoice Report";
        $mail = $this->subject($subject)
            ->view('emails.invoice_report');

        if ($this->reportPdf !== null) {
            $mail->attachData($this->reportPdf, "invoice-report.pdf", [
                'mime' => 'application/pdf'
            ]);
        }

        if ($this->zipPath !== null) {
            $mail->attach($this->zipPath, [
                'as' => basename($this->zipPath),
                'mime' => 'application/zip'
            ]);
        }

        return $mail;
    }
}
