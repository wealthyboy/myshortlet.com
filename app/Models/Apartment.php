<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


use App\Traits\FormatPrice;
use App\Traits\ImageFiles;

class Apartment extends Model
{
    use HasFactory, FormatPrice, ImageFiles; //,SoftDeletes,CascadeSoftDeletes;


    protected $dates = ['available_from', 'sale_price_expires'];


    public $folder = 'apartments';


    public $appends = [
        'discounted_price',
        'currency',
        'converted_price',
        'exchange_rate',
        'exchange_price',
        'percentage_off',
        'image_m',
        'image_g',
        'image_tn',
        'guests',
        'display_price',
        'percentage_off',
        'google_drive_image_links',
        'google_drive_image_link',
        'google_drive_video_link',
        'hightlights',
        'converted_peak_price',
        'converted_regular_price',


    ];

    protected $fillable = [
        'name',
        'price',
        'sale_price',
        'image',
        'sale_price_expires',
        'slug',
        'available_from',
        'reservation_id',
        'max_adults',
        'max_children',
        'no_of_rooms',
        'toilets',
        'type',
        'price_mode',
        'apartment_id',
        'image_link',
        'video_link',
        'allow',
        'december_prices'
    ];


    public function attribute_prices()
    {
        return $this->hasMany(AttributePrice::class, 'room_id');
    }


    public function property()
    {
        return $this->belongsTo(Property::class);
    }


    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'apartment_id')->orderBy('sort_order', 'asc');
    }


    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('id', 'asc');
    }


    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }


    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->whereNull('bed_count')->withPivot('bed_count');;
    }


    // Define the accessor method
    public function getGoogleDriveImageLinksAttribute()
    {
        $images = [];
        // If the attribute exists and is not empty
        if ($this->image_link) {
            // Split the comma-separated links into an array
            $links  = explode(',', $this->image_link);

            foreach ($links as $link) {
                $images[] = self::generateThumbnailUrl($link);
            }

            return $images;
        }

        // Return an empty array if the attribute is empty
        return [];
    }


    public function getGoogleDriveImageLinkAttribute()
    {
        $images = [];
        if ($this->image_link) {
            $links  = explode(',', $this->image_link);

            foreach ($links as $link) {
                $images[] = self::generateThumbnailUrl($link);
            }

            $images_count  = $this->images->count();

            return  array_slice($images, 0, 9 -  $images_count);
        }

        // Return an empty array if the attribute is empty
        return [];
    }


    public function getGoogleDriveVideoLinkAttribute()
    {
        if ($this->video_link) {
            $link = self::generateId($this->video_link);
            return self::generateVideoLink($link);
        }

        return null;
    }


    public  static function generateId($originalUrl)
    {
        // Extract the ID from the original URL using regular expressions
        preg_match('/\/file\/d\/(.+?)\//', $originalUrl, $matches);
        $id =  isset($matches[1]) ? $matches[1] : null;

        return $id;
    }


    public  static function generateThumbnailUrl($originalUrl)
    {
        // Extract the ID from the original URL using regular expressions
        preg_match('/\/file\/d\/(.+?)\//', $originalUrl, $matches);
        $id =  isset($matches[1]) ? $matches[1] : null;

        // Construct the thumbnail URL
        $thumbnailUrl = "https://drive.google.com/thumbnail?id={$id}&sz=w2000";

        return $thumbnailUrl;
    }


    public  static function generateVideoLink($id)
    {
        $link = "https://drive.google.com/file/d/{$id}/preview";
        return $link;
    }







    public function free_services()
    {
        return $this->belongsToMany(Attribute::class)
            ->where('type', 'extra services')
            ->wherePivotNull('price');
    }


    public function extra_services()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'extra services')->wherePivotNotNull('price')->withPivot('price');
    }


    public function facilities()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'facilities');
    }

    public function apartment_facilities()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'apartment facilities');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function bedrooms()
    {
        return $this->belongsToMany(Attribute::class)->where('type', 'bedrooms')->withPivot('bed_count');
    }


    public function getGuestsAttribute()
    {
        return $this->max_children + $this->max_adults;
    }

    public function getImageMAttribute()
    {
        $image = basename(optional(optional($this->images)->first())->image);
        return asset('images/' . $this->folder . '/' . 'm' . '/' . $image);
    }


    public function getHightlightsAttribute()
    {
        $array = explode(',', $this->teaser);

        return $array;
    }


    public function getImageGAttribute()
    {
        return isset($this->google_drive_image_link[0]) ? $this->google_drive_image_link[0] : $this->image_m;
    }
}
