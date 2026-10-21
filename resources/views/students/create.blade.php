@extends('layouts.app', ['heading' => 'Tambah Siswa Baru'])

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800">Pendaftaran Data Siswa</h2>
            <p class="text-xs text-slate-500 mt-0.5">Daftarkan siswa baru ke dalam database sistem UKS sekolah.</p>
        </div>
        <a href="{{ route('students.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-600 hover:text-slate-900 bg-white border border-slate-200 px-3 py-2 rounded-xl hover:bg-slate-50 transition shadow-xs">
            ← Kembali ke Data Siswa
        </a>
    </div>

    @if ($errors->any())
        <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs">
            <p class="font-bold mb-1">Periksa kembali data berikut:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('students.store') }}" class="bg-white rounded-2xl border border-slate-200 p-6 md:p-8 shadow-xs space-y-5">
        @csrf

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Siswa *</label>
            <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Muhammad Rizky" class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-teal-600 focus:bg-white focus:ring-teal-600 transition">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kelas / Rombel *</label>
            <input type="text" name="class_name" value="{{ old('class_name') }}" required placeholder="Contoh: VII-A / 10 MIPA 1" class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-teal-600 focus:bg-white focus:ring-teal-600 transition">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jurusan (Opsional)</label>
            <select name="major" class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-sm focus:border-teal-600 focus:bg-white focus:ring-teal-600 transition">
                <option value="">-- Pilih Jurusan --</option>
                <option value="PPLG" @selected(old('major') === 'PPLG')>PPLG</option>
                <option value="BCF" @selected(old('major') === 'BCF')>BCF</option>
                <option value="ANIM" @selected(old('major') === 'ANIM')>ANIM</option>
                <option value="TO" @selected(old('major') === 'TO')>TO</option>
                <option value="TPFL" @selected(old('major') === 'TPFL')>TPFL</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenis Kelamin *</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50/60">
                    <input type="radio" name="gender" value="L" {{ old('gender', 'L') === 'L' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                    <span class="text-xs font-bold text-slate-800">Laki-laki</span>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 cursor-pointer hover:bg-slate-50 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/60">
                    <input type="radio" name="gender" value="P" {{ old('gender') === 'P' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                    <span class="text-xs font-bold text-slate-800">Perempuan</span>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
            <a href="{{ route('students.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-xs font-semibold text-slate-600 hover:bg-slate-50 transition">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-teal-700 px-6 py-2.5 text-xs font-bold text-white shadow-md hover:bg-teal-800 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>Simpan Siswa</span>
            </button>
        </div>
    </form>
</div>
@endsection