@extends('layouts.app', ['heading' => 'Edit Data Siswa'])

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Edit Data Siswa</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Perbarui profil dan identitas siswa: {{ $student->name }}</p>
        </div>
        <a href="{{ route('students.index') }}" class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-xs">
            ← Kembali ke Data Siswa
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 text-sm">
            <p class="font-semibold mb-1">Periksa kembali data berikut:</p>
            <ul class="list-disc list-inside space-y-0.5 text-sm">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.update', $student) }}" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 md:p-8 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kelas / Rombel <span class="text-rose-500">*</span></label>
            <input type="text" name="class_name" value="{{ old('class_name', $student->class_name) }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Jurusan (Opsional)</label>
            <input type="text" name="major" value="{{ old('major', $student->major) }}" placeholder="Contoh: PPLG, TJKT, DKV, Animasi, TO..." class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Jenis Kelamin <span class="text-rose-500">*</span></label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/60 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/60 dark:has-[:checked]:bg-blue-950/40">
                    <input type="radio" name="gender" value="L" {{ old('gender', $student->gender) === 'L' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">Laki-laki</span>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/60 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/60 dark:has-[:checked]:bg-rose-950/40">
                    <input type="radio" name="gender" value="P" {{ old('gender', $student->gender) === 'P' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                    <span class="text-sm font-semibold text-slate-800 dark:text-slate-100">Perempuan</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 dark:bg-teal-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-teal-800 dark:hover:bg-teal-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Perbarui Data Siswa
            </button>
        </div>
    </form>
</div>
@endsection
