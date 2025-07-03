<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'gambar',
        'is_active',
    ];

    protected $appends = ['image_url']; // Menambahkan accessor ke JSON output

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the default image URL
     *
     * @return string
     */
    protected function getDefaultImageUrl()
    {
        return asset('assets/images/placeholder2.jpg');
    }

    // Scope untuk banner aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the URL for the banner image
     *
     * @return string URL gambar banner atau gambar default jika tidak ditemukan
     */
    public function getImageUrlAttribute()
    {
        if (empty($this->gambar)) {
            return $this->getDefaultImageUrl();
        }

        // Jika gambar adalah URL lengkap
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }

        // Jika gambar sudah mengandung 'storage/banners/'
        if (Str::startsWith($this->gambar, 'storage/banners/')) {
            return asset($this->gambar);
        }

        // Jika gambar sudah mengandung 'banners/'
        if (Str::startsWith($this->gambar, 'banners/')) {
            return asset('storage/' . $this->gambar);
        }

        // Jika gambar hanya nama file saja
        return asset('storage/banners/' . $this->gambar);
    }
}
