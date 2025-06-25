<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';
    protected $fillable = [
        'team_id',
        'judul',
        'keterangan',
        'gambar',
        'is_active',
    ];

    protected $dates = ['published_at'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    // Scope untuk banner aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the URL for the banner image
     *
     * @return string
     */
    public function getGambarUrlAttribute()
    {
        if (empty($this->gambar)) {
            // Return a default placeholder if no image is set
            return json_encode([
                'type' => 'placeholder',
                'bg_color' => 'bg-gray-200',
                'text' => 'Banner tidak tersedia',
                'icon' => 'image'
            ]);
        }

        // If the image is a full URL, return it directly
        if (filter_var($this->gambar, FILTER_VALIDATE_URL)) {
            return $this->gambar;
        }

        // Check if the image is a placeholder JSON
        $placeholderData = json_decode($this->gambar, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($placeholderData) && isset($placeholderData['type']) && $placeholderData['type'] === 'placeholder') {
            return $this->gambar;
        }

        // Return the full URL for the stored image
        return asset('storage/banners/' . $this->gambar);
    }
}
