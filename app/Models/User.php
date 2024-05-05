<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use Filament\Facades\Filament;
use Filament\Models\Contracts\HasName;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser, HasName, HasAvatar
{
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_active',
        'settings',
        'avatar_url',
        'created_at',
        'updated_at',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_admin'          => 'boolean',
            'is_active'         => 'boolean',
            'settings'          => 'array',
            'created_at'        => 'datetime:d/m/Y H:i:s',
            'updated_at'        => 'datetime:d/m/Y H:i:s',
            'deleted_at'        => 'datetime:d/m/Y H:i:s'
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($user) {
            $user->is_admin = false;
            $user->is_active = true;
            $user->email_verified_at = now();
            $user->created_at = now();
            $user->updated_at = now();
            $user->settings = null;
        });
    }

    public function getFilamentName(): string
    {
        return $this->name;
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url
            ? env('APP_URL') . '/storage/' . $this->avatar_url
            : 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($this->email))) . '?d=mp';
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isActive() && $this->hasVerifiedEmail();
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function contas(): HasMany
    {
        return $this->hasMany(Conta::class);
    }

    public function categorias(): HasMany
    {
        return $this->hasMany(Categoria::class);
    }

    public function tipoDocumentos(): HasMany
    {
        return $this->hasMany(TipoDocumento::class);
    }

    public function movimentos(): HasMany
    {
        return $this->hasMany(Movimento::class);
    }
}
