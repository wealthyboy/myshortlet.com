<?php

namespace App\Jobs;

use App\Mail\InvoiceReportMail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;

class SendInvoiceZipReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $invoices;
    protected $apartmentId;
    protected $email;
    protected $ccEmail;

    public function __construct($invoices, $apartmentId, $email, $ccEmail = null)
    {
        $this->invoices = $invoices;
        $this->apartmentId = $apartmentId;
        $this->email = $email;
        $this->ccEmail = $ccEmail;
    }

    public function handle()
    {
        /** ---------------------------------------------------
         *  GET APARTMENT NAME FOR ZIP FILENAME
         * ---------------------------------------------------*/
        $apartment = \App\Models\Apartment::find($this->apartmentId);
        $apartmentName = $apartment ? str_replace(' ', '_', $apartment->name) : 'apartment';

        $date = now()->format('Y-m-d');
        $zipName = "{$apartmentName}-{$date}-invoices.zip";
        $zipPath = storage_path("app/{$zipName}");

        /** ---------------------------------------------------
         *  GENERATE SUMMARY REPORT PDF
         * ---------------------------------------------------*/
        $reportPdf = \PDF::loadView('admin.invoices.report', [
            'invoices' => $this->invoices
        ])->output();

        /** ---------------------------------------------------
         *  GENERATE ZIP OF FILTERED INVOICES
         * ---------------------------------------------------*/
        $zip = new \ZipArchive();
        $zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE);

        $fileCount = 0;

        foreach ($this->invoices as $invoice) {

            $items = $invoice->invoice_items()
                ->where('apartment_id', $this->apartmentId)
                ->get();

            if ($items->isEmpty()) continue;

            $invoice->setRelation('invoice_items', $items);

            $invoice->filtered_subtotal = $items->sum('total');
            $invoice->filtered_total = $invoice->filtered_subtotal + ($invoice->caution_fee ?? 0);

            $pdf = \PDF::loadView('admin.invoices.pdf', [
                'invoice' => $invoice,
                'filtered' => true
            ])->output();

            $zip->addFromString($invoice->invoice . '.pdf', $pdf);

            $fileCount++;
        }

        $zip->close();

        /** ---------------------------------------------------
         *  EMPTY ZIP SAFETY CHECK
         * ---------------------------------------------------*/
        if ($fileCount === 0) {
            \Log::warning("ZIP empty for apartment {$this->apartmentId}");
            return; // no mail sent, quietly exits
        }

        /** ---------------------------------------------------
         *  SEND EMAIL WITH 2 ATTACHMENTS
         * ---------------------------------------------------*/
        $mail = new InvoiceReportMail($reportPdf, $zipPath);

        if ($this->ccEmail) {
            Mail::to($this->email)->cc($this->ccEmail)->send($mail);
        } else {
            Mail::to($this->email)->send($mail);
        }
    }
}
