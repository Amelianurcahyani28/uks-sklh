@extends('layouts.app', ['heading' => 'Beranda / Dashboard'])

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner Admin -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-800 via-teal-700 to-slate-900 p-8 text-white shadow-lg">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-500/20 text-teal-200 border border-teal-400/30 mb-2">
                    Panel Petugas UKS
                </span>
                <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight">Selamat Datang, {{ Auth::user()->name ?? 'Petugas UKS' }}!</h2>
                <p class="mt-1 text-sm text-teal-100 max-w-xl">
                    Pantau kesehatan siswa, kelola catatan kunjungan UKS, dan akses manajemen data CRUD secara langsung dari dashboard ini.
                </p>
            </div>
        </div>
        <div class="absolute -right-8 -bottom-10 w-48 h-48 bg-teal-500/10 rounded-full blur-2xl pointer-events-none"></div>
    </div>



    <!-- Bagian Filter Status (Jika sedang melihat data kunjungan) -->
    @if ($activeFilter !== 'students')
        <div class="flex flex-wrap items-center gap-2">
            <span class="text-xs font-semibold text-slate-400 mr-2">Filter Status Pasien:</span>
            <a href="{{ route('dashboard', ['filter' => $activeFilter]) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ empty($activeStatus) ? 'bg-teal-700 text-white shadow-xs' : 'bg-white border border-slate-200 text-slate-600 hover:bg-slate-50' }}">
                Semua Status
            </a>
            <a href="{{ route('dashboard', ['filter' => $activeFilter, 'status' => 'ditangani']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $activeStatus === 'ditangani' ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-emerald-700 hover:bg-emerald-50' }}">
                Ditangani di UKS ({{ $statusCounts['ditangani'] }})
            </a>
            <a href="{{ route('dashboard', ['filter' => $activeFilter, 'status' => 'dirujuk']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $activeStatus === 'dirujuk' ? 'bg-amber-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-amber-700 hover:bg-amber-50' }}">
                Dirujuk ({{ $statusCounts['dirujuk'] }})
            </a>
            <a href="{{ route('dashboard', ['filter' => $activeFilter, 'status' => 'pulang']) }}" 
               class="px-3 py-1.5 rounded-lg text-xs font-semibold transition {{ $activeStatus === 'pulang' ? 'bg-sky-600 text-white shadow-xs' : 'bg-white border border-slate-200 text-sky-700 hover:bg-sky-50' }}">
                Pulang ({{ $statusCounts['pulang'] }})
            </a>
        </div>
    @endif

    <!-- Data Table & CRUD Section Langsung di Dashboard Admin -->
    <div class="space-y-4">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
            <div>
                <h3 class="text-base font-bold text-slate-900">
                    @if ($activeFilter === 'students')
                        Manajemen Data Siswa (CRUD)
                    @elseif ($activeFilter === 'today')
                        Catatan Kunjungan Hari Ini (CRUD) — {{ now()->format('d/m/Y') }}
                    @elseif ($activeFilter === 'month')
                        Catatan Kunjungan Bulan Ini (CRUD) — {{ now()->translatedFormat('F Y') }}
                    @else
                        Seluruh Arsip Riwayat Kunjungan (CRUD)
                    @endif
                </h3>
                <p class="text-xs text-slate-500 mt-0.5">Kelola data pasien dan siswa: Tambah baru, Edit, atau Hapus catatan.</p>
            </div>

            <!-- Pencarian & Tombol Aksi Tambah -->
            <div class="flex items-center gap-3">
                <form method="GET" action="{{ route('dashboard') }}" class="flex items-center gap-2">
                    <input type="hidden" name="filter" value="{{ $activeFilter }}">
                    @if ($activeStatus)
                        <input type="hidden" name="status" value="{{ $activeStatus }}">
                    @endif
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ $activeFilter === 'students' ? 'Cari nama, NIS, kelas...' : 'Cari nama atau keluhan...' }}" class="rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600 w-52 sm:w-60">
                    <button type="submit" class="px-3.5 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">
                        Cari
                    </button>
                    @if (request()->filled('q'))
                        <a href="{{ route('dashboard', ['filter' => $activeFilter, 'status' => $activeStatus]) }}" class="px-2.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition">
                            ✕
                        </a>
                    @endif
                </form>

                @if ($activeFilter === 'students')
                    <a href="{{ route('students.create') }}" class="shrink-0 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition">
                        + Tambah Siswa
                    </a>
                @else
                    <a href="{{ route('kunjungan.create') }}" class="shrink-0 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-3.5 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition">
                        + Catat Kunjungan
                    </a>
                @endif
            </div>
        </div>

        <!-- Tabel Interaktif CRUD -->
        <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
            @if ($activeFilter === 'students')
                <!-- Tabel Siswa (CRUD) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                            <tr>

                                <th class="px-6 py-4">Nama Lengkap Siswa</th>
                                <th class="px-6 py-4">Kelas</th>
                                <th class="px-6 py-4">Jenis Kelamin</th>
                                <th class="px-6 py-4 text-center">Riwayat Kunjungan</th>
                                <th class="px-6 py-4 text-center">Aksi (CRUD)</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($studentsData as $student)
                                <tr class="hover:bg-slate-50/60 transition">

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
                                            <a href="{{ route('students.edit', $student) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Edit Siswa">
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
                <!-- Tabel Kunjungan Pasien (CRUD) -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="px-6 py-4 w-12 text-center">No</th>
                                <th class="px-6 py-4">{{ $activeFilter === 'today' ? 'Jam Masuk' : 'Waktu & Tanggal' }}</th>
                                <th class="px-6 py-4">Siswa Pasien</th>
                                <th class="px-6 py-4">Kelas</th>

                                <th class="px-6 py-4">Keluhan Sakit</th>
                                <th class="px-6 py-4">Tindakan Awal</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($visitsData as $index => $visit)
                                <tr class="hover:bg-slate-50/60 transition">
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
                                            <a href="{{ route('kunjungan.edit', $visit) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Edit Kunjungan">
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
                                        <p class="text-base font-semibold text-slate-600">Belum ada catatan kunjungan untuk filter ini.</p>
                                        <a href="{{ route('kunjungan.create') }}" class="mt-3 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition">
                                            + Catat Kunjungan Sekarang
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

    <!-- Keluhan Terbanyak Bulan Berjalan -->
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-xs">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-5">
            <div>
                <h3 class="text-base font-bold text-slate-800">Keluhan Paling Sering</h3>
                <p class="text-xs text-slate-400">Rekapitulasi 5 keluhan teratas bulan berjalan</p>
            </div>
            <a href="{{ route('admin.ringkasan') }}" class="text-xs font-semibold text-teal-700 hover:text-teal-800 hover:underline">
                Buka Halaman Ringkasan Lengkap →
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
                        <div class="h-full bg-teal-600 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
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