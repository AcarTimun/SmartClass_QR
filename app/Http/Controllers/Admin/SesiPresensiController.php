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

        if (!$sesi->isDibuka()) {
            return "Presensi sudah ditutup";
        }

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if ($user->role !== 'mahasiswa') {
            return view('mahasiswa.scan')
                ->with('error', 'Hanya mahasiswa yang bisa absen');
        }

        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            return view('mahasiswa.scan')
                ->with('error', 'Data mahasiswa tidak ditemukan');
        }

        Kehadiran::updateOrCreate(
            [
                'sesi_presensi_id' => $sesi->id,
                'mahasiswa_id' => $mahasiswa->id,
            ],
            [
                'status' => 'H',
            ]
        );

        return view('mahasiswa.scan')
            ->with('success', 'Berhasil Absen!');
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



    public function tutup($id)
    {
        $sesi = SesiPresensi::findOrFail($id);

        $sesi->update([
            'status' => 'ditutup'
        ]);

        if (auth()->user()->role === 'dosen') {
            return redirect()->route('dosen.jadwal_kuliah')
                ->with('success', 'Presensi ditutup');
        }

        return redirect()->route('admin.jadwal_kuliah.index')
            ->with('success', 'Presensi ditutup');
    }

    public function update($sesi_id, $mahasiswa_id, Request $request)
    {
        $status = $request->status == 'hadir' ? 'H' : 'X';

        Kehadiran::updateOrCreate(
            [
                'sesi_presensi_id' => $sesi_id,
                'mahasiswa_id' => $mahasiswa_id,
            ],
            [
                'status' => $status,
            ]
        );

        return back();
    }

    public function bulkUpdate(Request $request)
    {
        $sesi_id = $request->sesi_id;

        foreach ($request->kehadiran as $mahasiswa_id => $status) {

            $dbStatus = match ($status) {
                'hadir' => 'H',
                'tidak_hadir' => 'X',
                default => '-',
            };

            Kehadiran::updateOrCreate(
                [
                    'sesi_presensi_id' => $sesi_id,
                    'mahasiswa_id' => $mahasiswa_id,
                ],
                [
                    'status' => $dbStatus,
                ]
            );
        }

        return redirect()->route('admin.jadwal_kuliah.index')
            ->with('success', 'Absensi berhasil disimpan');
    }

    public function data($jadwal_id)
    {
        $sesi = SesiPresensi::with('kehadiran')
            ->where('jadwal_kuliah_id', $jadwal_id)
            ->latest()
            ->first();

        return response()->json($sesi->kehadiran);
    }
}
