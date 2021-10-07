<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ApartmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
        
       return [
        'id' => $this->id,
        'name' => $this->name,
        'converted_price' => $this->converted_price,
        'default_discounted_price' => $this->default_discounted_price,
        'price' => $this->price,
        'guests' => $this->type == $this->max_children + $this->max_adults,
        'rooms' => $this->no_of_rooms,
        'property' => $this->property,
        'currency' => $this->currency,
        'image_m' => $this->image_m,
        'image' => $this->image,
        'image_tn' => $this->image_tn,
        'link' => $this->link,
        'type' => $this->type,
        'free_services' =>$this->free_services,
        'facilities' => $this->facilities,
        'bedrooms' => $this->bedrooms,
        'check_in_checkout' => request()->check_in_checkout,
        'display_price' => $this->display_price,
        'uuid'=> $this->uuid
        ];
    }
}
