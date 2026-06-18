@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Tambah Kelas
</h1>

<form action="{{ route('admin.kelas.store') }}" method="POST">

    @csrf

    <div class="mb-4">

        <label class="block mb-2">
            Nama Kelas
        </label>

        <input
            type="text"
            name="nama_kelas"
            class="w-full border rounded p-2"
            required
        >

    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Simpan
    </button>

</form>

@endsection