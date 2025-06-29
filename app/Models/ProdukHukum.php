<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Team;

class ProdukHukum extends Model
{
    use SoftDeletes;

    protected $table = 'produk_hukums';

    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'file',
    ];


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
