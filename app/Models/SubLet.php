<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubLet extends Model
{
    use HasFactory;


    public function sublet()
    {
        return $this->hasOne(User::class);
    }
}
