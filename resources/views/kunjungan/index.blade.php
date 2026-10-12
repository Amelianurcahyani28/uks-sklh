@extends('layouts.app', ['heading' => 'Catat Kunjungan — Data Siswa yang Berkunjung'])

@section('content')
<!-- Hero Section Admin Full Width: Menempel Langsung Tanpa Space di Atasnya -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                Manajemen Data Kunjungan
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Catat Kunjungan & Riwayat Medis</h2>
            <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 leading-relaxed">
                Total tercatat {{ $totalVisits }} kunjungan ({{ $todayCount }} kunjungan hari ini).
            </p>
        </div>
    </div>
</div>

<div class="p-4 sm:p-8 space-y-6 flex-1">
    @if (session('success'))
        <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center justify-between">
            <span>✓ {{ session('success') }}</span>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-700 hover:text-emerald-900 font-bold ml-4">✕</button>
        </div>
    @endif

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <p class="font-bold mb-1">Periksa kembali data yang dimasukkan:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Filter & Pencarian Box -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('kunjungan.index') }}" class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                <!-- Pencarian Kata Kunci -->
                <div class="lg:col-span-2">
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, atau keluhan sakit..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                </div>

                <!-- Filter Status -->
                <div>
                    <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                        <option value="">-- Semua Status --</option>
                        <option value="ditangani" @selected(request('status') === 'ditangani')>Ditangani di UKS</option>
                        <option value="dirujuk" @selected(request('status') === 'dirujuk')>Dirujuk ke Faskes</option>
                        <option value="pulang" @selected(request('status') === 'pulang')>Diperbolehkan Pulang</option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit" class="w-full shrink-0 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">
                        Cari
                    </button>
                    @if (request()->hasAny(['q', 'status', 'period', 'date', 'month']))
                        <a href="{{ route('kunjungan.index') }}" class="shrink-0 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition flex items-center justify-center" title="Reset filter">
                            ✕
                        </a>
                    @endif
                </div>
            </div>

            <!-- Filter Waktu Khusus -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 pt-3 border-t border-slate-100">
                <!-- Filter Hari Ini & Semua -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Cepat</label>
                    <div class="flex gap-2">
                        <a href="{{ route('kunjungan.index', ['period' => 'today']) }}" class="flex-1 text-center rounded-xl border border-teal-200 bg-teal-50 text-teal-700 hover:bg-teal-100 dark:border-teal-800/60 dark:bg-teal-900/40 dark:text-teal-300 dark:hover:bg-teal-900/60 text-xs font-bold px-2 py-2 transition {{ request('period') === 'today' ? 'ring-2 ring-teal-500 dark:ring-teal-400' : '' }}">
                            Hari Ini
                        </a>
                        <a href="{{ route('kunjungan.index') }}" class="flex-1 text-center rounded-xl border border-indigo-200 bg-indigo-50 text-indigo-700 hover:bg-indigo-100 dark:border-indigo-800/60 dark:bg-indigo-900/40 dark:text-indigo-300 dark:hover:bg-indigo-900/60 text-xs font-bold px-2 py-2 transition {{ !request()->hasAny(['period', 'date', 'month', 'q', 'status']) ? 'ring-2 ring-indigo-500 dark:ring-indigo-400' : '' }}">
                            Semua
                        </a>
                    </div>
                </div>

                <!-- Filter Per Hari -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Per Hari (Tanggal)</label>
                    <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600">
                </div>

                <!-- Filter Per Bulan -->
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Per Bulan</label>
                    <input type="month" name="month" value="{{ request('month') }}" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600">
                </div>
            </div>
        </form>
    </div>

    <!-- Tabel Data Siswa yang Berkunjung -->
    <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-800/80 border-b-2 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-4 py-4 w-12 text-center">No</th>
                        <th class="px-4 py-4">Tanggal & Jam</th>
                        <th class="px-4 py-4 min-w-[170px]">Nama Siswa</th>
                        <th class="px-4 py-4">Kelas</th>
                        <th class="px-4 py-4">Keluhan & Gejala</th>
                        <th class="px-4 py-4">Tindakan Awal</th>
                        <th class="px-4 py-4">Status</th>
                        <th class="px-4 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-800">
                    @forelse ($visits as $index => $visit)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
                            <td class="px-4 py-4 whitespace-nowrap text-center font-bold text-slate-500 dark:text-slate-400 text-xs">
                                {{ method_exists($visits, 'firstItem') && $visits->firstItem() ? $visits->firstItem() + $index : $loop->iteration }}
                            </td>
                            <td class="px-4 py-4 whitespace-nowrap">
                                <span class="font-bold text-slate-800 dark:text-slate-100 block">
                                    {{ $visit->visit_date ? $visit->visit_date->format('d/m/Y') : '-' }}
                                </span>
                                <span class="text-[11px] text-slate-400 dark:text-slate-500">
                                    {{ $visit->created_at ? $visit->created_at->format('H:i') : '' }} WIB
                                </span>
                            </td>

                            <td class="px-4 py-4 whitespace-nowrap min-w-[170px]">
                                <span class="font-bold text-slate-900 dark:text-slate-100 block">
                                    {{ $visit->student->name ?? 'Siswa Tidak Diketahui' }}
                                </span>
                            </td>

                            <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">
                                {{ $visit->student->class_name ?? '-' }}
                            </td>

                            <td class="px-4 py-4" style="max-width: 200px;">
                                <p class="text-slate-800 dark:text-slate-200 font-medium text-xs leading-relaxed line-clamp-2" title="{{ $visit->complaint }}">
                                    {{ $visit->complaint }}
                                </p>
                            </td>

                            <td class="px-4 py-4" style="max-width: 180px;">
                                <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed line-clamp-2" title="{{ $visit->initial_treatment }}">
                                    {{ $visit->initial_treatment ?: '-' }}
                                </p>
                            </td>

                            <td class="px-4 py-4 whitespace-nowrap">
                                @if ($visit->status === 'ditangani')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-50 dark:bg-emerald-950/40 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span> Ditangani di UKS
                                    </span>
                                @elseif ($visit->status === 'dirujuk')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 dark:bg-amber-950/40 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-amber-500"></span> Dirujuk ke Faskes
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-sky-50 dark:bg-sky-950/40 text-sky-700 dark:text-sky-400 border border-sky-200 dark:border-sky-800">
                                        <span class="h-1.5 w-1.5 rounded-full bg-sky-500"></span> Diizinkan Pulang
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('kunjungan.edit', $visit) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/40 hover:bg-teal-100 dark:hover:bg-teal-900/70 rounded-lg transition" title="Edit Kunjungan">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('kunjungan.destroy', $visit) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kunjungan ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-100 dark:hover:bg-rose-950/70 rounded-lg transition cursor-pointer" title="Hapus Catatan">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500">
                                <p class="text-base font-semibold text-slate-600 dark:text-slate-300">Tidak ada data siswa berkunjung</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Gunakan tombol di bawah untuk mencatat data kunjungan siswa baru.</p>
                                <button type="button" onclick="openCatatModal()" class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition cursor-pointer">
                                    Catat Kunjungan Baru
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($visits->hasPages())
            <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $visits->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Pop-up: Formulir Catat Kunjungan Siswa -->
