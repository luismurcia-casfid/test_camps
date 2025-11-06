<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasTenants;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser, HasTenants
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
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
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function tags(): MorphToMany
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    /**
     * Determina si el usuario puede acceder al panel de Filament
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Panel Admin: solo super_admin, administrador y monitor
        if ($panel->getId() === 'admin') {
            return $this->hasAnyRole(['super_admin', 'administrador', 'monitor']);
        }

        // Panel Gestor: solo gestor, super_admin y administrador
        if ($panel->getId() === 'gestor') {
            return $this->hasAnyRole(['super_admin', 'administrador', 'gestor']);
        }

        return false;
    }

    public function teams(): Collection
    {
        return Course::all();
    }

    public function getTenants(Panel $panel): Collection
    {
        return $this->teams();
    }

    /**
     * Verifica si el usuario puede acceder a un tenant específico
     * OPCIÓN 2: Permite acceso a cualquier curso
     */
    public function canAccessTenant(EloquentModel $tenant): bool
    {
        return true;
    }
}
