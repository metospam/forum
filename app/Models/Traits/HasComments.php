<?php

namespace App\Models\Traits;

use App\Models\Comment;
use App\Models\Interfaces\Commentable;
use App\Services\Impl\TimeServiceImpl;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasComments
{
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function parentComments(): HasMany
    {
        return $this->hasMany(Comment::class)->latest()->where('comment_id', null);
    }
}
