@extends('layouts.app', ['heading' => 'Data Siswa'])

@section('content')
<!-- Hero Section Admin Full Width: Menempel Langsung Tanpa Space di Atasnya -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 sm:py-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-white/20 dark:bg-emerald-800/80 text-white dark:text-emerald-200 border border-white/25 dark:border-emerald-600/40 mb-2 shadow-xs backdrop-blur-md">
                <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                Database Siswa Sekolah
            </span>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-white dark:text-emerald-50">Manajemen Data Siswa</h2>
            <p class="mt-1.5 text-sm text-emerald-50 dark:text-emerald-200/90 leading-relaxed">
                Total {{ $totalStudents }} siswa terdaftar dalam sistem UKS sekolah.
            </p>
        </div>
    </div>
</div>

<div class="p-4 sm:p-8 space-y-6 flex-1">

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Pencarian -->
            <div class="lg:col-span-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, atau kelas..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
            </div>

            <!-- Filter Jenis Kelamin -->
            <div>
                <select name="gender" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                    <option value="">-- Semua Gender --</option>
                    <option value="L" @selected(request('gender') === 'L')>Laki-laki</option>
                    <option value="P" @selected(request('gender') === 'P')>Perempuan</option>
                </select>
            </div>

            <!-- Filter Kelas & Submit -->
            <div class="flex gap-2">
                <select name="class_name" class="w-full px-3 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs text-slate-900 dark:text-white focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 transition shadow-xs">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($classes as $cl)
                        <option value="{{ $cl }}" @selected(request('class_name') === $cl)>Kelas {{ $cl }}</option>
                    @endforeach
                </select>
                <button type="submit" class="shrink-0 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white rounded-xl text-xs font-semibold transition">
                    Cari
                </button>
                @if (request()->hasAny(['q', 'gender', 'class_name']))
                    <a href="{{ route('students.index') }}" class="shrink-0 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl text-xs font-semibold transition flex items-center justify-center" title="Reset filter">
                        ✕
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Tabel Data Siswa -->
    <div class="rounded-2xl border border-slate-200 bg-white shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 border-b border-slate-200 text-slate-500 uppercase tracking-wider font-semibold">
                    <tr>
                        <th class="px-6 py-4 w-12 text-center">No</th>
                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-center">Total Kunjungan UKS</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $index => $student)
                        <tr class="hover:bg-slate-50/60 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-center font-bold text-slate-500 text-xs">
                                {{ method_exists($students, 'firstItem') && $students->firstItem() ? $students->firstItem() + $index : $loop->iteration }}
                            </td>
                            <td class="px-6 py-4 font-bold text-slate-900 text-sm">
                                {{ $student->name }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="bg-slate-100 px-2.5 py-1 rounded-lg text-slate-700 font-semibold">
                                    Kelas {{ $student->class_name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if ($student->gender === 'L')
                                    <span class="inline-flex items-center gap-1 text-blue-700 bg-blue-50 px-2.5 py-1 rounded-full font-medium">
                                        Laki-laki
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-rose-700 bg-rose-50 px-2.5 py-1 rounded-full font-medium">
                                        Perempuan
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-full text-xs font-bold {{ $student->visits_count > 0 ? 'bg-teal-50 text-teal-700 border border-teal-200' : 'bg-slate-100 text-slate-400' }}">
                                    {{ $student->visits_count }} kali
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('students.edit', $student) }}" class="px-2.5 py-1 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 rounded-lg transition" title="Edit Data">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('students.destroy', $student) }}" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data siswa ini? Semua catatan kunjungan siswa ini juga akan terhapus.');" class="inline-block">
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
                                <p class="text-base font-semibold text-slate-600">Tidak ada data siswa ditemukan</p>
                                <p class="text-xs text-slate-400 mt-1">Tambahkan siswa baru untuk memulai pencatatan.</p>
                                <a href="{{ route('students.create') }}" class="mt-4 inline-flex items-center gap-1.5 rounded-xl bg-teal-700 px-4 py-2 text-xs font-bold text-white shadow-xs hover:bg-teal-800 transition">
                                    + Tambah Siswa Baru
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($students->hasPages())
            <div class="p-5 border-t border-slate-100 bg-slate-50/50">
                {{ $students->links() }}
            </div>
        @endif
    </div>
</div>
@endsection