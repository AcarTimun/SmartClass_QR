<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiPresensi;
use Illuminate\Support\Str;
use App\Models\JadwalKuliah;


class SesiPresensiController extends Controller
{
    public function buka($jadwal_id)
    {
        SesiPresensi::create([
            'jadwal_kuliah_id' => $jadwal_id,
            'pertemuan' => 1, // nanti bisa dinamis
            'qr_token' => Str::random(40),
            'status' => 'dibuka',
        ]);

        return redirect()->route('admin.presensi.qr', $sesi->qr_token);
    }

    public function qr($token)
    {
        $sesi = SesiPresensi::where('qr_token', $token)->firstOrFail();

        return view('admin.presensi.qr', compact('sesi'));
    }

    public function scan($token)
    {
        $sesi = SesiPresensi::where('qr_token', $token)->firstOrFail();

        // cek masih aktif atau nggak
        if (!$sesi->isDibuka()) {
            return "Presensi sudah ditutup";
        }

        return "QR valid, lanjut simpan kehadiran nanti";
    }

    public function aktif($jadwal_id)
    {
        $sesi = SesiPresensi::where('jadwal_kuliah_id', $jadwal_id)
            ->latest()
            ->first();

        if (!$sesi || !$sesi->isDibuka()) {
            return back()->with('error', 'Tidak ada sesi aktif');
        }

        return redirect()->route('admin.presensi.qr', $sesi->qr_token);
    }

    public function lihat($jadwal_id)
    {
        $jadwal = JadwalKuliah::with('kelas.mahasiswa')->findOrFail($jadwal_id);

        $sesi = SesiPresensi::where('jadwal_kuliah_id', $jadwal_id)
            ->latest()
            ->first();

        return view('admin.presensi.lihat', compact('jadwal', 'sesi'));
    }
}
