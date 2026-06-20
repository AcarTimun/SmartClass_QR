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

        // Cek apakah ada sesi lain di jadwal kuliah yang sama yang sedang aktif (dibuka dan belum expired)
        $activeSession = SesiPresensi::where('jadwal_kuliah_id', $sesi->jadwal_kuliah_id)
            ->where('id', '!=', $sesi->id)
            ->where('status', 'dibuka')
            ->get()
            ->first(function ($s) {
                return $s->isDibuka();
            });

        if ($activeSession) {
            session()->flash('error', 'Gagal membuka QR. Sesi ' . $activeSession->pertemuan_label . ' sedang aktif. Harap tutup sesi tersebut terlebih dahulu atau tunggu sampai waktunya habis.');
            
            if (auth()->user()->role === 'dosen') {
                return redirect()->route('dosen.presensi.lihat', [
                    'jadwal' => $sesi->jadwal_kuliah_id,
                    'sesi_id' => $sesi->id
                ]);
            }
            return redirect()->route('admin.presensi.lihat', [
                'jadwal' => $sesi->jadwal_kuliah_id,
                'sesi_id' => $sesi->id
            ]);
        }

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

        // Cek apakah sesi masih aktif
        if (!$sesi->isDibuka()) {
            if (auth()->user()->role === 'dosen') {
                return redirect()->route('dosen.presensi.lihat', [
                    'jadwal' => $sesi->jadwal_kuliah_id,
                    'sesi_id' => $sesi->id
                ])->with('error', 'Sesi QR sudah expired atau ditutup');
            }
            return redirect()->route('admin.presensi.lihat', [
                'jadwal' => $sesi->jadwal_kuliah_id,
                'sesi_id' => $sesi->id
            ])->with('error', 'Sesi QR sudah expired atau ditutup');
        }

        $renderer = new ImageRenderer(
            new RendererStyle(300),
            new SvgImageBackEnd()
        );

        $writer = new Writer($renderer);

        $qr = $writer->writeString(route('presensi.scan', $sesi->qr_token));

        $remainingSeconds = $sesi->getRemainingSeconds();

       if (auth()->user()->role === 'dosen') {
            return view('dosen.presensi.qr', compact('qr', 'sesi', 'remainingSeconds'));
        }

        return view('admin.presensi.qr', compact('qr', 'sesi', 'remainingSeconds'));
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

        // Cek apakah mahasiswa terdaftar di kelas yang sesuai dengan sesi ini
        $jadwal = $sesi->jadwalKuliah()->with('kelas')->first();
        if ($jadwal && $mahasiswa->kelas_id !== $jadwal->kelas_id) {
            session()->flash('error', 'Anda tidak terdaftar di kelas ini. Hanya mahasiswa yang terdaftar di kelas ' . $jadwal->kelas->nama_kelas . ' yang dapat melakukan absensi.');

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
            ->where('status', 'dibuka')
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
            
            $totalMahasiswa = $jadwal->kelas->mahasiswa->count();
            $hadir = $sesi->kehadiran->where('status', 'H')->count();
            $tidakHadir = $sesi->kehadiran->where('status', 'X')->count();
            $belumDiisi = $totalMahasiswa - ($hadir + $tidakHadir);
        } else {
            $totalMahasiswa = 0;
            $hadir = 0;
            $tidakHadir = 0;
            $belumDiisi = 0;
        }

        if (auth()->user()->role === 'dosen') {
            return view('dosen.presensi.lihat', compact('jadwal', 'sessions', 'sesi', 'totalMahasiswa', 'hadir', 'tidakHadir', 'belumDiisi'));
        }

        return view('admin.presensi.lihat', compact('jadwal', 'sessions', 'sesi', 'totalMahasiswa', 'hadir', 'tidakHadir', 'belumDiisi'));
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

        // Auto-mark semua mahasiswa yang belum hadir/diabsen sebagai 'X'
        $jadwal = $sesi->jadwalKuliah()->with('kelas.mahasiswa')->first();
        $allMahasiswaIds = $jadwal->kelas->mahasiswa->pluck('id');

        $sudahDiabsenIds = Kehadiran::where('sesi_presensi_id', $sesi->id)
            ->whereIn('status', ['H', 'X'])
            ->pluck('mahasiswa_id');

        $belumHadirIds = $allMahasiswaIds->diff($sudahDiabsenIds);

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
