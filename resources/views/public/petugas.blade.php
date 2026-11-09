@extends('layouts.public', ['title' => 'Petugas UKS'])

@section('content')
<main class="space-y-12 pb-16">
    <!-- Hero Section Full Width: Serasi dengan Beranda & Layanan -->
    <section class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-xl overflow-hidden">
        <div class="w-full px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
            <div class="max-w-3xl space-y-5 text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 dark:bg-emerald-800/80 border border-white/25 dark:border-emerald-600/40 text-white dark:text-emerald-200 text-xs font-bold shadow-sm backdrop-blur-md">
                    <span class="h-2 w-2 rounded-full bg-white animate-pulse"></span>
                    <span>Kesiapsiagaan Tim Medis &amp; Relawan UKS</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-[42px] font-black text-white dark:text-emerald-50 tracking-tight leading-tight drop-shadow-sm">
                    Petugas &amp; Tim Medis UKS
                </h1>

                <p class="text-sm sm:text-base text-emerald-50 dark:text-emerald-200/90 leading-relaxed font-normal">
                    Mengenal para pembina, tenaga kesehatan, dan relawan PMR yang berdedikasi menjaga kesehatan, keselamatan, dan kenyamanan seluruh siswa SMKN 1 Ciomas.
                </p>

                <!-- Ringkasan Statistik Tim -->
                <div class="pt-2 flex flex-wrap items-center gap-3 text-xs font-semibold">
                    <div class="px-3.5 py-2 rounded-xl bg-white/15 border border-white/25 text-white flex items-center gap-2 backdrop-blur-md">
                        <span class="font-black text-amber-300 text-sm">{{ $totalPetugas }}</span>
                        <span>Total Petugas Terdaftar</span>
                    </div>
                    <div class="px-3.5 py-2 rounded-xl bg-white/15 border border-white/25 text-white flex items-center gap-2 backdrop-blur-md">
                        <span class="h-2 w-2 rounded-full bg-emerald-400 animate-ping"></span>
                        <span class="font-black text-emerald-300 text-sm">{{ $todaySchedules->count() }}</span>
                        <span>Petugas Piket Hari Ini ({{ $todayDayName }})</span>
                    </div>
                    <div class="px-3.5 py-2 rounded-xl bg-white/15 border border-white/25 text-white flex items-center gap-2 backdrop-blur-md">
                        <span>🕒 Jam Layanan: 06:30 – 15:00 WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Utama Halaman Petugas -->
    <div class="w-full px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Section: Agenda Piket Hari Ini (Terhubung Langsung dengan Manajemen Jadwal Admin) -->
        <div id="agenda-piket-hari-ini" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 md:p-10 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div class="space-y-1">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800">
                        <span class="h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                        <span>Agenda Piket Hari Ini</span>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white flex items-center gap-2.5">
                        <span>Petugas UKS Siaga Hari Ini — Hari {{ $todayDayName }}</span>
                        @if($isWeekday && $todaySchedules->isNotEmpty())
                            <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-950/60 px-2.5 py-0.5 rounded-full border border-emerald-200 dark:border-emerald-800">
                                {{ $todaySchedules->count() }} Petugas Siaga
                            </span>
                        @endif
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400">
                        Petugas jaga yang siap melayani dan mendampingi siswa pada hari <span class="font-bold text-teal-600 dark:text-teal-400">{{ $todayFormatted }}</span>.
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-2 shrink-0">
                    <span class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold flex items-center gap-1.5 border border-slate-200 dark:border-slate-700">
                        <span>🕒</span>
                        <span>Jam Layanan Sekolah: 06:30 – 15:00 WIB</span>
                    </span>
                </div>
            </div>

            @if($isWeekday)
                @if($todaySchedules->isNotEmpty())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-{{ min(count($todaySchedules), 3) }} gap-5">
                        @foreach($todaySchedules as $schedule)
                            @php
                                $petugas = $schedule->petugas;
                            @endphp
                            @if($petugas)
                                <div class="rounded-2xl bg-gradient-to-br from-slate-50 to-slate-100/70 dark:from-slate-950 dark:to-slate-900/90 border border-emerald-500/40 dark:border-emerald-500/30 ring-1 ring-emerald-500/20 p-5 shadow-xs hover:shadow-md transition flex flex-col justify-between">
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-[10px] font-extrabold bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 border border-emerald-300/80 dark:border-emerald-800">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                                <span>Sedang Bertugas Hari Ini</span>
                                            </span>
                                            <span class="text-[10px] font-semibold text-slate-400">
                                                {{ $schedule->room ?? 'Ruang UKS' }}
                                            </span>
                                        </div>

                                        <div class="flex items-center gap-3.5 pt-1">
                                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-400 to-teal-600 text-white font-extrabold text-base flex items-center justify-center shadow-sm shrink-0">
                                                {{ strtoupper(mb_substr($petugas->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-extrabold text-slate-900 dark:text-white leading-snug">
                                                    {{ $petugas->name }}
                                                </h4>
                                                <p class="text-xs font-semibold text-teal-600 dark:text-teal-400 mt-0.5">
                                                    {{ $petugas->role_title }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="pt-2 text-xs space-y-1.5">
                                            <div class="flex items-center gap-2 text-slate-600 dark:text-slate-400">
                                                <span class="text-emerald-600 dark:text-emerald-400 font-bold">🕒 Jam Piket:</span>
                                                <span class="font-bold text-slate-900 dark:text-slate-200">{{ $schedule->shift_time }}</span>
                                            </div>
                                            @if($schedule->notes)
                                                <p class="text-[11px] text-slate-500 dark:text-slate-400 italic">
                                                    "{{ $schedule->notes }}"
                                                </p>
                                            @endif
                                        </div>
                                    </div>

                                    @if($petugas->phone)
                                        @php
                                            $cleanPhone = preg_replace('/[^0-9]/', '', $petugas->phone);
                                            $waNumber = str_starts_with($cleanPhone, '0') ? '62' . substr($cleanPhone, 1) : $cleanPhone;
                                        @endphp
                                        <div class="mt-4 pt-3 border-t border-slate-200/70 dark:border-slate-800 flex items-center justify-between gap-2 text-xs">
                                            <div>
                                                <span class="text-[10px] text-slate-400 block">Kontak:</span>
                                                <span class="font-bold text-slate-700 dark:text-slate-300 text-xs">{{ $petugas->phone }}</span>
                                            </div>
                                            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Bapak/Ibu ' . $petugas->name . ' (Petugas UKS SMKN 1 Ciomas), saya ingin bertanya seputar layanan UKS.') }}" target="_blank" rel="noopener noreferrer" class="px-3 py-1.5 rounded-lg bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:hover:bg-emerald-900/60 text-emerald-700 dark:text-emerald-300 font-bold text-[11px] flex items-center gap-1 transition border border-emerald-200 dark:border-emerald-800 shadow-xs">
                                                <span>WhatsApp</span>
                                                <span>↗</span>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="rounded-2xl border border-dashed border-slate-300 dark:border-slate-800 p-8 text-center space-y-2 bg-slate-50/50 dark:bg-slate-950/40">
                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                            Tidak ada petugas reguler yang dijadwalkan piket pada hari {{ $todayDayName }}.
                        </p>
                        <p class="text-xs text-slate-500 dark:text-slate-400">
                            Ruang UKS tetap dapat diakses untuk penanganan darurat melalui koordinasi guru piket atau pihak sekolah.
                        </p>
                    </div>
                @endif
            @else
                <!-- Akhir Pekan (Sabtu / Minggu) -->
                <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-950/50 p-6 sm:p-8 space-y-3 text-center">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-300 dark:border-amber-800">
                        Libur Akhir Pekan
                    </span>
                    <h4 class="text-sm font-extrabold text-slate-900 dark:text-white">
                        Pelayanan Reguler UKS Libur Hari {{ $todayDayName }}
                    </h4>
                    <p class="text-xs text-slate-500 dark:text-slate-400 max-w-md mx-auto">
                        Unit Kesehatan Sekolah melayani kegiatan belajar mengajar setiap hari Senin sampai Jumat (06:30 – 15:00 WIB).
                    </p>
                </div>
            @endif
        </div>



    </div>
</main>
@endsection
