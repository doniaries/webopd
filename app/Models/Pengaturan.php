<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengaturan extends Model
{
    protected $table = 'pengaturans';

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'favicon',
        'kepala_instansi',
        'alamat_instansi',
        'no_telp_instansi',
        'email_instansi',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->name);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && empty($model->slug)) {
                $model->slug = \Illuminate\Support\Str::slug($model->name);
            }
        });
    }

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
