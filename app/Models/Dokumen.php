<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasSlug;
    
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

    protected $casts = [
        'views' => 'integer',
        'downloads' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'nama_dokumen';
    
    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';
}
