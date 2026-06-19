<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiPresensi;
use Illuminate\Support\Str;
use App\Models\JadwalKuliah;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use App\Models\Mahasiswa;
use App\Models\Kehadiran;


class SesiPresensiController extends Controller
{
    public function buka($jadwal_id)
    {
        $sesi = SesiPresensi::create([
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

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        $qr = $writer->writeString(route('presensi.scan', $sesi->qr_token));

        return view('admin.presensi.qr', compact('qr', 'sesi'));
    }

    public function scan($token)
    {
        $sesi = SesiPresensi::where('qr_token', $token)->firstOrFail();

        // cek masih aktif atau nggak
        if (!$sesi->isDibuka()) {
            return "Presensi sudah ditutup";
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== 'mahasiswa') {
            return "Hanya mahasiswa yang bisa absen";
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return "Data mahasiswa tidak ditemukan";
        }

        Kehadiran::updateOrCreate(
            [
                'sesi_presensi_id' => $sesi->id,
                'mahasiswa_id' => $mahasiswa->id,
            ],
            [
                'status' => 'hadir',
            ]
        );

        return "Berhasil absen 🎉";
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

        $sesi = SesiPresensi::with('kehadiran')
            ->where('jadwal_kuliah_id', $jadwal_id)
            ->latest()
            ->first();

        return view('admin.presensi.lihat', compact('jadwal', 'sesi'));
    }
}
