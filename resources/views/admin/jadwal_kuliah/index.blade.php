@extends('layouts.admin')

@section('title', 'Jadwal Kuliah')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Jadwal Kuliah</h1>
        <p class="text-slate-500 mt-1">Atur jadwal perkuliahan dan presensi.</p>
    </div>

    <a href="{{ route('admin.jadwal_kuliah.create') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-sm shadow-indigo-200">
        <i class="ph ph-calendar-plus text-xl"></i>
        Tambah Jadwal
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    {{-- Search & Pagination Header --}}
    <div class="p-4 border-b border-slate-100 bg-slate-50/30 flex flex-col sm:flex-row gap-4 justify-between items-center">
        <form action="{{ route('admin.jadwal_kuliah.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full justify-between">
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500 font-medium">Tampilkan</span>
                <select name="per_page" onchange="this.form.submit()" class="border-slate-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500 py-2 pl-3 pr-8">
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
                <span class="text-sm text-slate-500 font-medium">data</span>
            </div>
            
            <div class="flex gap-2">
                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <i class="ph ph-magnifying-glass text-slate-400 text-lg"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" class="bg-white border border-slate-200 text-slate-800 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 p-2 shadow-sm" placeholder="Cari MK, Dosen, Kelas...">
                </div>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors shadow-sm">
                    Cari
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.jadwal_kuliah.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm" title="Reset Pencarian">
                        <i class="ph ph-x"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-max">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="p-4 px-6 font-semibold text-slate-600 w-16">No</th>
                    <th class="p-4 px-6 font-semibold text-slate-600">Info Jadwal</th>
                    <th class="p-4 px-6 font-semibold text-slate-600">Dosen</th>
                    <th class="p-4 px-6 font-semibold text-slate-600">Status Presensi</th>
                    <th class="p-4 px-6 font-semibold text-slate-600 text-center">Presensi</th>
                    <th class="p-4 px-6 font-semibold text-slate-600 w-28 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($jadwalKuliah as $index => $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-4 px-6 text-slate-500">
                            {{ $jadwalKuliah->firstItem() + $index }}
                        </td>
                        
                        <td class="p-4 px-6">
                            <div class="mb-1 font-bold text-slate-800">{{ $item->mataKuliah->nama_mk }}</div>
                            <div class="flex items-center gap-2 text-sm">
                                <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded font-medium">{{ $item->mataKuliah->kode_mk }}</span>
                                <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded font-medium">{{ $item->kelas->nama_kelas }}</span>
                            </div>
                            <div class="mt-2 flex items-center gap-2 text-sm text-slate-500">
                                <i class="ph ph-calendar-blank"></i> {{ $item->hari }}
                                <i class="ph ph-clock ml-2"></i> {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                            </div>
                        </td>

                        <td class="p-4 px-6">
                            <div class="flex items-center gap-2 text-slate-700">
                                <i class="ph ph-user-circle text-xl text-slate-400"></i>
                                <span class="font-medium">{{ $item->dosen->user->name }}</span>
                            </div>
                        </td>

                        <td class="p-4 px-6">
                            @if ($item->activeSesi)
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-700 mb-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Aktif: {{ $item->activeSesi->pertemuan_label }}
                                </div>
                            @else
                                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-500 mb-1">
                                    Tidak ada sesi aktif
                                </div>
                            @endif
                            <div class="text-xs text-slate-500 font-medium">
                                {{ $item->sesiPresensi->where('status', 'ditutup')->count() }} / 16 Sesi Selesai
                            </div>
                        </td>

                        <td class="p-4 px-6">
                            <div class="flex gap-2 justify-center">
                                @if ($item->activeSesi)
                                    <a href="{{ route('admin.presensi.aktif', $item->id) }}"
                                       class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-emerald-200 tooltip" title="Lihat QR">
                                        <i class="ph ph-qr-code text-lg"></i>
                                    </a>
                                @endif

                                <a href="{{ route('admin.presensi.lihat', $item->id) }}" 
                                   class="bg-sky-50 hover:bg-sky-100 text-sky-600 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-sky-200 tooltip" title="Kelola Absensi">
                                    <i class="ph ph-list-checks text-lg"></i>
                                </a>
                            </div>
                        </td>

                        <td class="p-4 px-6">
                            <div class="flex items-center justify-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.jadwal_kuliah.edit', $item) }}"
                                   class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-colors tooltip" title="Edit Jadwal">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                </a>

                                <form action="{{ route('admin.jadwal_kuliah.destroy', $item) }}"
                                      method="POST"
                                      class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition-colors tooltip" title="Hapus Jadwal">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="ph ph-calendar-x text-5xl mb-3 text-slate-300"></i>
                                <p class="text-slate-500 font-medium">Belum ada data jadwal kuliah</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($jadwalKuliah->hasPages())
    <div class="p-4 border-t border-slate-100">
        {{ $jadwalKuliah->links() }}
    </div>
    @endif
</div>

<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Jadwal Kuliah?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: 'Ya, hapus',
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
</script>
@endsection
