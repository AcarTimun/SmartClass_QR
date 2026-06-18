<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\MataKuliahController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\JadwalKuliahController;

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
    Route::view('/admin/dashboard', 'admin.dashboard')
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
});

// group dosen
Route::middleware(['auth', 'role:dosen'])->group(function () {
    Route::view('/dosen/dashboard', 'dosen.dashboard')
        ->name('dosen.dashboard');


});

// group mahasiswa
Route::middleware(['auth', 'role:mahasiswa'])->group(function () {
    Route::view('/mahasiswa/dashboard', 'mahasiswa.dashboard')
        ->name('mahasiswa.dashboard');
});


require __DIR__.'/auth.php';
