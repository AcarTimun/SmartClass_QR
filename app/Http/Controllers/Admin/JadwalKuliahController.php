<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\JadwalKuliah;
use App\Models\Kelas;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class JadwalKuliahController extends Controller
{
    public function index()
    {
        $jadwalKuliah = JadwalKuliah::with([
            'dosen.user',
            'mataKuliah',
            'kelas',
        ])->latest()->get();

        return view('admin.jadwal_kuliah.index', compact('jadwalKuliah'));
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

        JadwalKuliah::create($validated);

        return redirect()
            ->route('admin.jadwal_kuliah.index')
            ->with('success', 'Jadwal kuliah berhasil ditambahkan.');
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
}
