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
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
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


    public static function getFirst()
    {
        return static::first();
    }
}
