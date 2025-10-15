<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'open_positions' => $this->open_positions,
            'position' => $this->position,
            'type' => $this->type->type,
            'location' => $this->location,
            'description' => $this->description,
            'registration_link' => $this->registration_link,
        ];
    }
}
