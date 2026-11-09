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

    <form method="POST" action="{{ route('students.update', $student) }}" autocomplete="off" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 md:p-8 shadow-xs space-y-5">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Nama Lengkap Siswa <span class="text-rose-500">*</span></label>
            <input type="text" name="name" value="{{ old('name', $student->name) }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5">
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Jurusan (Khusus SMK)</label>
            @php
                $currentMajor = old('major', $student->major);
                $isCustomMajor = $currentMajor && !in_array($currentMajor, ['PPLG', 'BCF', 'ANIM', 'TO', 'TPFL']);
            @endphp
            <select name="major" id="student_edit_major" class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5 cursor-pointer">
                <option value="">-- Pilih Jurusan / Umum --</option>
                <option value="PPLG" @selected($currentMajor === 'PPLG')>PPLG (Pengembangan Perangkat Lunak dan Gim)</option>
                <option value="BCF" @selected($currentMajor === 'BCF')>BCF (Broadcasting dan Perfilman)</option>
                <option value="ANIM" @selected($currentMajor === 'ANIM')>ANIM (Animasi)</option>
                <option value="TO" @selected($currentMajor === 'TO')>TO (Teknik Otomotif)</option>
                <option value="TPFL" @selected($currentMajor === 'TPFL')>TPFL (Teknik Pengelasan dan Fabrikasi Logam)</option>
                @if($isCustomMajor)
                    <option value="{{ $currentMajor }}" selected>{{ $currentMajor }}</option>
                @endif
            </select>
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Kelas / Rombel <span class="text-rose-500">*</span></label>
            <select name="class_name" id="student_edit_class" required class="w-full rounded-xl border-slate-200 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800 dark:text-slate-100 text-sm focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition px-3 py-2.5 cursor-pointer">
                <!-- Opsi kelas otomatis sesuai jurusan -->
            </select>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const majorSelect = document.getElementById('student_edit_major');
        const classSelect = document.getElementById('student_edit_class');
        const initialSelectedClass = @json(old('class_name', $student->class_name ?? ''));

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

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = major ? `-- Pilih Kelas ${major} --` : '-- Pilih Kelas --';
            classSelect.appendChild(placeholder);

            const targetClean = cleanString(selectedVal);
            let matched = false;

            if (major && majorClasses[major]) {
                const levels = ['X', 'XI', 'XII'];
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
            } else {
                const umumGroups = {
                    'Kelas X': ['X 1', 'X 2', 'X 3', 'X 4'],
                    'Kelas XI': ['XI 1', 'XI 2', 'XI 3', 'XI 4'],
                    'Kelas XII': ['XII 1', 'XII 2', 'XII 3', 'XII 4'],
                    'SMP / MTs': ['VII A', 'VII B', 'VIII A', 'VIII B', 'IX A', 'IX B'],
                };
                Object.entries(umumGroups).forEach(([label, list]) => {
                    const group = document.createElement('optgroup');
                    group.label = label;
                    list.forEach(item => {
                        const opt = document.createElement('option');
                        opt.value = item;
                        opt.textContent = item;
                        if (targetClean && cleanString(item) === targetClean) {
                            opt.selected = true;
                            matched = true;
                        }
                        group.appendChild(opt);
                    });
                    classSelect.appendChild(group);
                });
            }

            if (selectedVal && !matched) {
                const optCustom = document.createElement('option');
                optCustom.value = selectedVal;
                optCustom.textContent = `${selectedVal} (Tersimpan)`;
                optCustom.selected = true;
                classSelect.appendChild(optCustom);
            }
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
