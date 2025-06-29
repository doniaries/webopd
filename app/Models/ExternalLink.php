<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalLink extends Model
{
    protected $fillable = [
        'nama',
        'url',
        'icon',
        'deskripsi',
        'status',
        'urutan'
    ];

    protected $casts = [
        'status' => 'string',
        'urutan' => 'integer'
    ];

    /**
     * Get the user that owns the external link.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
