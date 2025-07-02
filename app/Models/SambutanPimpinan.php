<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SambutanPimpinan extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

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
    
    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'judul';
    
    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';
}
