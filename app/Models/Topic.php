<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'slug',
    ];

    public function themes(): HasMany
    {
        return $this->hasMany(Theme::class);
    }
}
