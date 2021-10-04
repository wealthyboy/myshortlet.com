<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PropertyLists extends JsonResource
{
    /**
     * Transform the resource collection into an array.
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
            'guests' => $this->type == 'single' ? optional($this->single_room)->max_children + optional($this->single_room)->max_adults : null,
            'rooms' => $this->type == 'single' ? optional($this->single_room)->no_of_rooms : null,
            'baths' => $this->type == 'single' ? optional($this->single_room)->toilets : null,
            'city' => $this->city,
            'state' => $this->state,
            'currency' => $this->currency,
            'image_m' => $this->image_m,
            'image' => $this->image,
            'image_tn' => $this->image_tn,
            'link' => $this->link,
            'type' => $this->type,
            'single_room' => $this->single_room,
            'multiple_apartment' => $this->multiple_rooms,
            'is_refundable' =>$this->is_refundable,
            'free_services' =>$this->free_services,
            'facilities' => $this->facilities,
            'check_in_checkout' => request()->check_in_checkout
        ];
    }


    public  function checkPropertyType($s, $m)
    {
        return $this->type == 'single' ? $s : $m ;   
    }
}
