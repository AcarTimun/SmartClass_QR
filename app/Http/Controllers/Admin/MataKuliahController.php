<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    public function index()
    {
        $mataKuliah = MataKuliah::latest()->get();

        return view('admin.mata_kuliah.index', compact('mataKuliah'));
    }

    public function create()
    {
        return view ('admin.mata_kuliah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|max:20|unique:mata_kuliah,kode_mk',
            'nama_mk' => 'required|max:100',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        MataKuliah::create($validated);

        return redirect()
            ->route('admin.mata_kuliah.index')
            ->with('success', 'Mata Kuliah berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        abort(404);
    }


    public function edit(MataKuliah $mataKuliah)
    {
         return view('admin.mata_kuliah.edit', compact('mataKuliah'));
    }

    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $validated = $request->validate([
            'kode_mk' => 'required|max:20|unique:mata_kuliah,kode_mk,' . $mataKuliah->id,
            'nama_mk' => 'required|max:100',
            'sks' => 'required|integer|min:1|max:6',
        ]);

        $mataKuliah->update($validated);

        return redirect()
            ->route('admin.mata_kuliah.index')
            ->with('success', 'Mata kuliah berhasil diperbarui.');
    }

    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();

        return redirect()
            ->route('admin.mata_kuliah.index')
            ->with ('success', 'Mata Kuliah berhasil dihapus' );
    }
}