<div id="modalCatatKunjungan" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden animate-fadeIn" onclick="event.stopPropagation()">
        <!-- Modal Header -->
        <div class="flex items-center justify-between px-6 py-4 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/60">
            <div>
                <h3 class="text-base font-bold text-slate-800 dark:text-white">Catat Kunjungan Baru</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Masukkan data pemeriksaan dan tindak lanjut siswa di UKS.</p>
            </div>
            <button type="button" onclick="closeCatatModal()" class="text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 p-1.5 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Modal Form -->
        <form method="POST" action="{{ route('kunjungan.store') }}" class="p-6 space-y-5">
            @csrf

            <!-- Bagian 1: Identitas Siswa -->
            <div class="space-y-3">
                <label class="block text-xs font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider">
                    1. Identitas Siswa Pasien
                </label>

                <!-- Pilih Siswa Terdaftar -->
                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Pilih dari Database Siswa Terdaftar</label>
                    <select name="student_id" id="modal_student_id" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100 p-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">
                        <option value="">-- Pilih Siswa Terdaftar (Atau isi cepat di bawah jika siswa baru) --</option>
                        @foreach ($students ?? [] as $student)
                            <option value="{{ $student->id }}" @selected(old('student_id') == $student->id)>
                                {{ $student->name }} — Kelas {{ $student->class_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Atau Isi Cepat Siswa Baru -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Atau Isi Cepat Jika Siswa Belum Ada di Database:</span>
                        <span class="text-[10px] text-teal-700 dark:text-teal-300 bg-teal-50 dark:bg-teal-900/40 border border-teal-200 dark:border-teal-800 px-2 py-0.5 rounded-md font-semibold">Otomatis Dibuatkan Profil</span>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1">Nama Lengkap Siswa</label>
                            <input type="text" id="modal_student_name" name="student_name" value="{{ old('student_name') }}" placeholder="Contoh: Budi Santoso" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-900 px-3 py-2 focus:border-teal-600 focus:ring-teal-600">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1">Kelas</label>
                            <input type="text" id="modal_class_name" name="class_name" value="{{ old('class_name') }}" placeholder="Contoh: VII-A / 10 IPA 1" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-900 px-3 py-2 focus:border-teal-600 focus:ring-teal-600">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-slate-600 dark:text-slate-300 mb-1">Jenis Kelamin</label>
                            <select id="modal_gender" name="gender" class="w-full rounded-lg border border-slate-200 dark:border-slate-700 text-sm text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-900 px-3 py-2 focus:border-teal-600 focus:ring-teal-600">
                                <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Waktu, Status & Keluhan -->
            <div class="space-y-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <label class="block text-xs font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider">
                    2. Waktu, Keluhan & Penanganan
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Pemeriksaan *</label>
                        <input type="date" name="visit_date" value="{{ old('visit_date', now()->toDateString()) }}" required class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100 px-3 py-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Status Penanganan Awal *</label>
                        <select name="status" required class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100 px-3 py-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">
                            <option value="ditangani" @selected(old('status') === 'ditangani')>Ditangani di UKS (Istirahat / Obat Dasar)</option>
                            <option value="pulang" @selected(old('status') === 'pulang')>Diizinkan Pulang (Perlu istirahat)</option>
                            <option value="dirujuk" @selected(old('status') === 'dirujuk')>Dirujuk ke Faskes (Puskesmas/RS)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Keluhan / Gejala Siswa *</label>
                    <textarea name="complaint" id="modal_complaint" rows="2" required placeholder="Tuliskan keluhan atau gejala siswa..." class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100 p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">{{ old('complaint') }}</textarea>
                    <!-- Quick tags -->
                    <div class="mt-2 flex flex-wrap items-center gap-1.5">
                        <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">Cepat:</span>
                        @foreach (['Pusing', 'Sakit Perut / Maag', 'Demam', 'Mual', 'Luka Jatuh', 'Flu / Batuk', 'Mimisan'] as $tag)
                            <button type="button" onclick="setComplaint('{{ $tag }}')" class="text-xs bg-slate-100 hover:bg-teal-50 hover:text-teal-700 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 dark:border-slate-700 px-2.5 py-1 rounded-lg border border-slate-200 transition font-medium cursor-pointer">
                                {{ $tag }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tindakan Awal / Obat (Opsional)</label>
                    <textarea name="initial_treatment" rows="2" placeholder="Contoh: Diberi minyak kayu putih, air hangat, paracetamol, dan istirahat 30 menit..." class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100 p-3 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">{{ old('initial_treatment') }}</textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-2.5 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeCatatModal()" class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 shadow-md transition cursor-pointer">
                    Simpan Catatan Kunjungan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCatatModal() {
        const modal = document.getElementById('modalCatatKunjungan');
        if (modal) {
            modal.classList.remove('hidden');
        }
    }

    function closeCatatModal() {
        const modal = document.getElementById('modalCatatKunjungan');
        if (modal) {
            modal.classList.add('hidden');
        }
    }

    function setComplaint(tag) {
        const textarea = document.getElementById('modal_complaint');
        if (textarea) {
            if (textarea.value.trim() === '') {
                textarea.value = tag;
            } else if (!textarea.value.includes(tag)) {
                textarea.value = textarea.value.trim() + ', ' + tag;
            }
            textarea.focus();
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalCatatKunjungan');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    closeCatatModal();
                }
            });
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeCatatModal();
            }
        });

        // Buka modal otomatis jika ada query parameter tambah=1 atau ada error input
        const urlParams = new URLSearchParams(window.location.search);
        @if ($errors->any())
            openCatatModal();
        @else
            if (urlParams.get('tambah') === '1') {
                openCatatModal();
            }
        @endif
    });
</script>
@endsection