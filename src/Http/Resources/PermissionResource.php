<?php

namespace App\Http\Resources;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'key'=>$this->key,
            'table_name'=>$this->table_name,
            'roles'=>RoleResource::collection($this->whenLoaded('roles')),
            'isDeleted'=>$this->isDeleted()
        ];
    }
}
