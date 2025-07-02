<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    use HasSlug;

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
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'nama_layanan';
    
    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';
}
