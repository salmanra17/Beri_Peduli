@extends('layouts.app')

@section('content')

@php
    $progress = 0;

    if ($kampanye->target_dana > 0) {
        $progress = ($kampanye->dana_terkumpul / $kampanye->target_dana) * 100;
    }

    $progress = min($progress, 100);

    $hariLagi = $kampanye->isSelesai() ? 0 : max(0, ceil(now()->diffInHours($kampanye->batas_tanggal) / 24));

    $maskName = static function (string $name): string {
        $letters = preg_replace('/\s+/', '', trim($name));

        return mb_substr($letters, 0, 1).str_repeat('*', max(1, mb_strlen($letters) - 1));
    };
@endphp


{{-- NOTIFIKASI SUKSES DONASI --}}
@if(session('donasi_berhasil'))
<div id="notif-sukses"
     class="fixed inset-0 z-[100] flex items-center justify-center p-4"
     style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">

    <div id="notif-card"
         class="relative bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden"
         style="animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">

        {{-- TOP GRADIENT STRIP --}}
        <div class="h-2 bg-gradient-to-r from-[#134F4F] via-[#1d7a7a] to-[#D7A31B]"></div>

        <div class="px-8 pt-8 pb-2 text-center">

            {{-- IKON HATI BERDETAK --}}
            <div class="w-20 h-20 rounded-full bg-[#D8F0EC] flex items-center justify-center mx-auto mb-5"
                 style="animation: heartbeat 1.5s ease-in-out infinite;">
                <svg class="w-10 h-10 text-[#134F4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                          d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-900 mb-1">{{ __('Donasi Berhasil!') }}</h2>
            <p class="text-gray-500 text-sm mb-6">{{ __('Terima kasih atas kebaikan hatimu') }}</p>

            {{-- DETAIL DONASI --}}
            <div class="bg-[#F2FAF8] rounded-2xl p-5 mb-6 text-left space-y-3">

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ __('Jumlah Donasi') }}</span>
                    <span class="font-bold text-[#134F4F] text-lg">
                        Rp {{ number_format(session('donasi_jumlah'), 0, ',', '.') }}
                    </span>
                </div>

                <div class="border-t border-[#D8F0EC]"></div>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ __('Metode Pembayaran') }}</span>
                    <span class="font-semibold text-gray-800">{{ session('donasi_metode') }}</span>
                </div>

                <div class="border-t border-[#D8F0EC]"></div>

                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-500">{{ __('Donasi sebagai') }}</span>
                    <span class="font-semibold text-gray-800">
                        {{ session('donasi_anonim') ? $maskName(auth()->user()->name) : auth()->user()->name }}
                    </span>
                </div>

            </div>

            {{-- TOMBOL AKSI --}}
            <div class="space-y-3 pb-8">

                <button onclick="tutupNotif()"
                        class="w-full bg-[#134F4F] text-white font-bold py-3.5 rounded-xl hover:bg-[#0c4a3d] transition-colors">
                    {{ __('Lihat Kampanye') }}
                </button>

                <a href="{{ route('donasi.history') }}"
                   class="block w-full text-center text-[#134F4F] font-semibold py-3 rounded-xl border border-[#134F4F] hover:bg-[#F2FAF8] transition-colors text-sm">
                    {{ __('Lihat Riwayat Donasi') }}
                </a>

            </div>

        </div>

    </div>

</div>

<style>
@keyframes popIn {
    0%   { opacity: 0; transform: scale(0.7) translateY(30px); }
    100% { opacity: 1; transform: scale(1) translateY(0); }
}
@keyframes heartbeat {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.1); }
}
</style>

<script>
function tutupNotif() {
    const el = document.getElementById('notif-sukses');
    el.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
    el.style.opacity = '0';
    el.style.transform = 'scale(0.95)';
    setTimeout(() => el.remove(), 300);
}
// Auto-tutup setelah 10 detik
setTimeout(tutupNotif, 10000);
</script>
@endif


