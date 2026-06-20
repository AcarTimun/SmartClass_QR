<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\JadwalKuliahController;
use App\Http\Controllers\Admin\SesiPresensiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Dosen\DashboardController as DosenDashboardController;
use App\Http\Controllers\Mahasiswa\KehadiranController as MahasiswaKehadiranController;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// tes routes
// Route::get('/', function () {
//     return 'SmartClass QR LIVE 🚀';
// });

// halaman utama
Route::get('/', function () {

    if (!auth()->check()) {
        return redirect()->route('login');
    }

    return match (auth()->user()->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'dosen' => redirect()->route('dosen.dashboard'),
        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
        default => abort(403),
    };
});

// group admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Dashboard
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    // Kelas
    Route::resource('/admin/kelas', KelasController::class)
        ->parameters(['kelas' => 'kelas'])
        ->except(['show'])
        ->names('admin.kelas');
    // MK
    Route::resource('/admin/mata-kuliah', MataKuliahController::class)
        ->parameters(['mata-kuliah' => 'mata_kuliah'])
        ->except(['show'])
        ->names('admin.mata_kuliah');
    // Dosen
    Route::resource('/admin/dosen', DosenController::class)
        ->parameters(['dosen' => 'dosen'])
        ->except(['show'])
        ->names('admin.dosen');

    // Mahasiswa
    Route::resource('/admin/mahasiswa', MahasiswaController::class)
        ->parameters(['mahasiswa' => 'mahasiswa'])
        ->except(['show'])
        ->names('admin.mahasiswa');

    // Jadwal Kuliah
    Route::resource('/admin/jadwal-kuliah', JadwalKuliahController::class)
        ->except(['show'])
        ->names('admin.jadwal_kuliah');

    Route::post('/admin/presensi/buka/{sesi}', [SesiPresensiController::class, 'buka'])
        ->name('admin.presensi.buka');

    // QR
    Route::get('/admin/presensi/qr/{token}', [SesiPresensiController::class, 'qr'])
        ->name('admin.presensi.qr');

    // sesi QR Aktif
    Route::get('/admin/presensi/{jadwal}/aktif', [SesiPresensiController::class, 'aktif'])
        ->name('admin.presensi.aktif');

    // lihat absen
    Route::get('/admin/presensi/{jadwal}/lihat', [SesiPresensiController::class, 'lihat'])
        ->name('admin.presensi.lihat');

    // tutup QR
        Route::post('/admin/presensi/{id}/tutup', [SesiPresensiController::class, 'tutup'])
        ->name('admin.presensi.tutup');

    // Update Absen manual
        Route::post('/admin/presensi/{sesi}/{mahasiswa}', [SesiPresensiController::class, 'update'])
    ->name('admin.presensi.update');

    // bulk update absen
    Route::post('/admin/presensi/bulk', [SesiPresensiController::class, 'bulkUpdate'])
        ->name('admin.presensi.bulk');

    // API auto Update Absen
    Route::get('/admin/presensi/data/{sesi}', [SesiPresensiController::class, 'data'])
        ->name('admin.presensi.data');
});

// group dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::get('/dosen/dashboard', [DosenDashboardController::class, 'index'])
        ->name('dosen.dashboard');

    Route::get('/dosen/jadwal_kuliah', [JadwalKuliahController::class, 'indexDosen'])
        ->name('dosen.jadwal_kuliah');

    Route::post('/dosen/presensi/buka/{sesi}', [SesiPresensiController::class, 'buka'])
        ->name('dosen.presensi.buka');

    Route::get('/dosen/presensi/qr/{token}', [SesiPresensiController::class, 'qr'])
        ->name('dosen.presensi.qr');

    // sesi QR Aktif
    Route::get('/dosen/presensi/{jadwal}/aktif', [SesiPresensiController::class, 'aktif'])
        ->name('dosen.presensi.aktif');

    Route::get('/dosen/presensi/{jadwal}/lihat', [SesiPresensiController::class, 'lihat'])
        ->name('dosen.presensi.lihat');

    Route::post('/dosen/presensi/{id}/tutup', [SesiPresensiController::class, 'tutup'])
        ->name('dosen.presensi.tutup');

    Route::get('/dosen/jadwal/{jadwal}', [JadwalKuliahController::class, 'showDosen'])
        ->name('dosen.jadwal.show');


    Route::get('/dosen/presensi/data/{sesi}', [SesiPresensiController::class, 'data'])
        ->name('dosen.presensi.data');

    Route::post('/dosen/presensi/bulk', [SesiPresensiController::class, 'bulkUpdate'])
        ->name('dosen.presensi.bulk');

});

// group mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::view('/mahasiswa/dashboard', 'mahasiswa.dashboard')
        ->name('mahasiswa.dashboard');

    // Rekap Kehadiran
    Route::get('/mahasiswa/kehadiran', [MahasiswaKehadiranController::class, 'index'])
        ->name('mahasiswa.kehadiran');
    // QR Scan
    Route::get('/scan/{token}', [SesiPresensiController::class, 'scan'])
    ->name('presensi.scan');
    // Scan Kamera
    Route::get('/scan-camera', function () {
        return view('mahasiswa.scan_camera');
    })->name('mahasiswa.scan.camera');
});



require __DIR__.'/auth.php';
