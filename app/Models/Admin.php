<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Pengajuan;
use App\Models\Jadwal;
use App\Models\Faq;
use App\Models\Komoditas;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admin';

    protected $fillable = [
        'nama',
        'username',
        'email',
        'password',
        'telepon',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function pengajuan(): HasMany
    {
        return $this->hasMany(Pengajuan::class);
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    public function faq(): HasMany
    {
        return $this->hasMany(Faq::class);
    }

    public function komoditas(): HasMany
    {
        return $this->hasMany(Komoditas::class);
    }
}
