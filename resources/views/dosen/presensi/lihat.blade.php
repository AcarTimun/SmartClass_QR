@extends('layouts.dosen')

@section('title', 'Rekap Absensi')

@section('content')
<div class="mb-6">
    <a href="{{ route('dosen.jadwal_kuliah') }}" class="inline-flex items-center text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors gap-1 mb-2">
        <i class="ph ph-arrow-left"></i> Kembali ke Jadwal Mengajar
    </a>
    <h1 class="text-2xl font-bold text-slate-800">Rekap & Kelola Absensi</h1>
    <p class="text-slate-500 mt-1">{{ $jadwal->mataKuliah->nama_mk }} ({{ $jadwal->kelas->nama_kelas }})</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    
    {{-- SISI KIRI: DAFTAR 16 SESI --}}
    <div class="lg:col-span-4 space-y-4">
        <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
            <i class="ph ph-calendar-blank text-xl"></i> Daftar Sesi
        </h2>
        
        <div class="bg-white rounded-3xl border border-slate-100 p-4 shadow-sm max-h-[70vh] overflow-y-auto space-y-3">
            @foreach($sessions as $item)
                @php 
                    $isActive = ($sesi && $sesi->id == $item->id);
                    $status = $item->status_label;
                @endphp
                <div class="p-3.5 rounded-2xl border transition-all flex flex-col md:flex-row md:items-center justify-between gap-3
                    {{ $isActive ? 'border-indigo-600 bg-indigo-50/30 ring-1 ring-indigo-600' : 'border-slate-100 hover:border-slate-300 bg-white' }}">
                    
                    <a href="{{ route('dosen.presensi.lihat', ['jadwal' => $jadwal->id, 'sesi_id' => $item->id]) }}" class="flex-1 text-left">
                        <div class="font-bold text-slate-800 text-sm md:text-base">
                            {{ $item->pertemuan_label }}
                        </div>
                        <div class="mt-1 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full 
                                {{ $status == 'Dibuka' ? 'bg-emerald-500 animate-pulse' : '' }}
                                {{ $status == 'Expired' ? 'bg-amber-500' : '' }}
                                {{ $status == 'Ditutup' ? 'bg-rose-500' : '' }}
                            "></span>
                            <span class="text-xs font-semibold
                                {{ $status == 'Dibuka' ? 'text-emerald-700' : '' }}
                                {{ $status == 'Expired' ? 'text-amber-700' : '' }}
                                {{ $status == 'Ditutup' ? 'text-rose-700' : '' }}
                            ">
                                {{ $status }}
                            </span>
                        </div>
                    </a>
                    
                    {{-- Aksi Sesi --}}
                    <div class="flex items-center gap-2">
                        @if ($item->status == 'ditutup')
                            <form action="{{ route('dosen.presensi.buka', $item->id) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm shadow-indigo-100" title="Buka Presensi">
                                    Buka
                                </button>
                            </form>
                        @elseif ($item->status == 'dibuka')
                            <a href="{{ route('dosen.presensi.qr', $item->qr_token) }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm shadow-emerald-100" title="Lihat QR">
                                QR
                            </a>
                            <form action="{{ route('dosen.presensi.tutup', $item->id) }}" method="POST" class="m-0 select-tutup-form">
                                @csrf
                                <button type="submit" class="bg-rose-600 hover:bg-rose-700 text-white px-2.5 py-1.5 rounded-xl text-xs font-bold transition-all shadow-sm shadow-rose-100" title="Tutup Presensi">
                                    Tutup
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- SISI KANAN: TABEL MAHASISWA & KEHADIRAN --}}
    <div class="lg:col-span-8 space-y-4">
        @if ($sesi)
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                    <i class="ph ph-users text-xl"></i> Presensi: {{ $sesi->pertemuan_label }}
                </h2>
                
                @if ($sesi->status == 'dibuka')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Mahasiswa sedang melakukan scanning QR...
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                        Sesi ditutup
                    </span>
                @endif
            </div>

            {{-- STATISTIK SESI --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4 mt-2">
                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm text-center">
                    <div class="text-sm text-slate-500 font-semibold">Total Mahasiswa</div>
                    <div class="text-2xl font-bold text-slate-800">{{ $totalMahasiswa }}</div>
                </div>
                <div class="bg-emerald-50 p-4 rounded-2xl border border-emerald-100 shadow-sm text-center">
                    <div class="text-sm text-emerald-600 font-semibold">Hadir</div>
                    <div class="text-2xl font-bold text-emerald-700">{{ $hadir }}</div>
                </div>
                <div class="bg-rose-50 p-4 rounded-2xl border border-rose-100 shadow-sm text-center">
                    <div class="text-sm text-rose-600 font-semibold">Tidak Hadir</div>
                    <div class="text-2xl font-bold text-rose-700">{{ $tidakHadir }}</div>
                </div>
                <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <div class="text-sm text-slate-500 font-semibold">Belum Diisi</div>
                    <div class="text-2xl font-bold text-slate-700">{{ $belumDiisi }}</div>
                </div>
            </div>

            <form action="{{ route('dosen.presensi.bulk') }}" method="POST" id="simpan-absensi-form">
                @csrf
                <input type="hidden" name="sesi_id" value="{{ $sesi->id }}">

                <div class="bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse min-w-max">
                            <thead>
                                <tr class="bg-slate-50/50 border-b border-slate-100">
                                    <th class="p-4 px-6 font-semibold text-slate-600">Mahasiswa</th>
                                    <th class="p-4 px-6 font-semibold text-slate-600 text-center w-28">Hadir</th>
                                    <th class="p-4 px-6 font-semibold text-slate-600 text-center w-28">Tidak Hadir</th>
                                    <th class="p-4 px-6 font-semibold text-slate-600 text-center w-28">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @forelse ($jadwal->kelas->mahasiswa as $mhs)
                                    @php
                                        $data = $sesi->kehadiran->firstWhere('mahasiswa_id', $mhs->id);
                                        $status = $data->status ?? '-'; // Default belum absen
                                    @endphp
                                    <tr class="hover:bg-slate-50/30 transition-colors" id="mhs-{{ $mhs->id }}">
                                        <td class="p-4 px-6">
                                            <div class="font-bold text-slate-800">{{ $mhs->user->name }}</div>
                                            <div class="text-xs text-slate-400 mt-0.5">NIM. {{ $mhs->nim }}</div>
                                        </td>
                                        
                                        {{-- RADIO BUTTON HADIR --}}
                                        <td class="p-4 px-6 text-center">
                                            <label class="inline-flex items-center justify-center w-10 h-10 rounded-xl hover:bg-slate-100 cursor-pointer transition-colors">
                                                <input type="radio"
                                                    name="kehadiran[{{ $mhs->id }}]"
                                                    value="hadir"
                                                    {{ $status == 'H' ? 'checked' : '' }}
                                                    class="w-5 h-5 accent-emerald-500">
                                            </label>
                                        </td>
                                        
                                        {{-- RADIO BUTTON TIDAK HADIR --}}
                                        <td class="p-4 px-6 text-center">
                                            <label class="inline-flex items-center justify-center w-10 h-10 rounded-xl hover:bg-slate-100 cursor-pointer transition-colors">
                                                <input type="radio"
                                                    name="kehadiran[{{ $mhs->id }}]"
                                                    value="tidak_hadir"
                                                    {{ $status == 'X' ? 'checked' : '' }}
                                                    class="w-5 h-5 accent-rose-500">
                                            </label>
                                        </td>

                                        <td class="p-4 px-6 text-center">
                                            <span id="status-{{ $mhs->id }}">
                                                @if($status == 'H')
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 font-bold" title="Hadir">H</span>
                                                @elseif($status == 'X')
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-rose-50 text-rose-600 font-bold" title="Tidak Hadir">X</span>
                                                @else
                                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 text-slate-400 font-bold" title="Belum">-</span>
                                                @endif
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="p-8 text-center text-slate-400">
                                            Belum ada mahasiswa terdaftar di kelas ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 bg-slate-50 border-t border-slate-100 flex flex-col sm:flex-row justify-between items-center gap-3">
                        <div class="text-xs text-slate-500">
                            * Ubah status di atas lalu klik <strong>Simpan Absensi</strong> untuk memperbarui data kehadiran manual.
                        </div>
                        <button type="submit" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-sm shadow-indigo-100 transition-all">
                            Simpan Absensi
                        </button>
                    </div>
                </div>
            </form>
        @else
            <div class="bg-white rounded-3xl border border-slate-100 p-8 text-center text-slate-500 shadow-sm">
                <i class="ph ph-calendar-x text-5xl text-slate-300 mb-3 block"></i>
                Belum ada sesi presensi yang dibuat untuk kelas ini.
            </div>
        @endif
    </div>

</div>

@if ($sesi)
<script>
    let isEditing = false;
    let lastStatus = {};

    // Deteksi interaksi edit manual agar tidak bentrok dengan polling
    document.querySelectorAll('input[type="radio"]').forEach(el => {
        el.addEventListener('change', () => {
            isEditing = true;
            setTimeout(() => {
                isEditing = false;
            }, 6000);
        });
    });

    // Polling data scanner mahasiswa real-time (setiap 3 detik)
    setInterval(() => {
        if (isEditing) return;

        fetch("{{ route('dosen.presensi.data', $sesi->id) }}")
            .then(res => res.json())
            .then(data => {
                data.forEach(item => {
                    let statusEl = document.getElementById('status-' + item.mahasiswa_id);
                    let radioHadir = document.querySelector(`input[name="kehadiran[${item.mahasiswa_id}]"][value="hadir"]`);
                    let radioTidak = document.querySelector(`input[name="kehadiran[${item.mahasiswa_id}]"][value="tidak_hadir"]`);
                    let row = document.getElementById('mhs-' + item.mahasiswa_id);

                    if (item.status === 'H') {
                        if (statusEl) statusEl.innerHTML = '<span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 font-bold" title="Hadir">H</span>';
                        if (radioHadir) radioHadir.checked = true;
                    } else if (item.status === 'X') {
                        if (statusEl) statusEl.innerHTML = '<span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-rose-50 text-rose-600 font-bold" title="Tidak Hadir">X</span>';
                        if (radioTidak) radioTidak.checked = true;
                    } else {
                        if (statusEl) statusEl.innerHTML = '<span class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-slate-100 text-slate-400 font-bold" title="Belum">-</span>';
                    }

                    if (lastStatus[item.mahasiswa_id] !== item.status) {
                        if (item.status === 'H' && row) {
                            row.classList.add('bg-emerald-50/50');
                            setTimeout(() => {
                                row.classList.remove('bg-emerald-50/50');
                            }, 2500);
                        }
                        lastStatus[item.mahasiswa_id] = item.status;
                    }
                });
            });
    }, 3000);
</script>
@endif

<script>
    // Konfirmasi tutup presensi dengan SweetAlert2
    document.querySelectorAll('.select-tutup-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Tutup Sesi Presensi?',
                text: 'Setelah ditutup, mahasiswa tidak dapat melakukan scan QR lagi pada sesi ini.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Tutup',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
    // Konfirmasi simpan absensi dengan SweetAlert2
    const simpanForm = document.getElementById('simpan-absensi-form');
    if (simpanForm) {
        simpanForm.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Simpan Absensi?',
                text: 'Mahasiswa yang belum diabsen (berstatus "-") akan otomatis ditandai sebagai "Tidak Hadir" (X). Anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, Simpan',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'rounded-3xl',
                    confirmButton: 'rounded-xl',
                    cancelButton: 'rounded-xl'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    simpanForm.submit();
                }
            });
        });
    }
</script>
@endsection
