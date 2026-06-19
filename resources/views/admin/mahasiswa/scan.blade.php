@extends('layouts.mahasiswa')W

@section('content')

<div class="flex items-center justify-center min-h-[70vh]">

    <div class="bg-white p-8 rounded shadow text-center w-full max-w-md">

        <h1 class="text-2xl font-bold mb-4">
            Scan Presensi
        </h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <p class="text-gray-600 mb-4">
            Sedang memproses presensi...
        </p>

    </div>

</div>

@endsection
