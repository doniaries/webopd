<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalLink extends Model
{
    protected $fillable = [
        'nama',
        'url',
        'icon',
        'deskripsi',
        'status',
        'urutan'
    ];

    protected $casts = [
        'status' => 'string',
        'urutan' => 'integer'
    ];
}
