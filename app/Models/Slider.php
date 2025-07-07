<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'post_id',
    ];

    protected $casts = [
        //
    ];



    // Accessor untuk URL gambar
    public function getGambarUrlAttribute()
    {
        // Jika gambar adalah URL lengkap (misalnya dari placeholder)
        if ($this->gambar && (str_starts_with($this->gambar, 'http://') || str_starts_with($this->gambar, 'https://'))) {
            return $this->gambar;
        }

        // Jika gambar ada di storage
        if ($this->gambar && file_exists(public_path('storage/' . $this->gambar))) {
            return asset('storage/' . $this->gambar);
        }

        // Kembalikan gambar default jika tidak ada
        return asset('assets/img/hero-img.png');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope a query to only include active sliders.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereHas('post', function ($q) {
            $q->where('status', 'published')
                ->where('published_at', '<=', now());
        });
    }
}
