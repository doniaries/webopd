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
        'persyaratan',
        'biaya',
        'waktu_penyelesaian',
        'file',
    ];

    protected $casts = [
        'file' => 'string',
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
     * Get the URL to the layanan's file.
     *
     * @return string|null
     */
    public function getFileUrlAttribute()
    {
        return $this->file ? \Storage::url($this->file) : null;
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
