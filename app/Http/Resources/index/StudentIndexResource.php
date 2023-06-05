<?php

namespace App\Http\Resources\index;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentIndexResource extends JsonResource
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
            'name'=> $this->name,
            'surname'=> $this->surname,
            'email'=> $this->email,
            'status'=> $this->status,
        ];
    }
}
