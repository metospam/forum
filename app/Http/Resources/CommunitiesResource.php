<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunitiesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'image' => $this->image,
            'name' => $this->name,
            'slug' => $this->slug,
            'members' => $this->users->count(),
        ];
    }
}
