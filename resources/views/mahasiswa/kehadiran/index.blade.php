@extends('layouts.mahasiswa')

@section('title', 'Rekap Kehadiran')

@section('content')

<div class="mb-6">
    <h1 class="text-2xl font-bold text-slate-800">Rekap Kehadiran</h1>
    <p class="text-slate-500 mt-1">Ringkasan kehadiran Anda di semua mata kuliah.</p>
</div>

@if($rekap->isEmpty())
    <div class="bg-white rounded-3xl border border-slate-100 p-12 text-center shadow-sm">
        <i class="ph ph-clipboard-text text-6xl text-slate-300 mb-4 block"></i>
        <h3 class="text-lg font-bold text-slate-500 mb-1">Belum Ada Data</h3>
        <p class="text-slate-400">Tidak ditemukan jadwal kuliah untuk kelas Anda.</p>
    </div>
@else
    {{-- LEGEND --}}
    <div class="flex flex-wrap items-center gap-4 mb-5">
        <div class="flex items-center gap-1.5">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-emerald-50 text-emerald-600 font-bold text-xs">H</span>
            <span class="text-xs text-slate-500">Hadir</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-rose-50 text-rose-600 font-bold text-xs">X</span>
            <span class="text-xs text-slate-500">Tidak Hadir</span>
        </div>
        <div class="flex items-center gap-1.5">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 text-slate-400 font-bold text-xs">-</span>
            <span class="text-xs text-slate-500">Belum</span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-max">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100">
                        <th class="p-4 px-6 font-semibold text-slate-600 sticky left-0 bg-slate-50/95 backdrop-blur-sm z-10 min-w-[200px]">Mata Kuliah</th>

                        @for ($i = 1; $i <= 16; $i++)
                            <th class="p-3 text-center font-semibold text-slate-600 min-w-[48px]">
                                @if ($i >= 1 && $i <= 7)
                                    <span class="text-xs">P{{ $i }}</span>
                                @elseif ($i == 8)
                                    <span class="text-xs font-bold text-amber-600">UTS</span>
                                @elseif ($i >= 9 && $i <= 15)
                                    <span class="text-xs">P{{ $i - 1 }}</span>
                                @elseif ($i == 16)
                                    <span class="text-xs font-bold text-amber-600">UAS</span>
                                @endif
                            </th>
                        @endfor

                        <th class="p-3 text-center font-semibold text-slate-600 min-w-[60px]">
                            <span class="text-xs">Total</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($rekap as $item)
                        <tr class="hover:bg-slate-50/30 transition-colors">
                            {{-- Mata Kuliah (sticky) --}}
                            <td class="p-4 px-6 sticky left-0 bg-white z-10 border-r border-slate-50">
                                <div class="font-bold text-slate-800 text-sm">{{ $item['nama_mk'] }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ $item['kode_mk'] }}</div>
                            </td>

                            {{-- 16 Status Columns --}}
                            @foreach ($item['statuses'] as $status)
                                <td class="p-3 text-center">
                                    @if ($status === 'H')
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 font-bold text-xs" title="Hadir">H</span>
                                    @elseif ($status === 'X')
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-rose-50 text-rose-600 font-bold text-xs" title="Tidak Hadir">X</span>
                                    @else
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 text-slate-400 font-bold text-xs" title="Belum">-</span>
                                    @endif
                                </td>
                            @endforeach

                            {{-- Total Hadir --}}
                            <td class="p-3 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-700 font-bold text-xs">
                                    {{ $item['total_hadir'] }}/16
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-6">
        @php
            $allStatuses = $rekap->pluck('statuses')->flatten();
            $totalH = $allStatuses->filter(fn($s) => $s === 'H')->count();
            $totalX = $allStatuses->filter(fn($s) => $s === 'X')->count();
            $totalDash = $allStatuses->filter(fn($s) => $s === '-')->count();
        @endphp

        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm text-center">
            <div class="w-12 h-12 mx-auto rounded-xl bg-emerald-50 flex items-center justify-center mb-3">
                <i class="ph ph-check-circle text-2xl text-emerald-500"></i>
            </div>
            <p class="text-2xl font-bold text-emerald-600">{{ $totalH }}</p>
            <p class="text-xs text-slate-500 mt-1">Total Hadir</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm text-center">
            <div class="w-12 h-12 mx-auto rounded-xl bg-rose-50 flex items-center justify-center mb-3">
                <i class="ph ph-x-circle text-2xl text-rose-500"></i>
            </div>
            <p class="text-2xl font-bold text-rose-600">{{ $totalX }}</p>
            <p class="text-xs text-slate-500 mt-1">Tidak Hadir</p>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 p-5 shadow-sm text-center">
            <div class="w-12 h-12 mx-auto rounded-xl bg-slate-50 flex items-center justify-center mb-3">
                <i class="ph ph-clock text-2xl text-slate-400"></i>
            </div>
            <p class="text-2xl font-bold text-slate-500">{{ $totalDash }}</p>
            <p class="text-xs text-slate-500 mt-1">Belum / Mendatang</p>
        </div>
    </div>
@endif

@endsection
