@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Kelas
</h1>

<form action="{{ route('admin.kelas.update', $kelas) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-4">

        <label class="block mb-2">
            Nama Kelas
        </label>

        <input
            type="text"
            name="nama_kelas"
            value="{{ $kelas->nama_kelas }}"
            class="w-full border rounded p-2"
            required
        >

    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection