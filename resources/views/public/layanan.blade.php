@extends('layouts.public', ['title' => 'Layanan & Fasilitas UKS'])

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-16">
    <!-- Header Banner Layanan Modern (Eye-Friendly & Bersih) -->
    <section class="rounded-3xl bg-gradient-to-r from-teal-800 via-teal-700 to-slate-900 p-8 sm:p-12 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 max-w-3xl space-y-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-500/20 text-teal-200 border border-teal-400/30">
                Fasilitas & Kesehatan Sekolah
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Layanan & Fasilitas UKS</h1>
            <p class="text-sm sm:text-base text-teal-100/90 leading-relaxed font-normal">
                Standar pelayanan kesehatan primer di lingkungan sekolah untuk memastikan setiap siswa, guru, dan staf mendapatkan pertolongan pertama yang cepat, aman, dan nyaman.
            </p>
            
            <!-- Quick Navigation Tabs -->
            <div class="pt-4 flex flex-wrap gap-2 text-xs font-semibold">
                <a href="#pilar-layanan" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition backdrop-blur-xs">
                    Pilar Layanan
                </a>
                <a href="#fasilitas" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition backdrop-blur-xs">
                    Sarana Dan Peralatan
                </a>
                <a href="#alur" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition backdrop-blur-xs">
                    Alur Pemeriksaan
                </a>
                <a href="#tim" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 border border-white/20 text-white transition backdrop-blur-xs">
                    Tim Dan Jadwal
                </a>
            </div>
        </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </section>

    <!-- Section 4 Pilar Layanan -->
    <section id="pilar-layanan" class="space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-700 block mb-1.5">Program Unggulan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">4 Pilar Utama Pelayanan UKS</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-500">Penanganan terstruktur mulai dari pencegahan hingga pertolongan medis darurat.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Pilar 1 -->
            <div id="pertolongan-pertama" class="rounded-2xl border border-slate-200/90 bg-white p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="h-8 w-8 rounded-lg bg-teal-100 text-teal-800 font-extrabold text-xs flex items-center justify-center">
                            01
                        </span>
                        <span class="text-[11px] font-semibold text-teal-700 bg-teal-50 px-2.5 py-1 rounded-md">Siap Sedia Jam Sekolah</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Pertolongan Pertama Pada Kecelakaan (P3K)</h3>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Tindakan cepat dan tepat untuk mengatasi cedera fisik yang terjadi saat aktivitas sekolah, olahraga, maupun upacara.
                    </p>
                    <ul class="mt-4 space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-teal-600 font-bold">✓</span>
                            <span>Pembersihan dan pembalutan luka lecet atau goresan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-teal-600 font-bold">✓</span>
                            <span>Penanganan terkilir, memar, atau cedera otot ringan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-teal-600 font-bold">✓</span>
                            <span>Penanganan mimisan dan luka robek ringan</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-teal-600 font-bold">✓</span>
                            <span>Imobilisasi awal sebelum rujukan bila dicurigai fraktur</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Pilar 2 -->
            <div id="penanganan-ringan" class="rounded-2xl border border-slate-200/90 bg-white p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="h-8 w-8 rounded-lg bg-amber-100 text-amber-800 font-extrabold text-xs flex items-center justify-center">
                            02
                        </span>
                        <span class="text-[11px] font-semibold text-amber-800 bg-amber-50 px-2.5 py-1 rounded-md">Standar Obat Aman</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Penanganan Keluhan Dan Sakit Ringan</h3>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Layanan bagi siswa yang mengalami penurunan kondisi fisik selama jam pelajaran berlangsung di kelas.
                    </p>
                    <ul class="mt-4 space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-amber-600 font-bold">✓</span>
                            <span>Pemberian obat pereda nyeri dan demam (Parasetamol)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-amber-600 font-bold">✓</span>
                            <span>Penanganan maag, kembung, dan sakit perut (Antasida)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-amber-600 font-bold">✓</span>
                            <span>Aromaterapi minyak kayu putih dan balsem pereda</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-amber-600 font-bold">✓</span>
                            <span>Pemberian larutan oralit / elektrolit untuk dehidrasi</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Pilar 3 -->
            <div id="ruang-istirahat" class="rounded-2xl border border-slate-200/90 bg-white p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="h-8 w-8 rounded-lg bg-sky-100 text-sky-800 font-extrabold text-xs flex items-center justify-center">
                            03
                        </span>
                        <span class="text-[11px] font-semibold text-sky-800 bg-sky-50 px-2.5 py-1 rounded-md">Kapasitas 4 Ranjang</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Ruang Istirahat Dan Observasi Siswa</h3>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Kamar khusus yang bersih, sejuk, dan tenang untuk pemulihan tenaga siswa sakit dalam pemantauan petugas.
                    </p>
                    <ul class="mt-4 space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-sky-600 font-bold">✓</span>
                            <span>Ranjang periksa dengan sprei yang diganti berkala</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-sky-600 font-bold">✓</span>
                            <span>Suhu ruangan berpendingin udara dan tenang</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-sky-600 font-bold">✓</span>
                            <span>Pemisahan area istirahat siswa putra dan putri</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-sky-600 font-bold">✓</span>
                            <span>Pemantauan berkala tanda vital setiap 20-30 menit</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Pilar 4 -->
            <div id="rujukan" class="rounded-2xl border border-slate-200/90 bg-white p-7 shadow-xs hover:shadow-md transition scroll-mt-28 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="h-8 w-8 rounded-lg bg-indigo-100 text-indigo-800 font-extrabold text-xs flex items-center justify-center">
                            04
                        </span>
                        <span class="text-[11px] font-semibold text-indigo-800 bg-indigo-50 px-2.5 py-1 rounded-md">Mitra Puskesmas</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-900">Prosedur Rujukan Dan Koordinasi Cepat</h3>
                    <p class="mt-2 text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Protokol penanganan jika kondisi siswa membutuhkan bantuan medis spesialis atau pertolongan dokter tingkat lanjut.
                    </p>
                    <ul class="mt-4 space-y-2 text-xs text-slate-600">
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-600 font-bold">✓</span>
                            <span>Pemberitahuan resmi langsung ke orang tua / wali murid</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-600 font-bold">✓</span>
                            <span>Koordinasi darurat dengan Puskesmas binaan terdekat</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-600 font-bold">✓</span>
                            <span>Fasilitas antar jemput ambulans sekolah / faskes</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-indigo-600 font-bold">✓</span>
                            <span>Penerbitan surat izin pulang sakit resmi dari UKS</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Fasilitas & Sarana Medis -->
    <section id="fasilitas" class="space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-700 block mb-1.5">Sarana Dan Peralatan</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Fasilitas Dan Peralatan Medis UKS</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-500">Peralatan kesehatan yang tersedia lengkap di ruang UKS sekolah.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-50 text-teal-700 text-xs font-bold mb-3">Diagnostik</span>
                <h4 class="text-sm font-bold text-slate-900">Tensimeter Dan Termometer Digital</h4>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">Pemeriksaan tekanan darah dan temperatur tubuh akurat nir-sentuh.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-50 text-teal-700 text-xs font-bold mb-3">Antropometri</span>
                <h4 class="text-sm font-bold text-slate-900">Timbangan Dan Microtoise</h4>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">Pengukuran berat dan tinggi badan untuk pemantauan tumbuh kembang.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-xs font-bold mb-3">Darurat</span>
                <h4 class="text-sm font-bold text-slate-900">Tabung Oksigen Siaga</h4>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">Bantuan pernapasan darurat bagi siswa dengan riwayat asma atau sesak.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-sky-50 text-sky-700 text-xs font-bold mb-3">P3K</span>
                <h4 class="text-sm font-bold text-slate-900">Kotak P3K</h4>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">Kotak pertolongan pertama portable yang siap dibawa ke lapangan.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-50 text-teal-700 text-xs font-bold mb-3">Perawatan</span>
                <h4 class="text-sm font-bold text-slate-900">Kassa, Plester Dan Antiseptik</h4>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">Povidone iodine, rivanol, perban elastis, plester cepat, dan bidai.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-5 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold mb-3">Farmasi</span>
                <h4 class="text-sm font-bold text-slate-900">Lemari Obat Khusus</h4>
                <p class="mt-1 text-xs text-slate-500 leading-relaxed">Penyimpanan obat teratur dengan kontrol tanggal kadaluwarsa ketat.</p>
            </div>
        </div>
    </section>

    <!-- Section Alur Penanganan SOP -->
    <section id="alur" class="rounded-3xl bg-slate-100/70 dark:bg-slate-900 p-8 sm:p-12 text-slate-800 dark:text-white border border-slate-200 dark:border-slate-800 shadow-xs dark:shadow-xl space-y-8 scroll-mt-24 transition-colors duration-200">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-widest text-teal-700 dark:text-teal-400 block mb-1.5">Standard Operating Procedure</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white">Alur Penanganan Siswa Sakit</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-300">Tata cara bagi siswa atau guru saat membawa siswa ke ruang UKS.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-xs">
                <span class="text-xl font-black text-amber-500 dark:text-amber-400 block mb-2">01</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Izin Kelas & Kedatangan</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Siswa meminta izin guru di kelas atau diantar oleh teman/guru piket ke ruang UKS.</p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-xs">
                <span class="text-xl font-black text-teal-600 dark:text-teal-400 block mb-2">02</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Pendataan & Anamnesa</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Petugas menanyakan keluhan, mengukur suhu/tensi, dan mencatat data kunjungan.</p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-xs">
                <span class="text-xl font-black text-sky-600 dark:text-sky-400 block mb-2">03</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Tindakan & Istirahat</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Diberikan obat yang relevan, pertolongan P3K, dan kesempatan istirahat tenang.</p>
            </div>

            <div class="p-6 rounded-2xl bg-white dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700/60 shadow-xs">
                <span class="text-xl font-black text-emerald-600 dark:text-emerald-400 block mb-2">04</span>
                <h4 class="text-sm font-bold text-slate-900 dark:text-white mb-1.5">Keputusan & Tindak Lanjut</h4>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">Kembali ke kelas jika membaik, izin pulang ke rumah, atau rujukan faskes.</p>
            </div>
        </div>
    </section>

    <!-- Section Tim & Jadwal UKS -->
    <section id="tim" class="space-y-8 scroll-mt-24">
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold uppercase tracking-wider text-teal-700 block mb-1.5">Personil</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">Tim Petugas Dan Jadwal Pelayanan</h2>
            <p class="mt-2 text-xs sm:text-sm text-slate-500">Didukung oleh tenaga pendamping yang berdedikasi menjaga kesehatan siswa.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-50 text-teal-700 text-xs font-bold mb-3">Koordinator</span>
                <h4 class="text-base font-bold text-slate-900">Pembina UKS Sekolah</h4>
                <p class="text-xs text-teal-700 font-semibold mt-0.5">Guru Penanggung Jawab</p>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed">Bertanggung jawab atas administrasi, ketersediaan obat, serta koordinasi dengan kepala sekolah.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-teal-50 text-teal-700 text-xs font-bold mb-3">Pelaksana</span>
                <h4 class="text-base font-bold text-slate-900">Petugas Medis Harian</h4>
                <p class="text-xs text-teal-700 font-semibold mt-0.5">Tim P3K Sekolah</p>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed">Siap siaga di ruang UKS memberikan pertolongan pertama dan observasi kesehatan harian siswa.</p>
            </div>

            <div class="rounded-2xl border border-slate-200/90 bg-white p-6 shadow-xs">
                <span class="inline-block px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold mb-3">Rujukan</span>
                <h4 class="text-base font-bold text-slate-900">Puskesmas</h4>
                <p class="text-xs text-indigo-700 font-semibold mt-0.5">Fasilitas Kesehatan Terdekat</p>
                <p class="mt-3 text-xs text-slate-500 leading-relaxed">Melakukan penyuluhan berkala, imunisasi, pemeriksaan berkala, dan penanganan rujukan darurat.</p>
            </div>
        </div>
    </section>
</main>
@endsection
