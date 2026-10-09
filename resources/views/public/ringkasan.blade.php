@extends('layouts.public', ['title' => 'Ringkasan & Data UKS'])

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12">
    <!-- Header Banner Ringkasan Modern & Bersih -->
    <section class="rounded-3xl bg-gradient-to-r from-teal-800 via-teal-700 to-slate-900 p-8 sm:p-12 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 max-w-3xl space-y-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-500/20 text-teal-200 border border-teal-400/30">
                Transparansi & Rekapitulasi
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Ringkasan & Statistik Data UKS</h1>
            <p class="text-sm sm:text-base text-teal-100/90 leading-relaxed font-normal">
                Data terkini mengenai aktivitas pelayanan kesehatan siswa di sekolah. Klik salah satu kartu metrik di bawah untuk menampilkan data riwayat terkait.
            </p>
        </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </section>

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
        <section class="bg-white rounded-2xl border border-slate-200/90 p-6 shadow-xs space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div>
                    <h3 class="text-sm font-bold text-slate-800">Distribusi Status Penanganan Kunjungan</h3>
                    <p class="text-xs text-slate-500">Pilih salah satu status di bawah untuk menyaring data pasien.</p>
                </div>
                @if ($activeStatus)
                    <a href="{{ route('public.ringkasan', ['filter' => $activeFilter]) }}" class="text-xs text-rose-600 font-semibold hover:underline">
                        ✕ Hapus Filter Status
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('public.ringkasan', ['filter' => $activeFilter, 'status' => 'ditangani']) }}" 
                   class="p-4 rounded-xl border transition {{ $activeStatus === 'ditangani' ? 'bg-emerald-50 border-emerald-500 ring-2 ring-emerald-500' : 'border-slate-200 hover:bg-slate-50' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-emerald-800">Ditangani di UKS</span>
                        <span class="text-lg font-black text-emerald-800">{{ $statusStats['ditangani'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">Selesai penanganan langsung di sekolah</p>
                </a>

                <a href="{{ route('public.ringkasan', ['filter' => $activeFilter, 'status' => 'dirujuk']) }}" 
                   class="p-4 rounded-xl border transition {{ $activeStatus === 'dirujuk' ? 'bg-amber-50 border-amber-500 ring-2 ring-amber-500' : 'border-slate-200 hover:bg-slate-50' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-amber-800">Dirujuk ke Faskes</span>
                        <span class="text-lg font-black text-amber-800">{{ $statusStats['dirujuk'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">Butuh penanganan lanjut dokter/Puskesmas</p>
                </a>

                <a href="{{ route('public.ringkasan', ['filter' => $activeFilter, 'status' => 'pulang']) }}" 
                   class="p-4 rounded-xl border transition {{ $activeStatus === 'pulang' ? 'bg-sky-50 border-sky-500 ring-2 ring-sky-500' : 'border-slate-200 hover:bg-slate-50' }}">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-sky-800">Diizinkan Pulang</span>
                        <span class="text-lg font-black text-sky-800">{{ $statusStats['pulang'] }}</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1">Dijemput wali untuk istirahat rumah</p>
                </a>
            </div>
        </section>
    @endif

    <!-- Data Display Section (Tabel Kunjungan atau Tabel Siswa) -->
    <section class="space-y-6">
        <!-- Bar Pencarian & Judul Data Aktif -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200/90 shadow-xs">
            <div>
                <h3 class="text-base font-bold text-slate-900">
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
                <p class="text-xs text-slate-500 mt-0.5">
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
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $activeFilter === 'students' ? 'Cari nama, kelas...' : 'Cari siswa atau keluhan...' }}" class="rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600 w-full sm:w-64 flex-1">
                <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition shrink-0">
                    Cari
                </button>
                @if (request()->filled('q'))
                    <a href="{{ route('public.ringkasan', ['filter' => $activeFilter, 'status' => $activeStatus]) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition shrink-0">
                        ✕
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Konten -->
        <div class="rounded-2xl border border-slate-200/90 bg-white shadow-xs overflow-hidden">
            @if ($activeFilter === 'students')
                <!-- Tabel Siswa Terdaftar -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                            <tr>

                                <th class="px-6 py-4">Nama Lengkap Siswa</th>
                                <th class="px-6 py-4">Kelas</th>
                                <th class="px-6 py-4">Jenis Kelamin</th>
                                <th class="px-6 py-4 text-center">Riwayat Kunjungan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($studentsData as $student)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 font-mono font-medium text-slate-600">
                                        {{ $student->nis }}
                                    </td>
                                    <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                        {{ $student->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-slate-100 px-2.5 py-1 rounded-md text-slate-700 font-semibold">
                                            Kelas {{ $student->class_name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if ($student->gender === 'L')
                                            <span class="text-blue-700 font-medium">Laki-laki</span>
                                        @else
                                            <span class="text-rose-700 font-medium">Perempuan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold {{ $student->visits_count > 0 ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-slate-100 text-slate-400' }}">
                                            {{ $student->visits_count }} kali kunjungan
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-400">
                                        Tidak ada data siswa ditemukan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($studentsData && $studentsData->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $studentsData->links() }}
                    </div>
                @endif
            @else
                <!-- Tabel Kunjungan Siswa -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="px-6 py-4 w-12 text-center">No</th>
                                <th class="px-6 py-4">Tanggal & Jam</th>
                                <th class="px-6 py-4">Siswa Pasien</th>
                                <th class="px-6 py-4">Kelas</th>

                                <th class="px-6 py-4">Keluhan Sakit</th>
                                <th class="px-6 py-4">Tindakan Awal</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($visitsData as $index => $visit)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-slate-500 text-xs">
                                        {{ method_exists($visitsData, 'firstItem') && $visitsData->firstItem() ? $visitsData->firstItem() + $index : $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="font-bold text-slate-800 block">
                                            {{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '-' }}
                                        </span>
                                        <span class="text-[11px] text-slate-400">
                                            {{ $visit->created_at ? $visit->created_at->format('H:i') : '' }} WIB
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block text-sm">
                                            {{ $visit->student->name ?? 'Siswa' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600 font-medium text-sm">
                                        {{ $visit->student->class_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-block bg-slate-100 text-slate-700 text-xs font-mono font-semibold px-2.5 py-1 rounded-lg">
                                            {{ $visit->student->nis ?? '-' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4" style="max-width: 200px;">
                                        <p class="text-slate-800 dark:text-slate-200 font-medium text-xs leading-relaxed line-clamp-2" title="{{ $visit->complaint }}">
                                            {{ $visit->complaint }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4" style="max-width: 180px;">
                                        <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-2" title="{{ $visit->initial_treatment }}">
                                            {{ $visit->initial_treatment ?: '-' }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($visit->status === 'ditangani')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Ditangani di UKS
                                            </span>
                                        @elseif ($visit->status === 'dirujuk')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Dirujuk ke Faskes
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                                Diizinkan Pulang
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                                        <p class="text-sm font-semibold text-slate-600">Belum ada catatan kunjungan untuk filter ini.</p>
                                        <p class="text-xs text-slate-400 mt-1">Gunakan formulir kunjungan untuk menambahkan data baru.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($visitsData && $visitsData->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $visitsData->links() }}
                    </div>
                @endif
            @endif
        </div>
    </section>
</main>
@endsection
