@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">
        Data Kelas
    </h1>

    <a href="{{ route('admin.kelas.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded">
        Tambah Kelas
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
            <th class="p-3 text-left">Nama Kelas</th>
            <th class="p-3 text-left">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @forelse($kelas as $item)
            <tr class="border-t">

                <td class="p-3">
                    {{ $loop->iteration }}
                </td>

                <td class="p-3">
                    {{ $item->nama_kelas }}
                </td>

                <td class="p-3 flex gap-2">

                    <a href="{{ route('admin.kelas.edit', $item) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded">
                        Edit
                    </a>

                    <form action="{{ route('admin.kelas.destroy', $item) }}"
                        method="POST"
                        class="delete-form">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">
                            Hapus
                        </button>
                    </form>

                </td>

            </tr>
        @empty

            <tr>
                <td colspan="3" class="p-3 text-center">
                    Belum ada data kelas
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
                title: 'Hapus Data Kelas ini?',
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
