@extends('layouts.app', ['heading' => 'Catat Kunjungan'])

@section('content')
<script>
    window.location.href = "{{ route('kunjungan.index') }}";
</script>
<div class="p-8 text-center text-slate-500">
    <p class="text-sm">Mengalihkan ke Data Siswa yang Berkunjung...</p>
    <a href="{{ route('kunjungan.index') }}" class="text-teal-700 underline font-semibold mt-2 inline-block text-xs">Klik di sini jika tidak beralih otomatis</a>
</div>
@endsection