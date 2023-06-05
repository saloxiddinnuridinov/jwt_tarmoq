<?php

namespace App\Http\Resources\show;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'name'           =>  $this->name,
            'surname'        =>  $this->surname,
            'email'          =>  $this->email,
            'status'         =>  $this->status,
            'block_reason'   =>  $this->block_reason,
            'is_blocked'     =>  $this->is_blocked,
            'balance'        =>  $this->balance,
            'birthday'       =>  $this->birthday,
            'created_at'     =>  date('Y-m-d H:i:s', strtotime($this->created_at)),
            'updated_at'     =>  date('Y-m-d H:i:s', strtotime($this->updated_at)),
        ];
    }
}
