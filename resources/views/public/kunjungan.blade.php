@extends('layouts.public', ['title' => 'Riwayat Kunjungan UKS'])

@section('content')
<main class="space-y-12 pb-16">
    <!-- Hero Section Full Width: Menempel langsung di bawah navbar seperti Beranda -->
    <section class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
            <div class="max-w-3xl space-y-5 text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 dark:bg-emerald-800/80 border border-white/25 dark:border-emerald-600/40 text-white dark:text-emerald-200 text-xs font-bold shadow-sm backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                    <span>Catatan Aktivitas Siswa</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white dark:text-emerald-50 tracking-tight leading-tight drop-shadow-sm">
                    Riwayat Kunjungan UKS
                </h1>

                <p class="text-sm sm:text-base text-emerald-50 dark:text-emerald-200/90 leading-relaxed font-normal">
                    Daftar lengkap catatan pemeriksaan kesehatan, keluhan sakit, dan penanganan medis pertama bagi seluruh siswa di SMKN 1 Ciomas.
                </p>
            </div>
        </div>
    </section>

    <!-- Konten Kunjungan Dalam Container Rapi -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
    {{-- Active Filter & Search Notification Bar --}}
    @if ($activeStatus || request()->filled('q'))
        <div class="uk-active-filter-bar">
            <div class="uk-active-filter-text">
                <span class="uk-filter-indicator"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></span>
                <span>
                    @if ($activeStatus && request()->filled('q'))
                        Menampilkan hasil pencarian <strong>"{{ request('q') }}"</strong> dengan status <strong>"{{ ucfirst($activeStatus) }}"</strong>
                    @elseif (request()->filled('q'))
                        Menampilkan hasil pencarian: <strong>"{{ request('q') }}"</strong>
                    @else
                        Menampilkan filter: <strong>Status "{{ ucfirst($activeStatus) }}"</strong>
                    @endif
                </span>
            </div>
            <a href="{{ route('public.kunjungan') }}" class="uk-btn-reset-filter">
                <span>✕ Reset Filter</span>
            </a>
        </div>
    @endif



    {{-- Visits Table --}}
    <section class="uk-recent-visits-section">
        <div class="uk-panel-card">
            <div class="uk-panel-header uk-panel-header--between flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <div class="min-w-0">
                    <h3 class="text-lg sm:text-xl font-bold">
                        @if ($activeStatus)
                            Kunjungan Siswa Hari Ini — Status: {{ ucfirst($activeStatus) }}
                        @else
                            Kunjungan Siswa Hari Ini
                        @endif
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">Menampilkan data siswa yang berkunjung ke UKS hari ini. Klik tombol detail pada baris untuk melihat keterangan lengkap.</p>
                </div>
                
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 shrink-0">
                    <!-- Form Pencarian Cepat -->
                    <form method="GET" action="{{ route('public.kunjungan') }}" class="flex items-center gap-2 w-full sm:w-auto">
                        @if ($activeStatus)
                            <input type="hidden" name="status" value="{{ $activeStatus }}">
                        @endif
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama, kelas..." class="px-4 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-800 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 dark:placeholder-slate-400 focus:border-teal-500 dark:focus:border-teal-400 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 dark:focus:ring-teal-400/20 w-full sm:w-60 transition shadow-xs">
                        <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-xs sm:text-sm font-semibold transition shrink-0 shadow-sm">
                            Cari
                        </button>
                        @if (request()->filled('q'))
                            <a href="{{ route('public.kunjungan', array_filter(['status' => $activeStatus])) }}" class="px-3 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-xl text-xs sm:text-sm font-semibold transition shrink-0" title="Reset pencarian">
                                ✕
                            </a>
                        @endif
                    </form>

                    <div class="self-start sm:self-auto">
                        <span class="uk-badge-counter whitespace-nowrap">{{ count($recentVisits) }} Data</span>
                    </div>
                </div>
            </div>

            @if ($recentVisits->count() > 0)
                <div class="uk-table-wrap">
                    <table class="uk-table-pro">
                        <thead>
                            <tr>
                                <th style="width: 48px; text-align: center;">No</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th style="text-align: center;">Jumlah Kunjungan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentVisits as $visit)
                                <tr>
                                    <td class="uk-td-number">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="uk-td-student">
                                        <strong>{{ $visit->student->name ?? 'Siswa' }}</strong>

                                    </td>
                                    <td>
                                        <span class="uk-badge-class">{{ $visit->student->class_name ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="uk-badge-class" style="background: #eef2ff; color: #4338ca; border-color: #c7d2fe;">{{ $visit->student->major ?: '-' }}</span>
                                    </td>
                                    <td class="uk-td-visit-count">
                                        <span class="uk-badge-visit-count" title="Total riwayat siswa ini berkunjung ke UKS">
                                            {{ $visit->student->visits_count ?? 1 }} kali
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap">
                                        @if ($visit->status === 'ditangani')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Ditangani di UKS
                                            </span>
                                        @elseif ($visit->status === 'dirujuk')
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                Dirujuk ke Faskes
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">
                                                Diizinkan Pulang
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="uk-btn-table-action"
                                            data-name="{{ $visit->student->name ?? 'Siswa' }}"
                                            data-class="{{ $visit->student->class_name ?? '-' }}"
                                            data-major="{{ $visit->student->major ?? '-' }}"
                                            data-visit-count="{{ $visit->student->visits_count ?? 1 }}"
                                            data-date="{{ $visit->visit_date ? $visit->visit_date->translatedFormat('d F Y') : '-' }}"
                                            data-time="{{ $visit->created_at ? $visit->created_at->format('H:i') . ' WIB' : ($visit->visit_date ? $visit->visit_date->format('H:i') . ' WIB' : '') }}"
                                            data-complaint="{{ $visit->complaint }}"
                                            data-treatment="{{ $visit->initial_treatment ?: 'Belum ada catatan' }}"
                                            data-status="{{ $visit->status }}"
                                            onclick="openVisitModal(this)">
                                            Detail ↗
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="uk-empty-state">
                    <div class="uk-empty-icon"><svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto; color: #cbd5e1;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg></div>
                    <h4>Belum Ada Kunjungan Siswa Hari Ini</h4>
                    <p>
                        @if (request()->filled('q'))
                            Tidak ditemukan catatan kunjungan hari ini dengan kata kunci "{{ request('q') }}".
                        @elseif ($activeStatus)
                            Tidak ada catatan kunjungan hari ini dengan status "{{ ucfirst($activeStatus) }}".
                        @else
                            Belum ada siswa yang tercatat berkunjung ke UKS pada hari ini ({{ now()->translatedFormat('d F Y') }}).
                        @endif
                    </p>
                    <div style="display: flex; gap: 12px; justify-content: center;">
                        @if (request()->filled('q') || $activeStatus)
                            <a href="{{ route('public.kunjungan') }}" class="uk-btn-secondary uk-btn-sm">
                                <span>Reset Filter & Pencarian</span>
                            </a>
                        @endif
                        <a href="{{ route('public.kunjungan.create') }}" class="uk-btn-primary uk-btn-sm">
                            <span>Catat Kunjungan Siswa</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Bottom Guidance Section --}}
    <section class="uk-ringkasan-footer-cta">
        <div class="uk-info-grid">
            <a href="{{ route('home') }}#alur" class="uk-info-box uk-info-box--clickable" title="Lihat SOP dan ketentuan UKS">
                <div class="uk-info-box__icon"><svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: #f59e0b;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg></div>
                <div>
                    <h4>Ketentuan Penggunaan UKS ↗</h4>
                    <p>Siswa yang sakit selama jam pelajaran wajib melapor ke guru pengajar atau guru piket sebelum menuju ruang UKS untuk pendataan.</p>
                </div>
            </a>
            <a href="{{ route('public.ringkasan') }}" class="uk-info-box uk-info-box--clickable" title="Lihat statistik dan ringkasan UKS">
                <div class="uk-info-box__icon"><svg width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="color: #0ea5e9;"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg></div>
                <div>
                    <h4>Lihat Ringkasan & Statistik ↗</h4>
                    <p>Akses data statistik lengkap mengenai distribusi status penanganan, jumlah siswa terdaftar, dan metrik KPI layanan UKS.</p>
                </div>
            </a>
        </div>
    </section>
    </div>
