<?php

namespace App\Models;

use Illuminate\Support\Carbon;
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

    public function isDibuka()
    {
        // if ($this->status !== 'dibuka') {
        //     return false;
        // }

        // return Carbon::now()->lessThan(
        //     $this->created_at->addMinutes(30)
        // );

        return $this->status === 'dibuka';
    }

    public function getStatusLabelAttribute()
    {
        if ($this->isDibuka()) {
            return 'Dibuka';
        }

        if ($this->status === 'dibuka') {
            return 'Expired';
        }

        return 'Ditutup';
    }

    public function getPertemuanLabelAttribute()
    {
        if ($this->pertemuan >= 1 && $this->pertemuan <= 7) {
            return 'Pertemuan ' . $this->pertemuan;
        } elseif ($this->pertemuan == 8) {
            return 'UTS';
        } elseif ($this->pertemuan >= 9 && $this->pertemuan <= 15) {
            return 'Pertemuan ' . ($this->pertemuan - 1);
        } elseif ($this->pertemuan == 16) {
            return 'UAS';
        }
        return 'Pertemuan ' . $this->pertemuan;
    }

}
