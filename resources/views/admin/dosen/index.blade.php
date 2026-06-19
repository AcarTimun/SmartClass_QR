@extends('layouts.admin')

@section('title', 'Data Dosen')

@section('content')

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-2xl font-bold text-slate-800">Manajemen Dosen</h1>
        <p class="text-slate-500 mt-1">Kelola data pengajar / dosen.</p>
    </div>

    <a href="{{ route('admin.dosen.create') }}"
       class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2.5 rounded-xl font-medium transition-colors flex items-center gap-2 shadow-sm shadow-indigo-200">
        <i class="ph ph-plus-circle text-xl"></i>
        Tambah Dosen
    </a>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100">
                    <th class="p-4 px-6 font-semibold text-slate-600 w-24">No</th>
                    <th class="p-4 px-6 font-semibold text-slate-600">Dosen</th>
                    <th class="p-4 px-6 font-semibold text-slate-600">NIDN</th>
                    <th class="p-4 px-6 font-semibold text-slate-600 w-48">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($dosen as $item)
                    <tr class="hover:bg-slate-50/50 transition-colors group">
                        <td class="p-4 px-6 text-slate-500">
                            {{ $loop->iteration }}
                        </td>
                        <td class="p-4 px-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold">
                                    {{ substr($item->user->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-slate-800">{{ $item->user->name }}</div>
                                    <div class="text-sm text-slate-500">{{ $item->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="p-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-sm font-medium bg-slate-100 text-slate-700">
                                {{ $item->nidn }}
                            </span>
                        </td>
                        <td class="p-4 px-6">
                            <div class="flex items-center gap-2 opacity-100 md:opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="{{ route('admin.dosen.edit', $item) }}"
                                   class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center hover:bg-amber-100 transition-colors tooltip" title="Edit">
                                    <i class="ph ph-pencil-simple text-lg"></i>
                                </a>

                                <form action="{{ route('admin.dosen.destroy', $item) }}"
                                      method="POST"
                                      class="delete-form m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center hover:bg-rose-100 transition-colors" title="Hapus">
                                        <i class="ph ph-trash text-lg"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-8 text-center">
                            <div class="flex flex-col items-center justify-center text-slate-400">
                                <i class="ph ph-empty text-5xl mb-3 text-slate-300"></i>
                                <p class="text-slate-500 font-medium">Belum ada data dosen</p>
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
                title: 'Hapus Data Dosen?',
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
