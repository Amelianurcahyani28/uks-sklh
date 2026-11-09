@extends('layouts.public', ['title' => 'Catat Kunjungan UKS'])

@section('content')
<main class="uk-form-page-main">
    <div class="uk-form-container">
        <div class="uk-form-header">
            <div class="uk-hero-badge">
                <span class="uk-badge-dot"></span>
                <span>Layanan Kunjungan Siswa</span>
            </div>
            <h1>Kunjungan UKS</h1>
            <p>Silakan isi data siswa dan keluhan yang dialami</p>
        </div>

        <div class="uk-form-card">
            @if ($errors->any())
                <div style="background-color: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 12px; margin-bottom: 20px; font-size: 13px;">
                    <p style="font-weight: 700; margin-bottom: 4px;">Periksa kembali data yang dimasukkan:</p>
                    <ul style="list-style-type: disc; padding-left: 20px; margin: 0;">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('public.kunjungan.store') }}" autocomplete="off">
                @csrf
                <div class="uk-form-grid">
                    {{-- Nama Siswa (Manual Input / Datalist) --}}
                    <div class="uk-field-group">
                        <label for="student_name">Nama Siswa <span class="uk-required">*</span></label>
                        <input type="text" id="student_name" name="student_name" value="{{ old('student_name') }}" autocomplete="off" placeholder="Ketik nama lengkap siswa..." required list="student-name-list">
                        <datalist id="student-name-list">
                            @foreach ($students ?? [] as $student)
                                <option value="{{ $student->name }}">Kelas {{ $student->class_name }}{{ $student->major ? ' (' . $student->major . ')' : '' }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="uk-field-group">
                        <label for="gender">Jenis Kelamin <span class="uk-required">*</span></label>
                        <select name="gender" id="gender" required>
                            <option value="L" @selected(old('gender', 'L') === 'L')>Laki-laki</option>
                            <option value="P" @selected(old('gender') === 'P')>Perempuan</option>
                        </select>
                    </div>

                    {{-- Jurusan Siswa --}}
                    <div class="uk-field-group">
                        <label for="major">Jurusan (Khusus SMK) <span class="uk-required">*</span></label>
                        <select name="major" id="major">
                            <option value="">-- Pilih Jurusan / Umum --</option>
                            <option value="PPLG" @selected(old('major') === 'PPLG')>PPLG (Pengembangan Perangkat Lunak dan Gim)</option>
                            <option value="BCF" @selected(old('major') === 'BCF')>BCF (Broadcasting dan Perfilman)</option>
                            <option value="ANIM" @selected(old('major') === 'ANIM')>ANIM (Animasi)</option>
                            <option value="TO" @selected(old('major') === 'TO')>TO (Teknik Otomotif)</option>
                            <option value="TPFL" @selected(old('major') === 'TPFL')>TPFL (Teknik Pengelasan dan Fabrikasi Logam)</option>
                        </select>
                    </div>

                    {{-- Kelas Siswa (Dropdown Otomatis Sesuai Jurusan) --}}
                    <div class="uk-field-group">
                        <label for="class_name">Kelas <span class="uk-required">*</span></label>
                        <select name="class_name" id="class_name" required>
                            <!-- Opsi kelas terisi otomatis sesuai jurusan -->
                        </select>
                    </div>

                    {{-- Tanggal Kunjungan --}}
                    <div class="uk-field-group">
                        <label for="visit_date">Tanggal Kunjungan <span class="uk-required">*</span></label>
                        <input type="date" id="visit_date" name="visit_date" value="{{ old('visit_date', now()->toDateString()) }}" required>
                    </div>

                    {{-- Status Awal / Tindakan --}}
                    <div class="uk-field-group">
                        <label for="status">Status Penanganan Awal <span class="uk-required">*</span></label>
                        <select name="status" id="status" required>
                            <option value="ditangani" @selected(old('status') == 'ditangani')>Ditangani di UKS (Istirahat / Diberi Obat Dasar)</option>
                            <option value="pulang" @selected(old('status') == 'pulang')>Diizinkan Pulang (Perlu istirahat di rumah)</option>
                            <option value="dirujuk" @selected(old('status') == 'dirujuk')>Dirujuk ke Faskes (Puskesmas / Rumah Sakit)</option>
                        </select>
                    </div>

                    {{-- Keluhan atau Gejala --}}
                    <div class="uk-field-group uk-field-group--full">
                        <label for="complaint">Keluhan atau Gejala yang Dialami <span class="uk-required">*</span></label>
                        <textarea id="complaint" name="complaint" rows="3" required placeholder="Contoh: Merasa pusing sejak jam pelajaran kedua, badan terasa demam dan mual...">{{ old('complaint') }}</textarea>
                    </div>

                    {{-- Penanganan Awal --}}
                    <div class="uk-field-group uk-field-group--full">
                        <label for="initial_treatment">Penanganan Awal <span class="uk-optional">(Opsional)</span></label>
                        <textarea id="initial_treatment" name="initial_treatment" rows="2" placeholder="Contoh: Diberi minum teh hangat, minyak kayu putih, dan istirahat 30 menit...">{{ old('initial_treatment') }}</textarea>
                    </div>
                </div>

                <div class="uk-form-actions">
                    <a href="{{ route('home') }}" class="uk-btn-secondary">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                        <span>Kembali ke Beranda</span>
                    </a>
                    <button type="submit" class="uk-btn-primary">
                        <span>Simpan & Kirim Catatan Kunjungan</span>
                        <svg class="uk-icon-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const studentsData = @json($students ?? []);
        const oldClassName = @json(old('class_name', ''));
        const nameInput = document.getElementById('student_name');
        const classSelect = document.getElementById('class_name');
        const majorSelect = document.getElementById('major');
        const genderSelect = document.getElementById('gender');

        const majorClasses = {
            'PPLG': ['PPLG 1', 'PPLG 2', 'PPLG 3', 'PPLG 4'],
            'BCF': ['BCF 1', 'BCF 2', 'BCF 3', 'BCF 4'],
            'ANIM': ['ANIM 1', 'ANIM 2', 'ANIM 3', 'ANIM 4'],
            'TO': ['TO 1', 'TO 2', 'TO 3', 'TO 4'],
            'TPFL': ['TPFL 1', 'TPFL 2', 'TPFL 3', 'TPFL 4'],
        };

        function cleanString(str) {
            return (str || '').replace(/^kelas\s*/i, '').replace(/[\s\-_]/g, '').toUpperCase();
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

        function autofillStudent(nameVal) {
            const val = (nameVal || '').trim().toLowerCase();
            if (!val) return;
            const match = studentsData.find(s => (s.name || '').trim().toLowerCase() === val);
            if (match) {
                if (genderSelect && match.gender) {
                    genderSelect.value = match.gender;
                }

                let detectedMajor = match.major || '';
                if (!detectedMajor && match.class_name) {
                    const upperCls = match.class_name.toUpperCase();
                    for (const m of Object.keys(majorClasses)) {
                        if (upperCls.includes(m)) {
                            detectedMajor = m;
                            break;
                        }
                    }
                }

                if (majorSelect && detectedMajor) {
                    majorSelect.value = detectedMajor;
                }

                populateClassOptions(majorSelect ? majorSelect.value : detectedMajor, match.class_name || '');
            }
        }

        // Initialize class options on page load
        if (majorSelect && classSelect) {
            populateClassOptions(majorSelect.value, oldClassName);

            majorSelect.addEventListener('change', function () {
                populateClassOptions(this.value, '');
            });
        }

        if (classSelect) {
            classSelect.addEventListener('change', function () {
                if (majorSelect && !majorSelect.value) {
                    const valUpper = this.value.toUpperCase();
                    for (const m of Object.keys(majorClasses)) {
                        if (valUpper.includes(m)) {
                            majorSelect.value = m;
                            populateClassOptions(m, this.value);
                            break;
                        }
                    }
                }
            });
        }

        if (nameInput) {
            nameInput.addEventListener('input', function () {
                autofillStudent(this.value);
            });
            nameInput.addEventListener('change', function () {
                autofillStudent(this.value);
            });

            if (nameInput.value) {
                autofillStudent(nameInput.value);
            }
        }
    });
</script>
@endsection
