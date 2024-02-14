<?php

namespace App\Http\Resources;

use App\Services\Impl\TimeServiceImpl;
use App\Services\TimeService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $timeDifference = TimeServiceImpl::calculateCreatedAgoTime($this->created_at);

        return [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'content' => $this->content,
            'slug'  => $this->slug,
            'time' => $timeDifference,
            'community' => $this->community,
            'user' => $this->user,
            'likes_count' => $this->likesDiff(),
            'comments_count' => $this->comments->count(),
        ];
    }
}
