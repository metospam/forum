<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Community extends Model
{

    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'slug',
        'description',
    ];

    public function users(): belongsToMany
    {
        return $this->belongsToMany(User::class, 'users_communities');
    }

    public function administrators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_communities')
            ->where('role', 'admin');
    }

    public function moderators(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'users_communities')
            ->where('role', 'moderator');
    }

}