<main class="bg-[#f1f1f1] min-h-screen text-gray-900">

    <div class="max-w-[1320px] mx-auto px-4 lg:px-10 py-7">

        {{-- PEMBERITAHUAN KAMPANYE SELESAI --}}
        <x-flash-message class="mb-6" />

        <div class="mb-4">

            <h1 class="text-2xl md:text-3xl font-bold leading-tight max-w-4xl">
                {{ $kampanye->judul_tampil }}
            </h1>

        </div>



        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">


            {{-- LEFT --}}
            <div class="lg:col-span-2">


                @if($kampanye->gambar)

                    <img src="{{ asset('storage/' . $kampanye->gambar) }}"
                         class="w-full h-[220px] md:h-[380px] object-cover rounded-2xl mb-6">

                @endif



                {{-- PEMBUAT KAMPANYE --}}
                <div class="flex items-center gap-4 pb-6 border-b mb-4">

                    @php
                        $namaPenggalang = $kampanye->nama_lengkap ?: $kampanye->user->name;
                    @endphp

                    <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center font-bold text-[#134F4F]">

                        {{ strtoupper(substr($namaPenggalang, 0, 1)) }}

                    </div>



                    <div>

                        <p class="font-bold">
                            {{ $namaPenggalang }}
                        </p>


                        <p class="text-sm text-gray-500">
                            {{ __('Akun Penggalang Dana') }}
                        </p>

                    </div>


                </div>





                <section class="mb-6">

                    <h2 class="text-xl font-bold mb-0">
                        {{ __('Kronologi & Situasi Terkini') }}
                    </h2>


                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $kampanye->deskripsi_tampil }}
                    </p>


                </section>






                {{-- KOMENTAR --}}
                <section>


                    <div class="flex justify-between items-center mb-4">

                        <h2 class="text-xl font-bold">
                            {{ __('Doa & Dukungan') }}
                        </h2>

                    </div>




                    <div class="space-y-4">


                        @forelse($kampanye->komentars as $komentar)


                            <div class="bg-white rounded-2xl shadow-sm p-6">


                                <div class="flex gap-4">


                                    {{-- AVATAR --}}

                                    <div class="w-11 h-11 rounded-full bg-[#D8F0EC] flex items-center justify-center font-bold text-[#134F4F]">

                                        {{ strtoupper(substr($komentar->user->name, 0, 1)) }}

                                    </div>





                                    <div>


                                        <div class="flex items-center gap-2 flex-wrap">

                                        <p class="font-bold">

                                            @if($komentar->anonim)

                                                {{ $maskName($komentar->user->name) }}

                                            @else

                                                {{ $komentar->user->name }}

                                            @endif

                                        </p>

                                        @if($komentar->donasi)

                                            <span class="text-xs font-semibold bg-[#D8F0EC] text-[#134F4F] px-2.5 py-1 rounded-full">
                                                ♥ {{ __('Berdonasi Rp') }} {{ number_format($komentar->donasi->jumlah_donasi, 0, ',', '.') }}
                                            </span>

                                        @endif

                                    </div>



                                        <p class="text-gray-700 mt-2">

                                            {{ $komentar->pesan }}

                                        </p>




                                        <p class="text-sm text-gray-400 mt-2">

                                            {{ $komentar->created_at->diffForHumans() }}

                                        </p>


                                    </div>


                                </div>


                            </div>


                        @empty


                            <p>
                                {{ __('Belum ada doa dan dukungan.') }}
                            </p>


                        @endforelse


                    </div>


                </section>



            </div>






            {{-- RIGHT CARD DONASI --}}
            <aside>


                <div class="bg-white rounded-2xl shadow-sm p-6 sticky top-[70px]">



                    <p class="text-2xl font-bold text-[#134F4F]">

                        Rp {{ number_format($kampanye->dana_terkumpul, 0, ',', '.') }}

                    </p>



                    <p class="text-sm text-gray-500 mt-2">

                        {{ __('TERKUMPUL DARI TARGET') }}

                        <br>

                        Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}

                    </p>




                    <div class="flex items-center gap-3 mt-5">

                        <div class="flex-1 w-full h-2.5 bg-gray-200 rounded-full overflow-hidden">


                            <div class="h-2.5 bg-[#134F4F] rounded-full"
                                 style="width: {{ $progress }}%">
                            </div>


                        </div>

                        <span class="text-sm font-bold whitespace-nowrap {{ $kampanye->isSelesai() ? 'text-[#134F4F]' : 'text-[#D7A31B]' }}">
                            {{ number_format($progress, 0) }}%
                        </span>

                    </div>




                    <div class="flex justify-between mt-6 mb-8">


                        <div>

                            <p class="text-lg font-bold">

                                {{ $kampanye->donasis->count() }}

                            </p>


                            <p class="text-sm text-gray-500">

                                {{ __('Donatur') }}

                            </p>


                        </div>




                        <div class="text-right">


                            <p class="text-lg font-bold {{ $kampanye->isSelesai() ? 'text-[#134F4F]' : 'text-gray-900' }}">

                                {{ $kampanye->isSelesai() ? '✓' : $hariLagi }}

                            </p>


                            <p class="text-sm text-gray-500">

                                {{ $kampanye->isSelesai() ? __('Terkumpul') : __('Hari Lagi') }}

                            </p>


                        </div>


                    </div>




                    @if($kampanye->isSelesai())

                    <div class="w-full flex justify-center items-center bg-[#134F4F] text-white font-semibold py-4 rounded-xl">
                        {{ __('✓ Kampanye Selesai') }}
                    </div>

                @else

                    <a href="{{ route('donasi.create', $kampanye->id) }}"
                       class="w-full flex justify-center items-center bg-[#134F4F] text-white font-semibold py-4 rounded-xl hover:bg-[#0c4a3d]">

                        {{ __('Lanjut Donasi Sekarang ♡') }}

                    </a>

                @endif




                    <p class="text-center text-sm text-gray-500 mt-5">

                        {{ __('Dengan berdonasi, Anda setuju dengan') }}

                        <br>

                        {{ __('Syarat & Ketentuan BeriPeduli') }}

                    </p>



                </div>


            </aside>



        </div>


    </div>


</main>


@endsection