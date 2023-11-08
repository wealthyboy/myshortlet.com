<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class UserPermission extends Model
{
    use HasFactory;

    public $table_name  = 'user_permissions';

    protected $fillable = [
        'permission_id'
    ];




    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }
}
