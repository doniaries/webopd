<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'title',
        'slug',
        'content',
        'foto_utama',
        'foto_tambahan',
        'category_id',
        'user_id',
        'status',
        'published_at',
        'views',
        'is_featured',
    ];

    protected $with = ['category', 'user', 'categories'];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'foto_tambahan' => 'array',
    ];

    protected $appends = ['foto_utama_url', 'foto_tambahan_urls', 'excerpt'];

    /**
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            // Check if slug exists for this team and make it unique if needed
            $originalSlug = $post->slug;
            $count = 1;

            // Check if the slug already exists for this team
            while (static::where('team_id', $post->team_id)
                ->where('slug', $post->slug)
                ->exists()
            ) {
                $post->slug = $originalSlug . '-' . $count++;
            }

            if ($post->status === 'published' && !$post->published_at) {
                $post->published_at = now();
            }
        });

        static::updating(function ($post) {
            if ($post->isDirty('title') && empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }

            // If slug is being updated, ensure it's unique for this team
            if ($post->isDirty('slug')) {
                $originalSlug = $post->slug;
                $count = 1;

                // Check if the slug already exists for this team (excluding current post)
                while (static::where('team_id', $post->team_id)
                    ->where('slug', $post->slug)
                    ->where('id', '!=', $post->id)
                    ->exists()
                ) {
                    $post->slug = $originalSlug . '-' . $count++;
                }
            }

            if ($post->isDirty('status') && $post->status === 'published' && !$post->published_at) {
                $post->published_at = now();
            }
        });
    }

    /**
     * Get the excerpt attribute.
     */
    public function getExcerptAttribute()
    {
        return Str::limit(strip_tags($this->content), 200);
    }

    /**
     * Get the categories for the post.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'post_categories', 'post_id', 'category_id');
    }

    /**
     * Get the URL for the main photo (foto utama).
     */
    public function getFotoUtamaUrlAttribute()
    {
        // Gunakan foto_utama dari tabel posts
        if ($this->foto_utama) {
            // Jika sudah full URL, langsung kembalikan
            if (filter_var($this->foto_utama, FILTER_VALIDATE_URL)) {
                return $this->foto_utama;
            }

            // Pastikan path relatif ke storage
            $imagePath = trim($this->foto_utama, '/');

            // Periksa apakah file ada di storage
            if (Storage::disk('public')->exists($imagePath)) {
                return asset('storage/' . $imagePath);
            }

            // Jika tidak ditemukan, coba di foto-utama
            if (strpos($imagePath, 'foto-utama/') === false) {
                $imagePath = 'foto-utama/' . $imagePath;
                if (Storage::disk('public')->exists($imagePath)) {
                    return asset('storage/' . $imagePath);
                }
            }
        }

        return null;
    }

    /**
     * Get the additional photos with full URLs
     *
     * @return array|null
     */
    public function getFotoTambahanUrlsAttribute()
    {
        if (empty($this->foto_tambahan)) {
            return [];
        }

        $photos = is_array($this->foto_tambahan) ? $this->foto_tambahan : json_decode($this->foto_tambahan, true);

        return collect($photos)->map(function ($photo) {
            if (filter_var($photo, FILTER_VALIDATE_URL)) {
                return $photo;
            }

            $imagePath = trim($photo, '/');
            if (Storage::disk('public')->exists($imagePath)) {
                return asset('storage/' . $imagePath);
            }

            if (strpos($imagePath, 'foto-tambahan/') === false) {
                $imagePath = 'foto-tambahan/' . $imagePath;
                if (Storage::disk('public')->exists($imagePath)) {
                    return asset('storage/' . $imagePath);
                }
            }

            return $photo; // Return as is if not found in storage
        })->toArray();
    }

    /**
     * Get the team that owns the post.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get all of the images for the post.
     */
    public function images(): HasMany
    {
        return $this->hasMany(PostImage::class)->orderBy('order');
    }

    /**
     * Get the featured images for the post.
     */
    public function featuredImages(): HasMany
    {
        return $this->images()->where('is_featured', true);
    }

    /**
     * Get the category that owns the post.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }


    /**
     * Get the user that owns the post.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the main featured image for the post.
     */
    public function featuredImage(): HasOne
    {
        return $this->hasOne(PostImage::class)->where('is_featured', true);
    }

    /**
     * The tags that belong to the post.
     */
    /**
     * The tags that belong to the post.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag')
            ->using(PostTag::class)
            ->withPivot('team_id')
            ->withTimestamps();
    }


    /**
     * Scope a query to only include published posts.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published')
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
     * Scope a query to only include posts from a specific category.
     */
    public function scopeInCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
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
