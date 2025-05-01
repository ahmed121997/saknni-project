<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PropertiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'title' => @$this->des->title,
            'details' => @$this->des->details,
            'governorate' => [
                'id' => @$this->governorate->id,
                'name' => @$this->governorate->name
            ],
            'city' => [
                'id' => @$this->city->id,
                'name' => @$this->city->name
            ],
            'payment' => [
                'id' => @$this->payment->id,
                'name' => @$this->payment->name
            ],
            'type_property' => [
                'id' => @$this->typeProperty->id,
                'name' => @$this->typeProperty->name
            ],
            'view' => [
                'id' => @$this->view->id,
                'name' => @$this->view->name
            ],
            'finish' => [
                'id' => @$this->finish->id,
                'name' => @$this->finish->name
            ],
            'type_rent' => $this->type_rent,
            'list_section' => $this->list_section,
            'area' => $this->area,
            'num_floor' => $this->num_floor,
            'num_rooms' => $this->num_rooms,
            'num_bathroom' => $this->num_bathroom,
            'location' => $this->location,
            'price' => $this->price,
            'is_special' => $this->is_special,
            'link_youtube' => $this->link_youtube,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => asset($image->source),
                ];
            }),
        ];
    }
}
