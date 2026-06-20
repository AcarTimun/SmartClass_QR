<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Kelas;
use App\Models\MataKuliah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SesiPresensi;
use Illuminate\Support\Str;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        $jadwalKuliah = JadwalKuliah::with([
            'dosen.user',
            'mataKuliah',
            'kelas',
            'sesiPresensi'
        ])->get();

        return view('admin.jadwal_kuliah.index', compact('jadwalKuliah'));
    }
    public function indexDosen(){
        $user = Auth::user();
        $dosen = $user->dosen;

        $jadwal = \App\Models\JadwalKuliah::with(['mataKuliah', 'kelas'])
            ->where('dosen_id', $dosen->id)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get()
            ->groupBy('hari');

        return view('dosen.jadwal_kuliah.index', compact('jadwal'));
    }

    public function create()
    {
        $dosen = Dosen::with('user')->get();
        $mataKuliah = MataKuliah::orderBy('nama_mk')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.jadwal_kuliah.create', compact(
            'dosen',
            'mataKuliah',
            'kelas'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $jadwal = JadwalKuliah::create($validated);

        // Pre-create 16 SesiPresensi sessions (14 meetings, 1 UTS, 1 UAS)
        for ($i = 1; $i <= 16; $i++) {
            SesiPresensi::create([
                'jadwal_kuliah_id' => $jadwal->id,
                'pertemuan' => $i,
                'qr_token' => Str::random(40),
                'status' => 'ditutup',
            ]);
        }

        return redirect()
            ->route('admin.jadwal_kuliah.index')
            ->with('success', 'Jadwal kuliah dan 16 sesi presensi berhasil ditambahkan.');
    }

    public function show(JadwalKuliah $jadwalKuliah)
    {
        abort(404);
    }

    public function edit(JadwalKuliah $jadwalKuliah)
    {
        $dosen = Dosen::with('user')->get();
        $mataKuliah = MataKuliah::orderBy('nama_mk')->get();
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.jadwal_kuliah.edit', compact(
            'jadwalKuliah',
            'dosen',
            'mataKuliah',
            'kelas'
        ));
    }

    public function update(Request $request, JadwalKuliah $jadwalKuliah)
    {
         $validated = $request->validate([
            'dosen_id' => 'required|exists:dosen,id',
            'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
            'kelas_id' => 'required|exists:kelas,id',
            'hari' => 'required|max:20',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);

        $jadwalKuliah->update($validated);

        return redirect()
            ->route('admin.jadwal_kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil diperbarui.');
    }

    public function destroy(JadwalKuliah $jadwalKuliah)
    {
         $jadwalKuliah->delete();

        return redirect()
            ->route('admin.jadwal_kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil dihapus.');
    }

    public function showDosen($id)
    {
        $jadwal = JadwalKuliah::with(['mataKuliah', 'kelas'])
            ->findOrFail($id);

        return view('dosen.jadwal_detail', compact('jadwal'));
    }

}
