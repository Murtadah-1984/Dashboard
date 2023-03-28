<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'title'=>$this->title,
            'route'=>$this->route,
            'policy'=>$this->policy,
            'class'=>$this->class,
            'order'=>$this->order,
            'parent'=>new MenuResource($this->whenLoaded('parent')),
            'children'=>MenuResource::collection($this->whenLoaded('children')),
            'isDeleted'=>$this->isDeleted()
        ];
    }
}
