<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'team_id',
        'name',
        'slug',
    ];



    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the team that owns the tag.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    /**
     * The posts that belong to the tag.
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag')
            ->using(PostTag::class)
            ->withPivot('team_id')
            ->withTimestamps();
    }

    /**
     * Scope a query to only include tags with posts.
     */
    public function scopeHasPosts($query)
    {
        return $query->whereHas('posts', function ($q) {
            $q->published();
        });
    }

    /**
     * Scope a query to order tags by name.
     */
    public function scopeOrderByName($query, $direction = 'asc')
    {
        return $query->orderBy('name', $direction);
    }
}
