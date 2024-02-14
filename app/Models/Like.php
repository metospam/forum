<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'user_id',
        'is_like',
    ];
}
