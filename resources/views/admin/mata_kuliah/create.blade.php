@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Mata Kuliah
</h1>

<form action="{{ route('admin.mata_kuliah.store') }}" method="POST">

    @csrf

    <div class="mb-4">
        <label class="block mb-2">Kode Mata Kuliah</label>

        <input
            type="text"
            name="kode_mk"
            value="{{ old('kode_mk') }}"
            class="w-full border rounded p-2"
            required
        >

        @error('kode_mk')
            <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-2">Nama Mata Kuliah</label>

        <input
            type="text"
            name="nama_mk"
            value="{{ old('nama_mk') }}"
            class="w-full border rounded p-2"
            required
        >

        @error('nama_mk')
            <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block mb-2">SKS</label>

        <input
            type="number"
            name="sks"
            min="1"
            max="6"
            value="{{ old('sks') }}"
            class="w-full border rounded p-2"
            required
        >

        @error('sks')
            <p class="text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection