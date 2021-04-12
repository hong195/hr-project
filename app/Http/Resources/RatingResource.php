<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
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
            'user_id' => $this->user_id,
            'scored' => $this->scored,
            'out_of' => $this->out_of,
            'created_at' => $this->created_at,
            'checks' => CheckResource::collection($this->whenLoaded('checks')),
            'user'  => EmployeeResource::make($this->whenLoaded('user'))
        ];
    }
}
