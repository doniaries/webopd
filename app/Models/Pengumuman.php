<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Pengumuman extends Model
{
    use SoftDeletes;

    protected $table = 'pengumumen';

    protected $fillable = [
        'team_id',
        'judul',
        'slug',
        'isi',
        'file',
        'is_active',
        'published_at'
    ];

    protected $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        // Add global scope for team filtering
        static::addGlobalScope('team', function ($builder) {
            $teamId = 1; // Default team_id
            
            if (Auth::check() && Auth::user()->current_team_id) {
                $teamId = Auth::user()->current_team_id;
            }
            
            $builder->where(function($query) use ($teamId) {
                $query->where('team_id', $teamId)
                      ->orWhere('team_id', 1) // Always include team_id = 1
                      ->orWhereNull('team_id');
            });
        });

        static::creating(function ($pengumuman) {
            if (empty($pengumuman->slug)) {
                $pengumuman->slug = Str::slug($pengumuman->judul);
            }

            // Set team_id if not set
            if (empty($pengumuman->team_id)) {
                $pengumuman->team_id = Auth::check() ? Auth::user()->current_team_id : 1;
            }
        });

        static::updating(function ($pengumuman) {
            if ($pengumuman->isDirty('judul') && empty($pengumuman->slug)) {
                $pengumuman->slug = Str::slug($pengumuman->judul);
            }
        });

        // Global scope untuk memastikan hanya data dari team yang sesuai yang diambil
        static::addGlobalScope('team', function ($builder) {
            if (Auth::check()) {
                $builder->where('team_id', Auth::user()->current_team_id);
            } else {
                $builder->whereNull('team_id');
            }
        });
    }

    /**
     * Get the team that owns the pengumuman.
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
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
     * Scope a query to only include active pengumuman.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to only include published pengumuman.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    /**
     * Scope a query to only include pengumuman for a specific team.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int|null  $teamId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForTeam($query, $teamId = null)
    {
        if (!$teamId && Auth::check()) {
            $teamId = Auth::user()->current_team_id;
        }

        return $query->where('team_id', $teamId);
    }

    /**
     * Scope a query to only include pengumuman for the current user's team.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeForCurrentTeam($query)
    {
        $teamId = 1; // Default team_id
        
        if (Auth::check() && Auth::user()->current_team_id) {
            $teamId = Auth::user()->current_team_id;
        }
        
        return $query->where(function($q) use ($teamId) {
            $q->where('team_id', $teamId)
              ->orWhere('team_id', 1); // Always include team_id=1
        });
    }

    /**
     * Scope a query to search pengumuman by title or content.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $searchTerm
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $searchTerm)
    {
        if ($searchTerm) {
            return $query->where(function($q) use ($searchTerm) {
                $searchTerm = '%' . $searchTerm . '%';
                $q->where('judul', 'like', $searchTerm)
                  ->orWhere('isi', 'like', $searchTerm);
            });
        }
        
        return $query;
    }

    /**
     * Get the excerpt of the content.
     *
     * @param  int  $length
     * @return string
     */
    public function getExcerptAttribute($length = 160)
    {
        $text = strip_tags($this->isi);
        return Str::limit($text, $length);
    }
}
