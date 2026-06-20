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
use Carbon\Carbon;


class SesiPresensiController extends Controller
{
    public function buka($sesi_id)
    {
        $sesi = SesiPresensi::findOrFail($sesi_id);

        $sesi->update([
            'qr_token' => Str::random(40),
            'status' => 'dibuka',
        ]);

        if (auth()->user()->role === 'dosen') {
            return redirect()->route('dosen.presensi.qr', $sesi->qr_token);
        }

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

       if (auth()->user()->role === 'dosen') {
            return view('dosen.presensi.qr', compact('qr', 'sesi'));
        }

        return view('admin.presensi.qr', compact('qr', 'sesi'));
    }

    public function scan($token)
    {
        $sesi = SesiPresensi::where('qr_token', $token)->firstOrFail();

        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        if (!$sesi->isDibuka()) {
            session()->flash('error', 'Presensi sudah ditutup / expired');

            return view('mahasiswa.scan');
        }

        if ($user->role !== 'mahasiswa') {
            session()->flash('error', 'Hanya mahasiswa yang bisa absen');

            return view('mahasiswa.scan');
        }


        $mahasiswa = Mahasiswa::where('user_id', $user->id)->first();

        if (!$mahasiswa) {
            session()->flash('error', 'Data mahasiswa tidak ditemukan');

            return view('mahasiswa.scan');
        }

        Kehadiran::updateOrCreate(
            [
                'sesi_presensi_id' => $sesi->id,
                'mahasiswa_id' => $mahasiswa->id,
            ],
            [
                'status' => 'H',
                'waktu_scan' => now(),
            ]
        );

        session()->flash('success', 'Berhasil absen!');

        return view('mahasiswa.scan', [
            'mahasiswa' => $mahasiswa,
            'sesi' => $sesi,
            'waktu' => now(),
        ]);

    }

    public function aktif($jadwal_id)
    {
        $sesi = SesiPresensi::where('jadwal_kuliah_id', $jadwal_id)
            ->latest()
            ->first();

        if (!$sesi || !$sesi->isDibuka()) {
            return back()->with('error', 'Tidak ada sesi aktif');
        }

        if (auth()->user()->role === 'dosen') {
            return redirect()->route('dosen.presensi.qr', $sesi->qr_token);
        }

        return redirect()->route('admin.presensi.qr', $sesi->qr_token);
    }

    public function lihat($jadwal_id, Request $request)
    {
        $jadwal = JadwalKuliah::with(['kelas.mahasiswa.user', 'mataKuliah'])->findOrFail($jadwal_id);

        $sessions = SesiPresensi::where('jadwal_kuliah_id', $jadwal_id)
            ->orderBy('pertemuan')
            ->get();

        $selectedSesiId = $request->query('sesi_id');
        $sesi = null;

        if ($selectedSesiId) {
            $sesi = $sessions->firstWhere('id', $selectedSesiId);
        }

        if (!$sesi) {
            $sesi = $sessions->firstWhere('status', 'dibuka');
        }

        if (!$sesi) {
            $sesi = $sessions->first();
        }

        if ($sesi) {
            $sesi->load('kehadiran.mahasiswa.user');
        }

        if (auth()->user()->role === 'dosen') {
            return view('dosen.presensi.lihat', compact('jadwal', 'sessions', 'sesi'));
        }

        return view('admin.presensi.lihat', compact('jadwal', 'sessions', 'sesi'));
    }



    public function tutup($id)
    {
        $sesi = SesiPresensi::findOrFail($id);

        $sesi->update([
            'status' => 'ditutup'
        ]);

        // Auto-mark semua mahasiswa yang belum hadir sebagai 'X'
        $jadwal = $sesi->jadwalKuliah()->with('kelas.mahasiswa')->first();
        $allMahasiswaIds = $jadwal->kelas->mahasiswa->pluck('id');

        $sudahHadirIds = Kehadiran::where('sesi_presensi_id', $sesi->id)
            ->where('status', 'H')
            ->pluck('mahasiswa_id');

        $belumHadirIds = $allMahasiswaIds->diff($sudahHadirIds);

        foreach ($belumHadirIds as $mhsId) {
            Kehadiran::updateOrCreate(
                ['sesi_presensi_id' => $sesi->id, 'mahasiswa_id' => $mhsId],
                ['status' => 'X']
            );
        }

        if (auth()->user()->role === 'dosen') {
            return redirect()->route('dosen.presensi.lihat', [
                'jadwal' => $sesi->jadwal_kuliah_id,
                'sesi_id' => $sesi->id
            ])->with('success', 'Presensi ditutup');
        }

        return redirect()->route('admin.presensi.lihat', [
            'jadwal' => $sesi->jadwal_kuliah_id,
            'sesi_id' => $sesi->id
        ])->with('success', 'Presensi ditutup');
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
        $sesi = SesiPresensi::findOrFail($sesi_id);

        if ($request->kehadiran) {
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
        }

        if (auth()->user()->role === 'dosen') {
            return redirect()->route('dosen.presensi.lihat', [
                'jadwal' => $sesi->jadwal_kuliah_id,
                'sesi_id' => $sesi->id
            ])->with('success', 'Absensi berhasil disimpan');
        }

        return redirect()->route('admin.presensi.lihat', [
            'jadwal' => $sesi->jadwal_kuliah_id,
            'sesi_id' => $sesi->id
        ])->with('success', 'Absensi berhasil disimpan');
    }

    public function data($sesi_id)
    {
        $sesi = SesiPresensi::with('kehadiran')->findOrFail($sesi_id);

        return response()->json($sesi->kehadiran);
    }
}
