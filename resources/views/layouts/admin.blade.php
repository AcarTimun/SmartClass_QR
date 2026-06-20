<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SmartClass QR</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Phosphor Icons for modern thin icons -->
    <script src="https://unpkg.com/@phosphor-icons/web"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-x-hidden">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden relative">

        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen" x-transition.opacity 
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm md:hidden" style="display: none;"></div>

        <!-- Floating Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="fixed inset-y-0 left-0 z-50 w-72 flex-shrink-0 p-4 transition-transform duration-300 md:relative md:translate-x-0 flex flex-col">
            <div class="bg-white rounded-3xl shadow-sm border border-slate-100 flex-1 flex flex-col overflow-hidden relative h-full">
                
                <!-- Logo Area -->
                <div class="p-6 flex items-center justify-center border-b border-slate-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-indigo-200">
                            <i class="ph ph-qr-code"></i>
                        </div>
                        <h1 class="text-xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-sky-500">
                            SmartClass
                        </h1>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 overflow-y-auto p-4 space-y-1.5 scrollbar-hide">
                    
                    @php
                        $navItems = [
                            ['route' => 'admin.dashboard', 'icon' => 'ph-squares-four', 'label' => 'Dashboard'],
                            ['route' => 'admin.kelas.index', 'icon' => 'ph-chalkboard-teacher', 'label' => 'Kelas'],
                            ['route' => 'admin.mata_kuliah.index', 'icon' => 'ph-book-open-text', 'label' => 'Mata Kuliah'],
                            ['route' => 'admin.dosen.index', 'icon' => 'ph-users-three', 'label' => 'Dosen'],
                            ['route' => 'admin.mahasiswa.index', 'icon' => 'ph-student', 'label' => 'Mahasiswa'],
                            ['route' => 'admin.jadwal_kuliah.index', 'icon' => 'ph-calendar-blank', 'label' => 'Jadwal Kuliah'],
                        ];
                    @endphp

                    @foreach($navItems as $item)
                        @php
                            // Check if current route matches or is a child of the nav item route
                            $isActive = request()->routeIs($item['route']) || 
                                        (str_starts_with($item['route'], 'admin.kelas') && request()->routeIs('admin.kelas.*')) ||
                                        (str_starts_with($item['route'], 'admin.mata_kuliah') && request()->routeIs('admin.mata_kuliah.*')) ||
                                        (str_starts_with($item['route'], 'admin.dosen') && request()->routeIs('admin.dosen.*')) ||
                                        (str_starts_with($item['route'], 'admin.mahasiswa') && request()->routeIs('admin.mahasiswa.*')) ||
                                        (str_starts_with($item['route'], 'admin.jadwal_kuliah') && request()->routeIs('admin.jadwal_kuliah.*'));
                        @endphp
                        
                        <a href="{{ route($item['route']) }}" 
                           class="flex items-center gap-3 px-4 py-3 rounded-2xl transition-all duration-300 group {{ $isActive ? 'bg-indigo-600 text-white shadow-md shadow-indigo-200 translate-x-1' : 'text-slate-500 hover:bg-indigo-50 hover:text-indigo-600' }}">
                            <i class="ph {{ $item['icon'] }} text-2xl {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-indigo-600' }} transition-colors"></i>
                            <span class="font-medium">{{ $item['label'] }}</span>
                        </a>
                    @endforeach

                </nav>

                <!-- Logout Area -->
                <div class="p-4 border-t border-slate-50">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl text-rose-500 hover:bg-rose-50 font-medium transition-colors">
                            <i class="ph ph-sign-out text-xl"></i>
                            Keluar
                        </button>
                    </form>
                </div>

            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            
            <!-- Topbar (Glassmorphism) -->
            <header class="h-20 px-8 flex items-center justify-between backdrop-blur-md bg-white/70 border-b border-slate-100/50 z-10 sticky top-0">
                <div class="flex items-center gap-4">
                    <!-- Mobile Menu Button -->
                    <button @click="sidebarOpen = true" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-white shadow-sm text-slate-500 hover:text-indigo-600 transition-colors">
                        <i class="ph ph-list text-2xl"></i>
                    </button>
                    
                    <div>
                        <h2 class="text-xl font-bold text-slate-800">@yield('title', 'Admin Panel')</h2>
                        <p class="text-sm text-slate-500">Kelola data akademik dengan mudah.</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:flex items-center gap-3 bg-white px-4 py-2 rounded-full shadow-sm border border-slate-100">
                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 font-bold">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <span class="font-medium text-slate-700">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </header>

            <!-- Scrollable Content -->
            <div class="flex-1 overflow-y-auto p-4 md:p-8 scroll-smooth">
                <div class="max-w-7xl mx-auto space-y-6">
                    @yield('content')
                </div>
            </div>

        </main>

    </div>

    @if(session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false,
            customClass: {
                popup: 'rounded-3xl',
            }
        });
        </script>
    @endif
    @if(session('error'))
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            customClass: {
                popup: 'rounded-3xl',
            }
        });
        </script>
    @endif

    {{-- Session Timeout Auto-Logout --}}
    <script>
    (function() {
        const sessionLifetime = {{ config('session.lifetime') }} * 60 * 1000; // menit ke ms
        let logoutTimer;

        function resetTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(showExpiredAlert, sessionLifetime);
        }

        function showExpiredAlert() {
            Swal.fire({
                icon: 'warning',
                title: 'Sesi Login Berakhir',
                text: 'Sesi login telah berakhir, harap login kembali.',
                confirmButtonText: 'Login Kembali',
                allowOutsideClick: false,
                allowEscapeKey: false,
                customClass: { popup: 'rounded-3xl', confirmButton: 'rounded-xl' }
            }).then(() => {
                window.location.href = '{{ route("login") }}';
            });
        }

        // Reset timer saat ada aktivitas user
        ['click', 'keypress', 'scroll', 'mousemove'].forEach(event => {
            document.addEventListener(event, resetTimer, { passive: true });
        });

        resetTimer();
    })();
    </script>
</body>
</html>
