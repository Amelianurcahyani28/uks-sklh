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

        @php
            $studentName = old('student_name', $visit->student->name ?? '');
            $initialClass = old('class_name', $visit->student->class_name ?? '');
            $initialMajor = old('major', $visit->student->major ?? '');

            // Fallback: Jika major kosong namun class_name mengandung kode jurusan (contoh: XI PPLG 1 -> PPLG)
            if (empty($initialMajor) && ! empty($initialClass)) {
                foreach (['PPLG', 'BCF', 'ANIM', 'TO', 'TPFL'] as $mCode) {
                    if (stripos($initialClass, $mCode) !== false) {
                        $initialMajor = $mCode;
                        break;
                    }
                }
            }
        @endphp

        {{-- Nama Siswa (Ketik Manual / Rekomendasi Datalist) --}}
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">
                    Nama Lengkap Siswa <span class="text-rose-500">*</span>
                </label>
                <span class="text-[11px] text-teal-600 dark:text-teal-400 font-medium">Ketik manual / pilih rekomendasi</span>
            </div>
            <input type="text" name="student_name" id="student_name_input"
                value="{{ $studentName }}"
                list="students_datalist"
                required
                autocomplete="off"
                placeholder="Ketik nama lengkap siswa..."
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5">
            <datalist id="students_datalist">
                @foreach ($students as $student)
                    <option value="{{ $student->name }}">
                        Kelas {{ $student->class_name }}{{ $student->major ? ' (' . $student->major . ')' : '' }}
                    </option>
                @endforeach
            </datalist>
            <input type="hidden" name="student_id" id="student_id_hidden" value="{{ old('student_id', $visit->student_id) }}">
        </div>

        {{-- Jurusan (Khusus Siswa / PMR) - Posisi di Atas Kelas --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                Jurusan (Khusus SMK)
            </label>
            <select name="major" id="kunjungan_major"
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5 cursor-pointer">
                <option value="">-- Bukan Siswa / Umum / Guru --</option>
                <option value="PPLG" @selected($initialMajor === 'PPLG')>PPLG (Pengembangan Perangkat Lunak dan Gim)</option>
                <option value="BCF" @selected($initialMajor === 'BCF')>BCF (Broadcasting dan Perfilman)</option>
                <option value="ANIM" @selected($initialMajor === 'ANIM')>ANIM (Animasi)</option>
                <option value="TO" @selected($initialMajor === 'TO')>TO (Teknik Otomotif)</option>
                <option value="TPFL" @selected($initialMajor === 'TPFL')>TPFL (Teknik Pengelasan dan Fabrikasi Logam)</option>
            </select>
        </div>

        {{-- Kelas (Khusus Siswa / PMR) - Dropdown Pilihan Mengikuti Jurusan --}}
        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">
                Kelas (Khusus Siswa / PMR) <span class="text-rose-500">*</span>
            </label>
            <select name="class_name" id="kunjungan_class" required
                class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5 cursor-pointer">
                <!-- Opsi kelas akan terisi otomatis sesuai jurusan yang dipilih -->
            </select>
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
    document.addEventListener('DOMContentLoaded', function () {
        const studentNameInput = document.getElementById('student_name_input');
        const majorSelect = document.getElementById('kunjungan_major');
        const classSelect = document.getElementById('kunjungan_class');
        const studentIdHidden = document.getElementById('student_id_hidden');
        const initialSelectedClass = @json($initialClass);
        const studentsData = @json($students ?? []);

        const majorClasses = {
            'PPLG': ['PPLG 1', 'PPLG 2', 'PPLG 3', 'PPLG 4'],
            'BCF': ['BCF 1', 'BCF 2', 'BCF 3', 'BCF 4'],
            'ANIM': ['ANIM 1', 'ANIM 2', 'ANIM 3', 'ANIM 4'],
            'TO': ['TO 1', 'TO 2', 'TO 3', 'TO 4'],
            'TPFL': ['TPFL 1', 'TPFL 2', 'TPFL 3', 'TPFL 4'],
        };

        function cleanString(str) {
            return (str || '').replace(/[\s\-_]/g, '').toUpperCase();
        }

        function populateClassOptions(major, selectedVal) {
            if (!classSelect) return;
            classSelect.innerHTML = '';

            if (!major || !majorClasses[major]) {
                const optNone = document.createElement('option');
                optNone.value = '';
                optNone.textContent = '-- Pilih Kelas / Umum --';
                classSelect.appendChild(optNone);

                const optStrip = document.createElement('option');
                optStrip.value = '-';
                optStrip.textContent = '- (Bukan Siswa / Guru / Staf)';
                classSelect.appendChild(optStrip);

                const umumLevels = ['X', 'XI', 'XII'];
                umumLevels.forEach(lvl => {
                    const group = document.createElement('optgroup');
                    group.label = `Kelas ${lvl}`;
                    [1, 2, 3, 4].forEach(num => {
                        const opt = document.createElement('option');
                        opt.value = `${lvl} ${num}`;
                        opt.textContent = `${lvl} ${num}`;
                        if (cleanString(selectedVal) === cleanString(`${lvl} ${num}`)) {
                            opt.selected = true;
                        }
                        group.appendChild(opt);
                    });
                    classSelect.appendChild(group);
                });

                if (selectedVal && selectedVal !== '-' && selectedVal !== '') {
                    const targetClean = cleanString(selectedVal);
                    let foundExisting = Array.from(classSelect.options).some(o => cleanString(o.value) === targetClean);
                    if (!foundExisting) {
                        const optCustom = document.createElement('option');
                        optCustom.value = selectedVal;
                        optCustom.textContent = selectedVal;
                        optCustom.selected = true;
                        classSelect.appendChild(optCustom);
                    }
                } else if (selectedVal === '-') {
                    optStrip.selected = true;
                }
                return;
            }

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = `-- Pilih Kelas ${major} --`;
            classSelect.appendChild(placeholder);

            const levels = ['X', 'XI', 'XII'];
            const targetClean = cleanString(selectedVal);
            let matched = false;

            levels.forEach(lvl => {
                const optGroup = document.createElement('optgroup');
                optGroup.label = `Kelas ${lvl}`;

                majorClasses[major].forEach(rombel => {
                    const fullClassName = `${lvl} ${rombel}`;
                    const opt = document.createElement('option');
                    opt.value = fullClassName;
                    opt.textContent = fullClassName;

                    if (targetClean && (cleanString(fullClassName) === targetClean || targetClean === cleanString(`${lvl}${rombel}`))) {
                        opt.selected = true;
                        matched = true;
                    }

                    optGroup.appendChild(opt);
                });

                classSelect.appendChild(optGroup);
            });

            if (selectedVal && !matched && selectedVal !== '-') {
                const optCustom = document.createElement('option');
                optCustom.value = selectedVal;
                optCustom.textContent = `${selectedVal} (Tersimpan)`;
                optCustom.selected = true;
                classSelect.appendChild(optCustom);
            }
        }

        // Ketika nama siswa diketik atau dipilih dari datalist
        if (studentNameInput) {
            studentNameInput.addEventListener('input', function() {
                const val = this.value.trim().toLowerCase();
                const found = studentsData.find(s => s.name.toLowerCase() === val);
                if (found) {
                    if (studentIdHidden) studentIdHidden.value = found.id;
                    if (majorSelect && found.major) {
                        majorSelect.value = found.major;
                    }
                    populateClassOptions(majorSelect ? majorSelect.value : '', found.class_name || '');
                } else {
                    if (studentIdHidden) studentIdHidden.value = '';
                }
            });
        }

        if (majorSelect && classSelect) {
            populateClassOptions(majorSelect.value, initialSelectedClass);

            majorSelect.addEventListener('change', function () {
                populateClassOptions(this.value, '');
            });
        }
    });
</script>
@endsection
