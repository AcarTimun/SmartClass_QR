@extends('layouts.mahasiswa')

@section('title', 'Beranda')

@section('content')

<div class="flex justify-center items-center h-full min-h-[60vh]">
    <div class="w-full max-w-md">
        <!-- Digital ID Card Concept -->
        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-sky-100 overflow-hidden relative border border-slate-100">
            
            <!-- Card Header / Banner -->
            <div class="h-32 bg-gradient-to-r from-sky-500 to-blue-600 relative">
                <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
                <!-- Profile Avatar Overlapping -->
                <div class="absolute -bottom-12 left-1/2 -translate-x-1/2">
                    <div class="w-24 h-24 bg-white rounded-full p-1.5 shadow-lg">
                        <div class="w-full h-full bg-sky-100 rounded-full flex items-center justify-center text-4xl text-sky-600 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="pt-16 pb-8 px-8 text-center">
                <h2 class="text-2xl font-bold text-slate-800">
                    {{ auth()->user()->name }}
                </h2>
                <p class="text-sky-600 font-medium mt-1">Mahasiswa</p>

                <div class="mt-8 space-y-4 text-left">
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-500 text-xl">
                            <i class="ph ph-identification-card"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">NIM</p>
                            <p class="font-semibold text-slate-700">{{ auth()->user()->mahasiswa->nim ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-500 text-xl">
                            <i class="ph ph-books"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Program Studi</p>
                            <p class="font-semibold text-slate-700">{{ auth()->user()->mahasiswa->prodi ?? '-' }}</p>
                        </div>
                    </div>

                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-100 flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-slate-500 text-xl">
                            <i class="ph ph-chalkboard-teacher"></i>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-0.5">Kelas</p>
                            <p class="font-semibold text-slate-700">{{ auth()->user()->mahasiswa->kelas->nama_kelas ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Call to action -->
                <div class="mt-8 space-y-3">
                    <a href="{{ route('mahasiswa.scan.camera') }}"
                        class="group relative w-full flex items-center justify-center gap-3 bg-gradient-to-r from-sky-500 to-blue-600 text-white px-6 py-4 rounded-2xl font-bold text-lg hover:shadow-lg hover:shadow-sky-200 transition-all hover:-translate-y-0.5">
                        <i class="ph ph-scan text-2xl group-hover:scale-110 transition-transform"></i>
                        Scan QR Absensi
                    </a>

                    <a href="{{ route('mahasiswa.kehadiran') }}"
                        class="group relative w-full flex items-center justify-center gap-3 bg-white border-2 border-slate-200 text-slate-700 px-6 py-4 rounded-2xl font-bold text-lg hover:border-sky-300 hover:text-sky-600 hover:shadow-md transition-all hover:-translate-y-0.5">
                        <i class="ph ph-clipboard-text text-2xl group-hover:scale-110 transition-transform"></i>
                        Rekap Kehadiran
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@endsection
