<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property string $name
 * @property string $email
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property bool $is_active
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property Carbon|null $two_factor_confirmed_at
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
#[Fillable([
    'name',
    'nama_depan',
    'nama_belakang',
    'email',
    'password',
    'role',
    'is_active',
    'no_hp',
    'alamat',
    'tanggal_lahir',
    'provinsi',
    'kota',
    'kode_pos',
    'foto_profil',
    'bahasa',
])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

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
            'tanggal_lahir' => 'date',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Get avatar url or null
     */
    public function getAvatarUrlAttribute(): ?string
    {
        if ($this->foto_profil) {
            return asset('storage/'.$this->foto_profil);
        }

        return null;
    }

    /**
     * Fallback for first name
     */
    public function getResolvedNamaDepanAttribute(): string
    {
        if (! empty($this->nama_depan)) {
            return $this->nama_depan;
        }

        $parts = explode(' ', trim($this->name ?? ''), 2);

        return $parts[0] ?? '';
    }

    /**
     * Fallback for last name
     */
    public function getResolvedNamaBelakangAttribute(): string
    {
        if (! empty($this->nama_belakang)) {
            return $this->nama_belakang;
        }

        $parts = explode(' ', trim($this->name ?? ''), 2);

        return $parts[1] ?? '';
    }

    /**
     * Get the user's initials
     */
    public function initials(): string
    {
        $initials = Str::initials($this->name, true);

        return Str::length($initials) > 1
            ? Str::substr($initials, 0, 1).Str::substr($initials, -1)
            : $initials;
    }

    /**
     * Get the user's initials
     */
    public function kampanyes()
    {
        return $this->hasMany(Kampanye::class);
    }

    public function donasis()
    {
        return $this->hasMany(Donasi::class);
    }

    public function komentars()
    {
        return $this->hasMany(Komentar::class);
    }

    public function penarikanDanas()
    {
        return $this->hasMany(PenarikanDana::class);
    }

    public function rekeningBanks()
    {
        return $this->hasMany(RekeningBank::class);
    }
}
