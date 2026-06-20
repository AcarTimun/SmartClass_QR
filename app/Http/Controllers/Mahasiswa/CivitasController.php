<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class CivitasController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'mahasiswa'); // 'mahasiswa' or 'dosen'
        $search = $request->input('search');
        $perPage = 12; // Grid style, 12 per page is good

        if ($tab === 'dosen') {
            $data = Dosen::with('user')
                ->when($search, function ($query, $search) {
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhere('nidn', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate($perPage)
                ->withQueryString();
        } else {
            $data = Mahasiswa::with('user')
                ->when($search, function ($query, $search) {
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })->orWhere('nim', 'like', "%{$search}%")
                      ->orWhere('prodi', 'like', "%{$search}%");
                })
                ->latest()
                ->paginate($perPage)
                ->withQueryString();
        }

        return view('mahasiswa.civitas.index', compact('data', 'tab'));
    }
}
