<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $casts = [
        'sent' => 'boolean',
        'resent' => 'boolean',
    ];


    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'country',
        'currency',
        'sub_total',
        'discount',
        'caution_fee',
        'total',
        'invoice',
        'full_name',
        'description',
        'sent',
        'resent',
        'payment_info'
    ];

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $lastInvoice = static::orderBy('id', 'desc')->first();
                $nextNumber = $lastInvoice ? ((int) filter_var($lastInvoice->invoice_number, FILTER_SANITIZE_NUMBER_INT)) + 1 : 1;
                $invoice->invoice_number = 'INV-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
            }
        });
    }
}
