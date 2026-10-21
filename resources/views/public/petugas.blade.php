@extends('layouts.public', ['title' => 'Petugas UKS'])

@section('content')
<main class="space-y-12 pb-16">
    <!-- Hero Section Full Width: Serasi dengan Beranda & Layanan -->
    <section class="w-full bg-emerald-600 dark:bg-emerald-900 border-b border-transparent dark:border-emerald-700/60 text-white shadow-xl overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
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
                        <span class="font-black text-emerald-300 text-sm">{{ $aktifCount }}</span>
                        <span>Petugas Siaga Aktif</span>
                    </div>
                    <div class="px-3.5 py-2 rounded-xl bg-white/15 border border-white/25 text-white flex items-center gap-2 backdrop-blur-md">
                        <span>🕒 Jam Layanan: 07:00 – 15:30 WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Konten Utama Halaman Petugas -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">

        <!-- Bar Pencarian Petugas -->
        <div class="rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 shadow-xs flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Daftar Tim UKS SMKN 1 Ciomas</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Temukan petugas jaga berdasarkan nama atau jabatan</p>
            </div>

            <form method="GET" action="{{ route('public.petugas') }}" class="flex items-center gap-2">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau jabatan..." class="px-3.5 py-2 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-400 focus:border-teal-500 focus:bg-white dark:focus:bg-slate-800 focus:ring-2 focus:ring-teal-500/20 transition w-48 sm:w-64">
                
                <button type="submit" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 active:bg-emerald-800 text-white rounded-xl text-xs font-bold transition shadow-xs flex items-center gap-1.5 shrink-0 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span>Cari</span>
                </button>

                @if(request('q'))
                    <a href="{{ route('public.petugas') }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 rounded-xl text-xs font-medium transition">
                        Reset
                    </a>
                @endif
            </form>
        </div>

        <!-- Grid Kartu Profil Petugas UKS -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse ($petugasList as $item)
                <div class="group rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col justify-between">
                    <div class="space-y-4">
                        <!-- Header Kartu: Status Badge -->
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $item->status === 'aktif' ? 'bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-300 dark:border-emerald-800' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 border border-slate-200 dark:border-slate-700' }}">
                                @if($item->status === 'aktif')
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                    <span>Aktif Siaga</span>
                                @else
                                    <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>
                                    <span>Non-Aktif</span>
                                @endif
                            </span>

                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-md {{ $item->gender === 'L' ? 'bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300' : 'bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-300' }}">
                                {{ $item->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>

                        <!-- Avatar & Profil Utama -->
                        <div class="text-center pt-2">
                            <div class="w-20 h-20 mx-auto rounded-2xl bg-gradient-to-br {{ $item->gender === 'L' ? 'from-teal-500 to-emerald-600' : 'from-rose-400 to-teal-600' }} text-white font-extrabold text-2xl flex items-center justify-center shadow-md shadow-teal-500/20 border-2 border-white dark:border-slate-800 group-hover:scale-105 transition-transform">
                                {{ strtoupper(mb_substr($item->name, 0, 2)) }}
                            </div>

                            <h3 class="mt-3.5 text-base font-extrabold text-slate-900 dark:text-white leading-tight">
                                {{ $item->name }}
                            </h3>

                            <span class="inline-block mt-1 text-xs font-semibold text-teal-700 dark:text-teal-400 bg-teal-50 dark:bg-teal-950/60 px-2.5 py-0.5 rounded-full border border-teal-200 dark:border-teal-800">
                                {{ $item->role_title }}
                            </span>
                        </div>

                        <!-- Jadwal Jaga & Keterangan -->
                        <div class="space-y-2 pt-2 border-t border-slate-100 dark:border-slate-800/80 text-xs text-slate-600 dark:text-slate-400">
                            @if($item->schedule)
                                <div class="flex items-start gap-2 bg-slate-50 dark:bg-slate-950/60 p-2.5 rounded-xl border border-slate-200/70 dark:border-slate-800">
                                    <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <span class="block text-[10px] uppercase font-bold text-slate-400">Jadwal Tugas</span>
                                        <span class="font-medium text-slate-800 dark:text-slate-200">{{ $item->schedule }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($item->bio)
                                <p class="text-[11px] leading-relaxed text-slate-600 dark:text-slate-400 italic">
                                    "{{ $item->bio }}"
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Aksi Kontak (WhatsApp / Telepon) -->
                    <div class="mt-5 pt-3 border-t border-slate-100 dark:border-slate-800">
                        @if($item->phone)
                            @php
                                $cleanPhone = preg_replace('/[^0-9]/', '', $item->phone);
                                if (str_starts_with($cleanPhone, '0')) {
                                    $waNumber = '62' . substr($cleanPhone, 1);
                                } else {
                                    $waNumber = $cleanPhone;
                                }
                            @endphp
                            <a href="https://wa.me/{{ $waNumber }}?text={{ urlencode('Halo Bapak/Ibu ' . $item->name . ' (Petugas UKS SMKN 1 Ciomas), saya ingin bertanya seputar layanan UKS.') }}" target="_blank" rel="noopener noreferrer" class="w-full flex items-center justify-center gap-2 py-2.5 px-3 rounded-xl bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:hover:bg-emerald-900/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs font-bold transition">
                                <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.311.045-.698.077-2.228-.553-1.879-.775-3.08-2.695-3.174-2.82-.095-.125-.769-1.023-.769-1.95 0-.927.487-1.383.66-1.57.173-.188.38-.235.507-.235.127 0 .254.002.366.007.118.005.277-.045.433.329.16.386.549 1.339.596 1.436.048.096.08.209.016.336-.064.126-.096.205-.191.316-.095.111-.2.248-.286.333-.095.095-.194.198-.083.389.111.19.493.813 1.057 1.316.726.647 1.338.847 1.529.942.19.095.302.08.414-.048.111-.127.476-.554.603-.744.127-.19.254-.158.428-.095.174.063 1.109.523 1.299.618.19.095.317.142.364.222.048.079.048.46-.096.865z"/>
                                </svg>
                                <span>Hubungi WhatsApp</span>
                            </a>
                        @else
                            <div class="text-center py-2 text-[11px] text-slate-400 italic">
                                Kontak UKS Terpusat
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full p-12 text-center rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 space-y-3">
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-300">Belum ada data petugas yang cocok dengan pencarian.</p>
                    <a href="{{ route('public.petugas') }}" class="inline-block text-xs font-bold text-teal-600 dark:text-teal-400 hover:underline">
                        Tampilkan Semua Petugas
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Section Jadwal Piket Mingguan Petugas UKS -->
        @if(isset($weeklySchedules) && $weeklySchedules->isNotEmpty())
            <div id="jadwal-mingguan" class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-6 sm:p-8 md:p-10 shadow-sm space-y-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                            Agenda Tugas
                        </span>
                        <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">
                            Jadwal Piket Harian UKS SMKN 1 Ciomas
                        </h3>
                        <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                            Petugas pembina, tenaga medis, dan relawan PMR yang siaga melayani siswa setiap hari sekolah.
                        </p>
                    </div>

                    <span class="px-3.5 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 text-xs font-bold shrink-0">
                        🕒 Layanan Sekolah: 07:30 – 15:30 WIB
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                    @foreach(['Senin' => 1, 'Selasa' => 2, 'Rabu' => 3, 'Kamis' => 4, 'Jumat' => 5] as $dayName => $dayNum)
                        @php
                            $daySchedules = $weeklySchedules->where('day_number', $dayNum);
                            $isToday = $dayNum === ($todayDayNumber ?? 1);
                        @endphp
                        <div class="rounded-2xl border {{ $isToday ? 'border-emerald-500 bg-emerald-50/20 dark:bg-emerald-950/20 ring-2 ring-emerald-500/20' : 'border-slate-200 dark:border-slate-800 bg-slate-50/60 dark:bg-slate-950/60' }} p-5 space-y-3 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between pb-2 border-b border-slate-200/60 dark:border-slate-800">
                                    <span class="text-sm font-black {{ $isToday ? 'text-emerald-700 dark:text-emerald-400' : 'text-slate-900 dark:text-white' }}">
                                        {{ $dayName }}
                                    </span>
                                    @if($isToday)
                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-600 text-white">
                                            <span class="h-1.5 w-1.5 rounded-full bg-white animate-pulse"></span>
                                            <span>Hari Ini</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="space-y-3 pt-3">
                                    @forelse($daySchedules as $schedule)
                                        @php $p = $schedule->petugas; @endphp
                                        @if($p)
                                            <div class="flex items-start gap-2.5">
                                                <div class="w-8 h-8 rounded-lg bg-teal-600 text-white font-black text-[11px] flex items-center justify-center shrink-0 mt-0.5">
                                                    {{ strtoupper(mb_substr($p->name, 0, 2)) }}
                                                </div>
                                                <div class="min-w-0">
                                                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ $p->name }}</p>
                                                    <p class="text-[11px] text-teal-600 dark:text-teal-400 font-semibold">{{ $p->role_title }}</p>
                                                    <p class="text-[10px] text-slate-500 dark:text-slate-400 mt-0.5">🕒 {{ $schedule->shift_time }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <p class="text-xs text-slate-400 italic">Tidak ada petugas dijadwalkan.</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Section Nilai & Prinsip Pelayanan Petugas UKS -->
        <div class="rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 md:p-12 shadow-sm space-y-6">
            <div class="text-center max-w-2xl mx-auto">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 border border-teal-300 dark:border-teal-800 uppercase tracking-wider mb-2">
                    Standar Pelayanan
                </span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-slate-900 dark:text-white">
                    Komitmen Petugas UKS SMKN 1 Ciomas
                </h3>
                <p class="mt-2 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                    Setiap petugas memegang teguh prinsip kepedulian, kebersihan, dan keselamatan dalam menangani setiap siswa.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4">
                <div class="p-5 rounded-2xl bg-teal-50/60 dark:bg-slate-950/60 border border-teal-200/70 dark:border-slate-800 space-y-2">
                    <div class="w-9 h-9 rounded-xl bg-teal-600 text-white flex items-center justify-center font-black text-sm">
                        01
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Tanggap &amp; Sigap</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Memberikan respons cepat pada kondisi darurat medis dan pertolongan pertama tanpa penundaan.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-amber-50/60 dark:bg-slate-950/60 border border-amber-200/70 dark:border-slate-800 space-y-2">
                    <div class="w-9 h-9 rounded-xl bg-amber-500 text-slate-950 flex items-center justify-center font-black text-sm">
                        02
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kerahasiaan Medis</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Keluhan dan riwayat kesehatan siswa dicatat dengan aman dan hanya dikoordinasikan kepada pihak berwenang.
                    </p>
                </div>

                <div class="p-5 rounded-2xl bg-sky-50/60 dark:bg-slate-950/60 border border-sky-200/70 dark:border-slate-800 space-y-2">
                    <div class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-black text-sm">
                        03
                    </div>
                    <h4 class="text-sm font-bold text-slate-900 dark:text-white">Kolaboratif &amp; Humanis</h4>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        Bekerja sama erat dengan wali kelas, guru piket, orang tua/wali murid, serta puskesmas terdekat.
                    </p>
                </div>
            </div>
        </div>

        <!-- Banner Call to Action Bawah -->
        <div class="rounded-3xl bg-gradient-to-r from-emerald-700 via-teal-700 to-slate-900 p-8 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="space-y-2 text-center md:text-left">
                <h3 class="text-xl sm:text-2xl font-black tracking-tight">Siswa Merasa Sakit di Sekolah?</h3>
                <p class="text-xs sm:text-sm text-teal-100 max-w-xl">
                    Silakan lapor ke ruang UKS dan catat formulir kunjungan agar petugas dapat memberikan perawatan yang sesuai.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 shrink-0">
                <a href="{{ route('public.kunjungan.create') }}" class="px-5 py-3 rounded-xl bg-amber-400 hover:bg-amber-300 text-slate-950 font-black text-xs shadow-lg transition">
                    Isi Kunjungan Siswa
                </a>
                <a href="{{ route('public.hubungi') }}" class="px-5 py-3 rounded-xl bg-rose-600 hover:bg-rose-500 text-white font-bold text-xs shadow-lg transition">
                    Hubungi Darurat
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
