<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | SanakTech Academy Student Dashboard</title>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body class="bg-gray-100 text-gray-900 font-sans antialiased">

    <!-- Layout Wrapper -->
    <div class="flex h-screen overflow-hidden">

        <!-- Sidebar -->
        <aside id="sidebar" class="bg-white shadow-md w-64 flex-shrink-0 hidden md:block">
            <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <h1 class="text-xl font-bold text-orange-500">SanakTech Academy</h1>
            </div>

            <nav class="mt-6">
                <a href="{{ route('student.courses.index') }}"
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 7h18M3 12h18m-9 5h9"/>
                    </svg>
                    Kursus Saya
                </a>

                <a href="{{ route('student.certificates.show', $course ?? null) }}"
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-orange-50 hover:text-orange-500 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 11c0 .265-.105.52-.293.707A.997.997 0 0111 12a1 1 0 011-1zm0 0V9m0 6h.01M4 6h16M4 6l8 14L20 6"/>
                    </svg>
                    Sertifikat
                </a>

                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                   class="flex items-center px-6 py-3 text-gray-700 hover:bg-red-50 hover:text-red-600 transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5"/>
                    </svg>
                    Keluar
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col">

            <!-- Top Navbar -->
            <header class="bg-white shadow-md border-b border-gray-200 flex items-center justify-between px-6 py-3">
                <div class="flex items-center space-x-4">
                    <!-- Mobile Sidebar Button -->
                    <button id="sidebarToggle" class="md:hidden text-gray-600 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h1 class="text-lg font-semibold text-gray-800">@yield('title')</h1>
                </div>

                <!-- User Info -->
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-orange-500 rounded-full flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name ?? 'Student' }}</span>
                </div>
            </header>

            <!-- Dynamic Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 text-center py-4 text-sm text-gray-500">
                &copy; {{ date('Y') }} SanakTech Academy — Semua hak dilindungi.
            </footer>
        </div>
    </div>

    <!-- Sidebar Toggle Script -->
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('hidden');
        });
    </script>
</body>
</html>
