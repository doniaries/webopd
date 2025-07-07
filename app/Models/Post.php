<?php

namespace App\Models;

use App\Models\PostTag;
use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'foto_utama',
        'user_id',
        'status',
        'published_at',
        'views',
        'is_featured',
    ];

    protected $with = ['user', 'tags', 'PostGallery'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'title';

    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';

    protected $appends = ['foto_utama_url', 'excerpt'];


    /**
     * The slider that this post belongs to.
     * @return BelongsTo<Slider, Post>
     */
    public function slider(): BelongsTo
    {
        return $this->belongsTo(Slider::class, 'slider_id');
    }



    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 200);
    }

    /**
     * Get the URL for the main photo (foto utama).
     * @return string URL gambar atau gambar default jika tidak ada
     */
    public function getFotoUtamaUrlAttribute()
    {
        // Jika tidak ada foto_utama, kembalikan placeholder
        if (empty($this->foto_utama)) {
            return $this->getDefaultPlaceholder();
        }

        // Jika sudah full URL, langsung kembalikan
        if (filter_var($this->foto_utama, FILTER_VALIDATE_URL)) {
            return $this->foto_utama;
        }

        // Cek jika ini adalah placeholder data
        $placeholderData = json_decode($this->foto_utama, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($placeholderData) && isset($placeholderData['type']) && $placeholderData['type'] === 'placeholder') {
            return $this->foto_utama;
        }

        // Pastikan path relatif ke storage
        $imagePath = ltrim($this->foto_utama, '/');

        // Coba berbagai lokasi penyimpanan
        $possiblePaths = [
            $imagePath,
            'foto-utama/' . basename($imagePath),
            'storage/' . $imagePath,
            'storage/foto-utama/' . basename($imagePath)
        ];

        foreach ($possiblePaths as $path) {
            $fullPath = public_path($path);
            if (file_exists($fullPath)) {
                return asset($path);
            }
        }

        // Jika tidak ditemukan di storage, coba cek di direktori public
        if (strpos($imagePath, 'public/') === 0) {
            $publicPath = str_replace('public/', '', $imagePath);
            if (file_exists(public_path($publicPath))) {
                return asset($publicPath);
            }
        }

        // Jika masih tidak ditemukan, kembalikan placeholder
        return $this->getDefaultPlaceholder();
    }

    /**
     * Get default placeholder data
     */
    protected function getDefaultPlaceholder()
    {
        return json_encode([
            'type' => 'placeholder',
            'html' => '
                <div style="width: 100%; height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; background-color: #f3f4f6; color: #6b7280; padding: 1rem; text-align: center;">
                    <svg class="w-16 h-16 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm font-medium">Tidak ada gambar</span>
                </div>
            ',
            'bg_color' => '#f3f4f6',
            'text' => 'Tidak ada gambar',
            'color' => '#6b7280',
            'class' => 'w-full h-full'
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function postGallery()
    {
        return $this->hasMany(PostGallery::class);
    }

    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Relasi many-to-many ke Tag.
     * Mendapatkan semua tag yang terkait dengan post ini.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag')
            ->withTimestamps();
    }


    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        // Pastikan status adalah 'published' (case sensitive) dan published_at tidak null dan <= now
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include featured posts.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to only include posts from a specific tag.
     */
    public function scopeInTag($query, $tagId)
    {
        return $query->whereHas('tags', function ($q) use ($tagId) {
            $q->where('tags.id', $tagId);
        });
    }

    /**
     * Scope a query to order posts by most viewed.
     */
    public function scopeMostViewed($query, $limit = 5)
    {
        return $query->orderBy('views', 'desc')->limit($limit);
    }

    /**
     * Scope a query to order posts by latest.
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('published_at', 'desc');
    }

    /**
     * Increment the view count for the post.
     */
    public function incrementViewCount()
    {
        $this->increment('views');
    }
}
