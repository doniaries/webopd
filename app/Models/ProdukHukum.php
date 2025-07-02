<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProdukHukum extends Model
{
    use SoftDeletes, HasSlug;

    protected $table = 'produk_hukums';
    protected $slugSource = 'judul';
    protected $slugField = 'slug';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'file',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
}