</main>

{{-- Detail Modal --}}
<div id="visitDetailModal" class="uk-modal-overlay" style="display: none;" onclick="if(event.target === this) closeVisitModal()">
    <div class="uk-modal-card">
        <div class="uk-modal-header">
            <div class="uk-hero-badge" style="margin-bottom: 0;">
                <span class="uk-badge-dot"></span>
                <span>Detail Kunjungan</span>
            </div>
            <button type="button" class="uk-modal-close" onclick="closeVisitModal()">✕</button>
        </div>
        <div class="uk-modal-body">
            <h3 id="modalStudentName" style="margin: 0 0 16px; font-size: 22px; font-weight: 800; color: #082d33;"></h3>

            <div class="uk-modal-info-block" style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Kelas</label>
                    <div id="modalStudentClass" style="background: #f7faf9; border: 1px solid #e1ede8; padding: 12px; border-radius: 8px; font-size: 13.5px; color: #1c333b;"></div>
                </div>
                <div>
                    <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Jurusan</label>
                    <div id="modalStudentMajor" style="background: #f7faf9; border: 1px solid #e1ede8; padding: 12px; border-radius: 8px; font-size: 13.5px; color: #1c333b;"></div>
                </div>
            </div>

            <div class="uk-modal-info-block" style="margin-top: 14px;">
                <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Keluhan atau Gejala</label>
                <div id="modalComplaint" style="background: #f7faf9; border: 1px solid #e1ede8; padding: 12px; border-radius: 8px; font-size: 13.5px; color: #1c333b; white-space: pre-wrap; word-break: break-word;"></div>
            </div>

            <div class="uk-modal-info-block" style="margin-top: 14px;">
                <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Penanganan Awal</label>
                <div id="modalTreatment" style="background: #f7faf9; border: 1px solid #e1ede8; padding: 12px; border-radius: 8px; font-size: 13.5px; color: #1c333b; white-space: pre-wrap; word-break: break-word;"></div>
            </div>

            <div class="uk-modal-info-block" style="margin-top: 14px;">
                <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Status Penanganan</label>
                <div id="modalStatusBadge"></div>
            </div>

            <div class="uk-modal-info-block" style="margin-top: 14px;">
                <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Waktu & Jam Pengisian Kunjungan</label>
                <div id="modalVisitTimeBlock" style="background: #f7faf9; border: 1px solid #e1ede8; padding: 12px; border-radius: 8px; font-size: 13.5px; color: #1c333b; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <span id="modalDateDetail" style="font-weight: 700;">-</span>
                    <span id="modalTimeDetail" style="font-weight: 750; color: #0284c7; background: #e0f2fe; padding: 4px 12px; border-radius: 8px; font-size: 13px; border: 1px solid #bae6fd;">-</span>
                </div>
            </div>

            <div class="uk-modal-info-block" style="margin-top: 14px;">
                <label style="display: block; font-size: 11.5px; font-weight: 750; color: #536c76; text-transform: uppercase; margin-bottom: 4px;">Jumlah Kunjungan Siswa</label>
                <div id="modalVisitCountDisplay" style="background: #f7faf9; border: 1px solid #e1ede8; padding: 12px; border-radius: 8px; font-size: 13.5px; color: #1c333b; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 8px;">
                    <span class="uk-badge-visit-count" style="font-size: 13px; padding: 5px 12px;">
                        <strong id="modalVisitCountBadgeText">1 kali</strong>
                    </span>
                    <span id="modalVisitCountDesc" style="font-size: 12.5px; color: #64748b;">Siswa ini sudah 1 kali berkunjung ke UKS</span>
                </div>
            </div>
        </div>
        <div class="uk-modal-footer">
            <button type="button" class="uk-btn-secondary uk-btn-sm" onclick="closeVisitModal()">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openVisitModal(button) {
        showVisitModal(
            button.getAttribute('data-name') || 'Siswa',
            button.getAttribute('data-class') || '-',
            button.getAttribute('data-major') || '-',
            button.getAttribute('data-visit-count') || '1',
            button.getAttribute('data-date') || '-',
            button.getAttribute('data-time') || '',
            button.getAttribute('data-complaint') || '',
            button.getAttribute('data-treatment') || 'Belum ada catatan',
            button.getAttribute('data-status') || ''
        );
    }

    function showVisitModal(name, className, major, visitCount, date, time, complaint, treatment, status) {
        document.getElementById('modalStudentName').textContent = name;
        var classElement = document.getElementById('modalStudentClass');
        if (classElement) {
            classElement.textContent = className || '-';
        }
        var majorElement = document.getElementById('modalStudentMajor');
        if (majorElement) {
            majorElement.textContent = major || '-';
        }
        document.getElementById('modalComplaint').textContent = complaint;
        document.getElementById('modalTreatment').textContent = treatment;

        var dateDetail = document.getElementById('modalDateDetail');
        var timeDetail = document.getElementById('modalTimeDetail');
        if (dateDetail) dateDetail.textContent = 'Tanggal: ' + date;
        if (timeDetail) timeDetail.textContent = time ? 'Pukul ' + time : 'Waktu tercatat';
        
        var badgeText = document.getElementById('modalVisitCountBadgeText');
        var descText = document.getElementById('modalVisitCountDesc');
        if (badgeText) badgeText.textContent = visitCount + ' kali';
        if (descText) descText.textContent = 'Siswa ini sudah ' + visitCount + ' kali tercatat berkunjung ke UKS';
        
        var statusBadge = document.getElementById('modalStatusBadge');
        if (status === 'ditangani') {
            statusBadge.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">Ditangani di UKS</span>';
        } else if (status === 'dirujuk') {
            statusBadge.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">Dirujuk ke Faskes</span>';
        } else if (status === 'pulang') {
            statusBadge.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-sky-50 text-sky-700 border border-sky-200">Diizinkan Pulang</span>';
        } else {
            statusBadge.innerHTML = '<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">' + status + '</span>';
        }

        document.getElementById('visitDetailModal').style.display = 'flex';
    }

    function closeVisitModal() {
        document.getElementById('visitDetailModal').style.display = 'none';
    }
