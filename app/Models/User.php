<?php

namespace App\Models;

use BezhanSalleh\FilamentShield\Traits\HasPanelShield;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable, HasRoles, HasPanelShield;

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Get the external links for the user.
     */
    public function externalLinks()
    {
        return $this->hasMany(ExternalLink::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->hasRole('super_admin') || $this->hasRole('admin') || $this->hasRole('editor');
    }
    
    public function getAllPermissions()
    {
        $permissions = $this->permissions->pluck('name');
        
        foreach ($this->roles as $role) {
            $permissions = $permissions->merge($role->permissions->pluck('name'));
        }
        
        return $permissions->unique()->values();
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    protected static function booted()
    {
        static::creating(function ($user) {
            $user->is_active = true;
        });
    }
}
