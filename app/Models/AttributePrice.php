<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttributePrice extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = ['price'];

    public function attribute(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }
}
