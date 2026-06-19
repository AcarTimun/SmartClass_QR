@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Absensi Mahasiswa
</h1>

<form action="{{ route('admin.presensi.bulk') }}" method="POST">
@csrf
<input type="hidden" name="sesi_id" value="{{ $sesi->id }}">

<table class="w-full bg-white rounded shadow">

        <thead class="bg-gray-200">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-center">Hadir</th>
                <th class="p-3 text-center">Tidak Hadir</th>
            </tr>
        </thead>

        <tbody>

            @foreach ($jadwal->kelas->mahasiswa as $mhs)
                @php
                    $data = null;

                    if ($sesi) {
                        $data = $sesi->kehadiran
                            ->where('mahasiswa_id', $mhs->id)
                            ->first();
                    }

                    $status = $data->status ?? 'X'; // default tidak hadir
                @endphp

                <tr class="border-t">
                    <td class="p-3">{{ $mhs->user->name }}</td>

                    {{-- HADIR --}}
                    <td class="p-3 text-center">
                        <input type="radio"
                            name="kehadiran[{{ $mhs->id }}]"
                            value="hadir"
                            {{ $status == 'H' ? 'checked' : '' }}
                            class="w-5 h-5 accent-green-500">
                    </td>

                    {{-- TIDAK HADIR --}}
                    <td class="p-3 text-center">
                        <input type="radio"
                            name="kehadiran[{{ $mhs->id }}]"
                            value="tidak_hadir"
                            {{ $status == 'X' ? 'checked' : '' }}
                            class="w-5 h-5 accent-red-500">
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>
    <div class="mt-6 flex justify-between items-center">
        {{-- INFO --}}
        <div class="text-sm text-gray-600">
            Pilih status lalu klik simpan
        </div>

        {{-- SUBMIT --}}
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded">
            Simpan Absensi
        </button>
    </div>
</form>


@endsection
