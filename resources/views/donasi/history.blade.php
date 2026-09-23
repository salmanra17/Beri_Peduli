@extends('layouts.dashboard')

@section('title', __('Riwayat Donasi'))

@section('content')

    <main class="flex-1 min-w-0 bg-[#F1F1F1]">

        <div class="max-w-[1100px] mx-auto px-6 lg:px-8 pt-9 pb-24">

            {{-- ── HEADER ── --}}
            <header class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] leading-tight">
                        {{ __('Riwayat Donasi Lengkap') }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">
                        {{ __('Kelola dan pantau seluruh kontribusi kebaikan Anda di sini.') }}
                    </p>
                </div>

                {{-- Unduh Rekap CSV --}}
                <a href="{{ route('donasi.download') }}"
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold shadow-xs transition-colors">
                    <svg class="w-3.5 h-3.5 text-[#135B59]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    <span>{{ __('Unduh Rekap Laporan') }}</span>
                </a>
            </header>


            {{-- ── FILTER CARD ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-5">
                <form method="GET" action="{{ route('donasi.history') }}" id="form-filter">
                    <div class="flex flex-col sm:flex-row gap-4 items-end">

                        {{-- Cari Campaign --}}
                        <div class="flex-1">
                            <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">
                                {{ __('Cari Campaign') }}
                            </label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                    </svg>
                                </span>
                                <input type="text"
                                       name="cari"
                                       id="input-cari"
                                       value="{{ request('cari') }}"
                                       placeholder="{{ __('Masukkan nama kampanye...') }}"
                                       class="w-full h-[46px] pl-10 pr-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none">
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="w-full sm:w-56">
                            <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">
                                {{ __('Status') }}
                            </label>
                            <select name="status"
                                    id="select-status"
                                    class="w-full h-[46px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none appearance-none">
                                <option value="semua" {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>{{ __('Semua Status') }}</option>
                                <option value="berhasil"  {{ request('status') === 'berhasil'  ? 'selected' : '' }}>{{ __('Berhasil') }}</option>
                                <option value="menunggu"  {{ in_array(request('status'), ['menunggu', 'pending']) ? 'selected' : '' }}>{{ __('Menunggu') }}</option>
                                <option value="gagal"     {{ request('status') === 'gagal'     ? 'selected' : '' }}>{{ __('Gagal') }}</option>
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div>
<button type="submit"
                                    class="inline-flex items-center gap-2 h-[46px] px-6 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white text-sm font-semibold transition-colors shadow-sm whitespace-nowrap cursor-pointer">
                                    {{ __('Terapkan Filter') }}
                                </button>
                        </div>

                    </div>
                </form>
            </div>


            {{-- ── TABEL RIWAYAT DONASI ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">

                {{-- Header kolom --}}
                <div class="grid grid-cols-[160px_1fr_160px_140px_64px] gap-0 px-6 py-3.5 border-b border-gray-100 bg-[#FAFAFA]">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Tanggal') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Nama Campaign') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Nominal') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Status') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider text-right">{{ __('Struk') }}</span>
                </div>

                {{-- Baris data --}}
                @forelse ($donasis as $donasi)
                    <div class="grid grid-cols-[160px_1fr_160px_140px_64px] gap-0 px-6 py-4 border-b border-gray-50 hover:bg-[#FAFFF9] transition-colors items-center
                        @if ($loop->last) border-b-0 @endif">

                        {{-- Tanggal --}}
                        <span class="text-sm text-gray-500">
                            {{ $donasi->created_at->translatedFormat('d M Y') }}
                        </span>

                        {{-- Nama Campaign --}}
                        <span class="text-sm font-semibold text-[#135B59] pr-4 truncate" title="{{ $donasi->kampanye->judul ?? '—' }}">
                            {{ $donasi->kampanye->judul ?? '—' }}
                        </span>

                        {{-- Nominal --}}
                        <span class="text-sm font-bold text-gray-800">
                            Rp {{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}
                        </span>

                        {{-- Status badge --}}
                        <div>
                            @if ($donasi->status_pembayaran === 'berhasil')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold bg-[#EAF3F2] text-[#135B59] border border-[#C5DDD9]">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('BERHASIL') }}
                                </span>
                            @elseif ($donasi->status_pembayaran === 'menunggu' || $donasi->status_pembayaran === 'pending')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('MENUNGGU') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold bg-red-50 text-red-600 border border-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('GAGAL') }}
                                </span>
                            @endif
                        </div>

                        {{-- Aksi: Buka Pop-up Struk Bukti Donasi --}}
                        <div class="flex justify-end">
                            @php
                                $strukData = [
                                    'id' => $donasi->id,
                                    'kode' => 'BP-DON-' . str_pad($donasi->id, 6, '0', STR_PAD_LEFT),
                                    'tanggal' => $donasi->created_at->translatedFormat('d F Y, H:i') . ' WIB',
                                    'kampanye_judul' => $donasi->kampanye->judul ?? '—',
                                    'jumlah' => 'Rp ' . number_format($donasi->jumlah_donasi, 0, ',', '.'),
                                    'metode' => $donasi->metode_pembayaran ?: 'Transfer Bank',
                                    'status' => $donasi->status_pembayaran,
                                    'nama_donatur' => $donasi->anonim ? __('Hamba Allah (Anonim)') : ($donasi->user->name ?? $user->name),
                                    'pesan' => $donasi->pesan ?: null,
                                ];
                            @endphp
                            <button type="button"
                               onclick='openStrukModal(@json($strukData))'
                               title="{{ __('Lihat Struk Bukti Donasi') }}"
                               class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-[#135B59] hover:bg-[#E4EEEE] transition-colors cursor-pointer">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                </svg>
                            </button>
                        </div>

                    </div>
                @empty
                    <div class="py-20 flex flex-col items-center justify-center gap-3 text-gray-400">
                        <svg class="w-14 h-14 opacity-30" fill="none" viewBox="0 0 24 24" stroke-width="1.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25Z"/>
                        </svg>
                        <p class="font-semibold text-base">{{ __('Belum ada riwayat donasi') }}</p>
                        <p class="text-sm">
                            @if(request('cari') || (request('status') && request('status') !== 'semua'))
                                {{ __('Tidak ada hasil untuk filter ini.') }}
                                <a href="{{ route('donasi.history') }}" class="text-[#135B59] hover:underline font-semibold">{{ __('Reset filter') }}</a>
                            @else
                                {{ __('Mulai berdonasi untuk melihat riwayat di sini.') }}
                            @endif
                        </p>
                    </div>
                @endforelse

                {{-- Footer tabel: info + pagination --}}
                @if ($donasis->total() > 0)
                    <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">

                        <p class="text-sm text-gray-400">
                            {{ __('Menampilkan') }} {{ $donasis->firstItem() }}–{{ $donasis->lastItem() }} {{ __('dari') }} {{ $donasis->total() }} {{ __('transaksi') }}
                        </p>

                        {{-- Pagination custom --}}
                        <div class="flex items-center gap-1">

                            {{-- Prev --}}
                            @if ($donasis->onFirstPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $donasis->previousPageUrl() }}"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                    </svg>
                                </a>
                            @endif

                            {{-- Halaman --}}
                            @foreach ($donasis->getUrlRange(1, $donasis->lastPage()) as $page => $url)
                                @if ($page === $donasis->currentPage())
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#135B59] text-white text-sm font-bold">
                                        {{ $page }}
                                    </span>
                                @elseif ($page === 1 || $page === $donasis->lastPage() || abs($page - $donasis->currentPage()) <= 1)
                                    <a href="{{ $url }}"
                                       class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                        {{ $page }}
                                    </a>
                                @elseif (abs($page - $donasis->currentPage()) === 2)
                                    <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                                @endif
                            @endforeach

                            {{-- Next --}}
                            @if ($donasis->hasMorePages())
                                <a href="{{ $donasis->nextPageUrl() }}"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </a>
                            @else
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                    </svg>
                                </span>
                            @endif

                        </div>

                    </div>
                @endif

            </div>


            {{-- ── SUMMARY CARDS ── --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">

                {{-- Total Donasi Terkumpul --}}
                <div class="bg-[#135B59] rounded-2xl px-6 py-6 text-white shadow-sm">
                    <p class="text-sm font-medium text-[#A8D5D3] mb-2">
                        {{ __('Total Donasi Terkumpul') }}
                    </p>
                    <p class="text-[28px] font-bold leading-tight tracking-tight">
                        Rp {{ number_format($totalDana, 0, ',', '.') }}
                    </p>
                    <p class="mt-2 text-xs text-[#A8D5D3]">
                        {{ __('Akumulasi dari') }} {{ $donasis->total() }} {{ __('aksi kebaikan') }}
                    </p>
                </div>

                {{-- Impact Sosial --}}
                <div class="bg-white rounded-2xl px-6 py-6 shadow-sm border border-gray-100">
                    <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">
                        {{ __('Impact Sosial') }}
                    </p>
                    <div class="flex items-center gap-3">
                        <span class="w-11 h-11 rounded-full bg-[#E4EEEE] flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6 text-[#135B59]" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                            </svg>
                        </span>
                        <div>
                            <p class="text-[26px] font-bold text-gray-900 leading-tight">
                                {{ $totalKampanye }} {{ __('Campaign') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">{{ __('Berhasil didanai') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Unduh Laporan --}}
                <div class="bg-white rounded-2xl px-6 py-6 shadow-sm border border-gray-100 flex flex-col items-center justify-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-[#E4EEEE] flex items-center justify-center">
                        <svg class="w-6 h-6 text-[#135B59]" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                        </svg>
                    </div>
                    <a href="{{ route('donasi.download') }}"
                       class="text-sm font-bold text-[#135B59] hover:underline text-center">
                        {{ __('Unduh Laporan Riwayat') }}
                    </a>
                    <p class="text-xs text-gray-400 text-center -mt-1">Format CSV · Excel-compatible</p>
                </div>

            </div>

        </div>

    </main>
    {{-- ==================== MODAL STRUK BUKTI DONASI ==================== --}}
    <div id="modal-struk-donasi"
         class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
         role="dialog" aria-modal="true" aria-labelledby="modal-struk-title">

        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/40 backdrop-blur-sm" onclick="closeStrukModal()"></div>

        {{-- Receipt Card Container: Lebar Full (max-w-md), Terlihat Penuh & Tidak Terpotong --}}
        <div class="relative w-full max-w-md bg-white rounded-2xl sm:rounded-3xl shadow-2xl overflow-hidden z-10 my-auto max-h-[calc(100vh-2.5rem)] flex flex-col min-h-0 animate-in fade-in zoom-in-95 duration-150">

            {{-- Area yang akan dicetak / tampil sebagai struk --}}
            <div id="struk-printable-area" class="px-6 py-4 sm:px-7 sm:py-5 overflow-y-auto flex-1 min-h-0">

                {{-- Header Struk --}}
                <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                    <div class="flex items-center gap-2">
                        <img src="{{ asset('images/logo.png') }}" alt="BeriPeduli" class="h-6 w-auto object-contain">
                    </div>
                    <button type="button"
                            onclick="closeStrukModal()"
                            class="no-print w-7 h-7 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Bagian Nominal & Status --}}
                <div class="text-center pt-3 pb-2.5">
                    {{-- Status Icon --}}
                    <div id="struk-status-icon" class="w-10 h-10 rounded-full bg-[#135B59] text-white flex items-center justify-center mx-auto mb-1.5 shadow-sm shadow-[#135B59]/20">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                        </svg>
                    </div>

                    <p id="struk-status-sub" class="text-xs font-bold uppercase tracking-wider text-[#135B59] mb-0.5">
                        {{ __('Donasi Berhasil') }}
                    </p>

                    <h2 id="struk-jumlah" class="text-2xl sm:text-[28px] font-black text-gray-900 tracking-tight leading-tight mb-0.5">
                        Rp 0
                    </h2>

                    <p id="struk-tanggal" class="text-[11px] text-gray-400 font-medium">
                        -
                    </p>
                </div>

                {{-- Garis Sobekan Struk (Dashed Tear Line Bersih) --}}
                <div class="border-t border-dashed border-gray-200 my-2"></div>

                {{-- Rincian Transaksi --}}
                <div class="space-y-2 py-1 text-xs sm:text-[13px]">

                    {{-- No Referensi --}}
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">{{ __('No. Referensi') }}</span>
                        <span id="struk-kode" class="font-mono font-bold text-gray-700">-</span>
                    </div>

                    {{-- Program Kampanye --}}
                    <div class="flex items-start justify-between gap-3">
                        <span class="text-gray-400 font-medium flex-shrink-0">{{ __('Kampanye') }}</span>
                        <span id="struk-kampanye" class="font-bold text-gray-900 text-right leading-snug truncate max-w-[230px]">-</span>
                    </div>

                    {{-- Nama Donatur --}}
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">{{ __('Nama Donatur') }}</span>
                        <span id="struk-donatur" class="font-bold text-gray-800">-</span>
                    </div>

                    {{-- Metode Pembayaran --}}
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">{{ __('Metode Pembayaran') }}</span>
                        <span id="struk-metode" class="font-bold text-gray-800 uppercase">-</span>
                    </div>

                    {{-- Status Transaksi --}}
                    <div class="flex items-center justify-between">
                        <span class="text-gray-400 font-medium">{{ __('Status') }}</span>
                        <span id="struk-status-badge" class="px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-[#EAF3F2] text-[#135B59] border border-[#C5DDD9]">
                            {{ __('BERHASIL') }}
                        </span>
                    </div>

                    {{-- Doa / Pesan (Opsional) --}}
                    <div id="struk-pesan-wrapper" class="pt-1">
                        <div class="p-2.5 bg-[#EAF3F2] rounded-xl border border-[#D5E8E5] text-gray-700">
                            <p class="text-[10px] font-bold text-[#135B59] uppercase tracking-wider mb-0.5 flex items-center gap-1.5">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 0 1-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z"/>
                                </svg>
                                {{ __('Doa / Pesan Kebaikan') }}
                            </p>
                            <p id="struk-pesan" class="text-xs italic leading-relaxed text-gray-800">
                                -
                            </p>
                        </div>
                    </div>

                </div>

                {{-- Catatan Pengesahan --}}
                <div class="mt-2.5 pt-2 border-t border-gray-100 text-center">
                    <p class="text-[10.5px] text-gray-400 leading-relaxed">
                        {{ __('Tanda terima ini merupakan bukti sah donasi yang disalurkan melalui platform') }} <strong>BeriPeduli</strong>. {{ __('Terima kasih atas kepedulian Anda.') }}
                    </p>
                </div>

            </div>

            {{-- Tombol Aksi di Bawah Struk (Cetak & Tutup) --}}
            <div class="no-print p-4 sm:px-6 bg-gray-50 border-t border-gray-100 flex items-center gap-3 flex-shrink-0">
                <button type="button"
                        onclick="closeStrukModal()"
                        class="flex-1 py-2 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-100 text-sm font-semibold text-gray-700 transition cursor-pointer">
                    {{ __('Tutup') }}
                </button>
                <button type="button"
                        onclick="cetakStruk()"
                        class="flex-1 py-2 px-4 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white text-sm font-semibold shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                    </svg>
                    <span>{{ __('Cetak Struk') }}</span>
                </button>
            </div>

        </div>

    </div>

    {{-- STYLE KHUSUS PRINT CETAK STRUK (PASTI TEPAT 1 HALAMAN) --}}
    <style>
        @media print {
            @page {
                size: A5 portrait;
                margin: 8mm;
            }
            html, body {
                background: white !important;
                height: auto !important;
                min-height: 0 !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
            }
            /* Sembunyikan semua elemen layout utama */
            aside, main, nav, header, footer {
                display: none !important;
            }
            /* Semua wrapper layout */
            body > *:not(#modal-struk-donasi),
            .min-h-screen, .flex-1 {
                display: none !important;
            }
            /* Tampilkan modal struk */
            #modal-struk-donasi {
                display: block !important;
                position: static !important;
                padding: 0 !important;
                margin: 0 auto !important;
                width: 100% !important;
                height: auto !important;
                background: transparent !important;
                box-shadow: none !important;
                overflow: visible !important;
                inset: unset !important;
            }
            /* Sembunyikan backdrop */
            #modal-struk-donasi > div:first-child {
                display: none !important;
            }
            /* Sembunyikan tombol aksi */
            .no-print {
                display: none !important;
            }
            /* Card struk utama — hapus semua constraint tinggi */
            #modal-struk-donasi .relative {
                position: static !important;
                display: block !important;
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                border-radius: 16px !important;
                margin: 0 auto !important;
                width: 100% !important;
                max-width: 100% !important;
                max-height: none !important;
                height: auto !important;
                min-height: 0 !important;
                overflow: visible !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                flex-direction: column !important;
            }
            /* Area konten struk */
            #struk-printable-area {
                padding: 20px 24px !important;
                overflow: visible !important;
                max-height: none !important;
                height: auto !important;
                flex: none !important;
                page-break-inside: avoid !important;
                break-inside: avoid !important;
            }
        }
    </style>

    {{-- SCRIPT INTERAKTIF STRUK DONASI --}}
    <script>
        const modalStruk = document.getElementById('modal-struk-donasi');

        function openStrukModal(data) {
            if (!modalStruk) return;

            // Isi Data ke Elemen Struk
            document.getElementById('struk-kode').textContent = data.kode || '-';
            document.getElementById('struk-kampanye').textContent = data.kampanye_judul || '-';
            document.getElementById('struk-donatur').textContent = data.nama_donatur || '-';
            document.getElementById('struk-metode').textContent = data.metode || '-';
            document.getElementById('struk-jumlah').textContent = data.jumlah || 'Rp 0';
            document.getElementById('struk-tanggal').textContent = data.tanggal || '-';

            // Status Badge & Styling
            const badgeEl = document.getElementById('struk-status-badge');
            const subTitleEl = document.getElementById('struk-status-sub');
            const iconWrapEl = document.getElementById('struk-status-icon');

            if (data.status === 'berhasil') {
                badgeEl.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-[#EAF3F2] text-[#135B59] border border-[#C5DDD9]';
                badgeEl.textContent = @js(__('BERHASIL'));
                subTitleEl.textContent = @js(__('Donasi Berhasil Disalurkan'));
                subTitleEl.className = 'text-xs font-bold uppercase tracking-wider text-[#135B59] mb-1';
                iconWrapEl.className = 'w-12 h-12 rounded-full bg-[#135B59] text-white flex items-center justify-center mx-auto mb-2.5 shadow-md shadow-[#135B59]/20';
                iconWrapEl.innerHTML = '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>';
            } else if (data.status === 'menunggu' || data.status === 'pending') {
                badgeEl.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-amber-50 text-amber-700 border border-amber-200';
                badgeEl.textContent = @js(__('MENUNGGU'));
                subTitleEl.textContent = @js(__('Menunggu Pembayaran'));
                subTitleEl.className = 'text-xs font-bold uppercase tracking-wider text-amber-600 mb-1';
                iconWrapEl.className = 'w-12 h-12 rounded-full bg-amber-500 text-white flex items-center justify-center mx-auto mb-2.5 shadow-md shadow-amber-500/20';
                iconWrapEl.innerHTML = '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>';
            } else {
                badgeEl.className = 'px-2.5 py-0.5 rounded-full text-xs font-bold uppercase bg-red-50 text-red-600 border border-red-200';
                badgeEl.textContent = @js(__('GAGAL'));
                subTitleEl.textContent = @js(__('Transaksi Dibatalkan / Gagal'));
                subTitleEl.className = 'text-xs font-bold uppercase tracking-wider text-red-600 mb-1';
                iconWrapEl.className = 'w-12 h-12 rounded-full bg-red-500 text-white flex items-center justify-center mx-auto mb-2.5 shadow-md shadow-red-500/20';
                iconWrapEl.innerHTML = '<svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>';
            }

            // Pesan / Doa
            const pesanWrapper = document.getElementById('struk-pesan-wrapper');
            const pesanEl = document.getElementById('struk-pesan');
            if (data.pesan && data.pesan.trim() !== '') {
                pesanEl.textContent = '"' + data.pesan + '"';
                pesanWrapper.classList.remove('hidden');
            } else {
                pesanWrapper.classList.add('hidden');
            }

            // Buka Modal (Flex center)
            modalStruk.classList.remove('hidden');
            modalStruk.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeStrukModal() {
            if (!modalStruk) return;
            modalStruk.classList.add('hidden');
            modalStruk.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function cetakStruk() {
            // Pastikan body overflow di-reset agar print engine dapat merender full height
            const prevOverflow = document.body.style.overflow;
            document.body.style.overflow = 'visible';
            window.print();
            // Kembalikan overflow setelah dialog print ditutup
            document.body.style.overflow = prevOverflow || 'hidden';
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && modalStruk && !modalStruk.classList.contains('hidden')) {
                closeStrukModal();
            }
        });
    </script>

@endsection