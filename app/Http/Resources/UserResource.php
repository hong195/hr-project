<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'full_name' => $this->full_name,
            'email' => $this->email,
            'meta' => $this->whenLoaded('meta'),
            'role' => $this->whenLoaded('roles', function() {
                return RoleResource::make($this->roles)->first();
            }),
            'permissions' => $this->getPermissionsViaRoles()->map->name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
