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

            <form method="POST" action="{{ route('public.kunjungan.store') }}">
                @csrf
                <div class="uk-form-grid">
                    {{-- Nama Siswa (Manual Input) --}}
                    <div class="uk-field-group">
                        <label for="student_name">Nama Siswa <span class="uk-required">*</span></label>
                        <input type="text" id="student_name" name="student_name" value="{{ old('student_name') }}" placeholder="Ketik nama lengkap siswa..." required list="student-name-list">
                        <datalist id="student-name-list">
                            @foreach ($students ?? [] as $student)
                                <option value="{{ $student->name }}">Kelas {{ $student->class_name }}{{ $student->major ? ' (' . $student->major . ')' : '' }}</option>
                            @endforeach
                        </datalist>
                    </div>

                    {{-- Kelas Siswa (Manual Input) --}}
                    <div class="uk-field-group">
                        <label for="class_name">Kelas <span class="uk-required">*</span></label>
                        <input type="text" id="class_name" name="class_name" value="{{ old('class_name') }}" placeholder="Contoh: VII A, VIII B, X PPLG 1..." required>
                    </div>

                    {{-- Jurusan Siswa --}}
                    <div class="uk-field-group">
                        <label for="major">Jurusan <span class="uk-required">*</span></label>
                        <select name="major" id="major" required>
                            <option value="" disabled {{ old('major') ? '' : 'selected' }}>-- Pilih Jurusan --</option>
                            <option value="PPLG" @selected(old('major') == 'PPLG')>PPLG</option>
                            <option value="BCF" @selected(old('major') == 'BCF')>BCF</option>
                            <option value="ANIM" @selected(old('major') == 'ANIM')>ANIM</option>
                            <option value="TO" @selected(old('major') == 'TO')>TO</option>
                            <option value="TPFL" @selected(old('major') == 'TPFL')>TPFL</option>
                        </select>
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="uk-field-group">
                        <label for="gender">Jenis Kelamin <span class="uk-required">*</span></label>
                        <select name="gender" id="gender" required>
                            <option value="L" @selected(old('gender') == 'L')>Laki-laki</option>
                            <option value="P" @selected(old('gender') == 'P')>Perempuan</option>
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
        const nameInput = document.getElementById('student_name');
        const classInput = document.getElementById('class_name');
        const majorInput = document.getElementById('major');
        const genderInput = document.getElementById('gender');

        if (!studentsData || !studentsData.length) return;

        function fillFromStudent(student, skipName = false) {
            if (!skipName && student.name) nameInput.value = student.name;
            if (student.class_name && student.class_name !== '-') classInput.value = student.class_name;
            if (student.major && majorInput) {
                const upperMajor = student.major.toUpperCase().trim();
                let matched = false;
                for (let i = 0; i < majorInput.options.length; i++) {
                    if (majorInput.options[i].value.toUpperCase() === upperMajor) {
                        majorInput.selectedIndex = i;
                        matched = true;
                        break;
                    }
                }
                if (!matched) {
                    majorInput.value = student.major;
                }
            }
            if (student.gender && genderInput) genderInput.value = student.gender;
        }

        if (nameInput) {
            nameInput.addEventListener('input', function () {
                const val = this.value.trim().toLowerCase();
                if (!val) return;
                const match = studentsData.find(s => (s.name || '').toLowerCase() === val);
                if (match) {
                    fillFromStudent(match, false, true);
                }
            });
            nameInput.addEventListener('change', function () {
                const val = this.value.trim().toLowerCase();
                if (!val) return;
                const match = studentsData.find(s => (s.name || '').toLowerCase() === val);
                if (match) {
                    fillFromStudent(match, false, true);
                }
            });
        }
    });
</script>
@endsection
