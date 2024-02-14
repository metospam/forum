<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{

    use HasFactory;

    protected $fillable = [
        'image',
        'username',
        'email',
        'password',
        'api_token',
    ];

    protected $hidden = [
        'password',
        'api_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];

    public function getJWTIdentifier(): mixed
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return [];
    }

    public function likesForPosts(): HasMany
    {
        return $this->hasMany(Like::class)
            ->where('likeable_type', Post::class)
            ->where('is_like', true);
    }

    public function dislikesForPosts(): HasMany
    {
        return $this->hasMany(Like::class)
            ->where('likeable_type', Post::class)
            ->where('is_like', false);
    }

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class, 'users_communities');
    }
}
