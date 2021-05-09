<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPermission extends Model
{
    //
    protected $fillable = [
        'permission_id'
    ];

    
    public function permission(){
        return $this->belongsTo(Permission::class);
    }

}
