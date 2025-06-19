<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $table = 'dokumens';
    protected $fillable = [
        'team_id',
        'nama_dokumen',
        'slug',
        'deskripsi',
        'cover',
        'file',
        'tahun_terbit',
    ];

    protected $dates = ['published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
