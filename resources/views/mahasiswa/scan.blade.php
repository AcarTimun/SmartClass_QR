@extends('layouts.mahasiswa')

@section('content')

<div class="flex items-center justify-center min-h-[70vh]">

    <div class="bg-white p-8 rounded shadow text-center w-full max-w-md">

        {{-- ICON --}}
        @if(session('success'))
            <div class="text-green-500 text-5xl mb-4">✔</div>
        @else
            <div class="text-red-500 text-5xl mb-4">✖</div>
        @endif

        {{-- TITLE --}}
        <h2 class="text-xl font-bold mb-2">
            {{ session('success') ? 'Presensi Berhasil' : 'Presensi Gagal' }}
        </h2>

        {{-- MESSAGE --}}
        <p class="text-gray-600 mb-4">
            {{ session('success') ?? session('error') }}
        </p>

        @if(session('success'))
        <div class="text-left bg-gray-100 p-4 rounded mb-4 text-sm">

            <p><strong>Nama:</strong> {{ $mahasiswa->user->name }}</p>

            <p><strong>Mata Kuliah:</strong>
                {{ $sesi->jadwalKuliah->mataKuliah->nama_mk ?? '-' }}
            </p>

            <p><strong>Waktu:</strong>
                {{ \Carbon\Carbon::parse($waktu)->format('h:i A') }}
            </p>

        </div>
        @endif

        {{-- BUTTON --}}
        <a href="{{ route('mahasiswa.dashboard') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded">
            Kembali ke Dashboard
        </a>

    </div>

</div>

@endsection
