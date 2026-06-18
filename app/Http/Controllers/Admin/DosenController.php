<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::with('user')->latest()->get();

        return view('admin.dosen.index', compact('dosen'));
    }

    public function create()
    {
        return view('admin.dosen.create');
    }

    public function store(Request $request)
    {
         $validated = $request->validate([
        'name' => 'required|max:100',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8',
        'nidn' => 'required|max:50|unique:dosen,nidn',
    ]);

        DB::transaction(function () use ($validated) {

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'dosen',
            ]);

            Dosen::create([
                'user_id' => $user->id,
                'nidn' => $validated['nidn'],
            ]);
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil ditambahkan.');
        }

    public function show(string $id)
    {
        abort(404);
    }

    public function edit(Dosen $dosen)
    {
        $dosen->load('user');

        return view('admin.dosen.edit', compact('dosen'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|unique:users,email,' . $dosen->user_id,
            'nidn' => 'required|max:50|unique:dosen,nidn,' . $dosen->id,
        ]);

        DB::transaction(function () use ($validated, $dosen) {

            $dosen->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $dosen->update([
                'nidn' => $validated['nidn'],
            ]);
        });

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Data dosen berhasil diperbarui.');

        }

    public function destroy(Dosen $dosen)
    {
        $dosen->user->delete();

        return redirect()
            ->route('admin.dosen.index')
            ->with('success', 'Dosen berhasil dihapus.');
    }
}
