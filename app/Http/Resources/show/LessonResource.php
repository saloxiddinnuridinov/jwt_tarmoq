<?php

namespace App\Http\Resources\show;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonResource extends JsonResource
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
            'id'         =>  $this->id,
            'title_uz'   =>  $this->title_uz,
            'title_ru'   =>  $this->title_ru,
            'title_en'   =>  $this->title_en,
            'category'   =>  $this->category,
            'created_at' =>  date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at' =>  date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
