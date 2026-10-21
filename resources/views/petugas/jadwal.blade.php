@extends('layouts.app', ['heading' => 'Jadwal Petugas UKS'])

@section('content')
<!-- Header Gradien Hijau Emerald Modern -->
<div class="bg-gradient-to-r from-emerald-800 via-teal-700 to-slate-900 border-b border-emerald-900/40 text-white p-6 sm:p-8 shadow-md">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('petugas.index') }}" class="text-xs font-semibold text-emerald-200 hover:text-white transition flex items-center gap-1">
                    <span>← Data Petugas</span>
                </a>
                <span class="text-xs text-emerald-300/60">•</span>
                <span class="text-xs text-emerald-100 font-medium">Jadwal Piket Senin – Jumat</span>
            </div>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">
                Jadwal Petugas UKS (Senin – Jumat)
            </h2>
            <p class="text-xs sm:text-sm text-emerald-100/90 mt-1 max-w-2xl leading-relaxed">
                Atur penugasan piket kerja harian petugas medis dan relawan UKS dari Senin sampai Jumat. Jadwal petugas untuk hari berjalan akan otomatis tampil di halaman Beranda.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button onclick="document.getElementById('modalTambahJadwal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs shadow-lg transition transform hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Jadwal Piket</span>
            </button>
        </div>
    </div>
</div>

<div class="p-4 sm:p-8 space-y-6 flex-1">
    <!-- Pesan Flash Sukses / Error -->
    @if (session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-700 dark:text-emerald-300 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <span class="text-base">✓</span>
                <span>{{ session('success') }}</span>
            </div>
            <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 font-black cursor-pointer">✕</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/20 text-rose-700 dark:text-rose-300 text-xs font-bold space-y-1">
            <p class="font-extrabold">Terjadi kesalahan input:</p>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Kartu Statistik Ringkasan Jadwal -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">Total Jadwal Piket</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white mt-1 block">{{ $totalJadwal }}</span>
                <span class="text-[11px] text-teal-600 dark:text-teal-400 font-medium mt-0.5 block">Senin – Jumat</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 dark:bg-teal-950/60 text-teal-600 dark:text-teal-400 flex items-center justify-center text-xl font-bold">
                📅
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">Piket Hari Ini ({{ $daysList[$todayDayNumber] ?? 'Libur' }})</span>
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400 mt-1 block">{{ $todayJadwalCount }}</span>
                <span class="text-[11px] text-emerald-600 dark:text-emerald-400 font-medium mt-0.5 block">Petugas Siaga</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-xl font-bold">
                🩺
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">Petugas Terdaftar</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white mt-1 block">{{ count($allPetugas) }}</span>
                <span class="text-[11px] text-slate-400 font-medium mt-0.5 block">Status Aktif</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-sky-50 dark:bg-sky-950/60 text-sky-600 dark:text-sky-400 flex items-center justify-center text-xl font-bold">
                👥
            </div>
        </div>
    </div>

    <!-- Visual Roster Mingguan: 5 Hari Sekolah (Senin – Jumat) -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-5 sm:p-6 shadow-xs space-y-4">
        <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
            <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase bg-teal-50 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 mb-1">
                    Agenda Piket Mingguan
                </span>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">
                    Jadwal Piket Petugas UKS (Senin – Jumat)
                </h3>
            </div>
            <span class="text-xs text-slate-400 font-medium hidden sm:inline">
                Hari aktif sekolah: Senin s/d Jumat
            </span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3.5">
            @foreach($daysList as $num => $dayName)
                @php
                    $dayItems = $weeklyCards[$num]['items'] ?? collect();
                    $isToday = $num === $todayDayNumber;
                @endphp
                <div class="rounded-2xl border {{ $isToday ? 'border-emerald-500 bg-emerald-50/40 dark:bg-emerald-950/30 ring-2 ring-emerald-500/20' : 'border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/50' }} p-4 flex flex-col justify-between transition hover:shadow-sm">
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

                        <div class="space-y-2.5">
                            @forelse($dayItems as $item)
                                @php $p = $item->petugas; @endphp
                                @if($p)
                                    <div class="space-y-1.5 pt-1">
                                        <div class="flex items-center gap-2.5">
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

                                        <div class="text-[10px] space-y-0.5 text-slate-500 dark:text-slate-400 pl-1 border-l-2 border-emerald-400 dark:border-emerald-600">
                                            <p class="font-bold text-slate-700 dark:text-slate-300">🕒 {{ $item->shift_time }}</p>
                                            <p class="truncate">{{ $item->room ?? 'Ruang UKS Utama' }}</p>
                                        </div>

                                        <button 
                                            type="button"
                                            onclick="openEditModal({{ $item->id }}, {{ $item->day_number }}, {{ $item->petugas_id }}, '{{ addslashes($item->shift_time) }}', '{{ addslashes($item->room) }}', '{{ addslashes($item->notes ?? '') }}', '{{ $item->status }}')"
                                            class="w-full mt-1 py-1 px-2 rounded-lg bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 border border-slate-200 dark:border-slate-700 text-[10px] font-bold text-slate-700 dark:text-slate-300 transition text-center cursor-pointer">
                                            Ubah Petugas
                                        </button>
                                    </div>
                                @endif
                            @empty
                                <div class="py-4 text-center space-y-1">
                                    <p class="text-[11px] text-slate-400 italic">Belum ada petugas</p>
                                    <button 
                                        type="button" 
                                        onclick="document.getElementById('modalTambahJadwal').classList.remove('hidden'); document.querySelector('[name=day_number]').value = {{ $num }};"
                                        class="text-[10px] font-bold text-teal-600 dark:text-teal-400 hover:underline cursor-pointer">
                                        + Jadwalkan
                                    </button>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Filter Hari Piket -->
    <div class="flex flex-wrap items-center gap-2 pb-1">
        <a href="{{ route('petugas.jadwal') }}" class="px-4 py-2 rounded-xl text-xs font-extrabold transition {{ is_null($selectedDay) ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-50' }}">
            Semua Hari (Senin – Jumat)
        </a>
        @foreach($daysList as $num => $dayName)
            <a href="{{ route('petugas.jadwal', ['day' => $num]) }}" class="px-3.5 py-2 rounded-xl text-xs font-extrabold transition flex items-center gap-1.5 {{ (int) $selectedDay === $num ? 'bg-emerald-600 text-white shadow-xs' : 'bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 border border-slate-200 dark:border-slate-800 hover:bg-slate-50' }}">
                <span>{{ $dayName }}</span>
                @if($num === $todayDayNumber)
                    <span class="h-2 w-2 rounded-full {{ (int) $selectedDay === $num ? 'bg-white' : 'bg-emerald-500' }}"></span>
                @endif
            </a>
        @endforeach
    </div>

    <!-- Tabel Data Jadwal Petugas UKS -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="p-5 border-b border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h3 class="text-sm font-extrabold text-slate-900 dark:text-white">
                    Daftar Penugasan Piket Petugas
                </h3>
                <p class="text-xs text-slate-400 mt-0.5">
                    Klik tombol "Ubah Petugas" pada baris tabel untuk mengganti petugas atau menyesuaikan jam piket.
                </p>
            </div>
            <button onclick="document.getElementById('modalTambahJadwal').classList.remove('hidden')" class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 text-xs font-bold transition flex items-center gap-1.5 cursor-pointer">
                <span>+ Tambah Piket</span>
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/80 text-slate-700 dark:text-slate-200 border-b border-slate-200 dark:border-slate-700">
                        <th class="py-3.5 px-4 font-bold text-center w-14">Hari</th>
                        <th class="py-3.5 px-4 font-bold">Petugas Yang Bertugas</th>
                        <th class="py-3.5 px-4 font-bold">Peran / Jabatan</th>
                        <th class="py-3.5 px-4 font-bold">Jam Piket</th>
                        <th class="py-3.5 px-4 font-bold">Ruangan</th>
                        <th class="py-3.5 px-4 font-bold">Catatan Tugas</th>
                        <th class="py-3.5 px-4 font-bold text-center">Status</th>
                        <th class="py-3.5 px-4 font-bold text-center w-36">Aksi Admin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($jadwals as $item)
                        @php
                            $petugas = $item->petugas;
                            $isToday = $item->day_number === $todayDayNumber;
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/50 transition {{ $isToday ? 'bg-emerald-50/30 dark:bg-emerald-950/20' : '' }}">
                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-block px-2.5 py-1 rounded-lg font-extrabold text-[11px] {{ $isToday ? 'bg-emerald-600 text-white shadow-xs' : 'bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300' }}">
                                    {{ $item->day }}
                                </span>
                                @if($isToday)
                                    <span class="block text-[9px] font-bold text-emerald-600 dark:text-emerald-400 mt-0.5">Hari Ini</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4">
                                @if($petugas)
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br {{ $petugas->gender === 'L' ? 'from-teal-500 to-emerald-600' : 'from-rose-400 to-teal-600' }} text-white font-black text-xs flex items-center justify-center shadow-xs shrink-0">
                                            {{ strtoupper(mb_substr($petugas->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <p class="font-extrabold text-slate-900 dark:text-white leading-tight">{{ $petugas->name }}</p>
                                            <p class="text-[11px] text-slate-400 font-medium">{{ $petugas->phone ?? '-' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-rose-500 italic font-bold">Petugas Tidak Ditemukan</span>
                                @endif
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-semibold text-teal-700 dark:text-teal-400">
                                    {{ $petugas?->role_title ?? '-' }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4">
                                <span class="font-bold text-slate-800 dark:text-slate-200">
                                    {{ $item->shift_time }}
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300 font-medium">
                                {{ $item->room ?? 'Ruang UKS Utama' }}
                            </td>

                            <td class="py-3.5 px-4 text-slate-500 dark:text-slate-400 text-[11px]">
                                {{ $item->notes ?? '-' }}
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold uppercase {{ $item->status === 'aktif' ? 'bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300' : 'bg-slate-100 dark:bg-slate-800 text-slate-500' }}">
                                    @if($item->status === 'aktif')
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                        <span>Aktif</span>
                                    @else
                                        <span>Non-Aktif</span>
                                    @endif
                                </span>
                            </td>

                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-1.5">
                                    <button 
                                        type="button"
                                        onclick="openEditModal({{ $item->id }}, {{ $item->day_number }}, {{ $item->petugas_id }}, '{{ addslashes($item->shift_time) }}', '{{ addslashes($item->room) }}', '{{ addslashes($item->notes ?? '') }}', '{{ $item->status }}')"
                                        class="px-2.5 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 dark:bg-teal-950/60 dark:hover:bg-teal-900/60 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 font-bold transition text-xs flex items-center gap-1 cursor-pointer" 
                                        title="Ubah Petugas & Jadwal">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        <span>Ubah</span>
                                    </button>

                                    <form method="POST" action="{{ route('petugas.jadwal.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal piket hari {{ $item->day }} untuk petugas ini?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 transition cursor-pointer" title="Hapus Jadwal">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-500 dark:text-slate-400">
                                <p class="text-sm font-bold">Belum ada jadwal piket yang terdaftar.</p>
                                <p class="text-xs text-slate-400 mt-1">Klik tombol "+ Tambah Jadwal Piket" untuk menambahkan jadwal tugas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Jadwal Piket -->
<div id="modalTambahJadwal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Tambah Jadwal Piket Baru</h3>
                <p class="text-xs text-slate-400 mt-0.5">Tentukan hari, petugas UKS yang bertugas, dan jam piket.</p>
            </div>
            <button type="button" onclick="document.getElementById('modalTambahJadwal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold text-lg cursor-pointer">✕</button>
        </div>

        <form method="POST" action="{{ route('petugas.jadwal.store') }}" class="p-6 space-y-4">
            @csrf

            <!-- Pilih Hari -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Hari Piket <span class="text-rose-500">*</span>
                </label>
                <select name="day_number" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    @foreach($daysList as $num => $dayName)
                        <option value="{{ $num }}" {{ $num === ($selectedDay ?? $todayDayNumber) ? 'selected' : '' }}>
                            Hari {{ $dayName }} {{ $num === $todayDayNumber ? '(Hari Ini)' : '' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Petugas UKS (Dropdown untuk mengubah petugas) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Pilih Petugas UKS <span class="text-rose-500">*</span>
                </label>
                <select name="petugas_id" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    <option value="">-- Pilih Petugas UKS --</option>
                    @foreach($allPetugas as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->name }} — {{ $p->role_title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jam Shift & Ruangan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Jam Shift / Piket <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="shift_time" value="07:30 - 15:30 WIB" required placeholder="Contoh: 07:30 - 15:30 WIB" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Ruangan / Lokasi
                    </label>
                    <input type="text" name="room" value="Ruang UKS Utama" placeholder="Contoh: Ruang UKS Utama" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                </div>
            </div>

            <!-- Catatan Tugas -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Catatan / Fokus Tugas
                </label>
                <input type="text" name="notes" placeholder="Contoh: Siaga Pemeriksaan Medis, P3K, atau Perawatan Siswa Sakit" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Status Jadwal <span class="text-rose-500">*</span>
                </label>
                <select name="status" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    <option value="aktif">Aktif (Berlaku)</option>
                    <option value="nonaktif">Non-Aktif (Libur)</option>
                </select>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalTambahJadwal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-md transition cursor-pointer">
                    Simpan Jadwal Piket
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Ubah Petugas & Jadwal Piket -->
<div id="modalEditJadwal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-xs p-4 hidden">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 w-full max-w-lg shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div>
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Ubah Petugas &amp; Jadwal Piket</h3>
                <p class="text-xs text-slate-400 mt-0.5">Ganti petugas yang bertugas atau perbarui jam dinas piket.</p>
            </div>
            <button type="button" onclick="document.getElementById('modalEditJadwal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 font-bold text-lg cursor-pointer">✕</button>
        </div>

        <form id="formEditJadwal" method="POST" action="" class="p-6 space-y-4">
            @csrf
            @method('PUT')

            <!-- Pilih Hari -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Hari Piket <span class="text-rose-500">*</span>
                </label>
                <select id="edit_day_number" name="day_number" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    @foreach($daysList as $num => $dayName)
                        <option value="{{ $num }}">Hari {{ $dayName }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Pilih Petugas UKS (Fitur utama: Mengubah Petugas) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Ganti Petugas UKS <span class="text-rose-500">*</span>
                </label>
                <select id="edit_petugas_id" name="petugas_id" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    @foreach($allPetugas as $p)
                        <option value="{{ $p->id }}">
                            {{ $p->name }} — {{ $p->role_title }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Jam Shift & Ruangan -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Jam Shift / Piket <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" id="edit_shift_time" name="shift_time" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Ruangan / Lokasi
                    </label>
                    <input type="text" id="edit_room" name="room" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                </div>
            </div>

            <!-- Catatan Tugas -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Catatan / Fokus Tugas
                </label>
                <input type="text" id="edit_notes" name="notes" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
            </div>

            <!-- Status -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                    Status Jadwal <span class="text-rose-500">*</span>
                </label>
                <select id="edit_status" name="status" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white text-xs p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 transition">
                    <option value="aktif">Aktif (Berlaku)</option>
                    <option value="nonaktif">Non-Aktif (Libur)</option>
                </select>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="document.getElementById('modalEditJadwal').classList.add('hidden')" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-extrabold shadow-md transition cursor-pointer">
                    Perbarui Jadwal
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditModal(id, dayNumber, petugasId, shiftTime, room, notes, status) {
        const form = document.getElementById('formEditJadwal');
        form.action = '/admin/jadwal-petugas/' + id;
        document.getElementById('edit_day_number').value = dayNumber;
        document.getElementById('edit_petugas_id').value = petugasId;
        document.getElementById('edit_shift_time').value = shiftTime;
        document.getElementById('edit_room').value = room || 'Ruang UKS Utama';
        document.getElementById('edit_notes').value = notes || '';
        document.getElementById('edit_status').value = status || 'aktif';
        document.getElementById('modalEditJadwal').classList.remove('hidden');
    }
</script>
@endsection
