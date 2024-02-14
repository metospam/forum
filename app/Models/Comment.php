<?php

namespace App\Models;

use App\Models\Interfaces\Likeable;
use App\Models\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model implements Likeable
{
    use HasFactory, HasLikes;

    protected $fillable = [
        'content',
        'user_id',
        'post_id',
        'comment_id',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'comment_id')->latest();
    }
}
