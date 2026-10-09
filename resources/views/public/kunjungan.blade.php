@extends('layouts.public', ['title' => 'Riwayat Kunjungan UKS'])

@section('content')
<main class="uk-ringkasan-main">
    {{-- Header Kunjungan Modern Senada dengan Layanan & Ringkasan --}}
    <section class="rounded-3xl bg-gradient-to-r from-teal-800 via-teal-700 to-slate-900 p-8 sm:p-12 text-white shadow-lg relative overflow-hidden mb-8">
        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="max-w-3xl space-y-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-500/20 text-teal-200 border border-teal-400/30">
                    Catatan Aktivitas Siswa
                </span>
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Riwayat Kunjungan UKS</h1>
                <p class="text-sm sm:text-base text-teal-100/90 leading-relaxed font-normal">
                    Data riwayat kunjungan dan penanganan kesehatan siswa di sekolah
                </p>
            </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </section>

    {{-- Active Filter Notification Bar --}}
    @if ($activeFilter || $activeStatus)
        <div class="uk-active-filter-bar">
            <div class="uk-active-filter-text">
                <span class="uk-filter-indicator"><svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg></span>
                <span>
                    Menampilkan filter: 
                    <strong>
                        @if ($activeFilter === 'today') Kunjungan Hari Ini
                        @elseif ($activeFilter === 'month') Kunjungan Bulan Ini
                        @elseif ($activeFilter === 'all') Seluruh Riwayat Kunjungan
                        @endif

                        @if ($activeStatus)
                            Status "{{ ucfirst($activeStatus) }}"
                        @endif
                    </strong>
                </span>
            </div>
            <a href="{{ route('public.kunjungan') }}" class="uk-btn-reset-filter">
                <span>✕ Reset Filter (Tampilkan Semua)</span>
            </a>
        </div>
    @endif



    {{-- Visits Table --}}
    <section class="uk-recent-visits-section">
        <div class="uk-panel-card">
            <div class="uk-panel-header uk-panel-header--between">
                <div>
                    <h3>
                        @if ($activeStatus)
                            Riwayat Kunjungan — Status: {{ ucfirst($activeStatus) }}
                        @elseif ($activeFilter === 'today')
                            Riwayat Kunjungan Hari Ini
                        @elseif ($activeFilter === 'month')
                            Riwayat Kunjungan Bulan Ini
                        @else
                            Riwayat Kunjungan UKS
                        @endif
                    </h3>
                    <p>Klik tombol detail pada baris untuk melihat keterangan lengkap penanganan.</p>
                </div>
                <div>
                    <span class="uk-badge-counter">{{ count($recentVisits) }} Data</span>
                </div>
            </div>

            @if ($recentVisits->count() > 0)
                <div class="uk-table-wrap">
                    <table class="uk-table-pro">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Nama Siswa</th>
                                <th>Kelas</th>
                                <th>Keluhan / Gejala</th>
                                <th>Penanganan Awal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recentVisits as $visit)
                                <tr>
                                    <td class="uk-td-date">
                                        <div class="uk-date-badge">
                                            <strong>{{ $visit->visit_date ? $visit->visit_date->format('d/m') : '-' }}</strong>
                                            <small>{{ $visit->visit_date ? $visit->visit_date->format('Y') : '' }}</small>
                                        </div>
                                    </td>
                                    <td class="uk-td-student">
                                        <strong>{{ $visit->student->name ?? 'Siswa' }}</strong>

                                    </td>
                                    <td>
                                        <span class="uk-badge-class">{{ $visit->student->class_name ?? '-' }}</span>
                                    </td>
                                    <td class="uk-td-complaint">
                                        <p>{{ $visit->complaint }}</p>
                                    </td>
                                    <td class="uk-td-treatment">
                                        <p>{{ $visit->initial_treatment ?: '—' }}</p>
                                    </td>
                                    <td>
                                        @if ($visit->status === 'ditangani')
                                            <span class="uk-status-pill uk-status-pill--ditangani"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>Ditangani</span>
                                        @elseif ($visit->status === 'dirujuk')
                                            <span class="uk-status-pill uk-status-pill--dirujuk"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>Dirujuk</span>
                                        @elseif ($visit->status === 'pulang')
                                            <span class="uk-status-pill uk-status-pill--pulang"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>Pulang</span>
                                        @else
                                            <span class="uk-status-pill">{{ ucfirst($visit->status) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="uk-btn-table-action"
                                            data-name="{{ $visit->student->name ?? 'Siswa' }}"
                                            data-class="{{ $visit->student->class_name ?? '-' }}"
                                            data-date="{{ $visit->visit_date ? $visit->visit_date->format('d F Y') : '-' }}"
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
                    <h4>Belum Ada Catatan Kunjungan</h4>
                    <p>
                        @if ($activeStatus || $activeFilter)
                            Tidak ada data yang sesuai dengan filter yang Anda pilih.
                        @else
                            Saat ini belum ada catatan riwayat kunjungan UKS di sistem.
                        @endif
                    </p>
                    <div style="display: flex; gap: 12px; justify-content: center;">
                        @if ($activeStatus || $activeFilter)
                            <a href="{{ route('public.kunjungan') }}" class="uk-btn-secondary uk-btn-sm">
                                <span>Reset Filter</span>
                            </a>
                        @endif
                        <a href="{{ route('public.kunjungan.create') }}" class="uk-btn-primary uk-btn-sm">
                            <span>+ Catat Kunjungan Siswa</span>
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </section>

    {{-- Bottom Guidance Section --}}
    <section class="uk-ringkasan-footer-cta">
        <div class="uk-info-grid">
            <a href="{{ route('public.layanan') }}#alur" class="uk-info-box uk-info-box--clickable" title="Lihat SOP dan ketentuan UKS">
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
            <h3 id="modalStudentName" style="margin: 0 0 4px; font-size: 22px; font-weight: 800; color: #082d33;"></h3>
            <p id="modalStudentMeta" style="margin: 0 0 20px; color: #607680; font-size: 13.5px;"></p>

            <div class="uk-modal-info-block">
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
            button.getAttribute('data-date') || '-',
            button.getAttribute('data-complaint') || '',
            button.getAttribute('data-treatment') || 'Belum ada catatan',
            button.getAttribute('data-status') || ''
        );
    }

    function showVisitModal(name, className, date, complaint, treatment, status) {
        document.getElementById('modalStudentName').textContent = name;
        document.getElementById('modalStudentMeta').textContent = 'Kelas ' + className + ' • Tanggal ' + date;
        document.getElementById('modalComplaint').textContent = complaint;
        document.getElementById('modalTreatment').textContent = treatment;
        
        var statusBadge = document.getElementById('modalStatusBadge');
        if (status === 'ditangani') {
            statusBadge.innerHTML = '<span class="uk-status-pill uk-status-pill--ditangani"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" style="display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>Ditangani di UKS</span>';
        } else if (status === 'dirujuk') {
            statusBadge.innerHTML = '<span class="uk-status-pill uk-status-pill--dirujuk"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>Dirujuk ke Faskes</span>';
        } else if (status === 'pulang') {
            statusBadge.innerHTML = '<span class="uk-status-pill uk-status-pill--pulang"><svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display:inline;margin-right:4px;"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>Diizinkan Pulang</span>';
        } else {
            statusBadge.innerHTML = '<span class="uk-status-pill">' + status + '</span>';
        }

        document.getElementById('visitDetailModal').style.display = 'flex';
    }

    function closeVisitModal() {
        document.getElementById('visitDetailModal').style.display = 'none';
    }
</script>
@endsection
