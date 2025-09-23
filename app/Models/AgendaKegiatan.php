<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected $appends = ['nama_penyelenggara', 'status'];

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

    /**
     * Get the route key name for Laravel's route model binding.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getNamaPenyelenggaraAttribute()
    {
        return $this->penyelenggara ?? 'Tidak Diketahui';
    }

    /**
     * Computed status of the agenda based on dates and times.
     * - Mendatang: belum mulai
     * - Berlangsung: sedang dalam rentang tanggal (dan waktu jika ada)
     * - Selesai: sudah lewat tanggal selesai (atau lewat waktu selesai pada hari terakhir)
     */
    public function getStatusAttribute(): string
    {
        $today = Carbon::today();

        // Normalize dates
        $startDate = $this->dari_tanggal ? Carbon::parse($this->dari_tanggal) : null;
        $endDate = $this->sampai_tanggal ? Carbon::parse($this->sampai_tanggal) : $startDate;

        if (!$startDate) {
            return 'Mendatang';
        }

        // If fully before start
        if ($today->lt($startDate->copy()->startOfDay())) {
            return 'Mendatang';
        }

        // If after end date, it's finished
        if ($endDate && $today->gt($endDate->copy()->endOfDay())) {
            return 'Selesai';
        }

        // Same day checks for finer granularity by time
        if ($today->isSameDay($endDate)) {
            // If waktu_selesai is defined and already passed, mark finished
            if (!empty($this->waktu_selesai)) {
                $endTime = Carbon::parse($this->waktu_selesai);
                if (Carbon::now()->gt($endTime)) {
                    return 'Selesai';
                }
            }
        }

        return 'Berlangsung';
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
}
