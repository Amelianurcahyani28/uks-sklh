@extends('layouts.public', ['title' => 'Hubungi UKS'])

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-12 min-h-screen">
    <!-- Header Banner -->
    <section class="rounded-3xl bg-gradient-to-r from-teal-800 via-teal-700 to-slate-900 p-8 sm:p-12 text-white shadow-lg relative overflow-hidden">
        <div class="relative z-10 max-w-3xl space-y-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-teal-500/20 text-teal-200 border border-teal-400/30">
                Pusat Bantuan Darurat
            </span>
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Hubungi Petugas</h1>
            <p class="text-sm sm:text-base text-teal-100/90 leading-relaxed font-normal">
                Jika Anda merasa sakit, butuh pertolongan pertama, atau ada keadaan darurat kesehatan di lingkungan sekolah, jangan ragu untuk segera menghubungi petugas kami.
            </p>
        </div>
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
    </section>

    <!-- Informasi Kontak -->
    <section class="max-w-4xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kartu Kontak Darurat (WhatsApp) -->
            <div class="rounded-2xl border border-slate-200/90 bg-white p-8 shadow-xs hover:shadow-md transition flex flex-col justify-center items-center text-center">
                <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mb-5 border-4 border-emerald-50">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Petugas</h3>
                <p class="text-lg font-mono font-bold text-teal-700 mt-2">0895-3301-41832</p>
                <p class="text-sm text-slate-500 mt-2 mb-6">Hubungi via WhatsApp untuk pertolongan medis cepat, penjemputan dari kelas, atau konsultasi kesehatan.</p>
                <a href="https://wa.me/62895330141832" target="_blank" class="w-full inline-flex justify-center items-center gap-2 rounded-xl bg-emerald-600 px-6 py-3.5 text-sm font-bold text-white shadow-md hover:bg-emerald-700 transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.477 2 12c0 1.89.477 3.655 1.309 5.201L2.124 21.61a1.25 1.25 0 001.547 1.547l4.409-1.185A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2zm0 18c-1.574 0-3.056-.368-4.37-.999a.75.75 0 00-.518-.08l-3.32.892.892-3.32a.75.75 0 00-.08-.518A7.957 7.957 0 014 12c0-4.418 3.582-8 8-8s8 3.582 8 8-3.582 8-8 8zm3.682-6.52c-.193-.097-1.144-.564-1.32-.628-.178-.065-.308-.097-.438.097-.13.194-.503.629-.616.758-.113.13-.227.146-.42.049-.193-.097-.816-.301-1.554-.958-.574-.512-.962-1.144-1.075-1.34-.113-.193-.012-.298.085-.395.087-.087.193-.227.29-.34.097-.114.13-.194.193-.324.065-.13.033-.243-.016-.34-.049-.097-.438-1.056-.6-1.445-.158-.38-.32-.328-.438-.334-.114-.005-.243-.005-.373-.005a.71.71 0 00-.518.243c-.178.194-.68.665-.68 1.621 0 .957.697 1.88 7.93 2.19.114.162.308.26.551.26a4.877 4.877 0 001.621-2.481c.146-.438.146-.816.102-.892-.045-.076-.174-.122-.367-.219z" clip-rule="evenodd" />
                    </svg>
                    Hubungi via WhatsApp
                </a>
            </div>

            <!-- Kartu Info Ruangan -->
            <div class="rounded-2xl border border-slate-200/90 bg-slate-50 p-8 shadow-xs flex flex-col justify-center space-y-6 text-sm">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Lokasi Ruang UKS</h3>
                    <p class="font-semibold text-slate-900 text-base">SMKN 1 CIOMAS</p>
                    <p class="text-slate-500 mt-1">Siswa dapat langsung mendatangi ruangan jika masih kuat berjalan.</p>
                </div>
                <hr class="border-slate-200">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Jam Operasional UKS</h3>
                    <div class="space-y-1 text-slate-700 font-medium">
                        <div class="flex justify-between">
                            <span>Senin - Kamis</span>
                            <span>06:30 - 15:30 WIB</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Jumat</span>
                            <span>06:30 - 12:30 WIB</span>
                        </div>
                    </div>
                </div>
                <hr class="border-slate-200">
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Prosedur Jemput Darurat</h3>
                    <p class="text-slate-600">
                        Bagi teman atau guru: Jika ada siswa pingsan atau tidak bisa berjalan, kirim pesan WhatsApp dengan menyertakan <b>Nama, Kelas, dan Lokasi Siswa</b>. Petugas akan segera datang membawa perlengkapan pertolongan.
                    </p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
