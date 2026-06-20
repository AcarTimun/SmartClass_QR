<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class SesiPresensi extends Model
{
    protected $table = 'sesi_presensi';

    // Durasi QR aktif dalam menit
    const QR_DURATION_MINUTES = 10;

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
        if ($this->status !== 'dibuka') {
            return false;
        }

        return Carbon::now()->lessThan(
            $this->updated_at->addMinutes(self::QR_DURATION_MINUTES)
        );
    }

    /**
     * Sisa waktu QR dalam detik (untuk countdown timer)
     */
    public function getRemainingSeconds()
    {
        if ($this->status !== 'dibuka') {
            return 0;
        }

        $expiresAt = $this->updated_at->addMinutes(self::QR_DURATION_MINUTES);
        $remaining = Carbon::now()->diffInSeconds($expiresAt, false);

        return max(0, (int) $remaining);
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
