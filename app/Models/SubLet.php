<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLet extends Model
{
    use HasFactory;


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }


    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
