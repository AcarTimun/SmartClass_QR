@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Dosen
</h1>

<form action="{{ route('admin.dosen.store') }}" method="POST">

    @csrf

    <div class="mb-4">
        <label class="block mb-2">Nama</label>

        <input type="text"
               name="name"
               value="{{ old('name') }}"
               class="w-full border rounded p-2">

        @error('name')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-2">Email</label>

        <input type="email"
               name="email"
               value="{{ old('email') }}"
               class="w-full border rounded p-2">

        @error('email')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-2">Password</label>

        <input type="password"
               name="password"
               class="w-full border rounded p-2">

        @error('password')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block mb-2">NIDN</label>

        <input type="text"
               name="nidn"
               value="{{ old('nidn') }}"
               class="w-full border rounded p-2">

        @error('nidn')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection
