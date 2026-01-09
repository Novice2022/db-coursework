<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'client_id',
        'role_id'
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

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientsModel::class, 'client_id');
    }
    
    public function role(): BelongsTo
    {
        return $this->belongsTo(RoleModel::class, 'role_id');
    }
    
    public function isClient(): bool
    {
        return $this->role_id === 1;
    }

    public function isManager(): bool
    {
        return $this->role_id === 2;
    }

    public function isAnalyst(): bool
    {
        return $this->role_id === 3;
    }

    public function isAdmin(): bool
    {
        return $this->role_id === 4;
    }

    public function isRegisteredUser(): bool
    {
        return $this->role_id === 1;
    }

    public function getRoleName(): string
    {
        return match($this->role_id) {
            1 => 'Клиент',
            2 => 'Менеджер',
            3 => 'Аналитик',
            4 => 'Администратор',
            default => 'Неизвестно',
        };
    }
}
