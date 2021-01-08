<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CheckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {

        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'reviewer_id' => $this->reviewer_id,
            'name' => $this->name,
            'sum' => $this->sum,
            'criteria' => $this->criteria,
            'user' => new UserResource($this->whenLoaded('user')),
            'reviewer' => new UserResource($this->whenLoaded('reviewer')),
            'ratings' => $this->whenLoaded('ratings'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
