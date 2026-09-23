@extends('layouts.dashboard')

@section('title', __('Bukti Penyaluran Dana'))

@section('content')

    <main class="flex-1 min-w-0 bg-[#F1F1F1]">
        <div class="max-w-[1100px] mx-auto px-6 lg:px-8 pt-9 pb-24">

            {{-- ══════════════════════ HEADER ══════════════════════ --}}
            <header class="mb-6 flex flex-wrap items-start justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-[#E4EEEE] text-[#135B59] text-[10px] font-bold uppercase tracking-wider">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                            </svg>
                            {{ __('Transparansi Dana') }}
                        </span>
                    </div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] leading-tight">
                        {{ __('Bukti Penyaluran Dana') }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500 max-w-xl">
                        {{ __('Unggah dokumentasi penggunaan dana sebagai bentuk pertanggungjawaban kepada donatur dan tim BeriPeduli.') }}
                    </p>
                </div>
            </header>

            {{-- ══════════════════════ FLASH MESSAGES ══════════════════════ --}}
            <x-flash-message class="mb-5" />

            {{-- ══════════════════════ SUMMARY CARDS ══════════════════════ --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 mb-6">

                {{-- Card 1: Total Dana Tersalurkan --}}
                <div class="relative bg-gradient-to-br from-[#135B59] to-[#0d4240] rounded-2xl px-6 py-5 text-white shadow-sm overflow-hidden flex flex-col justify-center">
                    <div class="absolute -right-4 -top-4 w-24 h-24 rounded-full bg-white/5"></div>
                    <div class="absolute -right-2 bottom-0 w-16 h-16 rounded-full bg-white/5"></div>
                    <div class="relative">
                        <p class="text-[11px] font-bold text-[#A8D5D3] uppercase tracking-wider mb-3">{{ __('Total Dana Tersalurkan') }}</p>
                        <p class="text-[26px] font-black leading-tight tracking-tight">
                            Rp {{ number_format($totalDanaTersalurkan, 0, ',', '.') }}
                        </p>
                        <p class="mt-2 text-xs text-[#A8D5D3]">{{ __('dari') }} {{ $totalPenarikanBerhasil }} {{ __('pencairan berhasil') }}</p>
                    </div>
                </div>

                {{-- Card 2: Belum Dilaporkan --}}
                <div class="bg-white rounded-2xl px-6 py-5 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-3">
                        <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('Menunggu Laporan') }}</p>
                        @if($jumlahBelumDilaporkan > 0)
                            <span class="w-2 h-2 rounded-full bg-red-400 animate-pulse"></span>
                        @endif
                    </div>
                    <div class="flex items-end gap-2">
                        <p class="text-[26px] font-black text-gray-900 leading-tight">{{ $jumlahBelumDilaporkan }}</p>
                        <p class="text-sm text-gray-400 mb-0.5">{{ __('Pencairan') }}</p>
                    </div>
                    @if($jumlahBelumDilaporkan > 0)
                        <p class="mt-2 text-xs font-semibold text-red-500">{{ __('Perlu segera dilaporkan') }}</p>
                    @else
                        <p class="mt-2 text-xs text-gray-400">{{ __('Semua sudah dilaporkan ✓') }}</p>
                    @endif
                </div>

                {{-- Card 3: Terverifikasi vs Menunggu Review --}}
                <div class="bg-white rounded-2xl px-6 py-5 shadow-sm border border-gray-100">
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-3">{{ __('Status Laporan') }}</p>
                    <div class="space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                <span class="text-xs text-gray-600">{{ __('Terverifikasi') }}</span>
                            </div>
                            <span class="text-sm font-bold text-emerald-700">{{ $jumlahTerverifikasi }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-amber-400"></span>
                                <span class="text-xs text-gray-600">{{ __('Menunggu Review') }}</span>
                            </div>
                            <span class="text-sm font-bold text-amber-700">{{ $jumlahMenungguReview }}</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1.5">
                                <span class="w-2 h-2 rounded-full bg-gray-300"></span>
                                <span class="text-xs text-gray-600">{{ __('Belum Dilaporkan') }}</span>
                            </div>
                            <span class="text-sm font-bold text-gray-600">{{ $jumlahBelumDilaporkan }}</span>
                        </div>
                    </div>
                </div>

            </div>

            {{-- ══════════════════════ INFO BANNER (jika ada yg belum lapor) ══════════════════════ --}}
            @if($jumlahBelumDilaporkan > 0)
                <div class="mb-5 flex items-start gap-4 bg-amber-50 border border-amber-200 rounded-2xl px-5 py-4">
                    <div class="w-9 h-9 rounded-xl bg-amber-100 flex items-center justify-center flex-shrink-0 text-amber-600">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-amber-800">{{ __('Ada') }} {{ $jumlahBelumDilaporkan }} {{ __('pencairan yang belum dilaporkan') }}</p>
                        <p class="text-xs text-amber-700 mt-0.5">{{ __('Unggah bukti penyaluran untuk setiap pencairan yang berhasil diterima. Laporan diperlukan sebagai bentuk transparansi kepada donatur.') }}</p>
                    </div>
                </div>
            @endif

            {{-- ══════════════════════ FILTER BAR ══════════════════════ --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-5">
                <form method="GET" action="{{ route('bukti-penyaluran.index') }}" id="form-filter">
                    <div class="flex flex-col sm:flex-row gap-4 items-end">

                        {{-- Cari --}}
                        <div class="flex-1">
                            <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">{{ __('Cari Kampanye') }}</label>
                            <div class="relative">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                                    </svg>
                                </span>
                                <input type="text" name="cari" id="input-cari" value="{{ request('cari') }}"
                                       placeholder="{{ __('Cari nama kampanye atau kode transaksi...') }}"
                                       class="w-full h-[46px] pl-10 pr-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none">
                            </div>
                        </div>

                        {{-- Filter Status Laporan --}}
                        <div class="w-full sm:w-56">
                            <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">{{ __('Status Laporan') }}</label>
                            <select name="status_laporan" id="select-status"
                                    class="w-full h-[46px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none appearance-none cursor-pointer">
                                <option value="semua" {{ request('status_laporan', 'semua') === 'semua' ? 'selected' : '' }}>{{ __('Semua Status') }}</option>
                                <option value="belum" {{ request('status_laporan') === 'belum' ? 'selected' : '' }}>{{ __('Belum Dilaporkan') }}</option>
                                <option value="menunggu" {{ request('status_laporan') === 'menunggu' ? 'selected' : '' }}>{{ __('Menunggu Review') }}</option>
                                <option value="disetujui" {{ request('status_laporan') === 'disetujui' ? 'selected' : '' }}>{{ __('Terverifikasi') }}</option>
                                <option value="ditolak" {{ request('status_laporan') === 'ditolak' ? 'selected' : '' }}>{{ __('Ditolak') }}</option>
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div>
                            <button type="submit"
                                    class="inline-flex items-center gap-2 h-[46px] px-6 rounded-xl bg-[#135B59] hover:bg-[#0e4846] text-white text-sm font-semibold transition-colors shadow-sm whitespace-nowrap cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                                </svg>
                                {{ __('Terapkan Filter') }}
                            </button>
                        </div>

                    </div>
                </form>
            </div>

            {{-- ══════════════════════ DAFTAR PENARIKAN ══════════════════════ --}}
            <div class="space-y-3 mb-6">

                @forelse($penarikans as $item)
                    @php
                        $bukti = $item->buktiPenyaluran;
                        $statusLaporan = $bukti ? $bukti->status : 'belum';
                    @endphp

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow duration-200">

                        {{-- Strip aksen warna kiri berdasarkan status --}}
                        <div class="flex">
                            <div class="w-1 flex-shrink-0 rounded-l-2xl
                                @if($statusLaporan === 'belum') bg-red-400
                                @elseif($statusLaporan === 'menunggu') bg-amber-400
                                @elseif($statusLaporan === 'disetujui') bg-emerald-400
                                @else bg-gray-300
                                @endif">
                            </div>

                            <div class="flex-1 px-5 py-4">
                                <div class="flex flex-wrap items-start justify-between gap-3">

                                    {{-- Info Kiri --}}
                                    <div class="flex items-start gap-3.5 min-w-0">

                                        {{-- Ikon Kampanye --}}
                                        <div class="w-10 h-10 rounded-xl bg-[#E4EEEE] flex items-center justify-center flex-shrink-0 mt-0.5">
                                            <svg class="w-5 h-5 text-[#135B59]" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>
                                            </svg>
                                        </div>

                                        <div class="min-w-0">
                                            {{-- Badge Status Laporan --}}
                                            <div class="mb-1.5">
                                                @if($statusLaporan === 'belum')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-red-50 text-red-600 border border-red-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span>
                                                        {{ __('Perlu Dilaporkan') }}
                                                    </span>
                                                @elseif($statusLaporan === 'menunggu')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                                        {{ __('Menunggu Review') }}
                                                    </span>
                                                @elseif($statusLaporan === 'disetujui')
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/></svg>
                                                        {{ __('Terverifikasi') }}
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-[11px] font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                                        <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                        {{ __('Ditolak') }}
                                                    </span>
                                                @endif
                                            </div>

                                            {{-- Judul Kampanye --}}
                                            <h3 class="text-sm font-bold text-gray-900 leading-snug truncate max-w-[400px]">
                                                {{ $item->kampanye->judul ?? __('Kampanye Dihapus') }}
                                            </h3>

                                            {{-- Meta Info --}}
                                            <div class="flex flex-wrap items-center gap-x-3 gap-y-0.5 mt-1">
                                                <span class="text-xs text-gray-400 font-mono">{{ $item->kode_transaksi }}</span>
                                                <span class="text-gray-200">·</span>
                                                <span class="text-xs text-gray-400">
                                                    {{ __('Cair:') }} {{ \Carbon\Carbon::parse($item->disetujui_pada ?? $item->created_at)->translatedFormat('d M Y') }}
                                                </span>
                                                <span class="text-gray-200">·</span>
                                                <span class="text-xs font-bold text-[#135B59]">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</span>
                                            </div>

                                            {{-- Catatan admin jika ditolak --}}
                                            @if($statusLaporan === 'ditolak' && $bukti?->catatan_admin)
                                                <div class="mt-2 px-3 py-2 rounded-xl bg-red-50 border border-red-100">
                                                    <p class="text-[11px] font-bold text-red-700 mb-0.5">{{ __('Catatan Tim BeriPeduli:') }}</p>
                                                    <p class="text-xs text-red-600">{{ $bukti->catatan_admin }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    {{-- Tombol Aksi Kanan --}}
                                    <div class="flex items-center gap-2 flex-shrink-0">
                                        @if($statusLaporan === 'belum' || $statusLaporan === 'ditolak')
                                            <button type="button"
                                                    id="btn-upload-{{ $item->id }}"
                                                    class="js-btn-upload inline-flex items-center gap-2 px-4 py-2 rounded-xl
                                                        {{ $statusLaporan === 'ditolak' ? 'bg-red-600 hover:bg-red-700' : 'bg-[#135B59] hover:bg-[#0e4846]' }}
                                                        text-white text-xs font-semibold transition shadow-sm cursor-pointer"
                                                    data-id="{{ $item->id }}"
                                                    data-kode="{{ $item->kode_transaksi }}"
                                                    data-judul="{{ $item->kampanye->judul ?? __('Kampanye Dihapus') }}"
                                                    data-jumlah="Rp {{ number_format($item->jumlah, 0, ',', '.') }}"
                                                    data-is-revisi="{{ $statusLaporan === 'ditolak' ? '1' : '0' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                                </svg>
                                                {{ $statusLaporan === 'ditolak' ? __('Unggah Ulang') : __('Unggah Bukti') }}
                                            </button>
                                        @else
                                            <button type="button"
                                                    class="js-btn-lihat inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-gray-200 hover:bg-gray-50 text-gray-700 text-xs font-semibold transition cursor-pointer"
                                                    data-kode="{{ $item->kode_transaksi }}"
                                                    data-judul="{{ $item->kampanye->judul ?? __('Kampanye Dihapus') }}"
                                                    data-jumlah="Rp {{ number_format($item->jumlah, 0, ',', '.') }}"
                                                    data-deskripsi="{{ $bukti?->deskripsi ?? '' }}"
                                                    data-foto-bukti-url="{{ $bukti ? asset('storage/' . $bukti->foto_bukti) : '' }}"
                                                    data-is-pdf="{{ $bukti && str_ends_with(strtolower($bukti->foto_bukti ?? ''), '.pdf') ? '1' : '0' }}"
                                                    data-status="{{ $bukti?->status ?? 'menunggu' }}"
                                                    data-tanggal-upload="{{ $bukti ? \Carbon\Carbon::parse($bukti->created_at)->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}"
                                                    data-catatan-admin="{{ $bukti?->catatan_admin ?? '' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                                </svg>
                                                {{ __('Lihat Laporan') }}
                                            </button>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                @empty
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 flex flex-col items-center justify-center gap-3 text-gray-400">
                        <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-base text-gray-600">{{ __('Belum ada pencairan dana yang berhasil') }}</p>
                        <p class="text-sm text-center max-w-sm">
                            @if(request('cari') || (request('status_laporan') && request('status_laporan') !== 'semua'))
                                {{ __('Tidak ada data untuk filter ini.') }}
                                <a href="{{ route('bukti-penyaluran.index') }}" class="text-[#135B59] hover:underline font-semibold">{{ __('Reset filter') }}</a>
                            @else
                                {{ __('Halaman ini menampilkan pencairan berstatus berhasil. Ajukan penarikan dana terlebih dahulu.') }}
                            @endif
                        </p>
                    </div>
                @endforelse

            </div>

            {{-- ══════════════════════ PAGINATION ══════════════════════ --}}
            @if($penarikans->total() > 0)
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-2 mb-8 px-1">
                    <p class="text-xs text-gray-500">
                        {{ __('Menampilkan') }} {{ $penarikans->firstItem() }}–{{ $penarikans->lastItem() }} {{ __('dari') }} {{ $penarikans->total() }} {{ __('pencairan') }}
                    </p>
                    @if($penarikans->hasPages())
                        <nav class="flex items-center gap-1.5" aria-label="Pagination">
                            @if($penarikans->onFirstPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                                </span>
                            @else
                                <a href="{{ $penarikans->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                                </a>
                            @endif
                            @foreach($penarikans->getUrlRange(1, $penarikans->lastPage()) as $page => $url)
                                @if($page === $penarikans->currentPage())
                                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#135B59] text-white text-sm font-bold">{{ $page }}</span>
                                @elseif($page === 1 || $page === $penarikans->lastPage() || abs($page - $penarikans->currentPage()) <= 1)
                                    <a href="{{ $url }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">{{ $page }}</a>
                                @elseif(abs($page - $penarikans->currentPage()) === 2)
                                    <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                                @endif
                            @endforeach
                            @if($penarikans->hasMorePages())
                                <a href="{{ $penarikans->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                                </a>
                            @else
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/></svg>
                                </span>
                            @endif
                        </nav>
                    @endif
                </div>
            @endif

        </div>
    </main>

    {{-- ══════════════════════════════════════════════════════════════════
         MODAL 1: UNGGAH BUKTI PENYALURAN
    ══════════════════════════════════════════════════════════════════ --}}
    <div id="modal-upload" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
         role="dialog" aria-modal="true" aria-labelledby="modal-upload-title">

        {{-- Backdrop --}}
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeUploadModal()"></div>

        {{-- Card --}}
        <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden z-10 my-auto animate-in fade-in zoom-in-95 duration-150">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between">
                <div>
                    <h3 id="modal-upload-title" class="text-base font-semibold text-gray-800">{{ __('Unggah Bukti Penyaluran') }}</h3>
                    <p id="modal-upload-subtitle" class="text-xs text-gray-400 mt-0.5"></p>
                </div>
                <button type="button" onclick="closeUploadModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Form Body --}}
            <form id="form-upload-bukti" method="POST" action="{{ route('bukti-penyaluran.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="penarikan_dana_id" id="upload-penarikan-id">

                <div class="px-6 py-5 space-y-5 max-h-[70vh] overflow-y-auto">

                    {{-- Info Pencairan --}}
                    <div class="bg-[#F8FAFA] rounded-xl border border-[#D9E2E1] px-4 py-3 flex items-start gap-3">
                        <div class="w-8 h-8 rounded-lg bg-[#E4EEEE] flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-[#135B59]" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"/>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs font-semibold text-[#135B59]" id="upload-judul-kampanye">—</p>
                            <div class="flex items-center gap-3 mt-0.5">
                                <span class="text-xs text-gray-400 font-mono" id="upload-kode-transaksi">—</span>
                                <span class="text-xs font-semibold text-gray-700" id="upload-jumlah">—</span>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label for="upload-deskripsi" class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ __('Deskripsi Penggunaan Dana') }} <span class="text-red-500">*</span>
                        </label>
                        <textarea id="upload-deskripsi" name="deskripsi" rows="3"
                                  placeholder="{{ __('Jelaskan secara detail bagaimana dana tersebut digunakan. Contoh: Dana digunakan untuk membeli obat-obatan senilai Rp X, distribusi ke 50 penerima manfaat di desa Y, dsb...') }}"
                                  class="w-full px-4 py-3 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none resize-none leading-relaxed">{{ old('deskripsi') }}</textarea>
                        <p class="text-[11px] text-gray-400 mt-1">{{ __('Minimal 20 karakter. Deskripsi yang detail membantu membangun kepercayaan donatur.') }}</p>
                    </div>

                    {{-- Upload File --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">
                            {{ __('File Bukti Penyaluran') }} <span class="text-red-500">*</span>
                        </label>

                        {{-- Drop Zone --}}
                        <div id="drop-zone"
                             class="relative border-2 border-dashed border-[#D9E2E1] rounded-xl p-6 text-center cursor-pointer hover:border-[#135B59] hover:bg-[#F8FAFA] transition-colors group"
                             onclick="document.getElementById('upload-file-input').click()"
                             ondragover="event.preventDefault(); this.classList.add('border-[#135B59]', 'bg-[#F8FAFA]')"
                             ondragleave="this.classList.remove('border-[#135B59]', 'bg-[#F8FAFA]')"
                             ondrop="handleDrop(event)">

                            <div id="drop-zone-idle">
                                <div class="w-10 h-10 rounded-xl bg-[#E4EEEE] flex items-center justify-center mx-auto mb-3 group-hover:bg-[#d0e6e4] transition-colors">
                                    <svg class="w-5 h-5 text-[#135B59]" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700">{{ __('Klik atau seret file ke sini') }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ __('JPG, PNG, atau PDF · Maks. 5 MB') }}</p>
                            </div>

                            <div id="drop-zone-preview" class="hidden">
                                <div class="flex items-center justify-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center flex-shrink-0">
                                        <svg class="w-5 h-5 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                        </svg>
                                    </div>
                                    <div class="text-left">
                                        <p id="file-name-preview" class="text-sm font-semibold text-gray-900 truncate max-w-[220px]"></p>
                                        <p id="file-size-preview" class="text-xs text-gray-400 mt-0.5"></p>
                                    </div>
                                    <button type="button" onclick="clearFile(event)" class="text-gray-400 hover:text-red-500 transition cursor-pointer ml-2">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                                    </button>
                                </div>
                            </div>

                        </div>

                        <input type="file" id="upload-file-input" name="foto_bukti"
                               accept=".jpg,.jpeg,.png,.pdf"
                               class="hidden"
                               onchange="handleFileSelect(this)">
                    </div>

                </div>

                {{-- Footer --}}
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
                    <button type="button" onclick="closeUploadModal()"
                            class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-100 text-sm font-semibold text-gray-700 transition cursor-pointer">
                        {{ __('Batal') }}
                    </button>
                    <button type="submit" id="btn-submit-upload"
                            class="flex-1 py-2.5 px-4 rounded-xl bg-[#135B59] hover:bg-[#0e4846] text-white text-sm font-semibold shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5"/>
                        </svg>
                        {{ __('Kirim Laporan') }}
                    </button>
                </div>

            </form>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════════════
         MODAL 2: LIHAT LAPORAN YANG SUDAH DIKIRIM
    ══════════════════════════════════════════════════════════════════ --}}
    <div id="modal-lihat" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6"
         role="dialog" aria-modal="true" aria-labelledby="modal-lihat-title">

        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" onclick="closeLihatModal()"></div>

        <div class="relative w-full max-w-xl bg-white rounded-3xl shadow-2xl overflow-hidden z-10 my-auto max-h-[90vh] flex flex-col animate-in fade-in zoom-in-95 duration-150">

            {{-- Header --}}
            <div class="px-6 py-5 border-b border-gray-100 flex items-start justify-between flex-shrink-0">
                <div>
                    <h3 id="modal-lihat-title" class="text-base font-semibold text-gray-800">{{ __('Detail Laporan Penyaluran') }}</h3>
                    <p id="lihat-kode" class="text-xs text-gray-400 mt-0.5 font-mono"></p>
                </div>
                <button type="button" onclick="closeLihatModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Body --}}
            <div class="px-6 py-5 overflow-y-auto flex-1 space-y-5">

                {{-- Info Dasar --}}
                <div class="space-y-2.5 text-sm">
                    <div class="flex justify-between items-start gap-3">
                        <span class="text-gray-500 font-medium flex-shrink-0">{{ __('Kampanye') }}</span>
                        <span id="lihat-judul" class="font-semibold text-gray-900 text-right"></span>
                    </div>
                    <div class="flex justify-between items-center gap-3">
                        <span class="text-gray-500 font-medium">{{ __('Nominal Dicairkan') }}</span>
                        <span id="lihat-jumlah" class="font-bold text-[#135B59] text-base"></span>
                    </div>
                    <div class="flex justify-between items-center gap-3">
                        <span class="text-gray-500 font-medium">{{ __('Status Laporan') }}</span>
                        <span id="lihat-status-badge"></span>
                    </div>
                    <div class="flex justify-between items-center gap-3">
                        <span class="text-gray-500 font-medium">{{ __('Tanggal Unggah') }}</span>
                        <span id="lihat-tanggal" class="text-gray-700 text-xs"></span>
                    </div>
                </div>

                <div class="border-t border-gray-100"></div>

                {{-- Deskripsi --}}
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Deskripsi Penyaluran') }}</p>
                    <p id="lihat-deskripsi" class="text-sm text-gray-800 leading-relaxed bg-[#F8FAFA] rounded-xl border border-[#E9EFF0] px-4 py-3.5"></p>
                </div>

                {{-- Bukti File --}}
                <div>
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Bukti Dokumen') }}</p>
                    <div id="lihat-bukti-container">
                        {{-- Gambar preview --}}
                        <div id="lihat-bukti-img-wrap" class="rounded-xl overflow-hidden border border-gray-200 hidden">
                            <img id="lihat-bukti-img" src="" alt="Bukti Penyaluran" class="w-full object-contain max-h-64">
                        </div>
                        {{-- PDF link --}}
                        <div id="lihat-bukti-pdf-wrap" class="hidden">
                            <a id="lihat-bukti-pdf-link" href="#" target="_blank"
                               class="inline-flex items-center gap-3 px-4 py-3 rounded-xl border border-red-200 bg-red-50 hover:bg-red-100 transition text-red-700 text-sm font-semibold">
                                <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                </svg>
                                {{ __('Buka File PDF') }}
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Catatan Admin (jika ada) --}}
                <div id="lihat-catatan-wrap" class="hidden">
                    <div class="border-t border-gray-100 pt-4">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ __('Catatan dari Tim BeriPeduli') }}</p>
                        <div class="px-4 py-3 rounded-xl bg-amber-50 border border-amber-100">
                            <p id="lihat-catatan-admin" class="text-sm text-amber-800 leading-relaxed"></p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Footer --}}
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100 flex-shrink-0">
                <button type="button" onclick="closeLihatModal()"
                        class="w-full py-2.5 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-100 text-sm font-semibold text-gray-700 transition cursor-pointer">
                    {{ __('Tutup') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ══════════════════════ SCRIPT ══════════════════════ --}}
    <script>
        // ─── Modal Upload ───────────────────────────────────────────────────
        const modalUpload = document.getElementById('modal-upload');

        function openUploadModal(data) {
            document.getElementById('upload-penarikan-id').value = data.id;
            document.getElementById('upload-judul-kampanye').textContent = data.judul;
            document.getElementById('upload-kode-transaksi').textContent = data.kode;
            document.getElementById('upload-jumlah').textContent = data.jumlah;

            const title = document.getElementById('modal-upload-title');
            const subtitle = document.getElementById('modal-upload-subtitle');
            if (data.is_revisi) {
                title.textContent = @js(__('Unggah Ulang Bukti Penyaluran'));
                subtitle.textContent = @js(__('Laporan sebelumnya ditolak. Silakan unggah ulang dengan dokumen yang lebih valid.'));
            } else {
                title.textContent = @js(__('Unggah Bukti Penyaluran'));
                subtitle.textContent = @js(__('Lengkapi laporan untuk pencairan dana ini.'));
            }

            // Reset form
            document.getElementById('form-upload-bukti').reset();
            clearFilePreview();

            modalUpload.classList.remove('hidden');
            modalUpload.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeUploadModal() {
            modalUpload.classList.add('hidden');
            modalUpload.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // ─── File Handling ──────────────────────────────────────────────────
        function handleFileSelect(input) {
            if (input.files && input.files[0]) {
                showFilePreview(input.files[0]);
            }
        }

        function handleDrop(event) {
            event.preventDefault();
            document.getElementById('drop-zone').classList.remove('border-[#135B59]', 'bg-[#F8FAFA]');
            const file = event.dataTransfer.files[0];
            if (!file) return;

            const allowed = ['image/jpeg', 'image/png', 'application/pdf'];
            if (!allowed.includes(file.type)) {
                alert(@js(__('Format file tidak didukung. Gunakan JPG, PNG, atau PDF.')));
                return;
            }
            if (file.size > 5 * 1024 * 1024) {
                alert(@js(__('Ukuran file melebihi batas 5 MB.')));
                return;
            }

            // Set file ke input
            const dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('upload-file-input').files = dt.files;
            showFilePreview(file);
        }

        function showFilePreview(file) {
            document.getElementById('drop-zone-idle').classList.add('hidden');
            document.getElementById('drop-zone-preview').classList.remove('hidden');
            document.getElementById('file-name-preview').textContent = file.name;
            document.getElementById('file-size-preview').textContent = (file.size / 1024).toFixed(1) + ' KB';
        }

        function clearFile(event) {
            event.stopPropagation();
            document.getElementById('upload-file-input').value = '';
            clearFilePreview();
        }

        function clearFilePreview() {
            document.getElementById('drop-zone-idle').classList.remove('hidden');
            document.getElementById('drop-zone-preview').classList.add('hidden');
            document.getElementById('file-name-preview').textContent = '';
            document.getElementById('file-size-preview').textContent = '';
        }

        // ─── Modal Lihat ────────────────────────────────────────────────────
        const modalLihat = document.getElementById('modal-lihat');

        function openLihatModal(data) {
            document.getElementById('lihat-kode').textContent = data.kode;
            document.getElementById('lihat-judul').textContent = data.judul;
            document.getElementById('lihat-jumlah').textContent = data.jumlah;
            document.getElementById('lihat-deskripsi').textContent = data.deskripsi;
            document.getElementById('lihat-tanggal').textContent = data.tanggal_upload;

            // Badge status
            const badge = document.getElementById('lihat-status-badge');
            const statusMap = {
                menunggu: { cls: 'bg-amber-50 text-amber-700 border border-amber-200', label: @js(__('Menunggu Review')) },
                disetujui: { cls: 'bg-emerald-50 text-emerald-700 border border-emerald-200', label: @js(__('Terverifikasi ✓')) },
                ditolak: { cls: 'bg-red-50 text-red-600 border border-red-200', label: @js(__('Ditolak')) },
            };
            const s = statusMap[data.status] ?? statusMap.menunggu;
            badge.innerHTML = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold ${s.cls}">${s.label}</span>`;

            // File bukti
            if (data.is_pdf) {
                document.getElementById('lihat-bukti-img-wrap').classList.add('hidden');
                document.getElementById('lihat-bukti-pdf-wrap').classList.remove('hidden');
                document.getElementById('lihat-bukti-pdf-link').href = data.foto_bukti_url;
            } else {
                document.getElementById('lihat-bukti-pdf-wrap').classList.add('hidden');
                document.getElementById('lihat-bukti-img-wrap').classList.remove('hidden');
                document.getElementById('lihat-bukti-img').src = data.foto_bukti_url;
            }

            // Catatan admin
            const catatanWrap = document.getElementById('lihat-catatan-wrap');
            if (data.catatan_admin && data.catatan_admin.trim()) {
                document.getElementById('lihat-catatan-admin').textContent = data.catatan_admin;
                catatanWrap.classList.remove('hidden');
            } else {
                catatanWrap.classList.add('hidden');
            }

            modalLihat.classList.remove('hidden');
            modalLihat.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeLihatModal() {
            modalLihat.classList.add('hidden');
            modalLihat.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // ─── Tombol aksi (data-* via addEventListener) ──────────────────────
        document.querySelectorAll('.js-btn-upload').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openUploadModal({
                    id: this.dataset.id,
                    kode: this.dataset.kode,
                    judul: this.dataset.judul,
                    jumlah: this.dataset.jumlah,
                    is_revisi: this.dataset.isRevisi === '1',
                });
            });
        });

        document.querySelectorAll('.js-btn-lihat').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openLihatModal({
                    kode: this.dataset.kode,
                    judul: this.dataset.judul,
                    jumlah: this.dataset.jumlah,
                    deskripsi: this.dataset.deskripsi,
                    foto_bukti_url: this.dataset.fotoBuktiUrl,
                    is_pdf: this.dataset.isPdf === '1',
                    status: this.dataset.status,
                    tanggal_upload: this.dataset.tanggalUpload,
                    catatan_admin: this.dataset.catatanAdmin,
                });
            });
        });

        // ─── Keyboard ESC ───────────────────────────────────────────────────
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeUploadModal();
                closeLihatModal();
            }
        });

        // ─── Auto-open modal upload jika ada error validasi dari server ─────
        @if($errors->any() && old('penarikan_dana_id'))
            @php
                $modalPenarikan = session('modal_penarikan');
                $modalJumlah = isset($modalPenarikan['jumlah']) ? 'Rp ' . number_format($modalPenarikan['jumlah'], 0, ',', '.') : '';
            @endphp
            document.addEventListener('DOMContentLoaded', function () {
                openUploadModal({
                    id: '{{ old('penarikan_dana_id') }}',
                    kode: @json($modalPenarikan['kode'] ?? ''),
                    judul: @json($modalPenarikan['judul'] ?? __('Kampanye Dihapus')),
                    jumlah: @json($modalJumlah),
                    is_revisi: @json($modalPenarikan['is_revisi'] ?? false),
                });
            });
        @endif
    </script>

@endsection
