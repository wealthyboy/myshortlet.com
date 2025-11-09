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
        'resent'
    ];

    public function invoice_items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
