<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::with(['user', 'kelas'])
            ->latest()
            ->get();

        return view('admin.mahasiswa.index', compact('mahasiswa'));
    }

    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.mahasiswa.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
        'name' => 'required|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'nim' => 'required|max:50|unique:mahasiswa,nim',
        'kelas_id' => 'required|exists:kelas,id',
    ]);

    DB::transaction(function () use ($validated) {

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
        ]);

        Mahasiswa::create([
            'user_id' => $user->id,
            'nim' => $validated['nim'],
            'kelas_id' => $validated['kelas_id'],
        ]);
    });

    return redirect()
        ->route('admin.mahasiswa.index')
        ->with('success', 'Mahasiswa berhasil ditambahkan.');
    }

    public function show(Mahasiswa $mahasiswa)
    {
        abort(404);
    }

    public function edit(Mahasiswa $mahasiswa)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        return view('admin.mahasiswa.edit', compact('mahasiswa', 'kelas'));
    }

    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id,
            'nim' => 'required|max:50|unique:mahasiswa,nim,' . $mahasiswa->id,
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {

            $mahasiswa->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $mahasiswa->update([
                'nim' => $validated['nim'],
                'kelas_id' => $validated['kelas_id'],
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
         $mahasiswa->user->delete();

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
