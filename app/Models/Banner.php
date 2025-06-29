<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'judul',
        'keterangan',
        'gambar',
        'is_active',
    ];

    protected $appends = ['image_url', 'gambar_url']; // Menambahkan accessor ke JSON output

    protected $dates = ['published_at'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];


    /**
     * Get the default image URL
     *
     * @return string
     */
    protected function getDefaultImageUrl()
    {
        return asset('assets/images/placeholder.jpg');
    }

    // Scope untuk banner aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the URL for the banner image
     *
     * Metode ini menangani berbagai format penyimpanan gambar banner:
     * - Gambar kosong atau null
     * - URL lengkap
     * - JSON placeholder
     * - Nama file di storage
     * - Path relatif dengan awalan 'banners/'
     *
     * @return string URL gambar banner atau gambar default jika tidak ditemukan
     */
    public function getImageUrlAttribute()
    {
        // Jika tidak ada gambar atau string kosong, kembalikan gambar default
        if (empty($this->gambar) || $this->gambar === '') {
            return $this->getDefaultImageUrl();
        }

        // Jika gambar adalah URL lengkap, kembalikan langsung
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }

        // Cek apakah gambar adalah JSON placeholder
        if (is_string($this->gambar) && $this->isJsonPlaceholder($this->gambar)) {
            return $this->getDefaultImageUrl();
        }

        // Cek di storage dengan path lengkap
        $filename = basename($this->gambar);
        $storagePath = 'public/banners/' . $filename;

        if (file_exists(storage_path('app/' . $storagePath))) {
            return asset('storage/banners/' . $filename);
        }

        // Cek jika path dimulai dengan 'banners/'
        if (str_starts_with($this->gambar, 'banners/')) {
            $filename = basename($this->gambar);
            if (file_exists(storage_path('app/public/banners/' . $filename))) {
                return asset('storage/banners/' . $filename);
            }
        }

        // Fallback ke gambar default
        return $this->getDefaultImageUrl();
    }

    /**
     * Alias untuk getImageUrlAttribute untuk kompatibilitas dengan kode yang ada
     *
     * @return string URL gambar banner
     */
    public function getGambarUrlAttribute()
    {
        return $this->getImageUrlAttribute();
    }

    /**
     * Memeriksa apakah string adalah JSON placeholder
     *
     * @param string $string String yang akan diperiksa
     * @return bool True jika string adalah JSON placeholder
     */
    protected function isJsonPlaceholder($string)
    {
        $data = json_decode($string, true);
        return json_last_error() === JSON_ERROR_NONE &&
            is_array($data) &&
            (isset($data['type']) && $data['type'] === 'placeholder');
    }
}
