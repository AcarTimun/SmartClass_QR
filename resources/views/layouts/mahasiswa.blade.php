<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa - SmartClass QR</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">

    <div class="min-h-screen flex flex-col">

        {{-- HEADER --}}
        <div class="bg-blue-600 text-white p-4 flex justify-between">
            <span>
                Halo, {{ auth()->user()->name }}
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-200 hover:text-white">
                    Logout
                </button>
            </form>
        </div>

        {{-- CONTENT --}}
        <div class="flex-1 p-6">
            @yield('content')
        </div>

    </div>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Berhasil',
    text: '{{ session('success') }}',
    confirmButtonText: 'OK'
});
</script>
@endif

@if(session('error'))
<script>
Swal.fire({
    icon: 'error',
    title: 'Gagal',
    text: '{{ session('error') }}',
    confirmButtonText: 'OK'
});
</script>
@endif

</body>
</html>
