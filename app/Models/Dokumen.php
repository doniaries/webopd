<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumens';
    protected $fillable = [
        'nama_dokumen',
        'slug',
        'deskripsi',
        'cover',
        'views',
        'downloads',
        'file',
        'tahun_terbit',
    ];

    protected $dates = ['published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
