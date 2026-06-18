@extends('layouts.admin')

@section('content')

<h1>Tambah Jadwal Kuliah</h1>

<form action="{{ route('admin.jadwal_kuliah.store') }}" method="POST">
    @csrf

    <div>
        <label>Dosen</label>
        <select name="dosen_id" required>
            <option value="">Pilih Dosen</option>

            @foreach ($dosen as $item)
                <option value="{{ $item->id }}">
                    {{ $item->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Mata Kuliah</label>
        <select name="mata_kuliah_id" required>
            <option value="">Pilih Mata Kuliah</option>

            @foreach ($mataKuliah as $item)
                <option value="{{ $item->id }}">
                    {{ $item->kode_mk }} - {{ $item->nama_mk }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Kelas</label>
        <select name="kelas_id" required>
            <option value="">Pilih Kelas</option>

            @foreach ($kelas as $item)
                <option value="{{ $item->id }}">
                    {{ $item->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Hari</label>
        <select name="hari" required>
            <option value="Senin">Senin</option>
            <option value="Selasa">Selasa</option>
            <option value="Rabu">Rabu</option>
            <option value="Kamis">Kamis</option>
            <option value="Jumat">Jumat</option>
            <option value="Sabtu">Sabtu</option>
        </select>
    </div>

    <br>

    <div>
        <label>Jam Mulai</label>
        <input type="time" name="jam_mulai" required>
    </div>

    <br>

    <div>
        <label>Jam Selesai</label>
        <input type="time" name="jam_selesai" required>
    </div>

    <br>

    <button type="submit">
        Simpan
    </button>
</form>

@endsection
