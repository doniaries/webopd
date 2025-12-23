<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaturan extends Model
{
    use HasSlug;

    protected $table = 'pengaturans';

    protected $fillable = [
        'name',
        'slug',
        'kabupaten',
        'logo',
        'kepala_instansi',
        'foto_pimpinan',
        'alamat_instansi',
        'no_telp_instansi',
        'email_instansi',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'latitude',
        'longitude',
        'active_theme',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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

    public static function getFirst()
    {
        return static::first();
    }
}
