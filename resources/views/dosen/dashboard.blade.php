@extends('layouts.dosen')

@section('title', 'Beranda Dosen')

@section('content')

    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-violet-500 to-fuchsia-600 rounded-3xl p-8 text-white shadow-lg shadow-violet-200 relative overflow-hidden">
        <!-- Abstract Shapes -->
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-64 h-64 rounded-full bg-white opacity-10 blur-2xl"></div>
        <div class="absolute bottom-0 right-32 -mb-16 w-48 h-48 rounded-full bg-fuchsia-300 opacity-20 blur-xl"></div>
        
        <div class="relative z-10 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
                <p class="text-violet-100 text-lg">Kelola jadwal kelas dan presensi mahasiswa Anda hari ini.</p>
            </div>
            <div class="hidden md:flex w-24 h-24 bg-white/20 rounded-2xl backdrop-blur-sm items-center justify-center border border-white/30">
                <i class="ph ph-chalkboard-teacher text-5xl text-white"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('dosen.jadwal_kuliah') }}" class="group bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-md hover:border-violet-200 transition-all">
            <div class="w-16 h-16 rounded-2xl bg-violet-100 text-violet-600 flex items-center justify-center text-3xl group-hover:bg-violet-500 group-hover:text-white transition-colors">
                <i class="ph ph-calendar-check"></i>
            </div>
            <div>
                <h3 class="text-xl font-bold text-slate-800 mb-1">Jadwal Kuliah</h3>
                <p class="text-sm text-slate-500">Lihat jadwal mengajar dan buka presensi kelas.</p>
            </div>
            <div class="ml-auto text-slate-400 group-hover:text-violet-500 group-hover:translate-x-1 transition-all">
                <i class="ph ph-caret-right text-2xl"></i>
            </div>
        </a>
    </div>

@endsection