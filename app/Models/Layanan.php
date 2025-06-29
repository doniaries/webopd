<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{

    protected $table = 'layanans';
    protected $fillable = [
        'nama_layanan',
        'slug',
        'syarat',
        'biaya',
        'file',
    ];

    protected $casts = [
        'file' => 'array',
        'biaya' => 'string',
        'syarat' => 'string',
    ];
}
