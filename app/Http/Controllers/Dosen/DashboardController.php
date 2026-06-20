<?php

namespace App\Http\Controllers\Dosen;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalKuliah;
use App\Models\SesiPresensi;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // ambil dosen dari user
        $dosen = $user->dosen;

        // jumlah jadwal
        $totalJadwal = JadwalKuliah::where('dosen_id', $dosen->id)->count();

        // ID jadwal milik dosen ini
        $dosenJadwalIds = JadwalKuliah::where('dosen_id', $dosen->id)->pluck('id');

        // sesi aktif (hanya milik dosen ini)
        $sesiAktif = SesiPresensi::whereIn('jadwal_kuliah_id', $dosenJadwalIds)
            ->where('status', 'dibuka')->count();

        // total sesi (hanya milik dosen ini)
        $totalSesi = SesiPresensi::whereIn('jadwal_kuliah_id', $dosenJadwalIds)->count();

        return view('dosen.dashboard', compact(
            'totalJadwal',
            'sesiAktif',
            'totalSesi'
        ));
    }
}
