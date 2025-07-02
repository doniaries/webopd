<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Post;

class Tag extends Model
{
    use SoftDeletes, HasSlug;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'name';
    
    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';

    /**
     * The posts that belong to the tag.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class, 'post_tag')
            ->withTimestamps();
    }


    public function scopeHasPosts($query)
    {
        return $query->whereHas('posts', function ($q) {
            $q->published();
        });
    }


    public function scopeOrderByName($query, $direction = 'asc')
    {
        return $query->orderBy('name', $direction);
    }
}
