<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' — UKS Sekolah' : 'UKS Sekolah — Layanan Kesehatan Sekolah' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/uks.css') }}">
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
            darkMode: 'class'
        }
    </script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
        /* Hide scrollbar for Chrome, Safari and Opera */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        /* Hide scrollbar for IE, Edge and Firefox */
        .hide-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-slate-950 dark:text-slate-100 min-h-screen flex flex-col antialiased selection:bg-teal-500 selection:text-white overflow-x-hidden max-w-full w-full">

    <!-- Navbar Publik Modern (Mendukung Mode Terang & Gelap Senada dengan Admin) -->
    <header class="sticky top-0 z-50 bg-white/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 transition-colors duration-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-24">
                <!-- Brand / Logo -->
                <a href="{{ route('home') }}" class="flex items-center space-x-3 group">
                    <img src="{{ asset('images/logo-smkn1ciomas.svg') }}" alt="Logo SMKN 1 Ciomas" class="h-24 w-auto object-contain group-hover:scale-105 transition-transform duration-200">
                    <div class="hidden sm:block">
                        <span class="font-extrabold text-lg tracking-wider text-slate-900 dark:text-white block leading-tight">UKS SMKN 1 CIOMAS</span>
                        <span class="text-[11px] font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-widest block">Unit Kesehatan Sekolah</span>
                    </div>
                    <div class="sm:hidden">
                        <span class="font-extrabold text-base tracking-wider text-slate-900 dark:text-white block leading-tight">UKS</span>
                        <span class="text-[10px] font-semibold text-teal-600 dark:text-teal-400 uppercase tracking-widest block">SMKN 1 CIOMAS</span>
                    </div>
                </a>

                <!-- Navigasi Menu -->
                <nav class="hidden md:flex items-center gap-1 bg-slate-100/90 dark:bg-slate-800/60 p-1.5 rounded-2xl border border-slate-200/80 dark:border-slate-700/60 backdrop-blur-xs">
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('home') ? 'bg-teal-600 dark:bg-teal-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                        Beranda
                    </a>
                    <a href="{{ route('public.layanan') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('public.layanan') ? 'bg-teal-600 dark:bg-teal-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                        Layanan UKS
                    </a>
                    <a href="{{ route('public.ringkasan') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('public.ringkasan') ? 'bg-teal-600 dark:bg-teal-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                        Ringkasan
                    </a>
                    <a href="{{ route('public.kunjungan') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('public.kunjungan') ? 'bg-teal-600 dark:bg-teal-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                        Kunjungan Siswa
                    </a>
                    <a href="{{ route('public.kunjungan.create') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('public.kunjungan.create') ? 'bg-teal-600 dark:bg-teal-700 text-white shadow-xs' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-200/70 dark:text-slate-300 dark:hover:text-white dark:hover:bg-slate-700/50' }}">
                        Isi Kunjungan
                    </a>
                    <a href="{{ route('public.hubungi') }}" class="px-4 py-2 rounded-xl text-xs font-semibold transition {{ request()->routeIs('public.hubungi') ? 'bg-rose-600 dark:bg-rose-700 text-white shadow-xs' : 'text-rose-600 hover:text-rose-700 hover:bg-rose-50 dark:text-rose-400 dark:hover:text-white dark:hover:bg-rose-900/50' }}">
                        Hubungi Darurat
                    </a>
                </nav>

                <!-- Tombol Portal Admin & Theme Toggle -->
                <div class="flex items-center gap-2.5">
                    <!-- Tombol Toggle Terang / Gelap -->
                    <button type="button" onclick="toggleTheme()" class="p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800/90 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:text-amber-500 dark:hover:text-amber-400 transition shadow-xs cursor-pointer flex items-center justify-center" title="Ubah Mode Terang / Gelap" aria-label="Toggle Theme">
                        <svg class="theme-icon-sun w-4 h-4 text-amber-500 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        <svg class="theme-icon-moon w-4 h-4 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                        </svg>
                    </button>

                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-teal-600 px-3 py-2 sm:px-4 sm:py-2.5 text-xs font-bold text-white shadow-md hover:bg-teal-500 transition">
                            <span class="hidden sm:inline">Dashboard Admin</span>
                            <span class="sm:hidden">Admin</span>
                            <span>→</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 px-3 py-2 sm:px-4 sm:py-2 text-xs font-bold text-slate-700 hover:text-slate-900 dark:text-slate-200 dark:hover:text-white transition shadow-xs">
                            <span class="hidden sm:inline">Login Petugas</span>
                            <span class="sm:hidden">Login</span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Strip -->
        <div class="md:hidden flex items-center justify-start gap-2 border-t border-slate-200 dark:border-slate-800 px-4 py-2.5 bg-white/95 dark:bg-slate-900/95 overflow-x-auto text-xs font-medium hide-scrollbar">
            <a href="{{ route('home') }}" class="shrink-0 px-3 py-1.5 rounded-lg {{ request()->routeIs('home') ? 'bg-teal-600 text-white font-bold' : 'text-slate-600 dark:text-slate-400' }}">Beranda</a>
            <a href="{{ route('public.layanan') }}" class="shrink-0 px-3 py-1.5 rounded-lg {{ request()->routeIs('public.layanan') ? 'bg-teal-600 text-white font-bold' : 'text-slate-600 dark:text-slate-400' }}">Layanan</a>
            <a href="{{ route('public.ringkasan') }}" class="shrink-0 px-3 py-1.5 rounded-lg {{ request()->routeIs('public.ringkasan') ? 'bg-teal-600 text-white font-bold' : 'text-slate-600 dark:text-slate-400' }}">Ringkasan</a>
            <a href="{{ route('public.kunjungan') }}" class="shrink-0 px-3 py-1.5 rounded-lg {{ request()->routeIs('public.kunjungan') ? 'bg-teal-600 text-white font-bold' : 'text-slate-600 dark:text-slate-400' }}">Kunjungan</a>
            <a href="{{ route('public.kunjungan.create') }}" class="shrink-0 px-3 py-1.5 rounded-lg {{ request()->routeIs('public.kunjungan.create') ? 'bg-teal-600 text-white font-bold' : 'text-slate-600 dark:text-slate-400' }}">Isi</a>
            <a href="{{ route('public.hubungi') }}" class="shrink-0 px-3 py-1.5 rounded-lg {{ request()->routeIs('public.hubungi') ? 'bg-rose-600 text-white font-bold' : 'text-rose-600 dark:text-rose-400' }}">Hubungi</a>
        </div>
    </header>

    @if (session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs flex items-center gap-3">
                <span class="text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif

    @if (isset($errors) && $errors->any())
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
            <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs flex items-center gap-3">
                <span class="text-base">✕</span>
                <span>Periksa kembali kelengkapan formulir Anda.</span>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="flex-1">
        @yield('content')
    </div>

    <!-- Footer Modern (Dark Slate) -->
    <footer class="bg-slate-950 text-slate-400 border-t border-slate-800/80 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Kolom 1: Brand -->
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center space-x-3">
                        <div class="h-9 w-9 rounded-lg bg-amber-400 flex items-center justify-center text-slate-950 font-black text-lg">
                            +
                        </div>
                        <span class="font-extrabold text-base tracking-wider text-white">UKS SEKOLAH</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-sm">
                        Unit Kesehatan Sekolah yang mengutamakan pertolongan pertama, pencegahan, dan pemantauan kesehatan siswa dengan cepat, ramah, dan terintegrasi digital.
                    </p>
                    <div class="pt-2 flex items-center gap-2 text-xs text-teal-400 font-semibold">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        Pelayanan Siaga Aktif di Jam Sekolah
                    </div>
                </div>

                <!-- Kolom 2: Menu Navigasi -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">Navigasi Utama</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('home') }}" class="hover:text-teal-400 transition">Beranda</a></li>
                        <li><a href="{{ route('public.layanan') }}" class="hover:text-teal-400 transition">Layanan</a></li>
                        <li><a href="{{ route('public.ringkasan') }}" class="hover:text-teal-400 transition">Ringkasan</a></li>
                        <li><a href="{{ route('public.kunjungan.create') }}" class="hover:text-teal-400 transition">Kunjungan</a></li>
                        <li><a href="{{ route('public.hubungi') }}" class="hover:text-rose-400 transition text-rose-400 font-semibold">Hubungi Darurat</a></li>
                    </ul>
                </div>

                <!-- Kolom 3: Jadwal & Lokasi -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-white mb-4">JADWAL DAN LOKASI</h4>
                    <div class="space-y-2 text-xs text-slate-400">
                        <p><strong class="text-slate-200">Senin – Kamis:</strong><br>06.30 – 15.30 WIB</p>
                        <p><strong class="text-slate-200">Jumat:</strong><br>06.30 – 13.00 WIB</p>
                        <p><strong class="text-slate-200">Lokasi UKS:</strong><br>SMKN 1 CIOMAS</p>
                        <p><strong class="text-slate-200">Layanan Darurat:</strong><br>Petugas</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-800/80 pt-6 flex flex-col sm:flex-row items-center justify-between text-[11px] text-slate-500 gap-2">
                <span>&copy; {{ date('Y') }} UKS Sekolah. Seluruh hak cipta dilindungi.</span>
                <span>Kesehatan siswa adalah fondasi utama keberhasilan belajar.</span>
            </div>
        </div>
    </footer>

    <script>
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
