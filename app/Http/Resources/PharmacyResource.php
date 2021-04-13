<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PharmacyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'coordinates' => $this->coordinates,
            'email' => $this->email,
            'users_count' => $this->whenLoaded('users', function() {
                return $this->users->count();
            }) ?? 0,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
