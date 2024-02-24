<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_link',
        'video_link',
        'is_gallery'
    ];

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id', 'asc');
    }
}
