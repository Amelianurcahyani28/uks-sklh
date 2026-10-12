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
                        Ruang Sehat & Peduli Untuk Belajar Dengan Nyaman.
                    </h1>

                    <p class="text-sm sm:text-base text-emerald-50 dark:text-emerald-200/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Selamat datang di Unit Kesehatan Sekolah (UKS). Kami siap memberikan pertolongan pertama, pemulihan kondisi fisik, serta pencatatan kunjungan siswa yang cepat, akurat, dan terpercaya.
                    </p>

                    <!-- Tombol Aksi Utama -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="{{ route('public.kunjungan.create') }}" class="inline-flex items-center gap-2 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 px-6 py-3.5 text-xs sm:text-sm font-extrabold shadow-lg transition-all duration-200 transform hover:-translate-y-0.5">
                            <span>Isi Kunjungan Siswa</span>
                        </a>

                        <a href="{{ route('public.ringkasan') }}" class="inline-flex items-center gap-2 rounded-xl bg-white/10 hover:bg-white/20 text-white border border-white/25 px-5 py-3.5 text-xs sm:text-sm font-bold backdrop-blur-md transition-all duration-200">
                            <span>Lihat Ringkasan Data</span>
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
                            <span>Fasilitas P3K Lengkap & Higienis</span>
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
                                    <p class="text-[11px] text-teal-300 font-medium">Kesiapsiagaan & Kepedulian</p>
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
                            <a href="{{ route('public.layanan') }}#pertolongan-pertama" class="p-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition group block">
                                <p class="text-xs font-bold text-white group-hover:text-amber-300 transition">Pemeriksaan Cepat</p>
                                <p class="text-[11px] text-teal-100/70 mt-0.5">Suhu, tensi, dan keluhan</p>
                            </a>

                            <a href="{{ route('public.layanan') }}#ruang-istirahat" class="p-3.5 rounded-xl bg-white/10 hover:bg-white/20 border border-white/15 transition group block">
                                <p class="text-xs font-bold text-white group-hover:text-teal-300 transition">Ruang Istirahat</p>
                                <p class="text-[11px] text-teal-100/70 mt-0.5">Kondusif & nyaman</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Program & Fasilitas Layanan (Dibungkus Card Rapi Seperti Alur Pelayanan) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                    Program & Fasilitas
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Layanan Utama Kesehatan Sekolah</h2>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Standar pertolongan pertama dan tindakan kesehatan yang siap diberikan di ruang UKS.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Layanan 1 (Teal) -->
                <a href="{{ route('public.layanan') }}#pertolongan-pertama" class="group rounded-2xl border-t-4 border-t-teal-500 border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between shadow-xs">
                    <div>
                        <div class="h-10 w-10 rounded-xl bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 flex items-center justify-center font-black text-sm mb-4">
                            01
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition">Pertolongan Pertama (P3K)</h3>
                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Penanganan cepat untuk cedera olahraga, luka lecet, memar, mimisan, maupun kondisi mendadak lainnya dengan peralatan medis standar.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-teal-700 dark:text-teal-400">
                        <span>Lihat detail SOP</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                <!-- Layanan 2 (Amber) -->
                <a href="{{ route('public.layanan') }}#penanganan-ringan" class="group rounded-2xl border-t-4 border-t-amber-500 border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between shadow-xs">
                    <div>
                        <div class="h-10 w-10 rounded-xl bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 flex items-center justify-center font-black text-sm mb-4">
                            02
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-400 transition">Penanganan Sakit Ringan</h3>
                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Pemberian obat pereda nyeri, obat maag, minyak kayu putih, serta teh manis hangat untuk siswa yang pusing, mual, atau sakit perut.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-amber-700 dark:text-amber-400">
                        <span>Lihat detail SOP</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                <!-- Layanan 3 (Sky) -->
                <a href="{{ route('public.layanan') }}#ruang-istirahat" class="group rounded-2xl border-t-4 border-t-sky-500 border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between shadow-xs">
                    <div>
                        <div class="h-10 w-10 rounded-xl bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 border border-sky-200 dark:border-sky-800 flex items-center justify-center font-black text-sm mb-4">
                            03
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-400 transition">Ranjang Observasi Bersih</h3>
                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Ranjang pasien yang bersih dan tenang dengan pemisahan area istirahat agar siswa dapat beristirahat sejenak untuk memulihkan tenaga.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-sky-700 dark:text-sky-400">
                        <span>Lihat detail SOP</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>

                <!-- Layanan 4 (Indigo) -->
                <a href="{{ route('public.layanan') }}#rujukan" class="group rounded-2xl border-t-4 border-t-indigo-500 border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between shadow-xs">
                    <div>
                        <div class="h-10 w-10 rounded-xl bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 flex items-center justify-center font-black text-sm mb-4">
                            04
                        </div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition">Pencatatan & Rujukan Cepat</h3>
                        <p class="mt-2 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                            Setiap kunjungan dicatat secara digital. Jika memerlukan penanganan lebih lanjut, kami segera menghubungi wali murid atau faskes terdekat.
                        </p>
                    </div>
                    <div class="mt-5 pt-3 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between text-xs font-bold text-indigo-700 dark:text-indigo-400">
                        <span>Lihat detail SOP</span>
                        <span class="group-hover:translate-x-1 transition-transform">→</span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Section Alur Pelayanan (SOP Siswa Sakit - Berwarna & Terstruktur) -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800 uppercase tracking-wider mb-2">
                    Panduan Siswa
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
</main>
@endsection