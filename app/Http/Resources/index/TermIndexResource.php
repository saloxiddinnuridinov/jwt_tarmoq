<?php

namespace App\Http\Resources\index;

use Illuminate\Http\Resources\Json\JsonResource;

class TermIndexResource extends JsonResource
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
            'id'             => $this->id,
            'keyword_latin'  => $this->keyword_latin,
            'keyword_ru'     => $this->keyword_ru,
            'keyword_uz'     => $this->keyword_uz,
            'keyword_en'     => $this->keyword_en,
        ];
    }
}
