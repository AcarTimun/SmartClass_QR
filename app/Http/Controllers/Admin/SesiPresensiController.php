<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiPresensi;
use Illuminate\Support\Str;



class SesiPresensiController extends Controller
{
    public function buka($jadwal_id)
    {
        SesiPresensi::create([
            'jadwal_kuliah_id' => $jadwal_id,
            'pertemuan' => 1, // nanti bisa dinamis
            'qr_token' => Str::random(40),
            'status' => 'dibuka',
        ]);

        return back()->with('success', 'Presensi dibuka');
    }
}
