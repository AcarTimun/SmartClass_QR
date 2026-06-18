<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';

    protected $fillable = [
        'jadwal_kuliah_id',
        'pertemuan',
        'qr_token',
        'status',
    ];

    public function jadwalKuliah()
    {
        return $this->belongsTo(JadwalKuliah::class);
    }

    public function kehadiran()
    {
        return $this->hasMany(Kehadiran::class);
    }
}