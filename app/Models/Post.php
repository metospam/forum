<?php

namespace App\Models;

use App\Models\Interfaces\Commentable;
use App\Models\Interfaces\Likeable;
use App\Models\Traits\HasComments;
use App\Models\Traits\HasLikes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Post extends Model implements Likeable, Commentable
{
    use HasFactory, HasLikes, HasComments;

    protected $fillable = [
        'image',
        'title',
        'content',
        'slug',
        'theme_id',
        'community_id',
        'user_id',
    ];

    public function community(): BelongsTo
    {
        return $this->belongsTo(Community::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
