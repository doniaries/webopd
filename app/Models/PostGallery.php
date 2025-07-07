<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostGallery extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'post_id',
        'image_path'
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute()
    {
        return $this->image_path ? asset('storage/' . $this->image_path) : null;
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
