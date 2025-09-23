<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'session_id',
        'user_agent',
        'visited_at',
        'last_activity',
        'url',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'last_activity' => 'datetime',
    ];
}
