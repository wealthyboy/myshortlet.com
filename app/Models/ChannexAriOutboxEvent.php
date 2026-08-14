<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChannexAriOutboxEvent extends Model
{
    protected $fillable = [
        'property_id',
        'apartment_id',
        'event_type',
        'payload',
        'status',
        'attempts',
        'last_error',
        'processed_at',
    ];

    protected $casts = [
        'payload' => 'array',
        'processed_at' => 'datetime',
    ];
}
