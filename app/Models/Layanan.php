<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Layanan extends Model
{
    use HasSlug, SoftDeletes;

    protected $table = 'layanans';
    
    protected $fillable = [
        'nama_layanan',
        'slug',
        'deskripsi',
        'konten',
        'persyaratan',
        'biaya',
        'waktu_penyelesaian',
        'gambar',
        'file',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'file' => 'array',
        'is_active' => 'boolean',
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

    /**
     * Scope a query to only include active layanan.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the URL to the layanan's image.
     *
     * @return string
     */
    public function getImageUrlAttribute()
    {
        return $this->gambar ? \Storage::url($this->gambar) : null;
    }

    /**
     * Get the excerpt of the description.
     *
     * @param  int  $length
     * @return string
     */
    public function excerpt($length = 100)
    {
        return \Illuminate\Support\Str::limit(strip_tags($this->deskripsi), $length);
    }
}
