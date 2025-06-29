<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Infografis extends Model
{
    use SoftDeletes;

    protected $table = 'infografis';
    protected $fillable = [
        'judul',
        'gambar',
        'kategori',
        'is_active',
    ];

    protected $dates = [
        'deleted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // public function team(): BelongsTo
    // {
    //     return $this->belongsTo(Team::class);
    // }
}
