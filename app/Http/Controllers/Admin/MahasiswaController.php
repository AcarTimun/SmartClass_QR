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
    const PRODI = [
        'Sistem Informasi',
        'Teknologi Informasi',
        'Sistem Komputer',
        'Bisnis Digital',
        'Teknologi Informatika'
    ];

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $mahasiswa = Mahasiswa::with(['user', 'kelas'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })->orWhere('nim', 'like', "%{$search}%")
                  ->orWhere('prodi', 'like', "%{$search}%")
                  ->orWhereHas('kelas', function ($q) use ($search) {
                      $q->where('nama_kelas', 'like', "%{$search}%");
                  });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

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
        'prodi' => 'required|in:' . implode(',', self::PRODI),
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
            'prodi' => $validated['prodi'],
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
            'email' => 'required|email|unique:users,email,' . $mahasiswa->user_id . ',id',
            'password' => 'nullable|min:8',
            'prodi' => 'required|in:' . implode(',', self::PRODI),
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        DB::transaction(function () use ($validated, $mahasiswa) {

            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];

            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }

            $mahasiswa->user->update($userData);

            $mahasiswa->update([
                'prodi' => $validated['prodi'],
                'kelas_id' => $validated['kelas_id'],
            ]);
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mahasiswa $mahasiswa)
    {
        DB::transaction(function () use ($mahasiswa) {
            $mahasiswa->user->delete();
        });

        return redirect()
            ->route('admin.mahasiswa.index')
            ->with('success', 'Mahasiswa berhasil dihapus.');
    }
}
