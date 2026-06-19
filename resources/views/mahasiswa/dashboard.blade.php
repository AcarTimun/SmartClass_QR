@extends('layouts.mahasiswa')

@section('content')

<div class="max-w-md mx-auto bg-white p-6 rounded shadow text-center">

    <h2 class="text-xl font-bold mb-4">
        Profil Mahasiswa
    </h2>

    <div class="space-y-3 text-left">

        <div>
            <span class="font-semibold">Nama :</span><br>
            {{ auth()->user()->name }}
        </div>

        <div>
            <span class="font-semibold">NIM :</span><br>
            {{ auth()->user()->mahasiswa->nim ?? '-' }}
        </div>

        <div>
            <span class="font-semibold">PRODI :</span><br>
            {{ auth()->user()->mahasiswa->prodi ?? '-' }}
        </div>

        <div>
            <span class="font-semibold">KELAS :</span><br>
            {{ auth()->user()->mahasiswa->kelas->nama_kelas ?? '-' }}
        </div>

        <a href="{{ route('mahasiswa.scan.camera') }}"
            class="bg-blue-600 text-white px-6 py-3 rounded block text-center">
                Absen (Scan QR)
        </a>


    </div>

</div>

@endsection
