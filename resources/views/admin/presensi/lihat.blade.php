@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Absensi Mahasiswa
</h1>

<table class="w-full bg-white rounded shadow">

    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Status</th>
        </tr>
    </thead>

    <tbody>

        @foreach ($jadwal->kelas->mahasiswa as $mhs)

            @php
                $hadir = false;

                if ($sesi) {
                    $hadir = $sesi->kehadiran
                        ->where('mahasiswa_id', $mhs->id)
                        ->where('status', 'hadir')
                        ->count() > 0;
                }
            @endphp

            <tr class="border-t">
                <td class="p-3">{{ $mhs->user->name }}</td>

                <td class="p-3 text-xl">
                    @if ($hadir)
                        <span class="text-green-600">●</span>
                    @else
                        <span class="text-gray-400">○</span>
                    @endif
                </td>
            </tr>

        @endforeach

    </tbody>

</table>

@endsection
