<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommunityResource extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'members' => $this->users->count(),
            'moderators' => $this->moderators()->pluck('user_id')->toArray(),
            'admins' => $this->administrators()->pluck('user_id')->toArray(),
            'created_at' => $this->created_at->format('M d, Y'),
        ];
    }
}
