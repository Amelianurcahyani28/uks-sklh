@extends('layouts.app', ['heading' => 'Ringkasan & Rekapitulasi Data'])

@section('content')
<!-- Hero Section Admin Full Width: Menempel Langsung Tanpa Space di Atasnya -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
            <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
            Rekapitulasi & Manajemen UKS
        </span>
        <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Ringkasan & Rekapitulasi Sistem UKS</h2>
        <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 max-w-2xl leading-relaxed">
            Kelola, pantau, dan lakukan tindakan CRUD pada catatan kunjungan serta data siswa secara terpusat.
        </p>
    </div>
</div>

<div class="p-4 sm:p-8 space-y-8 flex-1">
    <!-- 3 Kartu Metrik Utama Admin (Interaktif & Terhubung ke Tabel CRUD di Bawah) -->
    <section class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <!-- 1. Kunjungan Hari Ini -->
        <a href="{{ route('admin.ringkasan', ['filter' => 'today']) }}" 
           class="group rounded-2xl border p-6 transition-all duration-200 shadow-xs block {{ $activeFilter === 'today' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-500/10 dark:bg-emerald-950/70 ring-2 ring-emerald-500/80 dark:ring-emerald-400/80 shadow-md' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/90 hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeFilter === 'today' ? 'text-emerald-800 dark:text-emerald-300' : 'text-slate-500 dark:text-slate-400' }}">
                    Kunjungan Hari Ini
                </span>
                <span class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $activeFilter === 'today' ? 'bg-emerald-600 text-white dark:bg-emerald-800 dark:text-emerald-100' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                    H
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayVisits }}</span>
                <span class="text-xs {{ $activeFilter === 'today' ? 'text-emerald-700 dark:text-emerald-300' : 'text-slate-500 dark:text-slate-400' }} font-medium">pasien</span>
            </div>
            <p class="mt-3 text-xs {{ $activeFilter === 'today' ? 'text-emerald-700 dark:text-emerald-400 font-bold' : 'text-slate-400 dark:text-slate-500' }}">
                {{ now()->translatedFormat('d F Y') }} ↗
            </p>
        </a>


        <!-- 3. Total Riwayat -->
        <a href="{{ route('admin.ringkasan', ['filter' => 'all']) }}" 
           class="group rounded-2xl border p-6 transition-all duration-200 shadow-xs block {{ $activeFilter === 'all' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-500/10 dark:bg-emerald-950/70 ring-2 ring-emerald-500/80 dark:ring-emerald-400/80 shadow-md' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/90 hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeFilter === 'all' ? 'text-emerald-800 dark:text-emerald-300' : 'text-slate-500 dark:text-slate-400' }}">
                    Total Riwayat
                </span>
                <span class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $activeFilter === 'all' ? 'bg-emerald-600 text-white dark:bg-emerald-800 dark:text-emerald-100' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                    T
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $totalVisits }}</span>
                <span class="text-xs {{ $activeFilter === 'all' ? 'text-emerald-700 dark:text-emerald-300' : 'text-slate-500 dark:text-slate-400' }} font-medium">riwayat</span>
            </div>
            <p class="mt-3 text-xs {{ $activeFilter === 'all' ? 'text-emerald-700 dark:text-emerald-400 font-bold' : 'text-slate-400 dark:text-slate-500' }}">
                Arsip keseluruhan sistem ↗
            </p>
        </a>

        <!-- 4. Siswa Terdaftar -->
        <a href="{{ route('admin.ringkasan', ['filter' => 'students']) }}" 
           class="group rounded-2xl border p-6 transition-all duration-200 shadow-xs block {{ $activeFilter === 'students' ? 'border-emerald-500 dark:border-emerald-400 bg-emerald-500/10 dark:bg-emerald-950/70 ring-2 ring-emerald-500/80 dark:ring-emerald-400/80 shadow-md' : 'border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900/90 hover:border-emerald-500 dark:hover:border-emerald-500/60 hover:shadow-md' }}">
            <div class="flex items-center justify-between mb-3">
                <span class="text-xs font-bold uppercase tracking-wider {{ $activeFilter === 'students' ? 'text-emerald-800 dark:text-emerald-300' : 'text-slate-500 dark:text-slate-400' }}">
                    Siswa Terdaftar
                </span>
                <span class="h-8 w-8 rounded-lg flex items-center justify-center font-bold text-xs {{ $activeFilter === 'students' ? 'bg-emerald-600 text-white dark:bg-emerald-800 dark:text-emerald-100' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }}">
                    S
                </span>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $studentCount }}</span>
                <span class="text-xs {{ $activeFilter === 'students' ? 'text-emerald-700 dark:text-emerald-300' : 'text-slate-500 dark:text-slate-400' }} font-medium">siswa</span>
            </div>
            <p class="mt-3 text-xs {{ $activeFilter === 'students' ? 'text-emerald-700 dark:text-emerald-400 font-bold' : 'text-slate-400 dark:text-slate-500' }}">
                Klik lihat daftar siswa ↗
            </p>
        </a>
    </section>

    <!-- Filter Status Cepat (Jika sedang melihat data kunjungan) -->
    @if ($activeFilter !== 'students')
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-semibold text-slate-400 mr-2">Filter Status:</span>
            <a href="{{ route('admin.ringkasan', ['filter' => $activeFilter]) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($activeStatus) ? 'bg-emerald-600 dark:bg-emerald-700 text-white shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                Semua Status
            </a>
            <a href="{{ route('admin.ringkasan', ['filter' => ($activeFilter === 'today' ? 'today' : 'all'), 'status' => 'ditangani']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $activeStatus === 'ditangani' ? 'bg-emerald-600 dark:bg-emerald-700 text-white shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-800' }}">
                Ditangani di UKS ({{ $statusStats['ditangani'] }})
            </a>
            <a href="{{ route('admin.ringkasan', ['filter' => ($activeFilter === 'today' ? 'today' : 'all'), 'status' => 'dirujuk']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $activeStatus === 'dirujuk' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-amber-700 hover:bg-amber-50' }}">
                Dirujuk ({{ $statusStats['dirujuk'] }})
            </a>
            <a href="{{ route('admin.ringkasan', ['filter' => ($activeFilter === 'today' ? 'today' : 'all'), 'status' => 'pulang']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $activeStatus === 'pulang' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-sky-700 hover:bg-sky-50' }}">
                Pulang ({{ $statusStats['pulang'] }})
            </a>
        </div>
    @endif

    <!-- Data Table & CRUD Section -->
    <div class="space-y-4">
        <!-- Bar Pencarian Cepat & Header Tabel -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div>
                <h3 class="text-base font-bold text-slate-900">
                    @if ($activeFilter === 'students')
                        Manajemen Data Siswa Terdaftar
                    @elseif ($activeFilter === 'today')
                        Catatan Kunjungan Hari Ini ({{ now()->format('d/m/Y') }})
                    @elseif ($activeFilter === 'month')
                        Catatan Kunjungan Bulan Ini ({{ now()->translatedFormat('F Y') }})
                    @else
                        Seluruh Catatan Riwayat Kunjungan
                    @endif
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data secara langsung dengan fitur Tambah, Edit, dan Hapus (CRUD).</p>
            </div>

            <form method="GET" action="{{ route('admin.ringkasan') }}" class="flex items-center gap-2">
                <input type="hidden" name="filter" value="{{ $activeFilter }}">
                @if ($activeStatus)
                    <input type="hidden" name="status" value="{{ $activeStatus }}">
                @endif
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $activeFilter === 'students' ? 'Cari nama, NIS, kelas...' : 'Cari siswa atau keluhan...' }}" class="w-56 sm:w-72 px-4 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                <button type="submit" class="px-4 py-2.5 bg-slate-800 hover:bg-slate-900 dark:bg-teal-600 dark:hover:bg-teal-700 text-white rounded-xl text-xs font-semibold transition shrink-0">
                    Cari
                </button>
                @if (request()->filled('q'))
                    <a href="{{ route('admin.ringkasan', ['filter' => $activeFilter, 'status' => $activeStatus]) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-semibold transition shrink-0">
                        ✕
                    </a>
                @endif
            </form>
        </div>

        <!-- Tabel Konten Interaktif dengan Tombol CRUD -->
        <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">
            @if ($activeFilter === 'students')
                <!-- Tabel Siswa Terdaftar (CRUD) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 dark:bg-slate-800/80 border-b-2 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 uppercase tracking-wider font-bold">
                            <tr>

                                <th class="px-6 py-4">Nama Lengkap Siswa</th>
                                <th class="px-6 py-4">Kelas</th>
                                <th class="px-6 py-4">Jenis Kelamin</th>
                                <th class="px-6 py-4 text-center">Riwayat Kunjungan</th>
                                <th class="px-6 py-4 text-center">Aksi (CRUD)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-300 dark:divide-slate-800">
                            @forelse ($studentsData as $student)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">

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
                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('students.edit', $student) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Edit Data Siswa">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Semua catatan kunjungan yang terkait juga akan dihapus.');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition" title="Hapus Siswa">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-slate-400">
                                        <p class="text-base font-semibold text-slate-600">Tidak ada data siswa ditemukan.</p>
                                        <a href="{{ route('students.create') }}" class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition">
                                            + Tambah Siswa Baru
                                        </a>
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
                <!-- Tabel Kunjungan Siswa (CRUD) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-100 dark:bg-slate-800/80 border-b-2 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 uppercase tracking-wider font-bold">
                            <tr>
                                <th class="px-6 py-4 w-12 text-center">No</th>
                                <th class="px-6 py-4">{{ $activeFilter === 'today' ? 'Jam Masuk' : 'Tanggal & Jam' }}</th>
                                <th class="px-6 py-4">Siswa Pasien</th>
                                <th class="px-6 py-4">Kelas</th>
                                <th class="px-6 py-4 text-center">Total Kunjungan</th>

                                <th class="px-6 py-4">Keluhan Sakit</th>
                                <th class="px-6 py-4">Tindakan Awal</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-300 dark:divide-slate-800">
                            @forelse ($visitsData as $index => $visit)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
                                    <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-slate-500 text-xs">
                                        {{ method_exists($visitsData, 'firstItem') && $visitsData->firstItem() ? $visitsData->firstItem() + $index : $loop->iteration }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($activeFilter === 'today')
                                            <span class="font-bold text-slate-800 text-xs inline-flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ $visit->created_at ? $visit->created_at->format('H:i') : ($visit->visit_date ? $visit->visit_date->format('H:i') : '-') }} WIB
                                            </span>
                                        @else
                                            <span class="font-bold text-slate-800 block">
                                                {{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '-' }}
                                            </span>
                                            <span class="text-[11px] text-slate-400">
                                                {{ $visit->created_at ? $visit->created_at->format('H:i') : '' }} WIB
                                            </span>
                                        @endif
                                    </td>

                                    <td class="px-6 py-4">
                                        <span class="font-bold text-slate-900 block text-sm">
                                            {{ $visit->student->name ?? 'Siswa Tidak Diketahui' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-slate-600 font-medium">
                                        {{ $visit->student->class_name ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200" title="Total riwayat kunjungan siswa ke UKS">
                                            {{ $visit->student->visits_count ?? 1 }} kali
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

                                    <td class="px-6 py-4 text-center whitespace-nowrap">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('kunjungan.edit', $visit) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Edit Catatan Kunjungan">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('kunjungan.destroy', $visit) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data catatan kunjungan ini?');" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 rounded-lg transition" title="Hapus Catatan">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-12 text-center text-slate-400">
                                        <p class="text-base font-semibold text-slate-600">Belum ada catatan kunjungan untuk filter ini.</p>
                                        <p class="text-xs text-slate-400 mt-1">Gunakan tombol di atas untuk mencatat data baru.</p>
                                        <a href="{{ route('kunjungan.create') }}" class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition">
                                            Catat Kunjungan Sekarang
                                        </a>
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
    </div>
</div>
@endsection
