<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Sistem UKS Sekolah</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <script>
        // Check theme preference before rendering to prevent flash
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
</head>
<body class="bg-slate-50 dark:bg-slate-950 font-sans text-slate-800 dark:text-slate-100 antialiased min-h-screen flex items-center justify-center p-4">

    <!-- Kontainer Utama -->
    <div class="max-w-5xl w-full bg-white dark:bg-slate-900 rounded-3xl shadow-2xl dark:shadow-none dark:border dark:border-slate-800 overflow-hidden flex flex-col md:flex-row relative">
        
        <!-- Sisi Kiri (Branding / Visual) -->
        <div class="md:w-5/12 bg-teal-700 dark:bg-teal-900 p-10 md:p-12 text-white flex flex-col justify-between relative overflow-hidden hidden md:flex">
            <!-- Pola / Ornamen Latar -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-teal-600/30 dark:bg-teal-800/30 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-teal-800/30 dark:bg-teal-950/30 rounded-full blur-3xl"></div>

            <div class="relative z-10">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-teal-800/50 dark:bg-teal-950/50 border border-teal-600/50 dark:border-teal-700/50 text-xs font-semibold tracking-wide mb-8">
                    <svg class="w-4 h-4 text-teal-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    UKS SEKOLAH
                </div>
                <h1 class="text-3xl lg:text-4xl font-extrabold leading-tight mb-4 text-white">Ruang sehat untuk tumbuh bersama.</h1>
                <p class="text-teal-100 dark:text-teal-200/80 text-sm leading-relaxed">
                    Kelola layanan kesehatan siswa dengan catatan yang rapi, cepat, dan mudah dipantau oleh seluruh petugas.
                </p>
            </div>
            
            <!-- Simulasi Diagram Bar -->
            <div class="mt-12 relative z-10 flex gap-3 items-end h-32 opacity-90">
                <div class="w-8 bg-teal-400 rounded-t-md h-3/6 shadow-lg shadow-teal-900/20"></div>
                <div class="w-8 bg-rose-400 rounded-t-md h-4/6 shadow-lg shadow-teal-900/20"></div>
                <div class="w-8 bg-slate-200 rounded-t-md h-2/6 shadow-lg shadow-teal-900/20"></div>
                <div class="w-8 bg-amber-400 rounded-t-md h-full shadow-lg shadow-teal-900/20"></div>
            </div>
        </div>

        <!-- Sisi Kanan (Form Login) -->
        <div class="md:w-7/12 p-8 md:p-14 flex items-center relative w-full">
            
            <!-- Tombol Toggle Tema (Absolute Top Right) -->
            <button type="button" onclick="toggleTheme()" class="absolute top-6 right-6 p-2 rounded-xl text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition" title="Ubah Mode Tema">
                <svg class="theme-icon-sun w-5 h-5 hidden text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                <svg class="theme-icon-moon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" /></svg>
            </button>

            <div class="w-full max-w-sm mx-auto">
                <div class="mb-8 md:hidden flex items-center gap-2 px-3 py-1.5 rounded-full bg-teal-50 dark:bg-teal-900/30 text-teal-700 dark:text-teal-400 text-xs font-bold tracking-wide w-fit mb-6">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    UKS SEKOLAH
                </div>

                <div class="mb-8">
                    <p class="text-xs font-bold tracking-wider text-slate-400 dark:text-slate-500 uppercase mb-2">Selamat Datang Kembali</p>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-slate-800 dark:text-white">Masuk ke UKS</h2>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mt-2">Gunakan akun petugas atau admin untuk melanjutkan ke ruang kerja Anda.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm font-medium flex gap-3 items-start">
                        <svg class="w-5 h-5 shrink-0 text-rose-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-4 py-3">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kata Sandi</label>
                        <input type="password" name="password" required
                            class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-4 py-3">
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            <input type="checkbox" name="remember" value="1" class="rounded border-slate-300 dark:border-slate-600 text-teal-600 focus:ring-teal-600 dark:bg-slate-800 cursor-pointer">
                            <span class="text-sm font-medium text-slate-600 dark:text-slate-400 group-hover:text-slate-900 dark:group-hover:text-slate-200 transition">Ingat saya</span>
                        </label>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-teal-700 dark:bg-teal-600 px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-teal-800 dark:hover:bg-teal-500 transition mt-2">
                        Masuk ke Dashboard
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                    
                    <div class="text-center mt-8">
                        <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Halaman Publik
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('uks_theme', 'light');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('uks_theme', 'dark');
            }
            updateThemeIcons();
        }

        function updateThemeIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            document.querySelectorAll('.theme-icon-sun').forEach(el => el.classList.toggle('hidden', !isDark));
            document.querySelectorAll('.theme-icon-moon').forEach(el => el.classList.toggle('hidden', isDark));
        }

        // Initialize icons on load
        updateThemeIcons();
    </script>
</body>
</html>