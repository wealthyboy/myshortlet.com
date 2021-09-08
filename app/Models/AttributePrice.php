<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributePrice extends Model
{
    use HasFactory;

    public $fillable = ['price'];

    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
}
