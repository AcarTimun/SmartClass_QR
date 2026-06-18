@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Mahasiswa
</h1>

<form action="{{ route('admin.mahasiswa.store') }}" method="POST">

    @csrf

    <div class="mb-4">
        <label class="block mb-2">Nama</label>

        <input type="text"
               name="name"
               value="{{ old('name') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2">Email</label>

        <input type="email"
               name="email"
               value="{{ old('email') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2">Password</label>

        <input type="password"
               name="password"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2">NIM</label>

        <input type="text"
               name="nim"
               value="{{ old('nim') }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-6">
        <label class="block mb-2">Kelas</label>

        <select name="kelas_id"
                class="w-full border rounded p-2">

            <option value="">Pilih Kelas</option>

            @foreach($kelas as $item)
                <option value="{{ $item->id }}">
                    {{ $item->nama_kelas }}
                </option>
            @endforeach

        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection
