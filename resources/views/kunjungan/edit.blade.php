@extends('layouts.app', ['heading' => 'Edit Data Kunjungan'])

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-white">Edit Data Kunjungan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Perbarui catatan kunjungan siswa: {{ $visit->student->name ?? '-' }}</p>
        </div>
        <a href="{{ url()->previous() ?: route('kunjungan.index') }}"
            class="inline-flex items-center gap-1.5 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-4 py-2 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-xs">
            ← Kembali
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

    <form method="POST" action="{{ route('kunjungan.update', $visit) }}"
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 md:p-8 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        {{-- Pilih Siswa --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Pilih Siswa <span class="text-rose-500">*</span></label>
            <select name="student_id" id="student_select" required
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:ring-teal-600 transition px-3 py-2.5">
                @foreach ($students as $student)
                    <option value="{{ $student->id }}"
                        data-kelas="{{ $student->class_name }}"
                        data-major="{{ $student->major ?? '-' }}"
                        @selected(old('student_id', $visit->student_id) == $student->id)>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Kelas (readonly) --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kelas</label>
            <input type="text" id="kelas_display" readonly
                value="{{ old('student_id') ? '' : ($visit->student->class_name ?? '-') }}"
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/80 dark:text-slate-400 text-sm text-slate-500 cursor-not-allowed py-2.5 px-3">
        </div>

        {{-- Jurusan (readonly) --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Jurusan</label>
            <input type="text" id="major_display" readonly
                value="{{ old('student_id') ? '' : ($visit->student->major ?? '-') }}"
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-800/80 dark:text-slate-400 text-sm text-slate-500 cursor-not-allowed py-2.5 px-3">
        </div>

        {{-- Tanggal --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Tanggal Pemeriksaan <span class="text-rose-500">*</span></label>
            <input type="date" name="visit_date"
                value="{{ old('visit_date', $visit->visit_date ? $visit->visit_date->toDateString() : now()->toDateString()) }}"
                required
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:ring-teal-600 transition px-3 py-2.5">
        </div>

        {{-- Keluhan --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Keluhan / Gejala Siswa <span class="text-rose-500">*</span></label>
            <textarea name="complaint" rows="3" required
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm leading-relaxed focus:border-teal-600 focus:ring-teal-600 transition p-3">{{ old('complaint', $visit->complaint) }}</textarea>
        </div>

        {{-- Penanganan --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Penanganan Awal / Obat yang Diberikan</label>
            <textarea name="initial_treatment" rows="2"
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm leading-relaxed focus:border-teal-600 focus:ring-teal-600 transition p-3">{{ old('initial_treatment', $visit->initial_treatment) }}</textarea>
        </div>

        {{-- Status --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Status Akhir Pasien <span class="text-rose-500">*</span></label>
            <div class="grid grid-cols-3 gap-3">
                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/60 transition has-[:checked]:border-emerald-500 has-[:checked]:bg-emerald-50/60 dark:has-[:checked]:bg-emerald-950/40">
                    <input type="radio" name="status" value="ditangani" @checked(old('status', $visit->status) === 'ditangani') class="text-teal-600 focus:ring-teal-600">
                    <div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 block">Ditangani di UKS</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Kondisi membaik</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/60 transition has-[:checked]:border-amber-500 has-[:checked]:bg-amber-50/60 dark:has-[:checked]:bg-amber-950/40">
                    <input type="radio" name="status" value="dirujuk" @checked(old('status', $visit->status) === 'dirujuk') class="text-amber-600 focus:ring-amber-600">
                    <div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 block">Dirujuk</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Ke Puskesmas / Faskes</span>
                    </div>
                </label>

                <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/60 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-700/60 transition has-[:checked]:border-sky-500 has-[:checked]:bg-sky-50/60 dark:has-[:checked]:bg-sky-950/40">
                    <input type="radio" name="status" value="pulang" @checked(old('status', $visit->status) === 'pulang') class="text-sky-600 focus:ring-sky-600">
                    <div>
                        <span class="text-sm font-semibold text-slate-800 dark:text-slate-100 block">Pulang</span>
                        <span class="text-xs text-slate-500 dark:text-slate-400">Dijemput orang tua</span>
                    </div>
                </label>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
            <a href="{{ url()->previous() ?: route('kunjungan.index') }}"
                class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                Batal
            </a>
            <button type="submit"
                class="inline-flex items-center gap-2 rounded-xl bg-teal-700 dark:bg-teal-600 px-6 py-2.5 text-sm font-bold text-white shadow-md hover:bg-teal-800 dark:hover:bg-teal-500 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
document.getElementById('student_select').addEventListener('change', function () {
    const selected = this.options[this.selectedIndex];
    const kelasInput = document.getElementById('kelas_display');
    const majorInput = document.getElementById('major_display');
    if (kelasInput) kelasInput.value = selected.dataset.kelas || '-';
    if (majorInput) majorInput.value = selected.dataset.major || '-';
});
</script>
@endsection
