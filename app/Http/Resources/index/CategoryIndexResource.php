<?php

namespace App\Http\Resources\index;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'=> $this->id,
            'name_uz'=> $this->name_uz,
            'name_ru'=> $this->name_ru,
            'name_en'=> $this->name_en,
            'image'=> $this->image,
            'parent_id'=> $this->parent_id,
        ];
    }
}
