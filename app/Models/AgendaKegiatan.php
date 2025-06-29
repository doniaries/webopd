<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AgendaKegiatan extends Model
{
    protected $table = 'agenda_kegiatans';

    protected $fillable = [
        'nama_agenda',
        'slug',
        'uraian_agenda',
        'tempat',
        'penyelenggara',
        'dari_tanggal',
        'waktu_mulai',
        'sampai_tanggal',
        'waktu_selesai',
    ];

    protected $dates = ['published_at', 'dari_tanggal', 'sampai_tanggal'];

    protected $casts = [
        'published_at' => 'datetime',
        'dari_tanggal' => 'date',
        'sampai_tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    protected $appends = ['nama_penyelenggara'];

    public function getNamaPenyelenggaraAttribute()
    {
        return $this->penyelenggara ?? 'Tidak Diketahui';
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            // Ensure penyelenggara is not empty
            if (empty($model->penyelenggara)) {
                $model->penyelenggara = 'Penyelenggara Tidak Diketahui';
            }
        });
    }



    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getSlugAttribute()
    {
        return Str::slug($this->nama_agenda);
    }
}
