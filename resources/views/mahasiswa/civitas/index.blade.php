@extends('layouts.mahasiswa')

@section('title', 'Civitas Akademika')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Direktori Civitas Akademika</h1>
    <p class="text-slate-500 mt-1">Cari dan kenali dosen serta sesama mahasiswa di kampus.</p>
</div>

<!-- Tabs & Search -->
<div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-4 mb-6">
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        
        <!-- Tabs -->
        <div class="flex p-1 bg-slate-100 rounded-xl w-full lg:w-auto">
            <a href="{{ route('mahasiswa.civitas', ['tab' => 'mahasiswa']) }}" 
               class="flex-1 lg:flex-none text-center px-6 py-2 rounded-lg font-medium text-sm transition-colors {{ $tab === 'mahasiswa' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="ph ph-student mr-1"></i> Mahasiswa
            </a>
            <a href="{{ route('mahasiswa.civitas', ['tab' => 'dosen']) }}" 
               class="flex-1 lg:flex-none text-center px-6 py-2 rounded-lg font-medium text-sm transition-colors {{ $tab === 'dosen' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-500 hover:text-slate-700' }}">
                <i class="ph ph-chalkboard-teacher mr-1"></i> Dosen
            </a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('mahasiswa.civitas') }}" method="GET" class="w-full lg:w-auto flex gap-2">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="relative flex-1 lg:w-80">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i class="ph ph-magnifying-glass text-slate-400 text-lg"></i>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="bg-slate-50 border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2.5 transition-colors" 
                       placeholder="{{ $tab === 'mahasiswa' ? 'Cari Nama, NIM, Prodi...' : 'Cari Nama, NIDN...' }}">
            </div>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl text-sm font-medium transition-colors shadow-sm shadow-indigo-200">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('mahasiswa.civitas', ['tab' => $tab]) }}" class="inline-flex items-center justify-center px-4 py-2.5 text-sm font-medium text-slate-700 bg-slate-100 rounded-xl hover:bg-slate-200 transition-colors">
                    <i class="ph ph-x"></i>
                </a>
            @endif
        </form>

    </div>
</div>

<!-- Card Grid -->
@if($data->isEmpty())
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-12 text-center">
        <i class="ph ph-users text-6xl text-slate-300 mb-4 inline-block"></i>
        <h3 class="text-lg font-bold text-slate-700">Tidak ada data ditemukan</h3>
        <p class="text-slate-500">Coba ubah kata kunci pencarian Anda.</p>
    </div>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mb-6">
        @foreach($data as $item)
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 flex flex-col items-center text-center hover:shadow-md transition-shadow group relative overflow-hidden">
                <!-- Decorative Top Border -->
                <div class="absolute top-0 left-0 w-full h-2 {{ $tab === 'mahasiswa' ? 'bg-sky-400' : 'bg-indigo-500' }}"></div>
                
                <div class="w-20 h-20 rounded-full {{ $tab === 'mahasiswa' ? 'bg-sky-50 text-sky-500' : 'bg-indigo-50 text-indigo-500' }} flex items-center justify-center text-3xl font-bold mb-4 mt-2">
                    {{ substr($item->user->name, 0, 1) }}
                </div>
                
                <h3 class="font-bold text-slate-800 text-lg mb-1 line-clamp-1" title="{{ $item->user->name }}">
                    {{ $item->user->name }}
                </h3>
                
                @if($tab === 'mahasiswa')
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 mb-2">
                        NIM: {{ $item->nim }}
                    </span>
                    <p class="text-sm text-slate-500 flex items-center justify-center gap-1 mt-auto pt-2">
                        <i class="ph ph-graduation-cap text-sky-500"></i> {{ $item->prodi }}
                    </p>
                @else
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-slate-100 text-slate-600 mt-auto pt-2">
                        NIDN: {{ $item->nidn }}
                    </span>
                @endif
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    @if($data->hasPages())
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-4">
            {{ $data->links() }}
        </div>
    @endif
@endif

@endsection
