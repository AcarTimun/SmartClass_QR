@extends('layouts.admin')

@section('content')

<h1>Edit Jadwal Kuliah</h1>

<form action="{{ route('admin.jadwal_kuliah.update', $jadwalKuliah) }}" method="POST">
    @csrf
    @method('PUT')

    <div>
        <label>Dosen</label>
        <select name="dosen_id" required>
            @foreach ($dosen as $item)
                <option value="{{ $item->id }}"
                    @selected($jadwalKuliah->dosen_id == $item->id)>
                    {{ $item->user->name }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Mata Kuliah</label>
        <select name="mata_kuliah_id" required>
            @foreach ($mataKuliah as $item)
                <option value="{{ $item->id }}"
                    @selected($jadwalKuliah->mata_kuliah_id == $item->id)>
                    {{ $item->kode_mk }} - {{ $item->nama_mk }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Kelas</label>
        <select name="kelas_id" required>
            @foreach ($kelas as $item)
                <option value="{{ $item->id }}"
                    @selected($jadwalKuliah->kelas_id == $item->id)>
                    {{ $item->nama_kelas }}
                </option>
            @endforeach
        </select>
    </div>

    <br>

    <div>
        <label>Hari</label>
            <select name="hari" required>

                <option value="Senin"
                    {{ $jadwalKuliah->hari == 'Senin' ? 'selected' : '' }}>
                    Senin
                </option>

                <option value="Selasa"
                    {{ $jadwalKuliah->hari == 'Selasa' ? 'selected' : '' }}>
                    Selasa
                </option>

                <option value="Rabu"
                    {{ $jadwalKuliah->hari == 'Rabu' ? 'selected' : '' }}>
                    Rabu
                </option>

                <option value="Kamis"
                    {{ $jadwalKuliah->hari == 'Kamis' ? 'selected' : '' }}>
                    Kamis
                </option>

                <option value="Jumat"
                    {{ $jadwalKuliah->hari == 'Jumat' ? 'selected' : '' }}>
                    Jumat
                </option>

                <option value="Sabtu"
                    {{ $jadwalKuliah->hari == 'Sabtu' ? 'selected' : '' }}>
                    Sabtu
                </option>

        </select>
    </div>

    <br>

    <div>
        <label>Jam Mulai</label>
        <input type="time"
               name="jam_mulai"
               value="{{ $jadwalKuliah->jam_mulai }}"
               required>
    </div>

    <br>

    <div>
        <label>Jam Selesai</label>
        <input type="time"
               name="jam_selesai"
               value="{{ $jadwalKuliah->jam_selesai }}"
               required>
    </div>

    <br>

    <button type="submit">
        Update
    </button>
</form>

@endsection
