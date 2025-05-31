<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Edukasi;
use App\Models\Pengajuan;
use App\Models\Jadwal;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'telepon',
        'kbli',
        'siinas',
        'alamat',
        'verifikasi',
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
        'verifikasi' => 'boolean',
    ];

    public function isAdmin()
    {
        return $this->email === 'disperindag@jemberkab.go.id';
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function edukasi(): HasMany
    {
        return $this->hasMany(Edukasi::class);
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function pendaftaranPelatihan(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }
}
