<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
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
            'task'=>$this->task,
            'user'=>$this->user,
            'details'=>$this->details,
            'isDeleted'=>$this->isDeleted()
        ];
    }
}
