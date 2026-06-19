<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SmartClass QR</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-800 text-white p-5">
            <h1 class="text-2xl font-bold mb-8">
                SmartClass QR
            </h1>

            <nav class="space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="block hover:text-blue-300">
                    Dashboard
                </a>

                <a href="{{ route('admin.kelas.index') }}" class="block hover:text-blue-300">
                    Kelas
                </a>

                <a href="{{ route('admin.mata_kuliah.index') }}" class="block hover:text-blue-300">
                    Mata Kuliah
                </a>

                <a href="{{ route('admin.dosen.index') }}" class="block hover:text-blue-300">
                    Dosen
                </a>

                <a href="{{ route('admin.mahasiswa.index') }}" class="block hover:text-blue-300">
                    Mahasiswa
                </a>

                <a href="{{ route('admin.jadwal_kuliah.index') }}" class="block hover:text-blue-300">
                    Jadwal Kuliah
                </a>
            </nav>

            <div class="mt-10">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button class="text-red-400 hover:text-red-300">
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 p-8">
            @yield('content')
        </main>

    </div>
@if(session('success'))
    <script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        timer: 2000,
        showConfirmButton: false
    });
    </script>
@endif
</body>
</html>
