@extends('layouts.app', ['heading' => 'Data Siswa'])

@section('content')
<div class="space-y-6">
    <!-- Top Action Bar -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-xs">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Manajemen Data Siswa</h2>
            <p class="text-xs text-slate-500 mt-1">Total {{ $totalStudents }} siswa terdaftar dalam sistem UKS sekolah.</p>
        </div>
    </div>

    <!-- Filter & Search Bar -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs">
        <form method="GET" action="{{ route('students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <!-- Pencarian -->
            <div class="lg:col-span-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama siswa, NIS, atau kelas..." class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600">
            </div>

            <!-- Filter Jenis Kelamin -->
            <div>
                <select name="gender" class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600">
                    <option value="">-- Semua Gender --</option>
                    <option value="L" @selected(request('gender') === 'L')>Laki-laki</option>
                    <option value="P" @selected(request('gender') === 'P')>Perempuan</option>
                </select>
            </div>

            <!-- Filter Kelas & Submit -->
            <div class="flex gap-2">
                <select name="class_name" class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-xs focus:border-teal-600 focus:bg-white focus:ring-teal-600">
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

                        <th class="px-6 py-4">Nama Lengkap</th>
                        <th class="px-6 py-4">Kelas</th>
                        <th class="px-6 py-4">Jenis Kelamin</th>
                        <th class="px-6 py-4 text-center">Total Kunjungan UKS</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $student)
                        <tr class="hover:bg-slate-50/60 transition">

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