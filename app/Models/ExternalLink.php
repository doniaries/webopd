<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExternalLink extends Model
{
    protected $fillable = [
        'name',
        'url',
        'icon',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
