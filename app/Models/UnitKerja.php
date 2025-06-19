<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UnitKerja extends Model
{
    use SoftDeletes;
    protected $table = 'unit_kerjas';
    protected $fillable = [
        'team_id',
        'nama_unit',
        'slug',
    ];

    protected $dates = ['published_at'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
