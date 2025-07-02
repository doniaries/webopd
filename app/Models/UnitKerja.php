<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class UnitKerja extends Model
{
    use HasSlug;
    
    protected $table = 'unit_kerjas';
    protected $fillable = [
        'nama_unit',
        'slug',
        'deskripsi',
    ];

    protected $dates = ['published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];
    
    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'nama_unit';
    
    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';
}
