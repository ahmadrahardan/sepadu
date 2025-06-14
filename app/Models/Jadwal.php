<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Admin;
use App\Models\Pendaftaran;
use App\Models\Komoditas;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Jadwal extends Model
{
    use HasFactory;

    protected $table = 'jadwal';

    protected $fillable = ['admin_id', 'topik', 'deskripsi', 'tanggal', 'pukul', 'lokasi', 'kuota', 'komoditas_id'];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'amdin_id');
    }

    public function pendaftaran(): HasMany
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function komoditas(): BelongsTo
    {
        return $this->belongsTo(Komoditas::class);
    }

    public function pesertas(): HasManyThrough
    {
        return $this->hasManyThrough(Peserta::class, Pendaftaran::class);
    }
}
