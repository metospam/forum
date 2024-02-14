<?php

namespace App\Http\Resources;

use App\Services\CommentService;
use App\Services\Impl\CommentServiceImpl;
use App\Services\Impl\TimeServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    protected CommentService $commentService;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $this->commentService = app(CommentServiceImpl::class);
        $timeDifference = TimeServiceImpl::calculateCreatedAgoTime($this->created_at);

        return [
            'id' => $this->id,
            'image' => $this->image,
            'title' => $this->title,
            'content' => $this->content,
            'time' => $timeDifference,
            'community' => CommunityResource::make($this->community),
            'user' => UserResource::make($this->user),
            'likes_count' => $this->likesDiff(),
            'comments' => $this->commentService->collectComments($this->resource),
            'comments_count' => $this->comments()->count(),
        ];
    }
}
