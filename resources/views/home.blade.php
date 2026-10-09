@extends('layouts.public', ['title' => 'Beranda'])

@section('content')
<main class="space-y-16 pb-16">
    <!-- Hero Section: Modern Container Adaptif Terang & Gelap -->
    <section class="bg-gradient-to-b from-teal-50/70 via-slate-50 to-white dark:from-slate-900 dark:via-slate-900 dark:to-slate-950 text-slate-900 dark:text-white pt-12 pb-16 lg:py-20 border-b border-slate-200 dark:border-slate-800 relative overflow-hidden transition-colors duration-200">
        <!-- Ambient Light Background Effects -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[350px] bg-teal-500/15 dark:bg-teal-500/10 blur-[120px] rounded-full pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Sisi Kiri: Teks & Aksi -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-teal-500/15 dark:bg-teal-500/10 border border-teal-600/30 dark:border-teal-500/30 text-teal-800 dark:text-teal-300 text-xs font-semibold backdrop-blur-sm">
                        <span class="h-2 w-2 rounded-full bg-teal-600 dark:bg-teal-400"></span>
                        <span>Pusat Layanan Kesehatan Siswa</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white tracking-tight leading-tight">
                        Ruang Sehat & Peduli Untuk Belajar Dengan Nyaman.
                    </h1>

                    <p class="text-sm sm:text-base text-slate-600 dark:text-slate-300 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Selamat datang di Unit Kesehatan Sekolah (UKS). Kami siap memberikan pertolongan pertama, pemulihan kondisi fisik, serta pencatatan kunjungan siswa yang cepat, akurat, dan terpercaya.
                    </p>

                    <!-- Tombol Aksi Utama (Tanpa Emoji) -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('public.kunjungan.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-400 px-6 py-3.5 text-xs sm:text-sm font-extrabold text-slate-950 shadow-md hover:bg-amber-300 transition-all duration-200">
                            <span>Isi Kunjungan Siswa</span>
                            <span>→</span>
                        </a>

                        <a href="{{ route('public.ringkasan') }}" class="inline-flex items-center gap-2 rounded-xl bg-white dark:bg-slate-800 border border-slate-300 dark:border-slate-700 px-5 py-3.5 text-xs sm:text-sm font-bold text-slate-700 dark:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-700 hover:text-slate-900 dark:hover:text-white transition shadow-xs">
                            <span>Lihat Ringkasan Data</span>
                        </a>
                    </div>

                    <!-- Trust Indicators -->
                    <div class="pt-4 flex flex-wrap items-center justify-center lg:justify-start gap-4 text-xs text-slate-500 dark:text-slate-400 font-medium">
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                            <span>Petugas Siaga Jam Belajar</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                            <span>Fasilitas P3K Lengkap & Higienis</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-teal-600 dark:text-teal-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0112 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 013.498 1.307 4.491 4.491 0 011.307 3.497A4.49 4.49 0 0121.75 12a4.49 4.49 0 01-1.549 3.397 4.491 4.491 0 01-1.307 3.497 4.491 4.491 0 01-3.497 1.307A4.49 4.49 0 0112 21.75a4.49 4.49 0 01-3.397-1.549 4.49 4.49 0 01-3.498-1.306 4.491 4.491 0 01-1.307-3.498A4.49 4.49 0 012.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 011.307-3.497 4.49 4.49 0 013.497-1.307zm7.007 6.387a.75.75 0 10-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 00-1.06 1.06l2.25 2.25a.75.75 0 001.14-.094l3.75-5.25z" clip-rule="evenodd" />
                            </svg>
                            <span>Pencatatan Digital Cepat</span>
                        </div>
                    </div>
                </div>

                <!-- Sisi Kanan: Kartu Showcase & Live Stats Modern -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="rounded-3xl border border-slate-200 dark:border-slate-700/80 bg-white/95 dark:bg-slate-800/90 p-6 md:p-8 shadow-xl dark:shadow-2xl backdrop-blur-xl transition-colors duration-200">
                        <!-- Header Kartu -->
                        <div class="flex items-center justify-between pb-5 border-b border-slate-200 dark:border-slate-700/60">
                            <div class="flex items-center space-x-3">
                                <div class="h-10 w-10 rounded-xl bg-amber-400 flex items-center justify-center text-slate-950 font-black text-xl shadow-xs">
                                    +
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-slate-900 dark:text-white tracking-wide">UKS Terpadu Sekolah</h3>
                                    <p class="text-[11px] text-teal-600 dark:text-teal-400 font-medium">Kesiapsiagaan & Kepedulian</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-500/15 dark:bg-emerald-500/20 text-emerald-700 dark:text-emerald-300 border border-emerald-500/30">
                                ● Online
                            </span>
                        </div>

                        <!-- Deskripsi Singkat -->
                        <p class="text-xs text-slate-600 dark:text-slate-300 mt-5 leading-relaxed">
                            Mendukung kesehatan fisik dan mental siswa agar dapat mengikuti kegiatan belajar mengajar dengan optimal setiap hari.
                        </p>

                        <!-- Strip Statistik Live -->
                        <div class="mt-6 grid grid-cols-3 gap-3 bg-slate-50 dark:bg-slate-950/70 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 transition-colors duration-200">
                            <div class="text-center">
                                <span class="text-xs text-slate-500 dark:text-slate-400 block mb-0.5">Hari Ini</span>
                                <strong class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white block">{{ $todayVisits }}</strong>
                                <span class="text-[10px] text-teal-600 dark:text-teal-400 font-medium">pasien</span>
                            </div>
                            <div class="text-center border-x border-slate-200 dark:border-slate-800 px-2">
                                <span class="text-xs text-slate-500 dark:text-slate-400 block mb-0.5">Bulan Ini</span>
                                <strong class="text-xl sm:text-2xl font-black text-amber-500 dark:text-amber-400 block">{{ $monthVisits }}</strong>
                                <span class="text-[10px] text-amber-600 dark:text-amber-400/80 font-medium">pasien</span>
                            </div>
                            <div class="text-center">
                                <span class="text-xs text-slate-500 dark:text-slate-400 block mb-0.5">Total Siswa</span>
                                <strong class="text-xl sm:text-2xl font-black text-teal-700 dark:text-teal-300 block">{{ $studentCount }}</strong>
                                <span class="text-[10px] text-teal-600 dark:text-teal-400 font-medium">terdata</span>
                            </div>
                        </div>

                        <!-- 2 Card Mini Akselerator (Tanpa Emoji) -->
                        <div class="mt-5 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <a href="{{ route('public.layanan') }}#pertolongan-pertama" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700/60 hover:border-teal-500/60 hover:bg-slate-100 dark:hover:bg-slate-900 transition group block">
                                <p class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-300 transition">Pemeriksaan Cepat</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Suhu, tensi, dan keluhan</p>
                            </a>

                            <a href="{{ route('public.layanan') }}#ruang-istirahat" class="p-3.5 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200 dark:border-slate-700/60 hover:border-teal-500/60 hover:bg-slate-100 dark:hover:bg-slate-900 transition group block">
                                <p class="text-xs font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-300 transition">Ruang Istirahat</p>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">Kondusif & nyaman</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Program & Fasilitas Layanan (Latar Bersih, Nyaman di Mata) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-700 block mb-1.5">Program & Fasilitas</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Layanan Utama Kesehatan Sekolah</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-500">Standar pertolongan pertama dan tindakan kesehatan yang siap diberikan di ruang UKS.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Layanan 1 -->
            <a href="{{ route('public.layanan') }}#pertolongan-pertama" class="group rounded-2xl border border-slate-200/90 bg-white p-6 hover:border-teal-600 hover:shadow-md transition-all duration-300 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center font-extrabold text-xs mb-4">
                        01
                    </div>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-teal-700 transition">Pertolongan Pertama (P3K)</h3>
                    <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                        Penanganan cepat untuk cedera olahraga, luka lecet, memar, mimisan, maupun kondisi mendadak lainnya dengan peralatan medis standar.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-teal-700">
                    <span>Lihat detail SOP</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

            <!-- Layanan 2 -->
            <a href="{{ route('public.layanan') }}#penanganan-ringan" class="group rounded-2xl border border-slate-200/90 bg-white p-6 hover:border-amber-600 hover:shadow-md transition-all duration-300 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-lg bg-amber-100 text-amber-800 flex items-center justify-center font-extrabold text-xs mb-4">
                        02
                    </div>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-amber-700 transition">Penanganan Sakit Ringan</h3>
                    <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                        Pemberian obat pereda nyeri, obat maag, minyak kayu putih, serta teh manis hangat untuk siswa yang pusing, mual, atau sakit perut.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-amber-700">
                    <span>Lihat detail SOP</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

            <!-- Layanan 3 -->
            <a href="{{ route('public.layanan') }}#ruang-istirahat" class="group rounded-2xl border border-slate-200/90 bg-white p-6 hover:border-sky-600 hover:shadow-md transition-all duration-300 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-lg bg-sky-100 text-sky-800 flex items-center justify-center font-extrabold text-xs mb-4">
                        03
                    </div>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-sky-700 transition">Ranjang Observasi Bersih</h3>
                    <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                        Ranjang pasien yang bersih dan tenang dengan pemisahan area istirahat agar siswa dapat beristirahat sejenak untuk memulihkan tenaga.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-sky-700">
                    <span>Lihat detail SOP</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>

            <!-- Layanan 4 -->
            <a href="{{ route('public.layanan') }}#rujukan" class="group rounded-2xl border border-slate-200/90 bg-white p-6 hover:border-indigo-600 hover:shadow-md transition-all duration-300 shadow-xs flex flex-col justify-between">
                <div>
                    <div class="h-9 w-9 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center font-extrabold text-xs mb-4">
                        04
                    </div>
                    <h3 class="text-base font-bold text-slate-900 group-hover:text-indigo-700 transition">Pencatatan & Rujukan Cepat</h3>
                    <p class="mt-2 text-xs text-slate-600 leading-relaxed">
                        Setiap kunjungan dicatat secara digital. Jika memerlukan penanganan lebih lanjut, kami segera menghubungi wali murid atau faskes terdekat.
                    </p>
                </div>
                <div class="mt-5 pt-3 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-indigo-700">
                    <span>Lihat detail SOP</span>
                    <span class="group-hover:translate-x-1 transition-transform">→</span>
                </div>
            </a>
        </div>
    </section>

    <!-- Section Alur Pelayanan (SOP Siswa Sakit) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200/90 bg-white p-8 md:p-12 shadow-xs space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="text-xs font-bold uppercase tracking-wider text-teal-700 block mb-1.5">Panduan Siswa</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Alur Pelayanan Saat Merasa Sakit di Sekolah</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-500">Ikuti tahapan sederhana ini saat membutuhkan pertolongan di ruang UKS.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Step 1 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl font-black text-amber-500 block mb-3">01</span>
                        <h4 class="text-sm font-bold text-slate-900 mb-2">Izin Dan Lapor Ke UKS</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Minta izin guru kelas atau guru piket, lalu datang ke ruang UKS didampingi teman jika perlu.
                        </p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl font-black text-teal-600 block mb-3">02</span>
                        <h4 class="text-sm font-bold text-slate-900 mb-2">Pemeriksaan Awal</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Petugas UKS melakukan anamnesa singkat, mengecek suhu badan atau keluhan fisik untuk tindakan tepat.
                        </p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl font-black text-sky-600 block mb-3">03</span>
                        <h4 class="text-sm font-bold text-slate-900 mb-2">Tindakan Dan Istirahat</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Diberikan penanganan pertama, obat yang sesuai, dan waktu beristirahat di ranjang observasi UKS.
                        </p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200/80 flex flex-col justify-between">
                    <div>
                        <span class="text-2xl font-black text-emerald-600 block mb-3">04</span>
                        <h4 class="text-sm font-bold text-slate-900 mb-2">Tindak Lanjut</h4>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Jika membaik, siswa kembali ke kelas. Jika belum, dikoordinasikan untuk izin pulang atau rujukan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection