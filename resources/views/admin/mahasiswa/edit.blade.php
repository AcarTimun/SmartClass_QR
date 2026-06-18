@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Mahasiswa
</h1>

<form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST">

    @csrf
    @method('PUT')

    <div class="mb-4">
        <label class="block mb-2">Nama</label>

        <input type="text"
               name="name"
               value="{{ old('name', $mahasiswa->user->name) }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2">Email</label>

        <input type="email"
               name="email"
               value="{{ old('email', $mahasiswa->user->email) }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-4">
        <label class="block mb-2">NIM</label>

        <input type="text"
               name="nim"
               value="{{ old('nim', $mahasiswa->nim) }}"
               class="w-full border rounded p-2">
    </div>

    <div class="mb-6">
        <label class="block mb-2">Kelas</label>

        <select name="kelas_id"
                class="w-full border rounded p-2">

            @foreach($kelas as $item)
                <option value="{{ $item->id }}"
                    @selected(old('kelas_id', $mahasiswa->kelas_id) == $item->id)>
                    {{ $item->nama_kelas }}
                </option>
            @endforeach

        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded">
        Update
    </button>

</form>

@endsection
