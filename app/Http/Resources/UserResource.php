<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'communities' => $this->communities()->pluck('community_id')->toArray(),
            'likes' => $this->likesForPosts()->pluck('likeable_id')->toArray(),
            'dislikes' => $this->dislikesForPosts()->pluck('likeable_id')->toArray(),
            'registered' => $this->created_at->format('M d, Y'),
        ];
    }
}
