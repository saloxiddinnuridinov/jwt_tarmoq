<?php

namespace App\Http\Resources\index;

use Illuminate\Http\Resources\Json\JsonResource;

class LessonIndexResource extends JsonResource
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
            'uzbekcha'=> $this->title_uz,
            'ruscha'=> $this->title_ru,
            'anglizcha'=> $this->title_en,
            'category'=> $this->category,
        ];
    }
}
