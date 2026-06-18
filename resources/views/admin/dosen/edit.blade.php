@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Dosen
</h1>

<form action="{{ route('admin.dosen.update', $dosen) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block mb-2">Nama</label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $dosen->user->name) }}"
            class="w-full border rounded p-2"
        >

        @error('name')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-2">Email</label>

        <input
            type="email"
            name="email"
            value="{{ old('email', $dosen->user->email) }}"
            class="w-full border rounded p-2"
        >

        @error('email')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label class="block mb-2">NIDN</label>

        <input
            type="text"
            name="nidn"
            value="{{ old('nidn', $dosen->nidn) }}"
            class="w-full border rounded p-2"
        >

        @error('nidn')
            <p class="text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-2">
        <button
            type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded">
            Update
        </button>

        <a href="{{ route('admin.dosen.index') }}"
           class="bg-gray-500 text-white px-4 py-2 rounded">
            Batal
        </a>
    </div>

</form>

@endsection
