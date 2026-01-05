<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public const ROLE_SUPERADMIN = 'superadmin';
    public const ROLE_ADMIN = 'admin';
    public const ROLE_PARTICIPANT = 'participant';
    public const ROLE_MARKETING = 'marketing';

    public static function manageableRoles(): array
    {
        // role yang boleh dibuat/diatur oleh superadmin
        return [
            self::ROLE_ADMIN,
            self::ROLE_MARKETING,
            self::ROLE_PARTICIPANT,
            // kalau mau superadmin bisa bikin superadmin juga, tambahkan:
            // self::ROLE_SUPERADMIN,
        ];
    }

    public static function roles(): array
    {
        return [self::ROLE_SUPERADMIN, self::ROLE_ADMIN, self::ROLE_PARTICIPANT, self::ROLE_MARKETING];
    }

     public function isSuperadmin(): bool
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isParticipant(): bool
    {
        return $this->role === self::ROLE_PARTICIPANT;
    }

    public function isMarketing(): bool
    {
        return $this->role === self::ROLE_MARKETING;
    }
}
