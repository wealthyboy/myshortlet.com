<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicePayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'sequence',
        'reference',
        'currency',
        'amount_minor',
        'status',
        'paid_at',
        'paystack_response',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'paystack_response' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }
}
