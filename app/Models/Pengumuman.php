<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Pengumuman extends Model
{
    use SoftDeletes;
    
    protected $table = 'pengumuman';
    
    protected $fillable = [
        'team_id',
        'judul',
        'slug',
        'isi',
        'file',
        'is_active',
        'published_at'
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($pengumuman) {
            if (empty($pengumuman->slug)) {
                $pengumuman->slug = Str::slug($pengumuman->judul);
            }
        });

        static::updating(function ($pengumuman) {
            if ($pengumuman->isDirty('judul') && empty($pengumuman->slug)) {
                $pengumuman->slug = Str::slug($pengumuman->judul);
            }
        });
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePublished($query)
    {
        return $query->where('is_active', true)
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function($q) use ($search) {
            $q->where('judul', 'like', "%{$search}%")
              ->orWhere('isi', 'like', "%{$search}%");
        });
    }

    public function getExcerptAttribute($length = 160)
    {
        $text = strip_tags($this->isi);
        return Str::limit($text, $length);
    }
}
