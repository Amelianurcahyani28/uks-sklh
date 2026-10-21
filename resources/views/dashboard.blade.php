@extends('layouts.app', ['heading' => 'Dashboard'])

@section('content')
<!-- Hero Section Admin Full Width: Menempel Langsung Tanpa Space di Atasnya -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                    Panel Petugas UKS
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Selamat Datang, {{ Auth::user()->name ?? 'Petugas UKS' }}!</h2>
                <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 max-w-2xl leading-relaxed">
                    Pantau kesehatan siswa, kelola catatan kunjungan UKS, dan akses manajemen data CRUD secara langsung dari dashboard ini.
                </p>
            </div>
        </div>
    </div>
</div>

<div class="p-4 sm:p-8 space-y-8 flex-1">
    <!-- 3 Kartu Metrik Ringkasan (Hari Ini, Total Riwayat, Data Siswa) -->
    <!-- 4 Kartu Metrik Ringkasan (Hari Ini, Total Riwayat, Data Siswa, Petugas UKS) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- 1. Hari Ini (Aktif di Dashboard) -->
        <a href="{{ route('dashboard') }}" 
           class="p-5 rounded-2xl border transition duration-200 block border-emerald-500 dark:border-emerald-600 bg-emerald-50 dark:bg-emerald-950/80 ring-2 ring-emerald-500/30 dark:ring-emerald-600/30 shadow-md">
            <span class="text-xs font-bold block mb-1.5 text-emerald-800 dark:text-emerald-300">Hari Ini</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayVisits }}</span>
                <span class="text-xs font-medium text-emerald-700 dark:text-emerald-300">pasien</span>
            </div>
            <p class="text-xs font-bold mt-2.5 text-emerald-700 dark:text-emerald-400">Kunjungan siswa hari ini (Aktif) ↗</p>
        </a>

        <!-- 2. Total Riwayat (Riwayat Siswa Hari Ini) -->
        <a href="{{ route('dashboard') }}" 
           class="p-5 rounded-2xl border transition duration-200 block border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:border-emerald-400 dark:hover:border-emerald-600 shadow-xs group">
            <span class="text-xs font-bold block mb-1.5 text-slate-500 dark:text-slate-400">Total Riwayat</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayVisits }}</span>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">riwayat</span>
            </div>
            <p class="text-xs font-bold mt-2.5 text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">Riwayat kunjungan hari ini ↗</p>
        </a>

        <!-- 3. Data Siswa (Siswa Berkunjung Hari Ini) -->
        <a href="{{ route('students.index') }}" 
           class="p-5 rounded-2xl border transition duration-200 block border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:border-emerald-400 dark:hover:border-emerald-600 shadow-xs group">
            <span class="text-xs font-bold block mb-1.5 text-slate-500 dark:text-slate-400">Data Siswa</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $todayStudentsCount }}</span>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">terdata</span>
            </div>
            <p class="text-xs font-bold mt-2.5 text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">Siswa berkunjung hari ini ↗</p>
        </a>

        <!-- 4. Petugas UKS -->
        <a href="{{ route('petugas.index') }}" 
           class="p-5 rounded-2xl border transition duration-200 block border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 hover:border-emerald-400 dark:hover:border-emerald-600 shadow-xs group">
            <span class="text-xs font-bold block mb-1.5 text-slate-500 dark:text-slate-400">Petugas UKS</span>
            <div class="flex items-baseline gap-2">
                <span class="text-3xl font-black text-slate-900 dark:text-white">{{ $petugasCount ?? \App\Models\Petugas::count() }}</span>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">petugas</span>
            </div>
            <p class="text-xs font-bold mt-2.5 text-slate-400 dark:text-slate-500 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 transition">Kelola petugas UKS ↗</p>
        </a>
    </div>

    <!-- Section Jadwal Piket Petugas UKS (Senin – Jumat) Khusus Halaman Admin -->
    <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-xs space-y-4">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <div class="flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Jadwal Piket Mingguan
                    </span>
                    <span class="text-xs text-slate-400 font-medium">Senin – Jumat</span>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white mt-1">
                    Jadwal Piket Petugas UKS (Senin – Jumat)
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">
                    Daftar penugasan piket petugas jaga UKS selama hari sekolah aktif. Petugas piket hari ini otomatis tampil di Beranda publik.
                </p>
            </div>

            <a href="{{ route('petugas.jadwal') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition border border-slate-200 dark:border-slate-700 shrink-0">
                <svg class="w-3.5 h-3.5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                <span>Kelola Jadwal Lengkap</span>
                <span>→</span>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5 pt-1">
            @foreach($daysList as $num => $dayName)
                @php
                    $isToday = $num === $todayDayNumber;
                    $daySchedules = $seninJumatSchedules[$num] ?? collect();
                @endphp
                <div class="rounded-2xl border {{ $isToday ? 'border-emerald-500 bg-emerald-50/50 dark:bg-emerald-950/30 ring-2 ring-emerald-500/20' : 'border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/50' }} p-4 flex flex-col justify-between transition hover:shadow-sm">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between pb-2 border-b {{ $isToday ? 'border-emerald-200 dark:border-emerald-800/80' : 'border-slate-200/80 dark:border-slate-800' }}">
                            <span class="text-xs font-black {{ $isToday ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-800 dark:text-slate-200' }}">
                                Hari {{ $dayName }}
                            </span>
                            @if($isToday)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[9px] font-extrabold bg-emerald-600 text-white shadow-xs">
                                    <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                                    <span>Hari Ini</span>
                                </span>
                            @endif
                        </div>

                        <div class="space-y-2">
                            @forelse($daySchedules as $item)
                                @php $p = $item->petugas; @endphp
                                @if($p)
                                    <div class="space-y-1.5">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-xl bg-gradient-to-br {{ $p->gender === 'L' ? 'from-teal-500 to-emerald-600' : 'from-rose-400 to-teal-600' }} text-white font-extrabold text-[11px] flex items-center justify-center shrink-0 shadow-xs">
                                                {{ strtoupper(mb_substr($p->name, 0, 2)) }}
                                            </div>
                                            <div class="min-w-0">
                                                <p class="text-xs font-extrabold text-slate-900 dark:text-white truncate" title="{{ $p->name }}">
                                                    {{ $p->name }}
                                                </p>
                                                <p class="text-[10px] text-teal-600 dark:text-teal-400 font-semibold truncate">
                                                    {{ $p->role_title }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="text-[10px] text-slate-500 dark:text-slate-400 space-y-0.5 pl-1 border-l-2 {{ $isToday ? 'border-emerald-500' : 'border-slate-300 dark:border-slate-700' }}">
                                            <p class="font-bold text-slate-700 dark:text-slate-300">🕒 {{ $item->shift_time }}</p>
                                            <p class="truncate">{{ $item->room ?? 'Ruang UKS Utama' }}</p>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="py-3 text-center space-y-1">
                                    <p class="text-[11px] text-slate-400 italic">Belum ada petugas</p>
                                    <a href="{{ route('petugas.jadwal', ['day' => $num]) }}" class="text-[10px] font-bold text-teal-600 dark:text-teal-400 hover:underline">
                                        + Jadwalkan
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    @if($daySchedules->isNotEmpty())
                        <div class="pt-2 border-t {{ $isToday ? 'border-emerald-200 dark:border-emerald-800/80' : 'border-slate-200/80 dark:border-slate-800' }} mt-2">
                            <a href="{{ route('petugas.jadwal', ['day' => $num]) }}" class="text-[10px] font-bold text-slate-600 dark:text-slate-400 hover:text-emerald-600 dark:hover:text-emerald-400 flex items-center justify-between transition">
                                <span>Ubah Jadwal</span>
                                <span>→</span>
                            </a>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Bagian Filter Status Pasien Hari Ini -->
    <div class="flex flex-wrap items-center gap-2">
        <span class="text-xs font-semibold text-slate-400 dark:text-slate-400 mr-2">Filter Status Pasien:</span>
        <a href="{{ route('dashboard') }}" 
           class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ empty($activeStatus) ? 'bg-emerald-600 dark:bg-emerald-700 text-white shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
            Semua Status ({{ $todayVisits }})
        </a>
        <a href="{{ route('dashboard', ['status' => ($activeStatus === 'ditangani' ? null : 'ditangani')]) }}" 
           class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $activeStatus === 'ditangani' ? 'bg-emerald-600 dark:bg-emerald-700 text-white shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-emerald-700 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-slate-800' }}">
            Ditangani di UKS ({{ $statusCounts['ditangani'] }})
        </a>
        <a href="{{ route('dashboard', ['status' => ($activeStatus === 'dirujuk' ? null : 'dirujuk')]) }}" 
           class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $activeStatus === 'dirujuk' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-amber-700 dark:text-amber-400 hover:bg-amber-50 dark:hover:bg-slate-800' }}">
            Dirujuk ({{ $statusCounts['dirujuk'] }})
        </a>
        <a href="{{ route('dashboard', ['status' => ($activeStatus === 'pulang' ? null : 'pulang')]) }}" 
           class="px-3.5 py-2 rounded-xl text-xs font-bold transition {{ $activeStatus === 'pulang' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sky-700 dark:text-sky-400 hover:bg-sky-50 dark:hover:bg-slate-800' }}">
            Pulang ({{ $statusCounts['pulang'] }})
        </a>
    </div>

    <!-- Data Table Section: Khusus Kunjungan Siswa Hari Ini -->
    <div class="space-y-4">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white dark:bg-slate-900 p-5 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
            <div class="shrink-0">
                <h3 class="text-base font-bold text-slate-900 dark:text-white">
                    @if ($activeStatus)
                        Catatan Kunjungan Hari Ini — Status: {{ $activeStatus === 'ditangani' ? 'Ditangani di UKS' : ($activeStatus === 'dirujuk' ? 'Dirujuk ke Faskes' : 'Diizinkan Pulang') }}
                    @else
                        Catatan Kunjungan Hari Ini
                    @endif
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Menampilkan catatan siswa yang berkunjung ke UKS khusus pada hari ini ({{ now()->translatedFormat('d F Y') }}).</p>
            </div>

            <!-- Pencarian & Tombol Aksi Tambah (Anti-Overflow / Responsif) -->
            <div class="flex flex-wrap items-center gap-2.5 sm:gap-3">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2 flex-wrap sm:flex-nowrap">
                    @if ($activeStatus)
                        <input type="hidden" name="status" value="{{ $activeStatus }}">
                    @endif
                    <div class="relative">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, kelas..." class="w-48 sm:w-56 lg:w-60 px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                    </div>
                    <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/30 active:scale-95 transition shrink-0 cursor-pointer">
                        <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <span>Cari</span>
                    </button>
                </form>

                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <a href="{{ route('admin.kunjungan.export', ['period' => 'today']) }}" class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-3.5 py-2.5 text-xs font-bold text-white shadow-xs transition shrink-0" title="Unduh rekapitulasi kunjungan hari ini ke Excel">
                        <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <span>Export Excel Hari Ini</span>
                    </a>

                    <a href="{{ route('kunjungan.create') }}" class="inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 px-3.5 py-2.5 text-xs font-bold text-white shadow-xs transition shrink-0 cursor-pointer">
                        + Catat Kunjungan
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabel Interaktif Kunjungan Hari Ini (CRUD) -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead class="bg-slate-50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-300 uppercase tracking-wider font-semibold">
                        <tr>
                            <th class="sticky left-0 z-20 bg-slate-50 dark:bg-slate-800 px-3 py-3.5 w-14 text-center whitespace-nowrap border-r border-slate-200 dark:border-slate-700 shadow-xs">No</th>
                            <th class="px-3.5 py-3.5 whitespace-nowrap">Jam Masuk</th>
                            <th class="px-3.5 py-3.5 min-w-[150px]">Siswa Pasien</th>
                            <th class="px-3.5 py-3.5 whitespace-nowrap">Kelas</th>
                            <th class="px-3.5 py-3.5 whitespace-nowrap">Jurusan</th>
                            <th class="px-3.5 py-3.5">Keluhan Sakit</th>
                            <th class="px-3.5 py-3.5">Tindakan Awal</th>
                            <th class="px-3.5 py-3.5 whitespace-nowrap">Status</th>
                            <th class="px-3.5 py-3.5 text-center whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @forelse ($visitsData as $index => $visit)
                            <tr class="group hover:bg-slate-50/60 dark:hover:bg-slate-850 transition">
                                <td class="sticky left-0 z-10 bg-white dark:bg-slate-900 group-hover:bg-slate-50 dark:group-hover:bg-slate-800 px-3 py-3.5 whitespace-nowrap text-center border-r border-slate-100 dark:border-slate-800 shadow-xs">
                                    <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs border border-slate-200 dark:border-slate-700">
                                        {{ method_exists($visitsData, 'firstItem') && $visitsData->firstItem() ? $visitsData->firstItem() + $index : $loop->iteration }}
                                    </span>
                                </td>
                                <td class="px-3.5 py-3.5 whitespace-nowrap">
                                    <span class="font-bold text-slate-800 dark:text-slate-100 text-xs inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5 text-teal-600 dark:text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $visit->created_at ? $visit->created_at->format('H:i') : ($visit->visit_date ? $visit->visit_date->format('H:i') : '-') }} WIB
                                    </span>
                                </td>

                                <td class="px-3.5 py-3.5 min-w-[150px]">
                                    <span class="font-bold text-slate-900 dark:text-white block text-sm">
                                        {{ $visit->student->name ?? 'Siswa Tidak Diketahui' }}
                                    </span>
                                </td>

                                <td class="px-3.5 py-3.5 whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">
                                    {{ $visit->student->class_name ?? '-' }}
                                </td>

                                <td class="px-3.5 py-3.5 whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                        {{ $visit->student->major ?: '-' }}
                                    </span>
                                </td>

                                <td class="px-3.5 py-3.5" style="max-width: 200px;">
                                    <p class="text-slate-800 dark:text-slate-200 font-medium text-xs leading-relaxed line-clamp-2" title="{{ $visit->complaint }}">
                                        {{ $visit->complaint }}
                                    </p>
                                </td>

                                <td class="px-3.5 py-3.5" style="max-width: 180px;">
                                    <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-2" title="{{ $visit->initial_treatment }}">
                                        {{ $visit->initial_treatment ?: '-' }}
                                    </p>
                                </td>

                                <td class="px-3.5 py-3.5 whitespace-nowrap">
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

                                <td class="px-3.5 py-3.5 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('kunjungan.edit', $visit) }}" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 rounded-lg transition" title="Edit Kunjungan">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('kunjungan.destroy', $visit) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kunjungan ini?');" class="inline-block">
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
                                    <p class="text-base font-semibold text-slate-600 dark:text-slate-300">
                                        @if (request()->filled('q'))
                                            Tidak ditemukan catatan kunjungan hari ini dengan kata kunci "{{ request('q') }}".
                                        @elseif ($activeStatus)
                                            Tidak ada catatan kunjungan siswa hari ini dengan status "{{ ucfirst($activeStatus) }}".
                                        @else
                                            Belum ada kunjungan siswa yang tercatat pada hari ini.
                                        @endif
                                    </p>
                                    <a href="{{ route('kunjungan.create') }}" class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs transition">
                                        Catat Kunjungan Baru
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($visitsData && $visitsData->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                    {{ $visitsData->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Keluhan Terbanyak Bulan Berjalan -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div>
                <h3 class="text-base font-bold text-slate-800">Keluhan Paling Sering</h3>
                <p class="text-xs text-slate-400">Rekapitulasi 5 keluhan teratas bulan berjalan</p>
            </div>
            <a href="{{ route('admin.ringkasan') }}" class="text-xs font-semibold text-emerald-600 hover:text-emerald-700 hover:underline">
                Buka Halaman Ringkasan & Laporan →
            </a>
        </div>

        <div class="space-y-4">
            @php
                $maxTotal = $complaints->max('total') ?: 1;
            @endphp
            @forelse ($complaints as $c)
                @php
                    $percentage = round(($c->total / $maxTotal) * 100);
                @endphp
                <div>
                    <div class="flex justify-between items-center text-xs mb-1.5 font-medium">
                        <span class="text-slate-700">{{ $c->complaint }}</span>
                        <span class="text-slate-900 font-bold">{{ $c->total }} kasus</span>
                    </div>
                    <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                    </div>
                </div>
            @empty
                <div class="py-8 text-center text-sm text-slate-400">
                    Belum ada keluhan yang tercatat bulan ini.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection