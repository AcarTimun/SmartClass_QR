@extends('layouts.mahasiswa')

@section('content')

<div class="max-w-md mx-auto bg-white p-6 rounded shadow text-center">

    <h2 class="text-xl font-bold mb-4">
        Profil Mahasiswa
    </h2>

    <div class="space-y-3 text-left">

        <div>
            <span class="font-semibold">Nama:</span><br>
            {{ auth()->user()->name }}
        </div>

        <div>
            <span class="font-semibold">NIM:</span><br>
            {{ auth()->user()->mahasiswa->nim ?? '-' }}
        </div>



    </div>

</div>

@endsection
