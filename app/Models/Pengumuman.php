<?php

namespace App\Models;

use App\Traits\HasSlug;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pengumuman extends Model
{
    use SoftDeletes, HasSlug;

    protected $table = 'pengumumen';

    protected $fillable = [
        'judul',
        'slug',
        'isi',
        'file',
        'published_at',
        'views',
    ];

    protected static function boot()
    {
        parent::boot();
    }

    protected $appends = ['view_count_formatted'];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    /**
     * The field that should be used for generating the slug.
     *
     * @var string
     */
    protected $slugSource = 'judul';

    /**
     * The field where the slug is stored.
     *
     * @var string
     */
    protected $slugField = 'slug';

    /**
     * Increment the view count
     */
    public function incrementViewCount()
    {
        $this->increment('views');
    }

    /**
     * Get formatted view count
     */
    public function getViewCountFormattedAttribute()
    {
        $viewCount = $this->views ?? 0;

        if ($viewCount >= 1000000) {
            return number_format($viewCount / 1000000, 1) . 'jt';
        }

        if ($viewCount >= 1000) {
            return number_format($viewCount / 1000, 1) . 'rb';
        }

        return $viewCount;
    }

    public function getPublishedAtFormattedAttribute()
    {
        if (!$this->published_at) {
            return null;
        }

        $date = Carbon::parse($this->published_at)->timezone('Asia/Jakarta');
        $day = $date->isoFormat('dddd');
        $dayNumber = $date->day;
        $month = $date->isoFormat('MMMM');
        $year = $date->year;
        $time = $date->format('H:i');

        // Format: Senin, 3 Juli 2023 13:45 WIB
        return ucfirst($day) . ", $dayNumber $month $year $time WIB";
    }

    public function getPublishedAtDateAttribute()
    {
        if (!$this->published_at) {
            return null;
        }

        $date = Carbon::parse($this->published_at)->timezone('Asia/Jakarta');
        $day = $date->isoFormat('dddd');
        $dayNumber = $date->day;
        $month = $date->isoFormat('MMMM');
        $year = $date->year;

        // Format: Senin, 3 Juli 2023
        return ucfirst($day) . ", $dayNumber $month $year";
    }

    public function getFileUrlAttribute()
    {
        if (!$this->file) {
            return null;
        }

        return asset('storage/' . $this->file);
    }

    public function scopePublished($query)
    {
        return $query->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');
    }

    public function scopeLatestPublished($query, $limit = 5)
    {
        return $query->published()->limit($limit);
    }
}
