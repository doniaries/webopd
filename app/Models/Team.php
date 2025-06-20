<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Team extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'singkatan',
        'url_logo',
        'alamat',
        'nomor_telepon',
        'email_organisasi',
        'website_organisasi',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'is_active',
    ];

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withPivot(['id']); // jika memang perlu akses id pivot
    }


    /**
     * Get all of the posts for the team.
     */
    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the infographics for the team.
     */
    /**
     * Get all of the infographics for the team.
     */
    public function infografis(): BelongsToMany
    {
        return $this->belongsToMany(Infografis::class);
    }

    /**
     * Get all of the tags for the team.
     */
    public function tags(): HasMany
    {
        return $this->hasMany(Tag::class);
    }

    /**
     * Get the pengaturan associated with the team.
     */
    public function pengaturans(): HasOne
    {
        return $this->hasOne(Pengaturan::class);
    }

    public function agendas(): HasMany
    {
        return $this->hasMany(AgendaKegiatan::class);
    }

    public function visiMisis(): HasOne
    {
        return $this->hasOne(VisiMisi::class);
    }

    public function unitKerjas(): HasMany
    {
        return $this->hasMany(UnitKerja::class);
    }

    public function sambutanPimpinans(): HasOne
    {
        return $this->hasOne(SambutanPimpinan::class);
    }





    /**
     * Get all of the banners for the team.
     */
    public function banners(): HasMany
    {
        return $this->hasMany(Banner::class);
    }

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class);
    }

    /** @return HasMany<\App\Models\AgendaKegiatan, self> */
    public function agendaKegiatans(): HasMany
    {
        return $this->hasMany(\App\Models\AgendaKegiatan::class);
    }


    /** @return HasMany<\App\Models\Dokumen, self> */
    public function dokumens(): HasMany
    {
        return $this->hasMany(\App\Models\Dokumen::class);
    }


    /** @return HasMany<\App\Models\Pengumuman, self> */
    public function pengumumans(): HasMany

    {
        return $this->hasMany(\App\Models\Pengumuman::class);
    }


    /** @return HasMany<\App\Models\ProdukHukum, self> */
    public function produkHukums(): HasMany
    {
        return $this->hasMany(\App\Models\ProdukHukum::class);
    }
}
