<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostImage extends Model
{
    protected $fillable = [
        'team_id',
        'post_id',
        'image_path',
        'caption',
        'description',
        'order',
        'is_featured',
    ];
    
    protected $appends = ['image_url'];
    
    protected $casts = [
        'order' => 'integer',
        'is_featured' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
    
    /**
     * Get the URL for the image.
     * Supports both local storage and full URLs.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }
        
        if (strpos($this->image_path, 'http') === 0) {
            return $this->image_path;
        }

        return asset('storage/' . ltrim($this->image_path, '/'));
    }
    
    /**
     * Get the team that owns the post image.
     */
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * Get the post that owns the image.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope a query to only include featured images.
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope a query to order images by order column.
     */
    public function scopeOrdered($query, string $direction = 'asc')
    {
        return $query->orderBy('order', $direction);
    }
}
