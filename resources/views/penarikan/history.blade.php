@extends('layouts.dashboard')

@section('title', __('Riwayat Penarikan Dana'))

@section('content')

    <main class="flex-1 min-w-0 bg-[#F1F1F1]">

        <div class="max-w-[1100px] mx-auto px-6 lg:px-8 pt-9 pb-24">

            {{-- ── HEADER ── --}}
            <header class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] leading-tight">
                        {{ __('Riwayat Penarikan Dana') }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">
                        {{ __('Pantau seluruh riwayat transaksi pencairan dana donasi Anda di sini.') }}
                    </p>
                </div>

                @if(isset($kampanyesSiapTarik) && $kampanyesSiapTarik->count() > 0)
                    @php
                        $tarikPertama = $kampanyesSiapTarik->first();
                        $tarikData = [
                            'id' => $tarikPertama->id,
                            'judul' => $tarikPertama->judul,
                            'saldo' => (float) $tarikPertama->saldo_siap_ditarik,
                            'bank' => $tarikPertama->bank_penyaluran ?: 'BCA',
                            'rekening' => $tarikPertama->nomor_rekening ?: '8820192831',
                            'pemilik' => $tarikPertama->nama_lengkap ?: ($tarikPertama->user->name ?? __('Penggalang Dana'))
                        ];
                    @endphp
                    <button type="button"
                            onclick='openTarikDanaModal(@json($tarikData))'
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg bg-[#135B59] hover:bg-[#0e4846] text-white text-xs font-semibold transition shadow-xs cursor-pointer">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>{{ __('Ajukan Penarikan Dana') }}</span>
                    </button>
                @endif
            </header>

            {{-- ── FLASH MESSAGES ── --}}
            <x-flash-message class="mb-5" />


            {{-- ── FILTER CARD ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 px-6 py-5 mb-5">
                <form method="GET" action="{{ route('penarikan.index') }}" id="form-filter">
                    <div class="flex flex-col sm:flex-row gap-4 items-end">

                        {{-- Cari Transaksi --}}
                        <div class="flex-1 w-full">
                            <label class="block text-[13px] font-semibold text-[#64748B] mb-1.5">
                                {{ __('Cari Transaksi') }}
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
                                       placeholder="{{ __('Cari kampanye, rekening, atau nominal...') }}"
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
                                    class="w-full h-[46px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none appearance-none cursor-pointer">
                                <option value="semua" {{ request('status', 'semua') === 'semua' ? 'selected' : '' }}>{{ __('Semua Status') }}</option>
                                <option value="berhasil" {{ request('status') === 'berhasil' ? 'selected' : '' }}>{{ __('Berhasil') }}</option>
                                <option value="diproses" {{ request('status') === 'diproses' ? 'selected' : '' }}>{{ __('Diproses') }}</option>
                                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>{{ __('Ditolak') }}</option>
                            </select>
                        </div>

                        {{-- Tombol Filter --}}
                        <div class="w-full sm:w-auto">
                            <button type="submit"
                                    class="w-full sm:w-auto inline-flex items-center justify-center gap-2 h-[46px] px-6 rounded-xl bg-[#135B59] hover:bg-[#0e4846] text-white text-sm font-semibold transition-colors shadow-sm whitespace-nowrap cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75"/>
                                </svg>
                                <span>{{ __('Terapkan Filter') }}</span>
                            </button>
                        </div>

                    </div>
                </form>
            </div>


            {{-- ── TABEL (PERSIS SEPERTI DI RIWAYAT DONASI) ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-5">

                {{-- Header kolom --}}
                <div class="grid grid-cols-[160px_1fr_160px_140px_64px] gap-0 px-6 py-3.5 border-b border-gray-100 bg-[#FAFAFA]">
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('TANGGAL') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('NAMA CAMPAIGN') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('NOMINAL') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">{{ __('STATUS') }}</span>
                    <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider text-right">{{ __('AKSI') }}</span>
                </div>

                {{-- Baris data --}}
                @forelse ($penarikans as $item)
                    <div class="grid grid-cols-[160px_1fr_160px_140px_64px] gap-0 px-6 py-4 border-b border-gray-50 hover:bg-[#FAFFF9] transition-colors items-center @if ($loop->last) border-b-0 @endif">

                        {{-- Tanggal --}}
                        <span class="text-sm text-gray-500">
                            {{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y') }}
                        </span>

                        {{-- Nama Campaign & Detail Tujuan --}}
                        <div class="pr-4 min-w-0">
                            <span class="text-sm font-semibold text-[#135B59] block truncate">
                                {{ $item->kampanye->judul ?? __('Penarikan Dana Kampanye') }}
                            </span>
                            <span class="text-xs text-gray-400 block truncate mt-0.5">
                                {{ $item->rekening_masked }} ({{ $item->nama_pemilik_rekening }})
                            </span>
                        </div>

                        {{-- Nominal --}}
                        <span class="text-sm font-bold text-gray-800">
                            Rp {{ number_format($item->jumlah, 0, ',', '.') }}
                        </span>

                        {{-- Status badge --}}
                        <div>
                            @if ($item->status === 'berhasil')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold bg-amber-50 text-amber-700 border border-amber-200">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('BERHASIL') }}
                                </span>
                            @elseif ($item->status === 'diproses')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold bg-blue-50 text-blue-600 border border-blue-200">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('DIPROSES') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[12px] font-bold bg-red-50 text-red-600 border border-red-200">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                    </svg>
                                    {{ __('DITOLAK') }}
                                </span>
                            @endif
                        </div>

                        {{-- Aksi (Icon Dokumen persis seperti riwayat donasi) --}}
                        <div class="flex justify-end">
                            @if ($item->status === 'ditolak')
                                <button type="button"
                                        onclick="showReasonModal('{{ addslashes($item->kode_transaksi) }}', '{{ number_format($item->jumlah, 0, ',', '.') }}', '{{ addslashes($item->alasan_penolakan ?? __('Alasan tidak dispesifikasikan oleh sistem.')) }}')"
                                        title="{{ __('Lihat Alasan Penolakan') }}"
                                        class="w-9 h-9 rounded-lg flex items-center justify-center text-red-500 hover:text-red-700 hover:bg-red-50 transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                        <circle cx="12" cy="12" r="9"/>
                                        <line x1="12" y1="16" x2="12" y2="12"/>
                                        <circle cx="12" cy="8" r="0.5" fill="currentColor"/>
                                    </svg>
                                </button>
                            @else
                                <button type="button"
                                        onclick="showDetailModal('{{ addslashes($item->kode_transaksi) }}', '{{ number_format($item->jumlah, 0, ',', '.') }}', '{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d M Y, H:i') }}', '{{ $item->disetujui_pada ? \Carbon\Carbon::parse($item->disetujui_pada)->translatedFormat('d M Y, H:i') : '-' }}', '{{ addslashes($item->bank_tujuan) }}', '{{ addslashes($item->nomor_rekening) }}', '{{ addslashes($item->nama_pemilik_rekening) }}', '{{ $item->status }}', '{{ addslashes($item->catatan ?? '-') }}', '{{ addslashes($item->kampanye->judul ?? __('Penarikan Dana Kampanye')) }}')"
                                        title="{{ __('Lihat Detail Transaksi') }}"
                                        class="w-9 h-9 rounded-lg flex items-center justify-center text-gray-400 hover:text-[#135B59] hover:bg-[#E4EEEE] transition-colors cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                    </svg>
                                </button>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="px-6 py-14 text-center">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-full bg-gray-100 flex items-center justify-center text-gray-400">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <rect x="2" y="6" width="20" height="12" rx="3"/>
                                <circle cx="12" cy="12" r="2.5"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h.01M18 12h.01"/>
                            </svg>
                        </div>
                        <p class="text-sm font-semibold text-gray-700">{{ __('Belum ada riwayat penarikan') }}</p>
                        <p class="text-xs text-gray-400 mt-1 max-w-sm mx-auto">
                            {{ __('Transaksi penarikan dana dari kampanye Anda akan otomatis tercatat di sini setelah Anda mengajukan pencairan.') }}
                        </p>
                    </div>
                @endforelse

            </div>


            {{-- ── COUNTER & PAGINATION ── --}}
            @if ($penarikans->total() > 0)
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mt-2 mb-10 px-1">

                    {{-- Teks Counter Kiri --}}
                    <p class="text-xs text-gray-500">
                        {{ __('Menampilkan') }} {{ $penarikans->count() }} {{ __('dari') }} {{ $penarikans->total() }} {{ __('riwayat penarikan') }}
                    </p>

                    {{-- Tombol Navigasi Pagination Kanan --}}
                    @if ($penarikans->hasPages())
                        <nav class="flex items-center gap-1.5" aria-label="Pagination Navigation">

                            {{-- Tombol Previous (<) --}}
                            @if ($penarikans->onFirstPage())
                                <span class="w-7 h-7 flex items-center justify-center text-xs text-gray-300 cursor-not-allowed">
                                    &lt;
                                </span>
                            @else
                                <a href="{{ $penarikans->previousPageUrl() }}"
                                   class="w-7 h-7 flex items-center justify-center text-xs text-gray-700 hover:bg-gray-200 rounded-lg transition">
                                    &lt;
                                </a>
                            @endif

                            {{-- Nomor Halaman --}}
                            @php
                                $currentPage = $penarikans->currentPage();
                                $lastPage = $penarikans->lastPage();
                            @endphp

                            @for ($i = 1; $i <= $lastPage; $i++)
                                @if ($i == $currentPage)
                                    <span class="w-7 h-7 rounded-lg bg-[#135B59] text-white text-xs font-bold flex items-center justify-center shadow-xs">
                                        {{ $i }}
                                    </span>
                                @elseif ($i <= 4 || $i == $lastPage)
                                    <a href="{{ $penarikans->url($i) }}"
                                       class="w-7 h-7 rounded-lg text-gray-700 hover:bg-gray-200 text-xs font-medium flex items-center justify-center transition">
                                        {{ $i }}
                                    </a>
                                @elseif ($i == 5 && $lastPage > 5)
                                    <span class="w-7 h-7 flex items-center justify-center text-xs text-gray-400">
                                        ...
                                    </span>
                                @endif
                            @endfor

                            {{-- Tombol Next (>) --}}
                            @if ($penarikans->hasMorePages())
                                <a href="{{ $penarikans->nextPageUrl() }}"
                                   class="w-7 h-7 flex items-center justify-center text-xs text-gray-700 hover:bg-gray-200 rounded-lg transition">
                                    &gt;
                                </a>
                            @else
                                <span class="w-7 h-7 flex items-center justify-center text-xs text-gray-300 cursor-not-allowed">
                                    &gt;
                                </span>
                            @endif

                        </nav>
                    @endif

                </div>
            @endif


            {{-- ── KARTU BANTUAN SUPPORT BANNER ── --}}
            <div class="bg-[#ECE5DC] rounded-2xl p-6 sm:p-7 flex flex-col md:flex-row items-center justify-between gap-6 shadow-sm">

                <div class="flex items-center gap-4">

                    {{-- Lingkaran Ikon Tanda Tanya --}}
                    <div class="w-12 h-12 rounded-full bg-[#135B59] flex items-center justify-center flex-shrink-0 text-white shadow-sm">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M12 18h.01"/>
                        </svg>
                    </div>

                    {{-- Teks Pertanyaan & Deskripsi --}}
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 leading-tight">
                            {{ __('Punya pertanyaan seputar pencairan?') }}
                        </h3>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1 max-w-xl leading-relaxed">
                            {{ __('Tim verifikasi kami bekerja setiap hari Senin - Jumat pukul 09:00 - 17:00 WIB untuk memastikan dana Anda sampai dengan aman.') }}
                        </p>
                    </div>

                </div>

                {{-- Tombol Hubungi Support --}}
                <a href="https://wa.me/6281234567890?text={{ rawurlencode(__('Halo Admin BeriPeduli, saya ingin bertanya seputar pencairan dana')) }}"
                   target="_blank"
                   rel="noopener noreferrer"
                   class="w-full md:w-auto px-7 py-3 bg-[#135B59] hover:bg-[#0e4846] text-white text-sm font-semibold rounded-xl transition shadow-sm text-center whitespace-nowrap cursor-pointer">
                    {{ __('Hubungi Support') }}
                </a>

            </div>

        </div>

    </main>

    {{-- ── MODAL DETAIL PENARIKAN (RAPI, MODERN, TIDAK DEMPET ATAS BAWAH) ── --}}
    <div id="modal-detail" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 transition-opacity duration-200" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
        {{-- Click area outside --}}
        <div class="fixed inset-0" onclick="closeDetailModal()"></div>

        <div class="relative bg-white w-full max-w-[430px] max-h-[85vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col my-auto z-10 animate-modal-pop">
            {{-- Top accent gradient strip --}}
            <div class="h-1.5 bg-gradient-to-r from-[#135B59] via-[#1b7573] to-[#D7A31B] flex-shrink-0"></div>

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white flex-shrink-0">
                <div>
                    <h3 class="font-extrabold text-gray-900 text-base">{{ __('Detail Penarikan Dana') }}</h3>
                    <p id="modal-detail-kode" class="text-xs text-gray-400 mt-0.5 font-mono"></p>
                </div>
                <button type="button" onclick="closeDetailModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-3 text-xs sm:text-sm custom-modal-scroll">
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Status') }}</span>
                    <span id="modal-detail-status" class="font-bold"></span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Campaign') }}</span>
                    <span id="modal-detail-campaign" class="font-semibold text-gray-800 text-right truncate max-w-[210px]"></span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Nominal Penarikan') }}</span>
                    <span id="modal-detail-nominal" class="font-black text-[#135B59] text-base"></span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Biaya Administrasi') }}</span>
                    <span class="text-[#135B59] font-bold">{{ __('Gratis (Rp 0)') }}</span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Rekening / E-Wallet') }}</span>
                    <span id="modal-detail-rekening" class="font-semibold text-gray-800 text-right"></span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Atas Nama') }}</span>
                    <span id="modal-detail-nama" class="font-semibold text-gray-800 text-right"></span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Tanggal Pengajuan') }}</span>
                    <span id="modal-detail-created" class="text-gray-700"></span>
                </div>
                <div class="flex justify-between items-center py-1.5 border-b border-gray-50">
                    <span class="text-gray-500 font-medium">{{ __('Tanggal Disetujui') }}</span>
                    <span id="modal-detail-approved" class="text-gray-700"></span>
                </div>
                <div class="pt-1.5">
                    <span class="block text-gray-500 font-medium mb-1.5">{{ __('Catatan') }}</span>
                    <p id="modal-detail-catatan" class="text-gray-700 text-xs bg-gray-50 p-3 rounded-xl border border-gray-100 leading-relaxed"></p>
                </div>
            </div>

            <div class="px-6 py-3.5 bg-gray-50/80 border-t border-gray-100 text-right flex-shrink-0">
                <button type="button" onclick="closeDetailModal()" class="px-5 h-[38px] bg-white border border-gray-200 hover:bg-gray-100 text-gray-700 text-xs font-bold rounded-xl transition cursor-pointer shadow-2xs">
                    {{ __('Tutup') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ── MODAL ALASAN PENOLAKAN ── --}}
    <div id="modal-reason" class="fixed inset-0 z-50 hidden items-center justify-center p-4 sm:p-6 transition-opacity duration-200" style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">
        {{-- Click area outside --}}
        <div class="fixed inset-0" onclick="closeReasonModal()"></div>

        <div class="relative bg-white w-full max-w-[430px] max-h-[85vh] rounded-3xl shadow-2xl overflow-hidden flex flex-col my-auto z-10 animate-modal-pop">
            <div class="h-1.5 bg-gradient-to-r from-rose-500 to-amber-500 flex-shrink-0"></div>

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-white flex-shrink-0">
                <div class="flex items-center gap-2.5">
                    <div class="w-7 h-7 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center font-bold text-xs flex-shrink-0">
                        !
                    </div>
                    <div>
                        <h3 class="font-extrabold text-gray-900 text-base">{{ __('Alasan Penolakan') }}</h3>
                        <p id="modal-reason-kode" class="text-xs text-gray-400 mt-0.5 font-mono"></p>
                    </div>
                </div>
                <button type="button" onclick="closeReasonModal()" class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6 overflow-y-auto space-y-3.5 text-xs sm:text-sm custom-modal-scroll">
                <div>
                    <span class="text-xs text-gray-500 font-semibold block mb-1">{{ __('Nominal Transaksi') }}</span>
                    <p id="modal-reason-nominal" class="text-lg font-black text-rose-600"></p>
                </div>
                <div class="bg-rose-50/80 border border-rose-100 rounded-2xl p-4">
                    <span class="text-xs font-bold text-rose-800 block mb-1">{{ __('Keterangan Verifikator:') }}</span>
                    <p id="modal-reason-text" class="text-xs sm:text-sm text-rose-700 leading-relaxed"></p>
                </div>
                <p class="text-xs text-gray-500 leading-relaxed">
                    {{ __('Jika ada kesalahan data atau butuh bantuan lebih lanjut, Anda dapat memperbarui informasi rekening kampanye atau menghubungi tim support kami.') }}
                </p>
            </div>

            <div class="px-6 py-3.5 bg-gray-50/80 border-t border-gray-100 flex items-center justify-end gap-2.5 flex-shrink-0">
                <a href="https://wa.me/6281234567890?text={{ rawurlencode(__('Halo BeriPeduli, saya butuh bantuan terkait penolakan pencairan dana')) }}"
                   target="_blank"
                   class="px-4 h-[38px] bg-[#135B59] hover:bg-[#0e4846] text-white text-xs font-bold rounded-xl transition inline-flex items-center gap-1.5 shadow-2xs">
                    {{ __('Hubungi Support') }}
                </a>
                <button type="button" onclick="closeReasonModal()" class="px-4 h-[38px] bg-white border border-gray-200 hover:bg-gray-100 text-gray-700 text-xs font-semibold rounded-xl transition cursor-pointer">
                    {{ __('Tutup') }}
                </button>
            </div>
        </div>
    </div>

    {{-- ── JAVASCRIPT MODAL INTERACTION ── --}}
    <script>
        function showDetailModal(kode, nominal, created, approved, bank, rek, nama, status, catatan, campaign) {
            document.getElementById('modal-detail-kode').innerText = kode;
            document.getElementById('modal-detail-nominal').innerText = 'Rp ' + nominal;
            document.getElementById('modal-detail-campaign').innerText = campaign;
            document.getElementById('modal-detail-created').innerText = created;
            document.getElementById('modal-detail-approved').innerText = approved;
            document.getElementById('modal-detail-rekening').innerText = bank + ' - ' + rek;
            document.getElementById('modal-detail-nama').innerText = nama;
            document.getElementById('modal-detail-catatan').innerText = catatan;

            const statusEl = document.getElementById('modal-detail-status');
            if (status === 'berhasil') {
                statusEl.innerHTML = '<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-50 text-amber-700 border border-amber-200">' + @js(__('BERHASIL')) + '</span>';
            } else if (status === 'diproses') {
                statusEl.innerHTML = '<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-blue-50 text-blue-600 border border-blue-200">' + @js(__('DIPROSES')) + '</span>';
            } else {
                statusEl.innerHTML = '<span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-200">' + @js(__('DITOLAK')) + '</span>';
            }

            const modal = document.getElementById('modal-detail');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeDetailModal() {
            const modal = document.getElementById('modal-detail');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        function showReasonModal(kode, nominal, alasan) {
            document.getElementById('modal-reason-kode').innerText = kode;
            document.getElementById('modal-reason-nominal').innerText = 'Rp ' + nominal;
            document.getElementById('modal-reason-text').innerText = alasan;

            const modal = document.getElementById('modal-reason');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeReasonModal() {
            const modal = document.getElementById('modal-reason');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Close on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeDetailModal();
                closeReasonModal();
            }
        });
    </script>

    @include('partials.modal-tarik-dana')

@endsection
