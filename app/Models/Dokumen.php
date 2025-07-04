<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Dokumen extends Model
{
    use HasSlug;
    
    protected $table = 'dokumens';
    protected $fillable = [
        'nama_dokumen',
        'slug',
        'deskripsi',
        'cover',
        'tahun_terbit',
        'file',
        'views',
        'downloads',
        'published_at',
    ];
    
    /**
     * The attributes that should be appended.
     *
     * @var array
     */
    protected $appends = ['file_url'];

    protected $casts = [
        'views' => 'integer',
        'downloads' => 'integer',
        'published_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'tahun_terbit' => 'date',
    ];
    
    /**
     * Get the file URL.
     *
     * @return string|null
     */
    /**
     * Get the file URL.
     *
     * @return string|null
     */
    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return null;
        }
        
        // Check if the file exists in storage
        if (Storage::disk('public')->exists($this->file)) {
            return Storage::url($this->file);
        }
        
        return null;
    }
    
    /**
     * Get the cover URL.
     *
     * @return string|null
     */
    public function getCoverUrlAttribute()
    {
        if (!$this->cover) {
            return null;
        }
        
        // Check if the cover exists in storage
        if (Storage::disk('public')->exists($this->cover)) {
            return Storage::url($this->cover);
        }
        
        return null;
    }
    
    /**
     * Boot the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Ensure the directories exist
            if (!Storage::disk('public')->exists('dokumen')) {
                Storage::disk('public')->makeDirectory('dokumen');
            }
            if (!Storage::disk('public')->exists('dokumen/covers')) {
                Storage::disk('public')->makeDirectory('dokumen/covers');
            }
        });
        
        static::deleting(function ($dokumen) {
            // Delete associated files when document is deleted
            if ($dokumen->file) {
                Storage::disk('public')->delete($dokumen->file);
            }
            if ($dokumen->cover) {
                Storage::disk('public')->delete($dokumen->cover);
            }
        });
    }
    
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
