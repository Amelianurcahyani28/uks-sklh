@extends('layouts.app', ['heading' => 'Data Petugas UKS'])

@section('content')
<!-- Hero Section Admin Full Width: Serasi dengan Siswa & Kunjungan -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                Manajemen Tim &amp; Tenaga Kesehatan
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Data Petugas UKS</h2>
            <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 leading-relaxed">
                Kelola data pembina, tenaga medis, dan relawan PMR yang bertugas di Unit Kesehatan Sekolah SMKN 1 Ciomas.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('petugas.jadwal') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 text-white font-extrabold text-xs border border-white/30 shadow-md transition backdrop-blur-md">
                <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span>Kelola Jadwal Piket</span>
            </a>
            <button type="button" onclick="openModalTambahPetugas()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-extrabold text-xs shadow-lg transition transform hover:-translate-y-0.5 cursor-pointer">
                <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                </svg>
                <span>Tambah Petugas Baru</span>
            </button>
        </div>
    </div>
</div>

<div class="p-4 sm:p-8 space-y-6 flex-1">


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

    <!-- Kartu Counter Ringkasan Cepat -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">Total Petugas</span>
                <span class="text-2xl font-black text-slate-900 dark:text-white">{{ $totalCount }}</span>
                <span class="text-[11px] text-slate-400 block">orang terdaftar</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-teal-50 dark:bg-teal-950/60 border border-teal-200 dark:border-teal-800 flex items-center justify-center text-teal-600 dark:text-teal-400 font-black text-lg">
                👥
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">Petugas Aktif</span>
                <span class="text-2xl font-black text-emerald-600 dark:text-emerald-400">{{ $aktifCount }}</span>
                <span class="text-[11px] text-emerald-600/80 block">siaga melayani</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-black text-lg">
                ✓
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block">Non-Aktif</span>
                <span class="text-2xl font-black text-slate-500 dark:text-slate-400">{{ $nonaktifCount }}</span>
                <span class="text-[11px] text-slate-400 block">sementara tidak jaga</span>
            </div>
            <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 flex items-center justify-center text-slate-500 dark:text-slate-400 font-black text-lg">
                ⏸
            </div>
        </div>
    </div>

    <!-- Bar Pencarian Cepat & Filter Status -->
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-3 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
        <form method="GET" action="{{ route('petugas.index') }}" autocomplete="off" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" autocomplete="off" placeholder="Cari nama, jabatan, jurusan, no telp..." class="w-56 sm:w-64 px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:border-teal-500 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition shadow-xs">
            
            <select name="status" class="px-3 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:border-teal-500 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition shadow-xs">
                <option value="">-- Semua Status --</option>
                <option value="aktif" @selected(request('status') === 'aktif')>Aktif</option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>Non-Aktif</option>
            </select>

            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2.5 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold shadow-md shadow-emerald-600/30 active:scale-95 transition shrink-0 cursor-pointer">
                <svg class="w-4 h-4 text-emerald-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <span>Cari</span>
            </button>

            @if(request('q') || request('status'))
                <a href="{{ route('petugas.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-medium transition">
                    Reset
                </a>
            @endif
        </form>


    </div>

    <!-- Tabel Data Petugas UKS -->
    <div class="rounded-2xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-100 dark:bg-slate-800/80 border-b-2 border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 uppercase tracking-wider font-bold">
                    <tr>
                        <th class="px-3 py-3.5 w-14 text-center whitespace-nowrap border-r border-slate-300 dark:border-slate-700">No</th>
                        <th class="px-3.5 py-3.5 min-w-[200px]">Nama &amp; Jenis Kelamin</th>
                        <th class="px-3.5 py-3.5 whitespace-nowrap">Jabatan / Peran</th>
                        <th class="px-3.5 py-3.5 whitespace-nowrap">Kelas</th>
                        <th class="px-3.5 py-3.5 whitespace-nowrap">Jurusan</th>
                        <th class="px-3.5 py-3.5 whitespace-nowrap">No. WhatsApp / HP</th>
                        <th class="px-3.5 py-3.5 min-w-[180px]">Jadwal Jaga</th>
                        <th class="px-3.5 py-3.5 whitespace-nowrap">Status</th>
                        <th class="px-3.5 py-3.5 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-300 dark:divide-slate-800">
                    @forelse ($petugas as $index => $item)
                        <tr class="group hover:bg-slate-50 dark:hover:bg-slate-800/60 transition">
                            <td class="px-3 py-3.5 whitespace-nowrap text-center border-r border-slate-200 dark:border-slate-800">
                                <span class="inline-flex items-center justify-center w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold text-xs border border-slate-200 dark:border-slate-700">
                                    {{ method_exists($petugas, 'firstItem') && $petugas->firstItem() ? $petugas->firstItem() + $index : $loop->iteration }}
                                </span>
                            </td>
                            <td class="px-3.5 py-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-rose-400 to-teal-600 text-white font-extrabold text-sm flex items-center justify-center shrink-0 shadow-xs">
                                        {{ strtoupper(mb_substr($item->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-slate-900 dark:text-white block">{{ $item->name }}</span>
                                        <span class="text-[10px] font-semibold text-slate-400">{{ $item->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3.5 py-3.5 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800">
                                    {{ $item->role_title }}
                                </span>
                            </td>
                            <td class="px-3.5 py-3.5 whitespace-nowrap text-slate-700 dark:text-slate-300 font-semibold text-xs">
                                @if($item->class_name)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200 border border-slate-200 dark:border-slate-700">
                                        {{ $item->formatted_class_name ?: $item->class_name }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-3.5 py-3.5 whitespace-nowrap text-slate-600 dark:text-slate-300 font-medium">
                                @if($item->major)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                        {{ $item->major }}
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-xs">-</span>
                                @endif
                            </td>
                            <td class="px-3.5 py-3.5 whitespace-nowrap">
                                @if($item->phone)
                                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $item->phone }}</span>
                                @else
                                    <span class="text-slate-400 italic">-</span>
                                @endif
                            </td>
                            <td class="px-3.5 py-3.5">
                                @if($item->jadwals && $item->jadwals->isNotEmpty())
                                    <div class="space-y-1">
                                        @foreach($item->jadwals as $j)
                                            <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-teal-50 dark:bg-teal-950/60 text-teal-800 dark:text-teal-300 border border-teal-200 dark:border-teal-800 text-[11px] font-bold">
                                                <span>Hari {{ $j->day }}</span>
                                                <span class="text-teal-500">•</span>
                                                <span class="font-normal">{{ $j->shift_time }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="font-medium text-slate-700 dark:text-slate-300 text-xs">{{ $item->schedule ?: 'Sesuai Jam Operasional UKS' }}</span>
                                @endif
                            </td>
                            <td class="px-3.5 py-3.5 whitespace-nowrap">
                                @if($item->status === 'aktif')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800 uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                        <span>Aktif</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700 uppercase tracking-wider">
                                        <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                        <span>Non-Aktif</span>
                                    </span>
                                @endif
                            </td>
                            <td class="px-3.5 py-3.5 text-center whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <a href="{{ route('petugas.edit', $item) }}" class="p-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 dark:bg-teal-950/60 dark:hover:bg-teal-900/60 text-teal-700 dark:text-teal-400 border border-teal-200 dark:border-teal-800 transition shadow-xs" title="Edit Petugas">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>

                                    <form method="POST" action="{{ route('petugas.destroy', $item) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus petugas {{ addslashes($item->name) }}?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/60 dark:hover:bg-rose-900/60 text-rose-700 dark:text-rose-400 border border-rose-200 dark:border-rose-800 transition shadow-xs cursor-pointer" title="Hapus Petugas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center text-slate-500 dark:text-slate-400">
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada data petugas UKS.</p>
                                <p class="text-xs text-slate-400 mt-1">Silakan klik tombol <button type="button" onclick="openModalTambahPetugas()" class="text-teal-600 dark:text-teal-400 font-bold underline cursor-pointer">"Tambah Petugas Baru"</button> untuk menambahkan data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($petugas, 'hasPages') && $petugas->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                {{ $petugas->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Tambah Petugas UKS Baru -->
<div id="modalTambahPetugas" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/60 backdrop-blur-xs p-4 hidden overflow-y-auto">
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 w-full max-w-xl shadow-2xl overflow-hidden animate-in fade-in zoom-in-95 duration-150 my-8">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-teal-50 dark:bg-teal-950/80 border border-teal-200 dark:border-teal-800 flex items-center justify-center text-teal-600 dark:text-teal-400 font-bold">
                    👥
                </div>
                <div>
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Tambah Petugas UKS Baru</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Daftarkan pembina, tenaga medis, atau relawan PMR.</p>
                </div>
            </div>
            <button type="button" onclick="closeModalTambahPetugas()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 font-bold text-lg cursor-pointer p-1">✕</button>
        </div>

        <form method="POST" action="{{ route('petugas.store') }}" autocomplete="off" class="p-6 space-y-4 max-h-[calc(85vh-120px)] overflow-y-auto">
            @csrf

            <!-- Nama Petugas -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap Petugas <span class="text-rose-500">*</span></label>
                <input type="text" name="name" id="modal_petugas_name" value="{{ old('name') }}" autocomplete="off" required placeholder="Contoh: Ns. Siti Rahmawati, S.Kep / Dra. Nurjanah" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3">
            </div>

            <!-- Jabatan / Peran -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jabatan / Peran di UKS <span class="text-rose-500">*</span></label>
                <input type="text" name="role_title" value="{{ old('role_title') }}" autocomplete="off" required placeholder="Contoh: Pembina UKS, Tenaga Medis UKS, Petugas P3K, Ketua PMR" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3">
            </div>

            <!-- Jurusan (Khusus Siswa / PMR) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jurusan (Khusus Siswa / PMR)</label>
                <select name="major" id="modal_petugas_major" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3 cursor-pointer">
                    <option value="">-- Bukan Siswa / Umum / Guru --</option>
                    <option value="PPLG" @selected(old('major') === 'PPLG')>PPLG (Pengembangan Perangkat Lunak dan Gim)</option>
                    <option value="BCF" @selected(old('major') === 'BCF')>BCF (Broadcasting dan Perfilman)</option>
                    <option value="ANIM" @selected(old('major') === 'ANIM')>ANIM (Animasi)</option>
                    <option value="TO" @selected(old('major') === 'TO')>TO (Teknik Otomotif)</option>
                    <option value="TPFL" @selected(old('major') === 'TPFL')>TPFL (Teknik Pengelasan dan Fabrikasi Logam)</option>
                </select>
            </div>

            <!-- Kelas (Khusus Siswa / PMR) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Kelas (Khusus Siswa / PMR)</label>
                <select name="class_name" id="modal_petugas_class" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3 cursor-pointer">
                    <!-- Opsi kelas otomatis sesuai jurusan -->
                </select>
            </div>

            <!-- Jenis Kelamin & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/60 dark:has-[:checked]:bg-teal-950/40">
                            <input type="radio" name="gender" value="L" {{ old('gender', 'L') === 'L' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Laki-laki</span>
                        </label>

                        <label class="flex items-center gap-2 p-2.5 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/60 dark:has-[:checked]:bg-rose-950/40">
                            <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Status Petugas <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3">
                        <option value="aktif" @selected(old('status', 'aktif') === 'aktif')>Aktif (Siaga Jaga)</option>
                        <option value="nonaktif" @selected(old('status') === 'nonaktif')>Non-Aktif</option>
                    </select>
                </div>
            </div>

            <!-- No WhatsApp -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">No. WhatsApp / HP</label>
                <input type="text" name="phone" value="{{ old('phone') }}" autocomplete="off" placeholder="Contoh: 081234567890" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3">
            </div>

            <!-- Penugasan Jadwal Piket Harian (Senin - Jumat) -->
            <div class="rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/80 dark:border-emerald-800/80 p-4 space-y-3">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">📅</span>
                    <div>
                        <h4 class="text-xs font-extrabold text-slate-900 dark:text-white">Jadwal Piket Harian (Senin – Jumat)</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Pilih hari dinas agar petugas otomatis terdaftar di jadwal piket.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Hari Piket
                        </label>
                        <select name="piket_day" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:ring-2 focus:ring-teal-500/20 transition p-2.5">
                            <option value="">-- Tanpa Piket Tetap --</option>
                            @foreach(($daysList ?? []) as $num => $dayName)
                                <option value="{{ $num }}" @selected(old('piket_day') == $num)>
                                    Hari {{ $dayName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Jam Shift / Piket
                        </label>
                        <input type="text" name="shift_time" value="{{ old('shift_time', '06:30 - 15:00 WIB') }}" autocomplete="off" placeholder="Contoh: 06:30 - 15:00 WIB" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:ring-2 focus:ring-teal-500/20 transition p-2.5">
                    </div>

                    <div>
                        <label class="block text-[11px] font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-1.5">
                            Ruangan / Pos Jaga
                        </label>
                        <input type="text" name="room" value="{{ old('room', 'Ruang UKS') }}" autocomplete="off" placeholder="Contoh: Ruang UKS" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:ring-2 focus:ring-teal-500/20 transition p-2.5">
                    </div>
                </div>
            </div>

            <!-- Bio / Catatan Tambahan -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Informasi Tambahan / Bio Singkat</label>
                <textarea name="bio" rows="2" placeholder="Catatan keahlian, tugas khusus, atau informasi profil petugas..." class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition p-3">{{ old('bio') }}</textarea>
            </div>

            <div class="pt-4 flex items-center justify-end gap-3 border-t border-slate-100 dark:border-slate-800">
                <button type="button" onclick="closeModalTambahPetugas()" class="px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition cursor-pointer">
                    Batal
                </button>
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-extrabold shadow-md shadow-emerald-600/30 transition cursor-pointer">
                    Simpan Petugas UKS
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModalTambahPetugas() {
        const modal = document.getElementById('modalTambahPetugas');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }
    }

    function closeModalTambahPetugas() {
        const modal = document.getElementById('modalTambahPetugas');
        if (modal) {
            modal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }
    }

    // Tutup modal jika klik di luar box modal
    window.addEventListener('click', function(e) {
        const modal = document.getElementById('modalTambahPetugas');
        if (e.target === modal) {
            closeModalTambahPetugas();
        }
    });

    // Tutup modal dengan tombol Escape
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeModalTambahPetugas();
        }
    });

    // Otomatis isi jurusan, kelas & jenis kelamin saat nama siswa dipilih dari daftar
    const studentNameInput = document.getElementById('modal_petugas_name');
    const modalMajorSelect = document.getElementById('modal_petugas_major');
    const modalClassSelect = document.getElementById('modal_petugas_class');

    const majorClasses = {
        'PPLG': ['PPLG 1', 'PPLG 2', 'PPLG 3', 'PPLG 4'],
        'BCF': ['BCF 1', 'BCF 2', 'BCF 3', 'BCF 4'],
        'ANIM': ['ANIM 1', 'ANIM 2', 'ANIM 3', 'ANIM 4'],
        'TO': ['TO 1', 'TO 2', 'TO 3', 'TO 4'],
        'TPFL': ['TPFL 1', 'TPFL 2', 'TPFL 3', 'TPFL 4'],
    };

    function cleanClassString(str) {
        return (str || '').replace(/^kelas\s*/i, '').replace(/[\s\-_]/g, '').toUpperCase();
    }

    function populateModalClassOptions(major, selectedVal) {
        if (!modalClassSelect) return;
        modalClassSelect.innerHTML = '';

        const targetClean = cleanClassString(selectedVal);
        let matched = false;

        if (!major || !majorClasses[major]) {
            const optNone = document.createElement('option');
            optNone.value = '';
            optNone.textContent = '-- Bukan Siswa / Tanpa Kelas --';
            if (!selectedVal || selectedVal === '') {
                optNone.selected = true;
                matched = true;
            }
            modalClassSelect.appendChild(optNone);

            const optStrip = document.createElement('option');
            optStrip.value = '-';
            optStrip.textContent = '- (Bukan Siswa / Guru / Staf)';
            if (selectedVal === '-') {
                optStrip.selected = true;
                matched = true;
            }
            modalClassSelect.appendChild(optStrip);

            const umumLevels = ['X', 'XI', 'XII'];
            umumLevels.forEach(lvl => {
                const group = document.createElement('optgroup');
                group.label = `Kelas ${lvl}`;
                [1, 2, 3, 4].forEach(num => {
                    const fullClass = `${lvl} ${num}`;
                    const opt = document.createElement('option');
                    opt.value = fullClass;
                    opt.textContent = fullClass;
                    if (!matched && (targetClean === cleanClassString(fullClass))) {
                        opt.selected = true;
                        matched = true;
                    }
                    group.appendChild(opt);
                });
                modalClassSelect.appendChild(group);
            });

            if (selectedVal && !matched && selectedVal !== '-' && selectedVal !== '') {
                const optCustom = document.createElement('option');
                optCustom.value = selectedVal;
                optCustom.textContent = selectedVal;
                optCustom.selected = true;
                modalClassSelect.appendChild(optCustom);
            }
            return;
        }

        const placeholder = document.createElement('option');
        placeholder.value = '';
        placeholder.textContent = `-- Pilih Kelas ${major} --`;
        modalClassSelect.appendChild(placeholder);

        const optNonSiswa = document.createElement('option');
        optNonSiswa.value = '';
        optNonSiswa.textContent = '-- Bukan Siswa / Tanpa Kelas --';
        if (!selectedVal || selectedVal === '') {
            optNonSiswa.selected = true;
            matched = true;
        }
        modalClassSelect.appendChild(optNonSiswa);

        const levels = ['X', 'XI', 'XII'];
        levels.forEach(lvl => {
            const optGroup = document.createElement('optgroup');
            optGroup.label = `Kelas ${lvl}`;

            majorClasses[major].forEach(rombel => {
                const fullClassName = `${lvl} ${rombel}`;
                const opt = document.createElement('option');
                opt.value = fullClassName;
                opt.textContent = fullClassName;

                if (!matched && selectedVal) {
                    const optClean = cleanClassString(fullClassName);
                    const majorClean = cleanClassString(major);
                    if (targetClean === optClean || targetClean === cleanClassString(`${lvl} ${rombel.replace(major, '').trim()}`) || targetClean.replace(majorClean, '') === optClean.replace(majorClean, '')) {
                        opt.selected = true;
                        matched = true;
                    }
                }
                optGroup.appendChild(opt);
            });
            modalClassSelect.appendChild(optGroup);
        });

        if (selectedVal && !matched && selectedVal !== '-' && selectedVal !== '') {
            const optCustom = document.createElement('option');
            optCustom.value = selectedVal;
            optCustom.textContent = selectedVal;
            optCustom.selected = true;
            modalClassSelect.appendChild(optCustom);
        }
    }

    if (modalMajorSelect) {
        modalMajorSelect.addEventListener('change', function() {
            populateModalClassOptions(this.value, modalClassSelect ? modalClassSelect.value : '');
        });
    }

    // Inisialisasi awal dropdown kelas modal
    populateModalClassOptions(modalMajorSelect ? modalMajorSelect.value : '', @json(old('class_name', '')));

    if (studentNameInput) {
        const studentsData = @json($allStudents ?? []);

        studentNameInput.addEventListener('input', function() {
            const val = this.value.trim().toLowerCase();
            if (!val) return;
            const found = studentsData.find(s => s.name.toLowerCase() === val);
            if (found) {
                if (modalMajorSelect && found.major) {
                    modalMajorSelect.value = found.major;
                }
                if (found.gender) {
                    const genderRadio = document.querySelector(`input[name="gender"][value="${found.gender}"]`);
                    if (genderRadio) genderRadio.checked = true;
                }
                populateModalClassOptions(found.major || (modalMajorSelect ? modalMajorSelect.value : ''), found.class_name);
            }
        });
    }
</script>

@if ($errors->any() || request('tambah'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            openModalTambahPetugas();
        });
    </script>
@endif
@endsection
