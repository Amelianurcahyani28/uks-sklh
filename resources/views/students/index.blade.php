@extends('layouts.app', ['heading' => 'Data Siswa'])

@section('content')
<!-- Hero Section Admin Full Width: Menempel Langsung Tanpa Space di Atasnya -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                Catatan Kunjungan Siswa
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Data Siswa yang Berkunjung</h2>
            <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 leading-relaxed">
                Total tercatat {{ $totalVisits }} kunjungan pemeriksaan siswa di UKS sekolah ({{ $todayCount }} kunjungan hari ini).
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

    <!-- Bar Pencarian Cepat & Filter Status -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-xs">
        <form method="GET" action="{{ route('students.index') }}" class="flex flex-wrap items-center gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, kelas, keluhan..." class="w-56 sm:w-72 px-4 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
            
            <select name="status" class="px-3 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                <option value="">-- Semua Status --</option>
                <option value="ditangani" @selected(request('status') === 'ditangani')>Ditangani di UKS</option>
                <option value="dirujuk" @selected(request('status') === 'dirujuk')>Dirujuk ke Faskes</option>
                <option value="pulang" @selected(request('status') === 'pulang')>Diperbolehkan Pulang</option>
            </select>

            <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs font-semibold transition shrink-0 shadow-sm">
                Cari
            </button>
            @if (request()->hasAny(['q', 'status']))
                <a href="{{ route('students.index') }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs font-semibold transition shrink-0" title="Reset filter">
                    ✕
                </a>
            @endif
        </form>

        <a href="{{ route('kunjungan.index', ['tambah' => 1]) }}" class="shrink-0 inline-flex items-center gap-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 px-4 py-2.5 text-xs font-bold text-white shadow-xs transition cursor-pointer">
            Catat Kunjungan Baru
        </a>
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
                        <th class="px-4 py-4">Jurusan</th>
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

                            <td class="px-4 py-4 whitespace-nowrap text-slate-600 dark:text-slate-400 font-medium">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                                    {{ $visit->student->major ?: '-' }}
                                </span>
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
                            <td colspan="9" class="px-6 py-12 text-center text-slate-400 dark:text-slate-500">
                                <p class="text-base font-semibold text-slate-600 dark:text-slate-300">Tidak ada catatan data siswa berkunjung</p>
                                <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">Gunakan tombol di atas untuk mencatat data kunjungan siswa baru.</p>
                                <a href="{{ route('kunjungan.index', ['tambah' => 1]) }}" class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition cursor-pointer">
                                    Catat Kunjungan Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($visits->hasPages())
            <div class="p-5 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $visits->links() }}
            </div>
        @endif
    </div>
</div>
@endsection