<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Informasi extends Model
{
    use HasFactory, SoftDeletes, HasSlug;

    protected $table = 'informasis';

    protected $fillable = [
        // 'team_id',
        'judul',
        'slug',
        'isi',
        'file',
        'views',
        'downloads',
        'published_at',
    ];
    
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // public function team(): BelongsTo
    // {
    //     return $this->belongsTo(Team::class);
    // }

    /**
     * Scope a query to only include published information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
            ->whereNotNull('published_at');
    }
}
