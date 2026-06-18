<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JadwalKuliah extends Model
{
    use HasFactory;
    protected $table = 'jadwal_kuliah';

    protected $fillable = [
        'dosen_id',
        'mata_kuliah_id',
        'kelas_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function dosen()
    {
        return $this->belongsTo(Dosen::class);
    }

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function sesiPresensi()
    {
        return $this->hasOne(SesiPresensi::class)->latestOfMany();
    }
}
