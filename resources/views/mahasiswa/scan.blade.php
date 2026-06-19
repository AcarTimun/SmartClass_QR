@extends('layouts.mahasiswa')

@section('content')

<div class="flex items-center justify-center min-h-[70vh]">

    <div class="bg-white p-8 rounded shadow text-center w-full max-w-md">

        @if(session('success'))

            <h1 class="text-2xl font-bold mb-4 text-green-600">
                Presensi Berhasil
            </h1>

            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>

            <p class="text-gray-600 mb-2">
                {{ $mahasiswa->user->name }}
            </p>

            <p class="text-gray-500 mb-4">
                {{ $waktu->format('H:i A') }}
            </p>

        @elseif(session('error'))

            <h1 class="text-2xl font-bold mb-4 text-red-600">
                Presensi Gagal
            </h1>

            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>

        @else

            <h1 class="text-2xl font-bold mb-4">
                Scan Presensi
            </h1>

            <p class="text-gray-600 mb-4">
                Menunggu scan QR...
            </p>

        @endif

        <a href="{{ route('mahasiswa.dashboard') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded mt-3 inline-block">
            Kembali ke Dashboard
        </a>

    </div>

</div>

@endsection
