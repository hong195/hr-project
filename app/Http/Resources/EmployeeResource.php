<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'patronymic' => $this->patronymic,
            'email' => $this->email,
            'meta' => $this->whenLoaded('meta'),
            'ratings' => $this->whenLoaded('ratings'),
            'pharmacy' => new PharmacyResource($this->whenLoaded('pharmacy')),
        ];
    }
}
