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
                @forelse($jadwalKuliah as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-4 px-6 text-slate-500">
                            {{ $loop->iteration }}
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
                            @if ($item->sesiPresensi)
                                @php $status = $item->sesiPresensi->status_label; @endphp
                                <span class="
                                    inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                                    {{ $status == 'Dibuka' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $status == 'Expired' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $status == 'Ditutup' ? 'bg-rose-100 text-rose-700' : '' }}
                                ">
                                    @if($status == 'Dibuka')
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    @endif
                                    {{ $status }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-slate-100 text-slate-500">
                                    Belum ada sesi
                                </span>
                            @endif
                        </td>

                        <td class="p-4 px-6">
                            <div class="flex gap-2 justify-center">
                                @if ($item->sesiPresensi && $item->sesiPresensi->isDibuka())
                                    <a href="{{ route('admin.presensi.aktif', $item->id) }}"
                                       class="bg-emerald-50 hover:bg-emerald-100 text-emerald-600 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-emerald-200 tooltip" title="Lihat QR">
                                        <i class="ph ph-qr-code text-lg"></i>
                                    </a>
                                @else
                                    <form action="{{ route('admin.presensi.buka', $item->id) }}" method="POST" class="m-0">
                                        @csrf
                                        <button class="bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-indigo-200 tooltip" title="Buka Presensi">
                                            <i class="ph ph-play-circle text-lg"></i>
                                        </button>
                                    </form>
                                @endif

                                <a href="{{ route('admin.presensi.lihat', $item->id) }}" 
                                   class="bg-sky-50 hover:bg-sky-100 text-sky-600 px-3 py-1.5 rounded-lg text-sm font-medium transition-colors border border-sky-200 tooltip" title="Lihat Rekap Absen">
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
