<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\MataKuliah;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalDosen' => Dosen::count(),
            'totalMahasiswa' => Mahasiswa::count(),
            'totalKelas' => Kelas::count(),
            'totalMataKuliah' => MataKuliah::count(),
        ]);
    }
}
