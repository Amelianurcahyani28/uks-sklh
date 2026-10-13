@extends('layouts.public', ['title' => 'Ringkasan & Data UKS'])

@section('content')
<main class="space-y-16 pb-16">
    <!-- Hero Section Full Width: Menempel langsung di bawah navbar seperti Beranda -->
    <section class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
            <div class="max-w-3xl space-y-5 text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 dark:bg-emerald-800/80 border border-white/25 dark:border-emerald-600/40 text-white dark:text-emerald-200 text-xs font-bold shadow-sm backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                    <span>Transparansi & Rekapitulasi Data</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white dark:text-emerald-50 tracking-tight leading-tight drop-shadow-sm">
                    Ringkasan & Statistik Data UKS
                </h1>

                <p class="text-sm sm:text-base text-emerald-50 dark:text-emerald-200/90 leading-relaxed font-normal">
                    Data terkini mengenai aktivitas pelayanan kesehatan siswa di sekolah. Klik salah satu metrik atau pilih tab di bawah untuk menyaring riwayat terkait.
                </p>

                <!-- Quick Navigation / Filters Tabs -->
                <div class="pt-2 flex flex-wrap items-center gap-2.5 text-xs font-semibold">
                    <a href="{{ route('public.ringkasan', ['filter' => 'today']) }}" class="px-4 py-2.5 rounded-xl {{ $activeFilter === 'today' ? 'bg-amber-400 text-slate-950 font-extrabold shadow-md' : 'bg-white/15 hover:bg-white/25 text-white border border-white/25' }} transition backdrop-blur-md shadow-sm">
                        Hari Ini ({{ $todayVisits }})
                    </a>
                    <a href="{{ route('public.ringkasan', ['filter' => 'all']) }}" class="px-4 py-2.5 rounded-xl {{ $activeFilter === 'all' ? 'bg-amber-400 text-slate-950 font-extrabold shadow-md' : 'bg-white/15 hover:bg-white/25 text-white border border-white/25' }} transition backdrop-blur-md shadow-sm">
                        Total Riwayat ({{ $totalVisits }})
                    </a>
                    <a href="{{ route('public.ringkasan', ['filter' => 'students']) }}" class="px-4 py-2.5 rounded-xl {{ $activeFilter === 'students' ? 'bg-amber-400 text-slate-950 font-extrabold shadow-md' : 'bg-white/15 hover:bg-white/25 text-white border border-white/25' }} transition backdrop-blur-md shadow-sm">
                        Siswa Terdaftar ({{ $studentCount }})
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Ringkasan Dalam Container Rapi -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <!-- 3 Kartu Metrik Utama (Dapat Diklik untuk Membuka Datanya) -->
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- 1. Kunjungan Hari Ini -->
        <a href="{{ route('public.ringkasan', ['filter' => 'today']) }}" 
           class="group rounded-2xl border p-6 transition-all duration-200 shadow-xs block {{ $activeFilter === 'today' ? 'border-teal-500 dark:border-teal-400 bg-teal-500/10 dark:bg-teal-950/70 ring-2 ring-teal-500/80 dark:ring-teal-400/80 shadow-md' : 'border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900/90 hover:border-teal-500 dark:hover:border-teal-500/60 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeFilter === 'today' ? 'text-teal-800 dark:text-teal-300' : 'text-slate-500 dark:text-slate-400' }}">
                    Kunjungan Hari Ini
                </span>
                <span class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $activeFilter === 'today' ? 'bg-teal-600 text-white dark:bg-teal-500 dark:text-slate-950' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                    H
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayVisits }}</span>
                <span class="text-xs {{ $activeFilter === 'today' ? 'text-teal-700 dark:text-teal-300' : 'text-slate-500 dark:text-slate-400' }} font-medium">pasien</span>
            </div>
            <p class="mt-3 text-xs {{ $activeFilter === 'today' ? 'text-teal-700 dark:text-teal-400 font-bold' : 'text-slate-400 dark:text-slate-500' }}">
                {{ now()->translatedFormat('d F Y') }} ↗
            </p>
        </a>

        <!-- 3. Total Riwayat Kunjungan -->
        <a href="{{ route('public.ringkasan', ['filter' => 'all']) }}" 
           class="group rounded-2xl border p-6 transition-all duration-200 shadow-xs block {{ $activeFilter === 'all' ? 'border-teal-500 dark:border-teal-400 bg-teal-500/10 dark:bg-teal-950/70 ring-2 ring-teal-500/80 dark:ring-teal-400/80 shadow-md' : 'border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900/90 hover:border-teal-500 dark:hover:border-teal-500/60 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeFilter === 'all' ? 'text-teal-800 dark:text-teal-300' : 'text-slate-500 dark:text-slate-400' }}">
                    Total Riwayat
                </span>
                <span class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $activeFilter === 'all' ? 'bg-teal-600 text-white dark:bg-teal-500 dark:text-slate-950' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                    T
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalVisits }}</span>
                <span class="text-xs {{ $activeFilter === 'all' ? 'text-teal-700 dark:text-teal-300' : 'text-slate-500 dark:text-slate-400' }} font-medium">riwayat</span>
            </div>
            <p class="mt-3 text-xs {{ $activeFilter === 'all' ? 'text-teal-700 dark:text-teal-400 font-bold' : 'text-slate-400 dark:text-slate-500' }}">
                Arsip keseluruhan sistem ↗
            </p>
        </a>

        <!-- 4. Siswa Terdaftar -->
        <a href="{{ route('public.ringkasan', ['filter' => 'students']) }}" 
           class="group rounded-2xl border p-6 transition-all duration-200 shadow-xs block {{ $activeFilter === 'students' ? 'border-teal-500 dark:border-teal-400 bg-teal-500/10 dark:bg-teal-950/70 ring-2 ring-teal-500/80 dark:ring-teal-400/80 shadow-md' : 'border-slate-200/90 dark:border-slate-800 bg-white dark:bg-slate-900/90 hover:border-teal-500 dark:hover:border-teal-500/60 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeFilter === 'students' ? 'text-teal-800 dark:text-teal-300' : 'text-slate-500 dark:text-slate-400' }}">
                    Siswa Terdaftar
                </span>
                <span class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $activeFilter === 'students' ? 'bg-teal-600 text-white dark:bg-teal-500 dark:text-slate-950' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                    S
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $studentCount }}</span>
                <span class="text-xs {{ $activeFilter === 'students' ? 'text-teal-700 dark:text-teal-300' : 'text-slate-500 dark:text-slate-400' }} font-medium">siswa</span>
            </div>
            <p class="mt-3 text-xs {{ $activeFilter === 'students' ? 'text-teal-700 dark:text-teal-400 font-bold' : 'text-slate-400 dark:text-slate-500' }}">
                Klik lihat daftar siswa ↗
            </p>
        </a>
    </section>

    <!-- Bagian Filter Status Kunjungan (Hanya jika bukan filter students) -->
    @if ($activeFilter !== 'students')
        <section class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">Distribusi Status Penanganan Kunjungan</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pilih salah satu status di bawah untuk menyaring data pasien (klik lagi untuk membatalkan).</p>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('public.ringkasan', ['filter' => ($activeFilter === 'today' ? 'today' : 'all'), 'status' => ($activeStatus === 'ditangani' ? null : 'ditangani')]) }}" 
                   class="p-4 rounded-xl border-2 transition shadow-2xs {{ $activeStatus === 'ditangani' ? 'bg-emerald-50 dark:bg-emerald-950/60 border-emerald-500 ring-2 ring-emerald-500/20' : 'bg-slate-50/60 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700/80 hover:bg-emerald-50/40 hover:border-emerald-400' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-800 dark:text-emerald-300">Ditangani di UKS</span>
                        <span class="text-lg font-black text-emerald-800 dark:text-emerald-300">{{ $statusStats['ditangani'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Selesai penanganan langsung di sekolah</p>
                </a>

                <a href="{{ route('public.ringkasan', ['filter' => ($activeFilter === 'today' ? 'today' : 'all'), 'status' => ($activeStatus === 'dirujuk' ? null : 'dirujuk')]) }}" 
                   class="p-4 rounded-xl border-2 transition shadow-2xs {{ $activeStatus === 'dirujuk' ? 'bg-amber-50 dark:bg-amber-950/60 border-amber-500 ring-2 ring-amber-500/20' : 'bg-slate-50/60 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700/80 hover:bg-amber-50/40 hover:border-amber-400' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-800 dark:text-amber-300">Dirujuk ke Faskes</span>
                        <span class="text-lg font-black text-amber-800 dark:text-amber-300">{{ $statusStats['dirujuk'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Butuh penanganan lanjut dokter/Puskesmas</p>
                </a>

                <a href="{{ route('public.ringkasan', ['filter' => ($activeFilter === 'today' ? 'today' : 'all'), 'status' => ($activeStatus === 'pulang' ? null : 'pulang')]) }}" 
                   class="p-4 rounded-xl border-2 transition shadow-2xs {{ $activeStatus === 'pulang' ? 'bg-sky-50 dark:bg-sky-950/60 border-sky-500 ring-2 ring-sky-500/20' : 'bg-slate-50/60 dark:bg-slate-800/50 border-slate-200 dark:border-slate-700/80 hover:bg-sky-50/40 hover:border-sky-400' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-sky-800 dark:text-sky-300">Diizinkan Pulang</span>
                        <span class="text-lg font-black text-sky-800 dark:text-sky-300">{{ $statusStats['pulang'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 dark:text-slate-400 mt-1">Dijemput wali untuk istirahat rumah</p>
                </a>
            </div>
        </section>
    @endif

    <!-- Data Display Section (Tabel Kunjungan atau Tabel Siswa) -->
    <section class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-sm overflow-hidden">
        <!-- Bar Pencarian & Judul Data Aktif -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 p-5 sm:p-6 border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
            <div>
                <h3 class="text-base font-bold text-slate-900 dark:text-white">
                    @if ($activeFilter === 'students')
                        Daftar Siswa Terdaftar
                    @elseif ($activeFilter === 'today')
                        Riwayat Kunjungan Hari Ini ({{ now()->format('d/m/Y') }})
                    @elseif ($activeFilter === 'month')
                        Riwayat Kunjungan Bulan Ini ({{ now()->translatedFormat('F Y') }})
                    @else
                        Seluruh Riwayat Kunjungan UKS
                    @endif
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    @if ($activeFilter === 'students')
                        Menampilkan database siswa yang tercatat di sistem UKS.
                    @else
                        Menampilkan catatan pemeriksaan dan tindakan medis siswa.
                    @endif
                </p>
            </div>

            <!-- Form Pencarian Cepat -->
            <form method="GET" action="{{ route('public.ringkasan') }}" class="flex items-center gap-2 w-full md:w-auto">
                <input type="hidden" name="filter" value="{{ $activeFilter }}">
                @if ($activeStatus)
                    <input type="hidden" name="status" value="{{ $activeStatus }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $activeFilter === 'students' ? 'Cari nama, kelas...' : 'Cari siswa atau keluhan...' }}" class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 w-full sm:w-64 flex-1 transition shadow-xs">
                <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-teal-600 dark:hover:bg-teal-700 text-white rounded-xl text-xs font-semibold transition shrink-0">
                    Cari
                </button>
                @if (request()->filled('q'))
                    <a href="{{ route('public.ringkasan', ['filter' => $activeFilter, 'status' => $activeStatus]) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-semibold transition shrink-0">
                        ✕
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Konten -->
        @if ($activeFilter === 'students')
            <!-- Tabel Siswa Terdaftar -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-100 dark:bg-slate-800/80 border-b-2 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-5 py-4 w-12 text-center border-b-2 border-slate-300 dark:border-slate-700">No</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">NIS</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Nama Lengkap Siswa</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Kelas</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Jurusan</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Jenis Kelamin</th>
                            <th class="px-5 py-4 text-center border-b-2 border-slate-300 dark:border-slate-700">Riwayat Kunjungan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse ($studentsData as $index => $student)
                            <tr class="border-b border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-center font-bold text-slate-600 dark:text-slate-400 text-xs border-b border-slate-200 dark:border-slate-800">
                                    {{ method_exists($studentsData, 'firstItem') && $studentsData->firstItem() ? $studentsData->firstItem() + $index : $loop->iteration }}
                                </td>
                                <td class="px-5 py-4 font-mono font-medium text-slate-600 dark:text-slate-400 border-b border-slate-200 dark:border-slate-800">
                                    {{ $student->nis }}
                                </td>
                                <td class="px-5 py-4 font-bold text-slate-900 dark:text-white text-sm border-b border-slate-200 dark:border-slate-800">
                                    {{ $student->name }}
                                </td>
                                <td class="px-5 py-4 border-b border-slate-200 dark:border-slate-800">
                                    <span class="bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-md text-slate-700 dark:text-slate-300 font-semibold border border-slate-200 dark:border-slate-700">
                                        Kelas {{ $student->class_name }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 border-b border-slate-200 dark:border-slate-800">
                                    <span class="bg-indigo-50 dark:bg-indigo-950/60 px-2.5 py-1 rounded-md text-indigo-700 dark:text-indigo-300 font-semibold border border-indigo-200 dark:border-indigo-800">
                                        {{ $student->major ?: '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 border-b border-slate-200 dark:border-slate-800">
                                    @if ($student->gender === 'L')
                                        <span class="text-blue-700 dark:text-blue-400 font-semibold">Laki-laki</span>
                                    @else
                                        <span class="text-rose-700 dark:text-rose-400 font-semibold">Perempuan</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center border-b border-slate-200 dark:border-slate-800">
                                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold {{ $student->visits_count > 0 ? 'bg-teal-50 dark:bg-teal-950 text-teal-700 dark:text-teal-300 border border-teal-200 dark:border-teal-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                                        {{ $student->visits_count }} kali kunjungan
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-400 border-b border-slate-200 dark:border-slate-800">
                                    Tidak ada data siswa ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($studentsData && $studentsData->hasPages())
                <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40">
                    {{ $studentsData->links() }}
                </div>
            @endif
        @else
            <!-- Tabel Kunjungan Siswa -->
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead class="bg-slate-100 dark:bg-slate-800 border-b-2 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-200 uppercase tracking-wider font-bold">
                        <tr>
                            <th class="px-5 py-4 w-12 text-center border-b-2 border-slate-300 dark:border-slate-700">No</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Tanggal & Jam</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Siswa Pasien</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Kelas</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Jurusan</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Keluhan Sakit</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Tindakan Awal</th>
                            <th class="px-5 py-4 border-b-2 border-slate-300 dark:border-slate-700">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800">
                        @forelse ($visitsData as $index => $visit)
                            <tr class="border-b border-slate-200 dark:border-slate-800 hover:bg-teal-50/20 dark:hover:bg-slate-800/60 transition">
                                <td class="px-5 py-4 whitespace-nowrap text-center font-bold text-slate-600 dark:text-slate-400 text-xs border-b border-slate-200 dark:border-slate-800">
                                    {{ method_exists($visitsData, 'firstItem') && $visitsData->firstItem() ? $visitsData->firstItem() + $index : $loop->iteration }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap border-b border-slate-200 dark:border-slate-800">
                                    <span class="font-bold text-slate-900 dark:text-white block">
                                        {{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '-' }}
                                    </span>
                                    <span class="text-[11px] text-slate-500 dark:text-slate-400 block mt-0.5">
                                        {{ $visit->created_at ? $visit->created_at->format('H:i') : '' }} WIB
                                    </span>
                                </td>
                                <td class="px-5 py-4 border-b border-slate-200 dark:border-slate-800">
                                    <span class="font-bold text-slate-900 dark:text-white block text-sm">
                                        {{ $visit->student->name ?? 'Siswa' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-slate-700 dark:text-slate-300 font-medium text-sm border-b border-slate-200 dark:border-slate-800">
                                    {{ $visit->student->class_name ?? '-' }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap text-slate-700 dark:text-slate-300 font-medium text-sm border-b border-slate-200 dark:border-slate-800">
                                    <span class="bg-indigo-50 dark:bg-indigo-950/60 px-2 py-0.5 rounded text-xs text-indigo-700 dark:text-indigo-300 font-semibold border border-indigo-200 dark:border-indigo-800">
                                        {{ $visit->student->major ?: '-' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 border-b border-slate-200 dark:border-slate-800" style="max-width: 200px;">
                                    <p class="text-slate-800 dark:text-slate-200 font-medium text-xs leading-relaxed line-clamp-2" title="{{ $visit->complaint }}">
                                        {{ $visit->complaint }}
                                    </p>
                                </td>
                                <td class="px-5 py-4 border-b border-slate-200 dark:border-slate-800" style="max-width: 180px;">
                                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-2" title="{{ $visit->initial_treatment }}">
                                        {{ $visit->initial_treatment ?: '-' }}
                                    </p>
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap border-b border-slate-200 dark:border-slate-800">
                                    @if ($visit->status === 'ditangani')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-300 dark:bg-emerald-950/60 dark:text-emerald-300 dark:border-emerald-800">
                                            Ditangani di UKS
                                        </span>
                                    @elseif ($visit->status === 'dirujuk')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-300 dark:bg-amber-950/60 dark:text-amber-300 dark:border-amber-800">
                                            Dirujuk ke Faskes
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-300 dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800">
                                            Diizinkan Pulang
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center text-slate-400 border-b border-slate-200 dark:border-slate-800">
                                    <p class="text-sm font-semibold text-slate-700 dark:text-slate-300">Belum ada catatan kunjungan untuk filter ini.</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Gunakan formulir kunjungan untuk menambahkan data baru.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($visitsData && $visitsData->hasPages())
                <div class="p-4 border-t border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-800/40">
                    {{ $visitsData->links() }}
                </div>
            @endif
        @endif
    </section>
    </div>
</main>

<style>
    /* Explicit crisp borders for Ringkasan tables */
    .overflow-x-auto table {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
        border: 2px solid #94a3b8 !important;
        border-radius: 14px !important;
        overflow: hidden !important;
    }
    .overflow-x-auto table th {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        font-weight: 800 !important;
        font-size: 11.5px !important;
        border-bottom: 2.5px solid #64748b !important;
        padding: 14px 16px !important;
    }
    .overflow-x-auto table td {
        border-bottom: 1.5px solid #94a3b8 !important;
        padding: 14px 16px !important;
    }
    .overflow-x-auto table tbody tr:last-child td {
        border-bottom: none !important;
    }
    .overflow-x-auto table tbody tr:nth-child(even) td {
        background-color: #f8fafc !important;
    }
    .overflow-x-auto table tbody tr:hover td {
        background-color: #e2e8f0 !important;
    }
    html.dark .overflow-x-auto table {
        border-color: #334155 !important;
    }
    html.dark .overflow-x-auto table th {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
        border-bottom-color: #475569 !important;
    }
    html.dark .overflow-x-auto table td {
        border-bottom-color: #334155 !important;
    }
    html.dark .overflow-x-auto table tbody tr:nth-child(even) td {
        background-color: rgba(15, 23, 42, 0.4) !important;
    }
    html.dark .overflow-x-auto table tbody tr:hover td {
        background-color: rgba(30, 41, 59, 0.7) !important;
    }
</style>
@endsection
