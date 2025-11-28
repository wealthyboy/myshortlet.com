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
    protected $rangeText;

    public function __construct($invoices, $apartmentId, $email, $ccEmail = null, $rangeText)
    {
        $this->invoices = $invoices;
        $this->apartmentId = $apartmentId;
        $this->email = $email;
        $this->ccEmail = $ccEmail;
        $this->rangeText = $rangeText;
    }

    public function handle()
    {
        /**
         * ---------------------------------------------------
         *  GET APARTMENT NAME FOR ZIP FILENAME
         * ---------------------------------------------------
         */
        $apartment = \App\Models\Apartment::find($this->apartmentId);

        if ($apartment) {
            // Prefer name → apartment_name → fallback
            $rawName = $apartment->name
                ?? $apartment->name
                ?? "Apartment_" . $apartment->id;
        } else {
            $rawName = "Apartment";
        }

        // Clean: replace spaces & remove invalid filename characters
        $apartmentName = preg_replace('/[^A-Za-z0-9_\-]/', '', str_replace(' ', '_', $rawName));

        $date = now()->format('Y-m-d');
        $zipName = "{$apartmentName}-{$date}-invoices.zip";
        $zipPath = storage_path("app/{$zipName}");

        /**
         * ---------------------------------------------------
         *  GENERATE SUMMARY REPORT PDF
         * ---------------------------------------------------
         */
        $reportPdf = \PDF::loadView('admin.invoices.report', [
            'invoices' => $this->invoices,
            'apartmentName' => $apartmentName,
            'rangeText' => $this->rangeText
        ])->output();



        /**
         * ---------------------------------------------------
         *  GENERATE ZIP OF FILTERED INVOICES
         * ---------------------------------------------------
         */
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
                'filtered' => true,
                'apartmentName' => $apartmentName,
                'rangeText' => $this->rangeText
            ])->output();

            $zip->addFromString($invoice->invoice . '.pdf', $pdf);

            $fileCount++;
        }

        $zip->close();



        /**
         * ---------------------------------------------------
         *  EMPTY ZIP SAFETY CHECK
         * ---------------------------------------------------
         */
        if ($fileCount === 0) {
            \Log::warning("ZIP empty for apartment {$this->apartmentId}");
            return; // exit quietly — no email sent
        }



        /**
         * ---------------------------------------------------
         *  SEND EMAIL WITH 2 ATTACHMENTS
         * ---------------------------------------------------
         */
        $mail = new InvoiceReportMail($reportPdf, $zipPath);

        if ($this->ccEmail) {
            Mail::to($this->email)->cc($this->ccEmail)->send($mail);
        } else {
            Mail::to($this->email)->send($mail);
        }
    }
}
