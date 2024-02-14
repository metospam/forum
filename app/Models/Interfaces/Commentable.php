<?php

namespace App\Models\Interfaces;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Relations\HasMany;

interface Commentable
{
    public function comments(): HasMany;
    public function parentComments(): HasMany;
}