</script>

<style>
    /* Sharp High-Contrast Table Styling */
    .uk-table-pro {
        border-collapse: separate !important;
        border-spacing: 0 !important;
        width: 100% !important;
        border: 2px solid #94a3b8 !important;
        border-radius: 14px !important;
        overflow: hidden !important;
    }
    .uk-table-pro th {
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        font-weight: 800 !important;
        font-size: 11.5px !important;
        border-bottom: 2.5px solid #64748b !important;
        padding: 14px 16px !important;
    }
    .uk-table-pro td {
        border-bottom: 1.5px solid #94a3b8 !important;
        padding: 14px 16px !important;
    }
    .uk-table-pro tr:last-child td {
        border-bottom: none !important;
    }
    .uk-table-pro tbody tr:nth-child(even) td {
        background-color: #f8fafc !important;
    }
    .uk-table-pro tbody tr:hover td {
        background-color: #e2e8f0 !important;
    }
    html.dark .uk-table-pro {
        border-color: #334155 !important;
    }
    html.dark .uk-table-pro th {
        background-color: #0f172a !important;
        color: #e2e8f0 !important;
        border-bottom-color: #475569 !important;
    }
    html.dark .uk-table-pro td {
        border-bottom-color: #334155 !important;
    }
    html.dark .uk-table-pro tbody tr:nth-child(even) td {
        background-color: rgba(15, 23, 42, 0.4);
    }
    html.dark .uk-table-pro tbody tr:hover td {
        background-color: rgba(30, 41, 59, 0.6) !important;
    }

    .uk-badge-counter {
        white-space: nowrap !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }

    @media (max-width: 640px) {
        .uk-panel-card {
            padding: 20px 16px !important;
        }
        .uk-panel-header--between {
            flex-direction: column !important;
            align-items: flex-start !important;
            gap: 12px !important;
        }
        .uk-badge-counter {
            align-self: flex-start !important;
        }
    }
</style>
@endsection
