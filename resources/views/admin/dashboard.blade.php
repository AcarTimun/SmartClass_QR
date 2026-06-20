@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-indigo-600 to-sky-500 rounded-3xl p-8 text-white shadow-lg shadow-indigo-200 relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
        <div class="absolute bottom-0 right-32 -mb-16 w-48 h-48 rounded-full bg-sky-300 opacity-20 blur-xl"></div>

        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! </h1>
                <p class="text-indigo-100 text-lg">Pantau dan kelola semua data akademik dari satu tempat.</p>
            </div>
            <div class="hidden md:flex w-24 h-24 bg-white/20 rounded-2xl backdrop-blur-sm items-center justify-center border border-white/30">
                <i class="ph ph-rocket-launch text-5xl text-white"></i>
            </div>
        </div>
    </div>

    <!-- Statistic Cards (Dummy Data for Now) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <!-- Card 1 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                <i class="ph ph-users-three"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Dosen</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalDosen }}</h3>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-14 h-14 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                <i class="ph ph-student"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Mahasiswa</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalMahasiswa }}</h3>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-14 h-14 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                <i class="ph ph-chalkboard-teacher"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Kelas</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalKelas }}</h3>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md transition-shadow group">
            <div class="w-14 h-14 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-3xl group-hover:scale-110 transition-transform">
                <i class="ph ph-book-open-text"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Mata Kuliah</p>
                <h3 class="text-2xl font-bold text-slate-800">{{ $totalMataKuliah }}</h3>
            </div>
        </div>
    </div>
@endsection
