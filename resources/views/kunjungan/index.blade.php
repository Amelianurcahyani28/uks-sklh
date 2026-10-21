@extends('layouts.app', ['heading' => 'Catat Kunjungan — Data Siswa'])

@section('content')
<!-- Hero Section Admin Full Width: Menempel Langsung Tanpa Space di Atasnya -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                Pencatatan Kunjungan & Data Siswa
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Catat Kunjungan UKS</h2>
            <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 leading-relaxed">
                Kelola data siswa dan catat kunjungan pemeriksaan UKS (Total {{ $totalStudents }} siswa terdaftar).
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

    <!-- Bar Pencarian Cepat & Tombol Aksi Tambah -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
        <form method="GET" action="{{ route('kunjungan.index') }}" class="flex items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, atau kelas..." class="w-56 sm:w-72 px-4 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/30 active:scale-95 transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Cari</span>
            </button>
        </form>

        <button type="button" onclick="openCatatModal()" class="shrink-0 inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer">
            Catat Kunjungan Baru
        </button>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 dark:bg-slate-800/80 border-b border-slate-200 dark:border-slate-700 text-slate-500 dark:text-slate-400 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="sticky left-0 z-20 bg-slate-50 dark:bg-slate-800 px-3 py-3.5 w-14 text-center whitespace-nowrap border-r border-slate-200 dark:border-slate-700 shadow-xs">No</th>
                        <th class="px-5 py-3.5 whitespace-nowrap">Nama Lengkap</th>
                        <th class="px-5 py-3.5 whitespace-nowrap">Kelas</th>
                        <th class="px-5 py-3.5 whitespace-nowrap">Jurusan</th>
                        <th class="px-5 py-3.5 whitespace-nowrap">Jenis Kelamin</th>
                        <th class="px-5 py-3.5 text-center whitespace-nowrap">Total Kunjungan UKS</th>
                        <th class="px-5 py-3.5 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse ($students as $index => $student)
                        @php
                            $cleanClass = trim(preg_replace('/^kelas\s*/i', '', $student->class_name ?? ''));
                        @endphp
                        <tr class="group hover:bg-slate-50/60 dark:hover:bg-slate-800/50 transition">
                            <td class="sticky left-0 z-10 bg-white dark:bg-slate-900 group-hover:bg-slate-50 dark:group-hover:bg-slate-800 px-3 py-3.5 whitespace-nowrap text-center border-r border-slate-100 dark:border-slate-800 shadow-xs">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs border border-slate-200 dark:border-slate-700">
                                    {{ method_exists($students, 'firstItem') && $students->firstItem() ? $students->firstItem() + $index : $loop->iteration }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap font-bold text-slate-900 dark:text-white text-sm">
                                {{ $student->name }}
                            </td>
                            <td class="px-5 py-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 whitespace-nowrap shadow-xs">
                                    {{ $cleanClass !== '' && $cleanClass !== '-' ? 'Kelas ' . $cleanClass : '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800 whitespace-nowrap">
                                    {{ $student->major ?: '-' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($student->gender === 'L')
                                    <span class="inline-flex items-center gap-1 text-blue-700 dark:text-blue-400 bg-blue-50 dark:bg-blue-950/60 px-2.5 py-1 rounded-full font-medium whitespace-nowrap">
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/60 px-2.5 py-1 rounded-full font-medium whitespace-nowrap">
                                        Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold whitespace-nowrap {{ $student->visits_count > 0 ? 'bg-teal-50 dark:bg-teal-950/60 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }}">
                                    {{ $student->visits_count }} kali
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <button type="button" onclick="catatUntukSiswa({{ $student->id }})" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/50 hover:bg-emerald-100 dark:hover:bg-emerald-900/50 rounded-lg transition cursor-pointer" title="Catat Kunjungan untuk Siswa Ini">
                                        Catat
                                    </button>
                                    <a href="{{ route('students.edit', $student) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/50 hover:bg-teal-100 dark:hover:bg-teal-900/50 rounded-lg transition" title="Edit Data Siswa">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Semua catatan kunjungan siswa ini juga akan terhapus.');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-700 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/50 hover:bg-rose-100 dark:hover:bg-rose-900/50 rounded-lg transition cursor-pointer" title="Hapus Siswa">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-slate-400">
                                <p class="text-base font-semibold text-slate-600 dark:text-slate-300">Tidak ada data siswa ditemukan</p>
                                <p class="text-xs text-slate-400 mt-1">Tambahkan siswa baru untuk memulai pencatatan.</p>
                                <button type="button" onclick="openCatatModal()" class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition cursor-pointer">
                                    Catat Kunjungan Baru
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
            <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Pop-up: Formulir Catat Kunjungan Siswa -->
<div id="modalCatatKunjungan" class="fixed inset-0 z-50 hidden overflow-y-auto bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
    <div class="relative w-full max-w-2xl bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-slate-100 dark:border-slate-800 overflow-hidden animate-fadeIn" onclick="event.stopPropagation()">
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
                        @foreach ($allStudents ?? [] as $st)
                            <option value="{{ $st->id }}" @selected(old('student_id') == $st->id)>
                                {{ $st->name }} — Kelas {{ $st->class_name }}{{ $st->major ? ' (' . $st->major . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Atau Isi Cepat Siswa Baru -->
                <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/60 border border-slate-200/80 dark:border-slate-700/80 space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Atau Isi Cepat Jika Siswa Belum Ada di Database:</span>
                        <span class="text-[10px] text-teal-700 dark:text-teal-400 font-semibold bg-teal-50 dark:bg-teal-950/60 px-2 py-0.5 rounded-full border border-teal-200 dark:border-teal-800">Otomatis Simpan Siswa</span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Nama Siswa Baru</label>
                            <input type="text" name="student_name" id="modal_student_name" value="{{ old('student_name') }}" placeholder="Contoh: Muhammad Rizki" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2 focus:border-teal-600 focus:ring-teal-600">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Jenis Kelamin</label>
                            <select name="gender" id="modal_gender" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2 focus:border-teal-600 focus:ring-teal-600">
                                <option value="">-- Pilih Gender --</option>
                                <option value="L" @selected(old('gender') === 'L')>Laki-laki</option>
                                <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Kelas</label>
                            <input type="text" name="class_name" id="modal_class_name" value="{{ old('class_name') }}" placeholder="Contoh: X PPLG 1" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2 focus:border-teal-600 focus:ring-teal-600">
                        </div>

                        <div>
                            <label class="block text-[11px] font-semibold text-slate-600 dark:text-slate-400 mb-1">Jurusan</label>
                            <select name="major" id="modal_major" class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2 focus:border-teal-600 focus:ring-teal-600">
                                <option value="">-- Pilih Jurusan --</option>
                                <option value="PPLG" @selected(old('major') === 'PPLG')>PPLG</option>
                                <option value="BCF" @selected(old('major') === 'BCF')>BCF</option>
                                <option value="ANIM" @selected(old('major') === 'ANIM')>ANIM</option>
                                <option value="TO" @selected(old('major') === 'TO')>TO</option>
                                <option value="TPFL" @selected(old('major') === 'TPFL')>TPFL</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Bagian 2: Data Medis Kunjungan -->
            <div class="space-y-3 pt-3 border-t border-slate-100 dark:border-slate-800">
                <label class="block text-xs font-bold text-teal-700 dark:text-teal-400 uppercase tracking-wider">
                    2. Catatan Pemeriksaan & Tindakan
                </label>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Tanggal Kunjungan</label>
                        <input type="date" name="visit_date" value="{{ old('visit_date', now()->toDateString()) }}" required class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Status Penanganan</label>
                        <select name="status" required class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">
                            <option value="ditangani" @selected(old('status', 'ditangani') === 'ditangani')>Ditangani di UKS</option>
                            <option value="dirujuk" @selected(old('status') === 'dirujuk')>Dirujuk ke Faskes / Rumah Sakit</option>
                            <option value="pulang" @selected(old('status') === 'pulang')>Diperbolehkan Pulang</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Keluhan / Gejala Sakit <span class="text-rose-500">*</span></label>
                    <textarea name="complaint" rows="2" required placeholder="Contoh: Demam tinggi, pusing, mual sejak jam ke-2..." class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">{{ old('complaint') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 dark:text-slate-300 mb-1">Tindakan Awal / Obat yang Diberikan</label>
                    <textarea name="initial_treatment" rows="2" placeholder="Contoh: Diberi paracetamol 500mg, istirahat di tempat tidur UKS selama 30 menit..." class="w-full rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900 text-xs text-slate-800 dark:text-slate-100 p-2.5 focus:border-teal-600 focus:bg-white dark:focus:bg-slate-900 focus:ring-teal-600">{{ old('initial_treatment') }}</textarea>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeCatatModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2 text-xs font-bold text-white bg-teal-600 hover:bg-teal-700 rounded-xl shadow-xs transition cursor-pointer">
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

    function catatUntukSiswa(studentId) {
        openCatatModal();
        const select = document.getElementById('modal_student_id');
        if (select) {
            select.value = studentId;
        }
    }

    document.getElementById('modalCatatKunjungan')?.addEventListener('click', function (e) {
        if (e.target === this) {
            closeCatatModal();
        }
    });

    @if (request()->query('tambah') || $errors->any())
        document.addEventListener('DOMContentLoaded', function () {
            openCatatModal();
        });
    @endif
</script>
@endsection