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

    <div class="min-h-screen p-6">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-xl font-bold">
                SmartClass QR
            </h1>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500 hover:text-red-700">
                    Logout
                </button>
            </form>
        </div>

        {{-- CONTENT --}}
        @yield('content')

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
