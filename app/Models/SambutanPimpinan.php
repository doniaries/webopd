<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class SambutanPimpinan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sambutan_pimpinans';

    protected $fillable = [
        'judul',
        'slug',
        'isi_sambutan',
        'foto',
        'nama',
        'jabatan',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function getSlugAttribute()
    {
        return Str::slug($this->judul);
    }
}
