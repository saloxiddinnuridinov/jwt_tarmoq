<?php

namespace App\Http\Resources\show;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
