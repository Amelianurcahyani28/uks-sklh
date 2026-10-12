@extends('layouts.public', ['title' => 'Layanan & Fasilitas UKS'])

@section('content')
<main class="space-y-16 pb-16">
    <!-- Hero Section Full Width: Menempel langsung di bawah navbar seperti Beranda -->
    <section class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center relative z-10">
                <!-- Sisi Kiri: Teks & Navigasi Cepat -->
                <div class="lg:col-span-7 space-y-5 text-center lg:text-left">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 dark:bg-emerald-800/80 border border-white/25 dark:border-emerald-600/40 text-white dark:text-emerald-200 text-xs font-bold shadow-sm backdrop-blur-md">
                        <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                        <span>Fasilitas & Kesehatan Sekolah</span>
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white dark:text-emerald-50 tracking-tight leading-tight drop-shadow-sm">
                        Layanan & Fasilitas UKS
                    </h1>

                    <p class="text-sm sm:text-base text-emerald-50 dark:text-emerald-200/90 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Standar pelayanan kesehatan primer di lingkungan sekolah untuk memastikan setiap siswa, guru, dan staf mendapatkan pertolongan pertama yang cepat, aman, dan nyaman.
                    </p>

                    <!-- Quick Navigation Tabs -->
                    <div class="pt-2 flex flex-wrap items-center justify-center lg:justify-start gap-2.5 text-xs font-semibold">
                        <a href="#pilar-layanan" class="px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-white transition backdrop-blur-md shadow-sm">
                            Pilar Layanan
                        </a>
                        <a href="#fasilitas" class="px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-white transition backdrop-blur-md shadow-sm">
                            Sarana Dan Peralatan
                        </a>
                        <a href="#alur" class="px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-white transition backdrop-blur-md shadow-sm">
                            Alur Pemeriksaan
                        </a>
                        <a href="#tim" class="px-4 py-2.5 rounded-xl bg-white/15 hover:bg-white/25 border border-white/25 text-white transition backdrop-blur-md shadow-sm">
                            Tim Dan Jadwal
                        </a>
                    </div>
                </div>

                <!-- Sisi Kanan: Showcase Card ala Beranda -->
                <div class="lg:col-span-5 space-y-4">
                    <div class="rounded-3xl border border-white/20 bg-slate-900/60 backdrop-blur-xl p-6 md:p-8 shadow-2xl text-white">
                        <div class="flex items-center justify-between pb-4 border-b border-white/15">
                            <div class="flex items-center space-x-3">
                                <img src="{{ asset('images/logo-pmr.png') }}" alt="Logo PMR SMKN 1 Ciomas" class="h-11 w-11 rounded-2xl object-contain bg-white/20 p-1 border border-white/30 shadow-inner">
                                <div>
                                    <h3 class="text-sm font-bold text-white tracking-wide">Pusat Layanan Medis</h3>
                                    <p class="text-[11px] text-teal-200">SMKN 1 Ciomas</p>
                                </div>
                            </div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/30 text-[11px] font-semibold">
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span> Siap Sedia
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-3 pt-4">
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                                <div class="text-xl font-black text-amber-300">4 Pilar</div>
                                <div class="text-[11px] text-slate-300 mt-0.5">Layanan Terpadu</div>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-white/5 border border-white/10 text-center">
                                <div class="text-xl font-black text-teal-300">6 Sarana</div>
                                <div class="text-[11px] text-slate-300 mt-0.5">Fasilitas Lengkap</div>
                            </div>
                        </div>
                        <div class="mt-4 pt-3 border-t border-white/10 flex items-center justify-between text-[11px] text-teal-100/80">
                            <span>Pelayanan Jam Sekolah</span>
                            <span class="font-semibold text-white">07:00 - 16:00 WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Layanan Dalam Container Rapi -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        <!-- Section 4 Pilar Layanan -->
        <section id="pilar-layanan" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                Program Unggulan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">4 Pilar Utama Pelayanan UKS</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Penanganan terstruktur mulai dari pencegahan hingga pertolongan medis darurat.</p>
        </div>

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
    </section>

    <!-- Section Fasilitas & Sarana Medis -->
    <section id="fasilitas" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                Sarana Dan Peralatan
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Fasilitas Dan Peralatan Medis UKS</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Peralatan kesehatan yang tersedia lengkap di ruang UKS sekolah.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Diagnostik</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tensimeter Dan Termometer Digital</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Pemeriksaan tekanan darah dan temperatur tubuh akurat nir-sentuh.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Antropometri</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Timbangan Dan Microtoise</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Pengukuran berat dan tinggi badan untuk pemantauan tumbuh kembang.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800 text-xs font-bold mb-3">Darurat</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tabung Oksigen Siaga</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Bantuan pernapasan darurat bagi siswa dengan riwayat asma atau sesak.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 border border-sky-200 dark:border-sky-800 text-xs font-bold mb-3">P3K</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kotak P3K</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Kotak pertolongan pertama portable yang siap dibawa ke lapangan.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Perawatan</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kassa, Plester Dan Antiseptik</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Povidone iodine, rivanol, perban elastis, plester cepat, dan bidai.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 text-xs font-bold mb-3">Farmasi</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white">Lemari Obat Khusus</h4>
                <p class="mt-1 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Penyimpanan obat teratur dengan kontrol tanggal kadaluwarsa ketat.</p>
            </div>
        </div>
    </section>

    <!-- Section Alur Penanganan SOP -->
    <section id="alur" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                Standard Operating Procedure
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Alur Penanganan Siswa Sakit</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Tata cara bagi siswa atau guru saat membawa siswa ke ruang UKS.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="p-6 rounded-2xl bg-slate-50/70 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xl font-black text-amber-500 dark:text-amber-400 block mb-2">01</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Izin Kelas & Kedatangan</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Siswa meminta izin guru di kelas atau diantar oleh teman/guru piket ke ruang UKS.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50/70 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xl font-black text-teal-600 dark:text-teal-400 block mb-2">02</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Pendataan & Anamnesa</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Petugas menanyakan keluhan, mengukur suhu/tensi, dan mencatat data kunjungan.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50/70 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xl font-black text-sky-600 dark:text-sky-400 block mb-2">03</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Tindakan & Istirahat</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Diberikan obat yang relevan, pertolongan P3K, dan kesempatan istirahat tenang.</p>
            </div>

            <div class="p-6 rounded-2xl bg-slate-50/70 dark:bg-slate-950/60 border border-slate-200 dark:border-slate-800 shadow-xs">
                <span class="text-xl font-black text-emerald-600 dark:text-emerald-400 block mb-2">04</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Keputusan & Tindak Lanjut</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Kembali ke kelas jika membaik, izin pulang ke rumah, atau rujukan faskes.</p>
            </div>
        </div>
    </section>

    <!-- Section Tim & Jadwal UKS -->
    <section id="tim" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                Personil
            </span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Tim Petugas Dan Jadwal Pelayanan</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">Didukung oleh tenaga pendamping yang berdedikasi menjaga kesehatan siswa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Koordinator</span>
                <h4 class="text-base font-bold text-slate-900 dark:text-white">Pembina UKS Sekolah</h4>
                <p class="text-xs text-teal-700 dark:text-teal-400 font-semibold mt-0.5">Guru Penanggung Jawab</p>
                <p class="mt-3 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Bertanggung jawab atas administrasi, ketersediaan obat, serta koordinasi dengan kepala sekolah.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-xs font-bold mb-3">Pelaksana</span>
                <h4 class="text-base font-bold text-slate-900 dark:text-white">Petugas Medis Harian</h4>
                <p class="text-xs text-teal-700 dark:text-teal-400 font-semibold mt-0.5">Tim P3K Sekolah</p>
                <p class="mt-3 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Siap siaga di ruang UKS memberikan pertolongan pertama dan observasi kesehatan harian siswa.</p>
            </div>

            <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/60 p-6 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 text-xs font-bold mb-3">Rujukan</span>
                <h4 class="text-base font-bold text-slate-900 dark:text-white">Puskesmas</h4>
                <p class="text-xs text-indigo-700 dark:text-indigo-400 font-semibold mt-0.5">Fasilitas Kesehatan Terdekat</p>
                <p class="mt-3 text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Melakukan penyuluhan berkala, imunisasi, pemeriksaan berkala, dan penanganan rujukan darurat.</p>
            </div>
        </div>
    </section>
    </div>
</main>
@endsection
