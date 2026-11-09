@extends('layouts.app', ['heading' => 'Edit Petugas UKS'])

@section('content')
<!-- Hero Section Admin Full Width -->
<div class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-md">
    <div class="px-4 sm:px-8 py-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-xl md:text-2xl font-extrabold tracking-tight text-white dark:text-emerald-50">Edit Data Petugas UKS</h2>
            <p class="mt-1 text-xs sm:text-sm text-emerald-50 dark:text-emerald-200/90">
                Perbarui data profil, peran, jadwal tugas, atau status petugas UKS.
            </p>
        </div>

        <a href="{{ route('petugas.index') }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-800 dark:text-slate-100 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 px-3.5 py-2.5 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-700 transition shadow-xs shrink-0">
            ← Kembali ke Daftar Petugas
        </a>
    </div>
</div>

<div class="p-4 sm:p-8 flex-1">
    <div class="max-w-2xl mx-auto space-y-6">
        @if ($errors->any())
            <div class="p-4 rounded-xl bg-rose-50 dark:bg-rose-950/60 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-200 text-xs">
                <p class="font-bold mb-1">Periksa kembali data berikut:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('petugas.update', $petugas) }}" autocomplete="off" class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 p-6 md:p-8 shadow-xs space-y-5">
            @csrf
            @method('PUT')

            <!-- Nama Petugas -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Nama Lengkap Petugas <span class="text-rose-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $petugas->name) }}" autocomplete="off" required placeholder="Contoh: Ns. Siti Rahmawati, S.Kep / Dra. Nurjanah" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3">
            </div>

            <!-- Jabatan / Peran -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jabatan / Peran di UKS <span class="text-rose-500">*</span></label>
                <input type="text" name="role_title" value="{{ old('role_title', $petugas->role_title) }}" autocomplete="off" required placeholder="Contoh: Pembina UKS, Tenaga Medis UKS, Petugas P3K, Ketua PMR" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3">
            </div>

            <!-- Jurusan (Khusus Siswa / PMR) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jurusan (Khusus Siswa / PMR)</label>
                <select name="major" id="petugas_edit_major" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3 cursor-pointer">
                    <option value="">-- Bukan Siswa / Umum / Guru --</option>
                    <option value="PPLG" @selected(old('major', $petugas->major) === 'PPLG')>PPLG (Pengembangan Perangkat Lunak dan Gim)</option>
                    <option value="BCF" @selected(old('major', $petugas->major) === 'BCF')>BCF (Broadcasting dan Perfilman)</option>
                    <option value="ANIM" @selected(old('major', $petugas->major) === 'ANIM')>ANIM (Animasi)</option>
                    <option value="TO" @selected(old('major', $petugas->major) === 'TO')>TO (Teknik Otomotif)</option>
                    <option value="TPFL" @selected(old('major', $petugas->major) === 'TPFL')>TPFL (Teknik Pengelasan dan Fabrikasi Logam)</option>
                </select>
            </div>

            <!-- Kelas (Khusus Siswa / PMR) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Kelas (Khusus Siswa / PMR)</label>
                <select name="class_name" id="petugas_edit_class" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3 cursor-pointer">
                    <!-- Opsi kelas otomatis sesuai jurusan -->
                </select>
            </div>

            <!-- Jenis Kelamin & Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Jenis Kelamin <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition has-[:checked]:border-teal-500 has-[:checked]:bg-teal-50/60 dark:has-[:checked]:bg-teal-950/40">
                            <input type="radio" name="gender" value="L" {{ old('gender', $petugas->gender) === 'L' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Laki-laki</span>
                        </label>

                        <label class="flex items-center gap-2.5 p-3 rounded-xl border border-slate-200 dark:border-slate-700 cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition has-[:checked]:border-rose-500 has-[:checked]:bg-rose-50/60 dark:has-[:checked]:bg-rose-950/40">
                            <input type="radio" name="gender" value="P" {{ old('gender', $petugas->gender) === 'P' ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-600">
                            <span class="text-xs font-bold text-slate-800 dark:text-slate-200">Perempuan</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Status Petugas <span class="text-rose-500">*</span></label>
                    <select name="status" required class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3">
                        <option value="aktif" @selected(old('status', $petugas->status) === 'aktif')>Aktif (Siaga Jaga)</option>
                        <option value="nonaktif" @selected(old('status', $petugas->status) === 'nonaktif')>Non-Aktif</option>
                    </select>
                </div>
            </div>

            <!-- No WhatsApp -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">No. WhatsApp / HP</label>
                <input type="text" name="phone" value="{{ old('phone', $petugas->phone) }}" autocomplete="off" placeholder="Contoh: 081234567890" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3">
            </div>

            <!-- Penugasan Jadwal Piket Otomatis (Senin - Jumat) -->
            <div class="rounded-2xl bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-200/80 dark:border-emerald-800/80 p-4 space-y-4">
                <div class="flex items-center gap-2">
                    <span class="w-6 h-6 rounded-lg bg-emerald-600 text-white flex items-center justify-center text-xs font-bold">📅</span>
                    <div>
                        <h4 class="text-xs font-extrabold text-slate-900 dark:text-white">Jadwal Piket Harian (Senin – Jumat)</h4>
                        <p class="text-[11px] text-slate-500 dark:text-slate-400">Atur hari piket agar petugas otomatis muncul pada jadwal piket admin dan hari bertugas.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Hari Piket
                        </label>
                        <select name="piket_day" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:ring-teal-600 transition p-3">
                            <option value="">-- Tanpa Jadwal Piket Tetap --</option>
                            @foreach($daysList as $num => $dayName)
                                <option value="{{ $num }}" @selected(old('piket_day', $primaryJadwal?->day_number) == $num)>
                                    Hari {{ $dayName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Jam Piket
                        </label>
                        <input type="text" name="shift_time" value="{{ old('shift_time', $primaryJadwal?->shift_time ?? '06:30 - 15:00 WIB') }}" placeholder="Contoh: 06:30 - 15:00 WIB" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:ring-teal-600 transition p-3">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Ruangan Piket
                        </label>
                        <input type="text" name="room" value="{{ old('room', $primaryJadwal?->room ?? 'Ruang UKS') }}" placeholder="Contoh: Ruang UKS" class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:ring-teal-600 transition p-3">
                    </div>
                </div>
            </div>

            <!-- Bio / Keterangan Tugas -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">Keterangan / Bio Tugas Singkat</label>
                <textarea name="bio" rows="3" placeholder="Contoh: Bertanggung jawab atas penanganan medis darurat dan pengelolaan obat dasar di ruang UKS." class="w-full rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 dark:text-white text-xs focus:border-teal-600 focus:bg-white dark:focus:bg-slate-800 focus:ring-teal-600 transition p-3">{{ old('bio', $petugas->bio) }}</textarea>
            </div>

            <!-- Tombol Aksi Simpan -->
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800">
                <a href="{{ route('petugas.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 px-6 py-2.5 text-xs font-bold text-white shadow-md transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <span>Simpan Perubahan</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const majorSelect = document.getElementById('petugas_edit_major');
        const classSelect = document.getElementById('petugas_edit_class');

        const majorClasses = {
            'PPLG': ['PPLG 1', 'PPLG 2', 'PPLG 3', 'PPLG 4'],
            'BCF': ['BCF 1', 'BCF 2', 'BCF 3', 'BCF 4'],
            'ANIM': ['ANIM 1', 'ANIM 2', 'ANIM 3', 'ANIM 4'],
            'TO': ['TO 1', 'TO 2', 'TO 3', 'TO 4'],
            'TPFL': ['TPFL 1', 'TPFL 2', 'TPFL 3', 'TPFL 4'],
        };

        function cleanClassString(str) {
            return (str || '').replace(/^kelas\s*/i, '').replace(/[\s\-_]/g, '').toUpperCase();
        }

        function populateEditClassOptions(major, selectedVal) {
            if (!classSelect) return;
            classSelect.innerHTML = '';

            const targetClean = cleanClassString(selectedVal);
            let matched = false;

            if (!major || !majorClasses[major]) {
                const optNone = document.createElement('option');
                optNone.value = '';
                optNone.textContent = '-- Bukan Siswa / Tanpa Kelas --';
                if (!selectedVal || selectedVal === '') {
                    optNone.selected = true;
                    matched = true;
                }
                classSelect.appendChild(optNone);

                const optStrip = document.createElement('option');
                optStrip.value = '-';
                optStrip.textContent = '- (Bukan Siswa / Guru / Staf)';
                if (selectedVal === '-') {
                    optStrip.selected = true;
                    matched = true;
                }
                classSelect.appendChild(optStrip);

                const umumLevels = ['X', 'XI', 'XII'];
                umumLevels.forEach(lvl => {
                    const group = document.createElement('optgroup');
                    group.label = `Kelas ${lvl}`;
                    [1, 2, 3, 4].forEach(num => {
                        const fullClass = `${lvl} ${num}`;
                        const opt = document.createElement('option');
                        opt.value = fullClass;
                        opt.textContent = fullClass;
                        if (!matched && (targetClean === cleanClassString(fullClass))) {
                            opt.selected = true;
                            matched = true;
                        }
                        group.appendChild(opt);
                    });
                    classSelect.appendChild(group);
                });

                if (selectedVal && !matched && selectedVal !== '-' && selectedVal !== '') {
                    const optCustom = document.createElement('option');
                    optCustom.value = selectedVal;
                    optCustom.textContent = selectedVal;
                    optCustom.selected = true;
                    classSelect.appendChild(optCustom);
                }
                return;
            }

            const placeholder = document.createElement('option');
            placeholder.value = '';
            placeholder.textContent = `-- Pilih Kelas ${major} --`;
            classSelect.appendChild(placeholder);

            const optNonSiswa = document.createElement('option');
            optNonSiswa.value = '';
            optNonSiswa.textContent = '-- Bukan Siswa / Tanpa Kelas --';
            if (!selectedVal || selectedVal === '') {
                optNonSiswa.selected = true;
                matched = true;
            }
            classSelect.appendChild(optNonSiswa);

            const levels = ['X', 'XI', 'XII'];
            levels.forEach(lvl => {
                const optGroup = document.createElement('optgroup');
                optGroup.label = `Kelas ${lvl}`;

                majorClasses[major].forEach(rombel => {
                    const fullClassName = `${lvl} ${rombel}`;
                    const opt = document.createElement('option');
                    opt.value = fullClassName;
                    opt.textContent = fullClassName;

                    if (!matched && selectedVal) {
                        const optClean = cleanClassString(fullClassName);
                        const majorClean = cleanClassString(major);
                        if (targetClean === optClean || targetClean === cleanClassString(`${lvl} ${rombel.replace(major, '').trim()}`) || targetClean.replace(majorClean, '') === optClean.replace(majorClean, '')) {
                            opt.selected = true;
                            matched = true;
                        }
                    }
                    optGroup.appendChild(opt);
                });
                classSelect.appendChild(optGroup);
            });

            if (selectedVal && !matched && selectedVal !== '-' && selectedVal !== '') {
                const optCustom = document.createElement('option');
                optCustom.value = selectedVal;
                optCustom.textContent = selectedVal;
                optCustom.selected = true;
                classSelect.appendChild(optCustom);
            }
        }

        if (majorSelect) {
            majorSelect.addEventListener('change', function() {
                populateEditClassOptions(this.value, classSelect ? classSelect.value : '');
            });
        }

        populateEditClassOptions(majorSelect ? majorSelect.value : '', @json(old('class_name', $petugas->class_name ?? '')));
    });
</script>

@endsection
