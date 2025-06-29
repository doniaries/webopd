<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        // 'team_id',
        'nama_website',
        'logo_instansi',
        'favicon_instansi',
        'kepala_instansi',
        'alamat_instansi',
        'no_telp_instansi',
        'email_instansi',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
    ];

    /**
     * Get the team that owns the pengaturan.
     */
    // public function team(): BelongsTo
    // {
    //     return $this->belongsTo(Team::class);
    // }

    public static function getFirst()
    {
        return static::first();
    }
}
