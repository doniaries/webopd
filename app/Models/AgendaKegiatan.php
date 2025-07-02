<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;

class AgendaKegiatan extends Model
{
    use HasSlug;

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

    protected $casts = [
        'published_at' => 'datetime',
        'dari_tanggal' => 'date',
        'sampai_tanggal' => 'date',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    protected $appends = ['nama_penyelenggara'];

    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'nama_agenda';

    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';

    public function getNamaPenyelenggaraAttribute()
    {
        return $this->penyelenggara ?? 'Tidak Diketahui';
    }

    protected static function booted()
    {
        parent::booted();

        static::saving(function ($model) {
            // Ensure penyelenggara is not empty
            if (empty($model->penyelenggara)) {
                $model->penyelenggara = 'Penyelenggara Tidak Diketahui';
            }
        });
    }



    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
    
    /**
     * Get the value of the model's route key.
     *
     * @return mixed
     */
    public function getRouteKey()
    {
        return $this->slug;
    }


}
