<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'sent' => 'boolean',
        'resent' => 'boolean',
        'invoice_mail_sent_at' => 'datetime',
        'invoice_delivered_at' => 'datetime',
        'invoice_mail_checked_at' => 'datetime',
        'paystack_paid_at' => 'datetime',
    ];

    public $appends = [
        'formatted_discount',
    ];

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'country',
        'currency',
        'subtotal',
        'discount',
        'caution_fee',
        'discount_type',
        'total',
        'invoice',
        'full_name',
        'description',
        'sent',
        'resent',
        'payment_info',
        'invoice_mail_status',
        'invoice_mail_client_reference',
        'zeptomail_request_id',
        'zeptomail_email_reference',
        'invoice_mail_sent_at',
        'invoice_delivered_at',
        'invoice_mail_checked_at',
        'invoice_mail_last_error',
        'paystack_reference',
        'paystack_paid_at',
    ];

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class)->whereNotNull('apartment_id');
    }

    public function extra_items()
    {
        return $this->hasMany(InvoiceItem::class)->whereNull('apartment_id');
    }

    public function user_reservation()
    {
        return $this->hasOne(UserReservation::class);
    }

    public function payments()
    {
        return $this->hasMany(InvoicePayment::class);
    }

    public function getFormattedDiscountAttribute()
    {
        return $this->discount_type === 'fixed'
            ? '-' . $this->currency . number_format($this->discount)
            : '-' . number_format($this->discount) . '%';
    }

    public function getDisplayNumberAttribute()
    {
        return $this->invoice ?: $this->invoice_number;
    }

    /**
     * Default wire instructions shown when an admin has not entered bespoke
     * payment details. USD invoices must never inherit the NGN account text.
     */
    public static function defaultPaymentInfo($currency)
    {
        $currency = strtoupper(trim((string) $currency));

        if (in_array($currency, ['$', 'USD'], true)) {
            return "For international Wire transfers in USD\n"
                . "Bank name: Providus bank plc\n"
                . "Account name: Avenue montaigne Limited\n"
                . "Account number: 1305006911 (USD)\n"
                . "Swift code: UMPLNGLA\n"
                . "Bank address: 54 Adetokunbo Ademola Street, Victoria\n"
                . "Island, Lagos, Nigeria";
        }

        return "Please make payment using the following details:\n"
            . "Avenue Montaigne Limited\n"
            . "Providus Bank\n"
            . "1305006894";
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
