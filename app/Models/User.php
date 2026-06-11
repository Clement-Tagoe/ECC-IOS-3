<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Kirschbaum\Commentions\Contracts\Commenter;
use Mattiverse\Userstamps\Traits\Userstamps;
use Wirechat\Wirechat\Contracts\WirechatUser;
use Filament\Panel;
use Wirechat\Wirechat\Panel as WirechatPanel;
use Wirechat\Wirechat\Traits\InteractsWithWirechat;

class User extends Authenticatable implements FilamentUser, WirechatUser, Commenter
{
  
    use HasFactory, Notifiable, InteractsWithWirechat, SoftDeletes, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'contact',
        'role_id',
        'department_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function canAccessWirechatPanel(WirechatPanel $panel): bool
    {
        return true;
    }

    public function canCreateChats(): bool
    {
        return true;
    }

    public function canCreateGroups(): bool
    {
        return true;
    }

    public function getWirechatAvatarUrlAttribute(): string
    {
        return $this->avatar_url ?? asset('images/default-avatar.png');
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')->withTimestamps();
    }

    public function hasRole(string|array $roles): bool
    {
        $userRoleNames = $this->roles()->pluck('name')->toArray(); 
    
        return !empty(array_intersect(Arr::wrap($roles), $userRoleNames));
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
