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
        'payment_info'
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

    public function getFormattedDiscountAttribute()
    {
        return $this->discount_type === 'fixed'
            ? '-' . $this->currency . number_format($this->discount)
            : '-' . number_format($this->discount) . '%';
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
