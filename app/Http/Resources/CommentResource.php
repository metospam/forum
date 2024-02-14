<?php

namespace App\Http\Resources;

use App\Services\Impl\TimeServiceImpl;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'avatar' => $this->user->image,
            'username' => $this->user->username,
            'post_time' => '1 sec. ago',
            'content' => $this->content,
            'children' => [],
        ];
    }
}
