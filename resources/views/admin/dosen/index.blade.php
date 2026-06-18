@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">
        Data Dosen
    </h1>

    <a href="{{ route('admin.dosen.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Dosen
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<table class="w-full bg-white rounded shadow">

    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">No</th>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">NIDN</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @forelse($dosen as $item)
            <tr class="border-t">

                <td class="p-3">
                    {{ $loop->iteration }}
                </td>

                <td class="p-3">
                    {{ $item->user->name }}
                </td>

                <td class="p-3">
                    {{ $item->user->email }}
                </td>

                <td class="p-3">
                    {{ $item->nidn }}
                </td>

                <td class="p-3 flex gap-2">

                    <a href="{{ route('admin.dosen.edit', $item) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">
                        Edit
                    </a>

                    <form action="{{ route('admin.dosen.destroy', $item) }}"
                          method="POST"
                          class="delete-form">

                        @csrf
                        @method('DELETE')

                        <button class="bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </button>
                    </form>
                </td>

            </tr>
        @empty

            <tr>
                <td colspan="5" class="p-3 text-center">
                    Belum ada data dosen
                </td>
            </tr>

        @endforelse

    </tbody>

</table>

<script>
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            Swal.fire({
                title: 'Hapus Data Dosen ini?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection
