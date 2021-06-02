<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserPermission extends Model
{
    use HasFactory;

    protected $fillable = [
        'permission_id'
    ];

    
    public function permission(){
        return $this->belongsTo(Permission::class);
    }

}
