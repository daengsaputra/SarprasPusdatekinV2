<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    public const ROLE_PEMINJAM = 'peminjam';
    public const ROLE_PETUGAS = 'petugas';
    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_LABELS = [
        self::ROLE_PEMINJAM => 'Pegawai',
        self::ROLE_PETUGAS => 'Admin Sarpras',
        self::ROLE_SUPER_ADMIN => 'Super Admin',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nip',
        'username_intra',
        'name',
        'email',
        'password',
        'role',
        'photo',
        'photo_url',
        'jabatan',
        'unit_kerja',
        'last_sso_login_at',
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
            'last_sso_login_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function roleValues(): array
    {
        return array_keys(self::ROLE_LABELS);
    }

    public function getRoleLabelAttribute(): string
    {
        return self::ROLE_LABELS[$this->role] ?? ucfirst(str_replace('_', ' ', (string) $this->role));
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isPetugas(): bool
    {
        return $this->role === self::ROLE_PETUGAS;
    }

    public function isPeminjam(): bool
    {
        return $this->role === self::ROLE_PEMINJAM;
    }
}
