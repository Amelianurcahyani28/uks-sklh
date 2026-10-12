<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $heading ?? 'Sistem UKS Sekolah' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/uks.css') }}?v={{ file_exists(public_path('css/uks.css')) ? filemtime(public_path('css/uks.css')) : time() }}">
    <script>
        if (localStorage.getItem('uks_theme') === 'dark' || (!('uks_theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        * {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        body, button, input, select, textarea, h1, h2, h3, h4, h5, h6 {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* High-Contrast Crisp Table Borders for Admin */
        table {
            border-collapse: collapse !important;
            width: 100%;
        }
        html:not(.dark) table th {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            font-weight: 800 !important;
            border-bottom: 2.5px solid #64748b !important;
        }
        html:not(.dark) table td {
            border-bottom: 1.5px solid #94a3b8 !important;
        }
        html:not(.dark) table tbody tr:nth-child(even) td {
            background-color: #f8fafc !important;
        }
        html:not(.dark) table tbody tr:hover td {
            background-color: #e2e8f0 !important;
        }
        html.dark table th {
            background-color: #0f172a !important;
            color: #f8fafc !important;
            border-bottom: 2.5px solid #475569 !important;
        }
        html.dark table td {
            border-bottom: 1.5px solid #334155 !important;
        }
    </style>
</head>
<body class="bg-slate-100 dark:bg-slate-950 font-sans antialiased text-slate-800 dark:text-slate-100">

    <div class="min-h-screen flex overflow-x-hidden w-full">
        <!-- Sidebar Backdrop (Mobile) -->
        <div id="sidebarBackdrop" class="fixed inset-0 bg-slate-950/50 z-40 hidden md:hidden backdrop-blur-sm transition-opacity" onclick="toggleSidebar()"></div>

        <!-- Sidebar Admin -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-300 flex flex-col justify-between border-r border-slate-800 transition-transform duration-300 -translate-x-full md:translate-x-0 md:static md:w-64 shrink-0">
            <div class="overflow-y-auto">
                <!-- Brand / Logo / Judul yang bisa diklik ke Beranda -->
                <div class="px-6 h-20 flex items-center space-x-3 border-b border-slate-800">
                    <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 text-white hover:opacity-80 transition">
                        <img src="{{ asset('images/logo-smkn1ciomas.svg') }}" alt="Logo" class="max-h-14 w-auto object-contain">
                        <span class="font-bold text-lg tracking-wide">UKS SEKOLAH</span>
                    </a>
                </div>

                <!-- Menu Navigasi Sidebar -->
                <nav class="p-4 space-y-1">
                    <!-- Menu Beranda / Dashboard -->
                    <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('dashboard') ? 'bg-emerald-600 dark:bg-emerald-800 text-white font-medium shadow-md' : 'hover:bg-slate-800 text-slate-300' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Dashboard</span>
                    </a>

                    <!-- Menu Ringkasan -->
                    <a href="{{ route('admin.ringkasan') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('admin.ringkasan') ? 'bg-emerald-600 dark:bg-emerald-800 text-white font-medium shadow-md' : 'hover:bg-slate-800 text-slate-300' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        <span>Ringkasan</span>
                    </a>

                    <!-- Menu Catat Kunjungan (Data Siswa yang Kunjung) -->
                    <a href="{{ route('kunjungan.index') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('kunjungan.*') ? 'bg-emerald-600 dark:bg-emerald-800 text-white font-medium shadow-md' : 'hover:bg-slate-800 text-slate-300' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Catat kunjungan</span>
                    </a>

                    <!-- Menu Data Siswa -->
                    <a href="{{ route('students.index') }}" class="flex items-center px-4 py-3 rounded-xl transition {{ request()->routeIs('students.*') ? 'bg-emerald-600 dark:bg-emerald-800 text-white font-medium shadow-md' : 'hover:bg-slate-800 text-slate-300' }}">
                        <svg class="w-5 h-5 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <span>Data siswa</span>
                    </a>
                </nav>
                </nav>
            </div>

            <!-- Bagian Profil & Logout di Bawah Sidebar -->
            <div class="p-4 border-t border-slate-800 space-y-2">
                <div class="mb-2 px-2">
                    <p class="text-sm font-bold text-white truncate">{{ Auth::user()->name ?? 'Admin UKS' }}</p>
                </div>
                
                <!-- Tombol Logout Menggunakan Form POST -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-2.5 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition text-sm font-medium">
                        <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        <span>Logout</span>
                    </button>
                </form>

                <!-- Akses Kembali ke Halaman Beranda -->
                <a href="{{ route('home') }}" class="w-full flex items-center px-4 py-2 rounded-lg text-slate-400 hover:bg-slate-800 hover:text-white transition text-xs font-medium">
                    <svg class="w-4 h-4 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                    </svg>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>
        </aside>

        <!-- Konten Utama -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header Atas -->
            <header class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 px-4 sm:px-8 h-20 flex justify-between items-center shadow-xs admin-header">
                <div class="flex items-center gap-3">
                    <button type="button" class="md:hidden p-2 rounded-lg text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 bg-slate-50 dark:bg-slate-800/50" onclick="toggleSidebar()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div>
                        <p class="text-xs text-slate-400 hidden sm:block">{{ now()->translatedFormat('l, d F Y') }}</p>
                        <h1 class="text-lg sm:text-2xl font-bold text-slate-800 dark:text-white">{{ $heading ?? 'Dashboard' }}</h1>
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3">
                    <!-- Tombol Ubah Tema Terang / Gelap Admin -->
                    <button type="button" onclick="toggleTheme()" class="inline-flex items-center gap-2 px-3 sm:px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 text-xs font-semibold transition shadow-xs cursor-pointer" title="Ubah Mode Terang / Gelap">
                        <svg class="theme-icon-sun w-4 h-4 text-amber-400 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="theme-icon-moon w-4 h-4 text-slate-500 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                        <span class="theme-toggle-text hidden sm:inline">Mode Terang</span>
                    </button>

                    <a href="{{ route('home') }}" target="_blank" class="inline-flex items-center gap-1.5 text-sm text-emerald-700 dark:text-emerald-400 hover:text-emerald-800 dark:hover:text-emerald-300 font-semibold bg-emerald-50 dark:bg-slate-800 hover:bg-emerald-100 dark:hover:bg-slate-700 px-3 sm:px-4 py-2 rounded-xl border border-emerald-200 dark:border-slate-700 transition">
                        <span class="hidden sm:inline">Lihat Website</span>
                        <span class="sm:hidden">Web</span>
                        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </header>

            <!-- Main Content Area -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden w-full flex flex-col">
                @if (session('success'))
                    <div class="mx-4 sm:mx-8 mt-4 p-4 bg-emerald-50 dark:bg-emerald-950/70 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-200 rounded-xl shadow-xs text-xs font-semibold">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
            }
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-icon-sun').forEach(el => el.classList.toggle('hidden', !isDark));
            document.querySelectorAll('.theme-icon-moon').forEach(el => el.classList.toggle('hidden', isDark));
            document.querySelectorAll('.theme-toggle-text').forEach(el => {
                el.textContent = isDark ? 'Mode Gelap' : 'Mode Terang';
            });
        }

        function toggleTheme() {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('uks_theme', isDark ? 'dark' : 'light');
            updateThemeIcons();
        }

        document.addEventListener('DOMContentLoaded', updateThemeIcons);
    </script>
</body>
</html>