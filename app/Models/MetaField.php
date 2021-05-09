<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MetaField extends Model
{
    public $table = 'meta_field';

    public function attribute()
   {   
      return $this->belongsTo(Attribute::class,'attribute_id');
   }
}
