<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facility extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'scope',  // property | room | both
        'channex_facility_id', // UUID from Channex
        'channex_kind', // property | room
        'is_active',
        'category'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
