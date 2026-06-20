@extends('layouts.dosen')

@section('title', 'Jadwal Kuliah')

@section('content')

<h1 class="text-2xl font-bold mb-6">
    Jadwal Mengajar
</h1>

<div class="space-y-6">

    @forelse($jadwal as $hari => $items)

        {{-- HEADER HARI --}}
        <h2 class="text-xl font-bold text-slate-700">
            {{ $hari }}
        </h2>

        <div class="space-y-4">

            @foreach($items as $item)

                <div class="bg-white rounded-3xl p-5 shadow-sm border border-slate-100 hover:shadow-md transition-all">

                    <div class="flex justify-between items-center">

                        {{-- LEFT --}}
                        <div>
                            <h3 class="text-lg font-bold text-slate-800">
                                {{ $item->mataKuliah->nama_mk }}
                            </h3>

                            <p class="text-sm text-slate-500">
                                {{ $item->kelas->nama_kelas }}
                            </p>

                            <p class="text-xs text-slate-400 mt-1">
                                {{ $item->hari }} •
                                {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                            </p>
                        </div>

                        {{-- RIGHT --}}
                        <div class="flex gap-2 items-center">

                            @if ($item->activeSesi)
                                <a href="{{ route('dosen.presensi.aktif', $item->id) }}"
                                   class="bg-emerald-600 hover:bg-emerald-700 text-white px-3 py-2 rounded-xl text-sm font-semibold shadow-sm flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                                    Lihat QR Sesi Aktif
                                </a>
                            @endif

                            <a href="{{ route('dosen.presensi.lihat', $item->id) }}"
                               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-semibold shadow-sm">
                                Kelola Absensi
                            </a>

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="mt-3 flex flex-wrap gap-2">

                        @if ($item->activeSesi)
                            <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                                Sesi Aktif: {{ $item->activeSesi->pertemuan_label }}
                            </span>
                        @else
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500">
                                Tidak ada sesi aktif
                            </span>
                        @endif

                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-600">
                            {{ $item->sesiPresensi->where('status', 'ditutup')->count() }} / 16 Sesi Selesai
                        </span>

                    </div>

                </div>

            @endforeach

        </div>

    @empty

        <div class="text-center text-slate-500">
            Belum ada jadwal mengajar
        </div>

    @endforelse

</div>

@endsection
