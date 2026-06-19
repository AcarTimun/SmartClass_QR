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
        <label class="block mb-2">Prodi</label>

        <select name="prodi"
                class="w-full border rounded p-2">

            <option value="">Pilih Prodi</option>

            <option value="Sistem Informasi"
                {{ old('prodi') == 'Sistem Informasi' ? 'selected' : '' }}>
                Sistem Informasi
            </option>

            <option value="Teknologi Informasi"
                {{ old('prodi') == 'Teknologi Informasi' ? 'selected' : '' }}>
                Teknologi Informasi
            </option>

            <option value="Sistem Komputer"
                {{ old('prodi') == 'Sistem Komputer' ? 'selected' : '' }}>
                Sistem Komputer
            </option>

            <option value="Bisnis Digital"
                {{ old('prodi') == 'Bisnis Digital' ? 'selected' : '' }}>
                Bisnis Digital
            </option>

            <option value="Teknologi Informatika"
                {{ old('prodi') == 'Teknologi Informatika' ? 'selected' : '' }}>
                Teknologi Informatika
            </option>

        </select>
        @error('prodi')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
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
