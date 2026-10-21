@extends('layouts.public', ['title' => 'Beranda'])

@section('content')
<main class="space-y-16 pb-16">
    <!-- Hero Section Full Width: Proporsional & Nyaman Dilihat -->
    <section class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center relative z-10">
                <!-- Sisi Kiri: Teks & Aksi -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 dark:bg-emerald-800/80 border border-white/25 dark:border-emerald-600/40 text-white dark:text-emerald-200 text-xs font-bold shadow-sm backdrop-blur-md">
                        <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                        <span>Pusat Layanan Kesehatan Siswa</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white dark:text-emerald-50 tracking-tight leading-tight drop-shadow-sm">
                        Ruang Sehat &amp; Peduli Untuk Belajar Dengan Nyaman.
                    </h1>

                    <p class="text-sm sm:text-base text-emerald-50 dark:text-emerald-200/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Selamat datang di Unit Kesehatan Sekolah (UKS) SMKN 1 Ciomas. Kami siap memberikan pertolongan pertama, pemulihan kondisi fisik, serta pencatatan kunjungan siswa yang cepat, akurat, dan terpercaya.
                    </p>

                    <!-- Tombol Aksi Utama -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('public.kunjungan.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 px-6 py-3.5 text-xs sm:text-sm font-extrabold shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                            <span>Isi Kunjungan Siswa</span>
                        </a>

                        <a href="#layanan" class="inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/25 px-5 py-3.5 text-xs sm:text-sm font-bold backdrop-blur-md transition-all duration-200">
                            <span>Lihat Layanan UKS</span>
                        </a>

                        <a href="{{ route('public.ringkasan') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/25 px-5 py-3.5 text-xs sm:text-sm font-bold backdrop-blur-md transition-all duration-200">
                            <span>Ringkasan Data</span>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-5 text-xs text-teal-100/80 font-medium">
                        <div class="flex items-center gap-2">
                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-teal-500/30 text-teal-300 text-xs font-bold">✓</span>
                            <span>Petugas Siaga Jam Belajar</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-teal-500/30 text-teal-300 text-xs font-bold">✓</span>
                            <span>Fasilitas P3K Lengkap &amp; Higienis</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="flex items-center justify-center w-5 h-5 rounded-full bg-teal-500/30 text-teal-300 text-xs font-bold">✓</span>
                            <span>Pencatatan Digital Cepat</span>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Kartu Showcase & Live Stats Modern -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="rounded-3xl border border-white/20 bg-slate-900/60 backdrop-blur-xl p-6 md:p-8 shadow-2xl text-white">
                        <!-- Header Kartu -->
                        <div class="flex items-center justify-between pb-5 border-b border-white/15">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('images/logo-pmr.png') }}" alt="Logo PMR SMKN 1 Ciomas" class="h-11 w-11 rounded-2xl object-contain bg-white/20 p-1 border border-white/30 shadow-inner">
                                <div>
                                    <h3 class="text-sm font-bold text-white tracking-wide">UKS Terpadu Sekolah</h3>
                                    <p class="text-[11px] text-teal-300 font-medium">Kesiapsiagaan &amp; Kepedulian</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[10px] font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-400/30">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                                Online
                            </span>
                        </div>

                        <!-- Deskripsi Singkat -->
                        <p class="text-xs text-teal-100/80 mt-5 leading-relaxed">
                            Mendukung kesehatan fisik dan mental siswa agar dapat mengikuti kegiatan belajar mengajar dengan optimal setiap hari.
                        </p>

                        <!-- Strip Statistik Live (Berwarna & Kontras) -->
                        <div class="mt-6 grid grid-cols-3 gap-3 bg-slate-950/60 p-4 rounded-2xl border border-white/10">
                            <!-- Hari ini: Amber accent -->
                            <div class="text-center p-2 rounded-xl bg-amber-500/10 border border-amber-500/20">
                                <span class="text-[11px] text-amber-200 block mb-0.5 font-medium">Hari Ini</span>
                                <strong class="text-2xl font-black text-amber-300 block">{{ $todayVisits }}</strong>
                                <span class="text-[10px] text-amber-200/80 font-medium">pasien</span>
                            </div>
                            <!-- Total Riwayat: Teal accent -->
                            <div class="text-center p-2 rounded-xl bg-teal-500/10 border border-teal-500/20">
                                <span class="text-[11px] text-teal-200 block mb-0.5 font-medium">Total Riwayat</span>
                                <strong class="text-2xl font-black text-teal-300 block">{{ $totalVisits }}</strong>
                                <span class="text-[10px] text-teal-200/80 font-medium">pasien</span>
                            </div>
                            <!-- Total Siswa: Sky accent -->
                            <div class="text-center p-2 rounded-xl bg-sky-500/10 border border-sky-500/20">
                                <span class="text-[11px] text-sky-200 block mb-0.5 font-medium">Total Siswa</span>
                                <strong class="text-2xl font-black text-sky-300 block">{{ $studentCount }}</strong>
                                <span class="text-[10px] text-sky-200/80 font-medium">terdata</span>
                            </div>
                        </div>

                        <!-- 2 Card Mini Akselerator -->
                        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="#pertolongan-pertama" class="p-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition group block">
                                <p class="text-xs font-bold text-white group-hover:text-amber-300 transition">Pemeriksaan Cepat</p>
                                <p class="text-[11px] text-teal-100/70 mt-0.5">Suhu, tensi, dan keluhan</p>
                            </a>

                            <a href="#ruang-istirahat" class="p-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition group block">
                                <p class="text-xs font-bold text-white group-hover:text-teal-300 transition">Ruang Istirahat</p>
                                <p class="text-[11px] text-teal-100/70 mt-0.5">Kondusif &amp; nyaman</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Petugas UKS Siaga Hari Ini (Tampilan Khusus Per Hari) -->
    <section id="petugas-hari-ini" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 md:p-10 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span>Jadwal Petugas Hari Ini</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">
                        Petugas UKS Siaga Hari Ini
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                        Petugas jaga yang siap melayani dan mendampingi siswa pada hari <span class="font-bold text-teal-600 dark:text-teal-400">{{ $todayFormatted }}</span>.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <span class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 border border-slate-200 dark:border-slate-700">
                        <span>🕒</span>
                        <span>Jam Operasional: 07:30 – 15:30 WIB</span>
                    </span>
                    <a href="{{ route('public.petugas') }}" class="px-3.5 py-1.5 rounded-xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 text-xs font-bold transition border border-emerald-200 dark:border-emerald-800 flex items-center gap-1">
                        <span>Semua Petugas</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            @if($todaySchedules->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($todaySchedules), 3) }} gap-5">
                    @foreach($todaySchedules as $schedule)
                        @php
                            $petugas = $schedule->petugas;
                        @endphp
                        @if($petugas)
                            <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/70 dark:from-slate-950 dark:to-slate-900/90 border border-slate-200/90 dark:border-slate-800 p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                                <div class="space-y-3">
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-300/80 dark:border-emerald-800">
                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                            <span>Sedang Bertugas Hari Ini</span>
                                        </span>
                                        <span class="text-[10px] font-semibold text-slate-400">
                                            {{ $schedule->room ?? 'Ruang UKS' }}
                                        </span>
                                    </div>

                                    <div class="flex items-center gap-3.5 pt-1">
                                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-br {{ $petugas->gender === 'L' ? 'from-teal-500 to-emerald-600' : 'from-rose-400 to-teal-600' }} text-white font-extrabold text-base flex items-center justify-center shadow-sm shrink-0">
                                            {{ strtoupper(mb_substr($petugas->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-extrabold text-slate-900 dark:text-white leading-snug">
                                                {{ $petugas->name }}
                                            </h4>
                                            <p class="text-xs font-semibold text-teal-600 dark:text-teal-400 mt-0.5">
                                                {{ $petugas->role_title }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="pt-2 text-xs space-y-1.5">
                                        <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                            <span class="text-emerald-600 dark:text-emerald-400 font-bold">🕒 Jam Piket:</span>
                                            <span class="font-bold text-slate-900 dark:text-slate-200">{{ $schedule->shift_time }}</span>
                                        </div>
                                        @if($schedule->notes)
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                                                "{{ $schedule->notes }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                @if($petugas->phone)
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $petugas->phone);
                                        $waNumber = str_starts_with($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : $cleanPhone;
                                    @endphp
                                    <div class="mt-4 pt-3 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between gap-2 text-xs">
                                        <div>
                                            <span class="text-[10px] text-slate-400 block">Kontak:</span>
                                            <span class="font-bold text-slate-700 dark:text-slate-300 text-xs">{{ $petugas->phone }}</span>
                                        </div>
                                        <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Bapak/Ibu ' . $petugas->name . ' (Petugas UKS SMKN 1 Ciomas), saya ingin bertanya seputar layanan UKS.') }}" target="_blank" rel="noopener noreferrer" class="px-2.5 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 font-bold text-[11px] flex items-center gap-1 transition border border-emerald-200 dark:border-emerald-800">
                                            <span>WhatsApp</span>
                                            <span>↗</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
            @elseif(! $isWeekday)
                <!-- Tampilan Khusus Akhir Pekan (Sabtu / Minggu) -->
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50 p-6 sm:p-8 space-y-4">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-slate-200/80 dark:border-slate-800">
                        <div>
                            <div class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800 mb-1">
                                Libur Akhir Pekan
                            </div>
                            <h4 class="text-sm font-extrabold text-slate-900 dark:text-white">
                                Pelayanan Reguler UKS Libur Hari {{ $todayDayName }}
                            </h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                                Unit Kesehatan Sekolah melayani kegiatan belajar mengajar setiap hari Senin sampai Jumat (07:30 – 15:30 WIB).
                            </p>
                        </div>

                        <a href="{{ route('public.hubungi') }}" class="px-3.5 py-2 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-xs transition shrink-0 flex items-center gap-1">
                            <span>Kontak Darurat</span>
                            <span>→</span>
                        </a>
                    </div>

                    @if($nextMondaySchedules && $nextMondaySchedules->isNotEmpty())
                        <div class="space-y-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block">
                                Petugas Jaga Siaga Hari Kerja Berikutnya (Senin):
                            </span>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($nextMondaySchedules as $schedule)
                                    @php $p = $schedule->petugas; @endphp
                                    @if($p)
                                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs">
                                            <div class="w-10 h-10 rounded-xl bg-gradient-to-br {{ $p->gender === 'L' ? 'from-teal-500 to-emerald-600' : 'from-rose-400 to-teal-600' }} text-white font-extrabold text-sm flex items-center justify-center shrink-0">
                                                {{ strtoupper(mb_substr($p->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $p->name }}</p>
                                                <p class="text-[10px] text-teal-600 dark:text-teal-400 font-semibold">{{ $p->role_title }}</p>
                                                <p class="text-[10px] text-slate-400">🕒 Senin, {{ $schedule->shift_time }}</p>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="rounded-2xl border border-dashed border-slate-300 dark:border-slate-800 p-8 text-center space-y-2 bg-slate-50/50 dark:bg-slate-950/40">
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                        Tidak ada petugas reguler yang dijadwalkan pada hari {{ $todayDayName }}.
                    </p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">
                        Ruang UKS tetap dapat diakses untuk penanganan darurat melalui koordinasi guru piket atau pihak sekolah.
                    </p>
                </div>
            @endif
        </div>
    </section>

    <!-- Section 1: Pilar Layanan UKS (Program Unggulan) -->
    <section id="layanan" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
        <div id="pilar-layanan" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8 scroll-mt-24">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                    Program Unggulan
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Layanan &amp; Fasilitas UKS</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Standar penanganan kesehatan primer terstruktur mulai dari pencegahan, pengobatan sakit ringan, hingga pertolongan medis darurat.
                </p>
            </div>

            <!-- 4 Pilar Layanan Lengkap -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Pilar 1 -->
                <div id="pertolongan-pertama" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="h-8 w-8 rounded-lg bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 font-extrabold text-xs flex items-center justify-center">
                                01
                            </span>
                            <span class="text-[11px] font-semibold text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-950/70 border border-teal-200 dark:border-teal-800 px-2.5 py-1 rounded-md">Siap Sedia Jam Sekolah</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Pertolongan Pertama Pada Kecelakaan (P3K)</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Tindakan cepat dan tepat untuk mengatasi cedera fisik yang terjadi saat aktivitas sekolah, olahraga, maupun upacara.
                        </p>
                        <ul class="mt-4 space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li class="flex items-start gap-2">
                                <span class="text-teal-600 dark:text-teal-400 font-bold">✓</span>
                                <span>Pembersihan dan pembalutan luka lecet atau goresan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-teal-600 dark:text-teal-400 font-bold">✓</span>
                                <span>Penanganan terkilir, memar, atau cedera otot ringan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-teal-600 dark:text-teal-400 font-bold">✓</span>
                                <span>Penanganan mimisan dan luka robek ringan</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-teal-600 dark:text-teal-400 font-bold">✓</span>
                                <span>Imobilisasi awal sebelum rujukan bila dicurigai fraktur</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Pilar 2 -->
                <div id="penanganan-ringan" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="h-8 w-8 rounded-lg bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 font-extrabold text-xs flex items-center justify-center">
                                02
                            </span>
                            <span class="text-[11px] font-semibold text-amber-800 dark:text-amber-300 bg-amber-50 dark:bg-amber-950/70 border border-amber-200 dark:border-amber-800 px-2.5 py-1 rounded-md">Standar Obat Aman</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Penanganan Keluhan Dan Sakit Ringan</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Layanan bagi siswa yang mengalami penurunan kondisi fisik selama jam pelajaran berlangsung di kelas.
                        </p>
                        <ul class="mt-4 space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 dark:text-amber-400 font-bold">✓</span>
                                <span>Pemberian obat pereda nyeri dan demam (Parasetamol)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 dark:text-amber-400 font-bold">✓</span>
                                <span>Penanganan maag, kembung, dan sakit perut (Antasida)</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 dark:text-amber-400 font-bold">✓</span>
                                <span>Aromaterapi minyak kayu putih dan balsem pereda</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-amber-600 dark:text-amber-400 font-bold">✓</span>
                                <span>Pemberian larutan oralit / elektrolit untuk dehidrasi</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Pilar 3 -->
                <div id="ruang-istirahat" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="h-8 w-8 rounded-lg bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 border border-sky-200 dark:border-sky-800 font-extrabold text-xs flex items-center justify-center">
                                03
                            </span>
                            <span class="text-[11px] font-semibold text-sky-800 dark:text-sky-300 bg-sky-50 dark:bg-sky-950/70 border border-sky-200 dark:border-sky-800 px-2.5 py-1 rounded-md">Kapasitas 4 Ranjang</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Ruang Istirahat Dan Observasi Siswa</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Kamar khusus yang bersih, sejuk, dan tenang untuk pemulihan tenaga siswa sakit dalam pemantauan petugas.
                        </p>
                        <ul class="mt-4 space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li class="flex items-start gap-2">
                                <span class="text-sky-600 dark:text-sky-400 font-bold">✓</span>
                                <span>Ranjang periksa dengan sprei yang diganti berkala</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sky-600 dark:text-sky-400 font-bold">✓</span>
                                <span>Suhu ruangan berpendingin udara dan tenang</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sky-600 dark:text-sky-400 font-bold">✓</span>
                                <span>Pemisahan area istirahat siswa putra dan putri</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-sky-600 dark:text-sky-400 font-bold">✓</span>
                                <span>Pemantauan berkala tanda vital setiap 20-30 menit</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Pilar 4 -->
                <div id="rujukan" class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <span class="h-8 w-8 rounded-lg bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 font-extrabold text-xs flex items-center justify-center">
                                04
                            </span>
                            <span class="text-[11px] font-semibold text-indigo-800 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-950/70 border border-indigo-200 dark:border-indigo-800 px-2.5 py-1 rounded-md">Mitra Puskesmas</span>
                        </div>
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white">Prosedur Rujukan Dan Koordinasi Cepat</h3>
                        <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed">
                            Protokol penanganan jika kondisi siswa membutuhkan bantuan medis spesialis atau pertolongan dokter tingkat lanjut.
                        </p>
                        <ul class="mt-4 space-y-2 text-xs text-slate-600 dark:text-slate-400">
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold">✓</span>
                                <span>Pemberitahuan resmi langsung ke orang tua / wali murid</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold">✓</span>
                                <span>Koordinasi darurat dengan Puskesmas binaan terdekat</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold">✓</span>
                                <span>Fasilitas antar jemput ambulans sekolah / faskes</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="text-indigo-600 dark:text-indigo-400 font-bold">✓</span>
                                <span>Penerbitan surat izin pulang sakit resmi dari UKS</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 2: Fasilitas & Sarana Medis UKS -->
    <section id="fasilitas" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                    Sarana Dan Peralatan
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Fasilitas Dan Peralatan Medis UKS</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Peralatan kesehatan yang tersedia lengkap di ruang UKS SMKN 1 Ciomas.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Diagnostik</span>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tensimeter Dan Termometer Digital</h4>
                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Pemeriksaan tekanan darah dan temperatur tubuh akurat nir-sentuh.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Antropometri</span>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Timbangan Dan Microtoise</h4>
                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Pengukuran berat dan tinggi badan untuk pemantauan tumbuh kembang.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 text-xs font-bold mb-3">Darurat</span>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tabung Oksigen Siaga</h4>
                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Bantuan pernapasan darurat bagi siswa dengan riwayat asma atau sesak.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 border border-sky-200 dark:border-sky-800 text-xs font-bold mb-3">P3K</span>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kotak P3K Portable</h4>
                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Kotak pertolongan pertama lengkap yang siap dibawa ke lapangan.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Perawatan</span>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kassa, Plester Dan Antiseptik</h4>
                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Povidone iodine, rivanol, perban elastis, plester cepat, dan bidai.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 text-xs font-bold mb-3">Farmasi</span>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Lemari Obat Khusus</h4>
                    <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Penyimpanan obat teratur dengan kontrol tanggal kadaluwarsa ketat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 3: Alur Pelayanan (SOP Siswa Sakit - Berwarna & Terstruktur) -->
    <section id="alur" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800 uppercase tracking-wider mb-2">
                    Standard Operating Procedure
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Alur Pelayanan Saat Merasa Sakit di Sekolah</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Ikuti tahapan sederhana ini saat membutuhkan pertolongan di ruang UKS.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="p-6 rounded-2xl bg-teal-50/60 dark:bg-slate-950/60 border border-teal-200/70 dark:border-slate-800/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center font-black text-sm mb-3 shadow-md shadow-teal-600/30">
                            01
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Izin Dan Lapor Ke UKS</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Minta izin guru kelas atau guru piket, lalu datang ke ruang UKS didampingi teman jika perlu.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-2xl bg-amber-50/60 dark:bg-slate-950/60 border border-amber-200/70 dark:border-slate-800/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-black text-sm mb-3 shadow-md shadow-amber-500/30">
                            02
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Pemeriksaan Awal</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Petugas UKS melakukan anamnesa singkat, mengecek suhu badan atau keluhan fisik untuk tindakan tepat.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-2xl bg-sky-50/60 dark:bg-slate-950/60 border border-sky-200/70 dark:border-slate-800/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-sky-600 text-white flex items-center justify-center font-black text-sm mb-3 shadow-md shadow-sky-600/30">
                            03
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Tindakan Dan Istirahat</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Diberikan penanganan pertama, obat yang sesuai, dan waktu beristirahat di ranjang observasi UKS.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-2xl bg-indigo-50/60 dark:bg-slate-950/60 border border-indigo-200/70 dark:border-slate-800/80 flex flex-col justify-between hover:shadow-md transition">
                    <div>
                        <div class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center font-black text-sm mb-3 shadow-md shadow-indigo-600/30">
                            04
                        </div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-2">Tindak Lanjut</h4>
                        <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Jika membaik, siswa kembali ke kelas. Jika belum, dikoordinasikan untuk izin pulang atau rujukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section 4: Tim Pengelola & Kemitraan Pelayanan -->
    <section id="tim" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 scroll-mt-24">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                    Personil &amp; Mitra
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Tim Pengelola &amp; Jadwal Pelayanan</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Didukung oleh tenaga pendamping yang berdedikasi menjaga kesehatan siswa.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Koordinator</span>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white">Pembina UKS Sekolah</h4>
                    <p class="text-xs text-teal-700 dark:text-teal-400 font-semibold mt-0.5">Guru Penanggung Jawab</p>
                    <p class="mt-3 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Bertanggung jawab atas administrasi, ketersediaan obat, serta koordinasi dengan kepala sekolah.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Pelaksana</span>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white">Petugas Harian &amp; PMR</h4>
                    <p class="text-xs text-teal-700 dark:text-teal-400 font-semibold mt-0.5">Tim Medis &amp; P3K Sekolah</p>
                    <p class="mt-3 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Siap siaga di ruang UKS memberikan pertolongan pertama dan observasi kesehatan harian siswa.</p>
                </div>

                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 shadow-xs hover:shadow-md transition">
                    <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 text-xs font-bold mb-3">Rujukan</span>
                    <h4 class="text-base font-bold text-slate-900 dark:text-white">Puskesmas Ciomas</h4>
                    <p class="text-xs text-indigo-700 dark:text-indigo-400 font-semibold mt-0.5">Fasilitas Kesehatan Terdekat</p>
                    <p class="mt-3 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Melakukan penyuluhan berkala, imunisasi, pemeriksaan berkala, dan penanganan rujukan darurat.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Banner Call to Action Bawah -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-emerald-700 via-teal-700 to-slate-900 p-8 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-2 text-center md:text-left">
                <h3 class="text-xl sm:text-2xl font-black tracking-tight">Siswa Merasa Sakit di Sekolah?</h3>
                <p class="text-xs sm:text-sm text-teal-100 max-w-xl">
                    Silakan lapor ke ruang UKS dan catat formulir kunjungan agar petugas dapat memberikan perawatan dan obat yang sesuai.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('public.kunjungan.create') }}" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-lg transition">
                    Isi Kunjungan Siswa
                </a>
                <a href="{{ route('public.hubungi') }}" class="px-5 py-3 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-lg transition">
                    Hubungi Darurat
                </a>
            </div>
        </div>
    </section>
</main>
@endsection