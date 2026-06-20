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

        // sesi aktif
        $sesiAktif = SesiPresensi::where('status', 'dibuka')->count();

        // total sesi (semua pertemuan)
        $totalSesi = SesiPresensi::count();

        return view('dosen.dashboard', compact(
            'totalJadwal',
            'sesiAktif',
            'totalSesi'
        ));
    }
}
