<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\JadwalKuliah;

class KehadiranController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;

        // Ambil semua jadwal berdasarkan kelas mahasiswa
        // Eager load sesiPresensi + kehadiran hanya milik mahasiswa ini
        $jadwalList = JadwalKuliah::with([
                'mataKuliah',
                'sesiPresensi' => fn($q) => $q->orderBy('pertemuan'),
                'sesiPresensi.kehadiran' => fn($q) => $q->where('mahasiswa_id', $mahasiswa->id),
            ])
            ->where('kelas_id', $mahasiswa->kelas_id)
            ->get();

        // Mapping ke format rekap: per mata kuliah → array 16 status
        $rekap = $jadwalList->map(function ($jadwal) {
            $sesiMap = $jadwal->sesiPresensi->keyBy('pertemuan');

            $statuses = [];
            for ($i = 1; $i <= 16; $i++) {
                $sesi = $sesiMap->get($i);
                if (!$sesi) {
                    $statuses[] = '-';
                } else {
                    $kehadiran = $sesi->kehadiran->first();
                    $statuses[] = $kehadiran ? $kehadiran->status : '-';
                }
            }

            return [
                'kode_mk'    => $jadwal->mataKuliah->kode_mk,
                'nama_mk'    => $jadwal->mataKuliah->nama_mk,
                'jadwal_id'  => $jadwal->id,
                'statuses'   => $statuses,
                'total_hadir' => collect($statuses)->filter(fn($s) => $s === 'H')->count(),
            ];
        });

        return view('mahasiswa.kehadiran.index', compact('rekap'));
    }
}
