<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use App\Models\Post;
use App\Models\Tag;

class PostTag extends Pivot
{
    protected $table = 'post_tag';

    protected $fillable = [
        'post_id',
        'tag_id',
    ];

    /**
     * Get the post that owns the pivot.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Get the tag that owns the pivot.
     */
    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
}
