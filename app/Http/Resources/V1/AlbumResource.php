<?php

namespace App\Http\Resources\V1;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class AlbumResource extends JsonResource
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
            "id" => $this->id,
            "name" => $this->name,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "user_id" => $this->user_id
        ];
    }
}
