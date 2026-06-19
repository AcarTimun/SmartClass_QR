@extends('layouts.admin')

@section('content')

<h1 class="text-3xl font-bold mb-6">
    Edit Mahasiswa
</h1>

<form action="{{ route('admin.mahasiswa.update', $mahasiswa) }}" method="POST">

    @csrf
    @method('PUT')
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 mb-4 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

        @error('email')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-2">Prodi</label>

        <select name="prodi"
                class="w-full border rounded p-2">

            <option value="">Pilih Prodi</option>

            <option value="Sistem Informasi"
                {{ old('prodi', $mahasiswa->prodi) == 'Sistem Informasi' ? 'selected' : '' }}>
                Sistem Informasi
            </option>

            <option value="Teknologi Informasi"
                {{ old('prodi', $mahasiswa->prodi) == 'Teknologi Informasi' ? 'selected' : '' }}>
                Teknologi Informasi
            </option>

            <option value="Sistem Komputer"
                {{ old('prodi', $mahasiswa->prodi) == 'Sistem Komputer' ? 'selected' : '' }}>
                Sistem Komputer
            </option>

            <option value="Bisnis Digital"
                {{ old('prodi', $mahasiswa->prodi) == 'Bisnis Digital' ? 'selected' : '' }}>
                Bisnis Digital
            </option>

            <option value="Teknologi Informatika"
                {{ old('prodi', $mahasiswa->prodi) == 'Teknologi Informatika' ? 'selected' : '' }}>
                Teknologi Informatika
            </option>

        </select>

        {{-- ERROR --}}
        @error('prodi')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-4">
        <label class="block mb-2">NIM</label>

        <input type="text"
               name="nim"
               value="{{ old('nim', $mahasiswa->nim) }}"
               class="w-full border rounded p-2">

        @error('nim')
            <small class="text-red-500">{{ $message }}</small>
        @enderror
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
