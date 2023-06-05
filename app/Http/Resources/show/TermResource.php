<?php

namespace App\Http\Resources\show;

use Illuminate\Http\Resources\Json\JsonResource;

class TermResource extends JsonResource
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
            'id'             =>  $this->id,
            'keyword_latin'  =>  $this->keyword_latin,
            'keyword_ru'     =>  $this->keyword_ru,
            'keyword_uz'     =>  $this->keyword_uz,
            'keyword_en'     =>  $this->keyword_en,
            'description_uz' =>  $this->description_uz,
            'description_ru' =>  $this->description_ru,
            'description_en' =>  $this->description_en,
            'created_at'     =>  date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at'     =>  date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
