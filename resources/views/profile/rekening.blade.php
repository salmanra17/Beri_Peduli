@extends('layouts.dashboard')

@section('title', __('Rekening Bank'))

@section('content')
<div class="p-6 sm:p-8 lg:p-10 max-w-7xl">

    {{-- ALERT TOAST MELAYANG (UNTUK SALIN REKENING DLL) --}}
    <div id="toast-notification"
         class="fixed bottom-6 right-6 z-50 hidden items-center gap-3 px-4 py-3 rounded-xl bg-gray-900 text-white text-sm font-medium shadow-2xl transition-all duration-300 transform translate-y-2 opacity-0">
        <svg class="w-5 h-5 text-emerald-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
        </svg>
        <span id="toast-message">{{ __('Nomor rekening berhasil disalin!') }}</span>
    </div>

    {{-- ALERT SUKSES / ERROR DARI BACKEND --}}
    <x-flash-message class="mb-5" />

    {{-- HEADER HALAMAN --}}
    <div class="mb-5">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
            {{ __('Pengaturan Akun') }}
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">
            {{ __('Kelola informasi pribadi, keamanan, dan rekening bank Anda.') }}
        </p>
    </div>

    {{-- TABS BAR --}}
    <div class="border-b border-gray-200 mb-6">
        <div class="flex items-center gap-6 text-xs sm:text-sm">
            {{-- TAB 1: PROFIL PERSONAL --}}
            <a href="{{ route('profile.edit') }}"
               class="pb-3 font-medium text-gray-400 hover:text-gray-600 transition">
                {{ __('Profil Personal') }}
            </a>

            {{-- TAB 2: KEAMANAN & PASSWORD --}}
            <a href="{{ route('profile.security') }}"
               class="pb-3 font-medium text-gray-400 hover:text-gray-600 transition">
                {{ __('Keamanan & Password') }}
            </a>

            {{-- TAB 3: REKENING BANK (AKTIF) --}}
            <a href="{{ route('profile.rekening') }}"
               class="pb-3 font-bold text-[#135B59] border-b-2 border-[#135B59] transition">
                {{ __('Rekening Bank') }}
            </a>
        </div>
    </div>

    {{-- ==================== KONTEN UTAMA ==================== --}}

    {{-- JUDUL SEKSI + TOMBOL TAMBAH REKENING --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-gray-900">{{ __('Rekening Tersimpan') }}</h2>
            <p class="text-sm text-gray-500 mt-0.5 leading-relaxed">
                {{ __('Daftar rekening bank yang digunakan untuk menerima pencairan dana kampanye.') }}
            </p>
        </div>

        <button type="button"
                id="btn-buka-tambah-rekening"
                class="flex-shrink-0 inline-flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white font-semibold text-sm shadow-sm transition cursor-pointer whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.4" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
            <span>{{ __('Tambah Rekening Baru') }}</span>
        </button>
    </div>

    {{-- GRID KARTU REKENING --}}
    @if($rekenings->isNotEmpty())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @foreach($rekenings as $rekening)
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex flex-col justify-between relative transition hover:shadow-md">

                    {{-- BARIS ATAS: IKON BANK BULAT (KIRI) & STATUS + TITIK TIGA (KANAN) --}}
                    <div class="flex items-start justify-between gap-3 mb-6">
                        {{-- IKON BANK BULAT (KIRI) --}}
                        <div class="w-12 h-12 rounded-full bg-[#dbeafe]/80 flex items-center justify-center flex-shrink-0 text-[#0284c7]">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                            </svg>
                        </div>

                        {{-- STATUS BADGE + MENU TITIK TIGA (KANAN) --}}
                        <div class="flex items-center gap-2">
                            {{-- BADGE STATUS --}}
                            @if($rekening->status === 'terverifikasi')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wider uppercase bg-[#dcfce7] text-[#15803d]">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                    </svg>
                                    {{ __('TERVERIFIKASI') }}
                                </span>
                            @elseif($rekening->status === 'ditolak')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wider uppercase bg-red-100 text-red-700">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    {{ __('DITOLAK') }}
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-[11px] font-bold tracking-wider uppercase bg-[#fef3c7] text-[#b45309]">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path stroke-linecap="round" d="M8 12h.01M12 12h.01M16 12h.01" stroke-width="3"/>
                                    </svg>
                                    {{ __('MENUNGGU') }}
                                </span>
                            @endif

                            {{-- TOMBOL MENU TITIK TIGA (⋮) --}}
                            <div class="relative dropdown-container">
                                <button type="button"
                                        class="btn-dropdown-toggle w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition cursor-pointer"
                                        title="{{ __('Opsi Rekening') }}"
                                        data-dropdown-target="dropdown-{{ $rekening->id }}">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="5" r="1.75"/>
                                        <circle cx="12" cy="12" r="1.75"/>
                                        <circle cx="12" cy="19" r="1.75"/>
                                    </svg>
                                </button>

                                {{-- DROPDOWN MENU KONTEN --}}
                                <div id="dropdown-{{ $rekening->id }}"
                                     class="dropdown-menu hidden absolute right-0 top-9 z-30 bg-white border border-gray-100 rounded-xl shadow-xl py-1.5 w-52 animate-in fade-in zoom-in-95 duration-100">

                                    {{-- 1. SALIN NOMOR REKENING --}}
                                    <button type="button"
                                            class="btn-action-copy w-full flex items-center gap-2.5 px-3.5 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition text-left cursor-pointer"
                                            data-nomor="{{ $rekening->nomor_rekening }}">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                        </svg>
                                        <span>{{ __('Salin Nomor Rekening') }}</span>
                                    </button>

                                    {{-- 2. JADIKAN REKENING UTAMA --}}
                                    @if($rekening->is_utama)
                                        <div class="flex items-center gap-2.5 px-3.5 py-2 text-xs font-semibold text-emerald-600 bg-emerald-50/70">
                                            <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                            </svg>
                                            <span>{{ __('Rekening Utama (Aktif)') }}</span>
                                        </div>
                                    @else
                                        <form action="{{ route('profile.rekening.utama', $rekening->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                    class="w-full flex items-center gap-2.5 px-3.5 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition text-left cursor-pointer">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                                </svg>
                                                <span>{{ __('Jadikan Rekening Utama') }}</span>
                                            </button>
                                        </form>
                                    @endif

                                    {{-- 3. EDIT REKENING (BUKA MODAL) --}}
                                    <button type="button"
                                            class="btn-action-edit w-full flex items-center gap-2.5 px-3.5 py-2 text-xs font-medium text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition text-left cursor-pointer"
                                            data-id="{{ $rekening->id }}"
                                            data-bank="{{ $rekening->nama_bank }}"
                                            data-nomor="{{ $rekening->nomor_rekening }}"
                                            data-pemilik="{{ $rekening->nama_pemilik }}"
                                            data-action="{{ route('profile.rekening.update', $rekening->id) }}">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                        <span>{{ __('Edit Rekening') }}</span>
                                    </button>

                                    <div class="my-1 border-t border-gray-100"></div>

                                    {{-- 4. HAPUS REKENING (BUKA MODAL KONFIRMASI) --}}
                                    <button type="button"
                                            class="w-full flex items-center gap-2.5 px-3.5 py-2 text-xs font-medium text-red-600 hover:bg-red-50 transition text-left cursor-pointer"
                                            onclick="openHapusRekeningModal({{ $rekening->id }}, '{{ addslashes($rekening->nama_bank) }}', '{{ $rekening->nomor_rekening_masked }}')">
                                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                        <span>{{ __('Hapus Rekening') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- BARIS TENGAH: NAMA BANK & NOMOR REKENING --}}
                    <div class="mb-6">
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-1">
                            BANK {{ strtoupper($rekening->nama_bank) }}
                        </p>
                        <p class="text-xl sm:text-2xl font-bold text-gray-900 tracking-wider">
                            {{ $rekening->nomor_rekening_masked }}
                        </p>
                    </div>

                    {{-- BARIS BAWAH: KOTAK ABU-ABU NAMA PEMILIK --}}
                    <div class="bg-[#f0f4f9] rounded-xl p-3.5 flex items-center gap-3">
                        <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <div class="min-w-0">
                            <p class="text-[11px] font-medium text-gray-400 leading-none mb-1">{{ __('Nama Pemilik') }}</p>
                            <p class="text-sm font-bold text-gray-900 truncate leading-snug">{{ $rekening->nama_pemilik }}</p>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    @else
        {{-- EMPTY STATE KALAU BELUM ADA REKENING --}}
        <div class="bg-white rounded-2xl p-10 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)] text-center mb-8">
            <div class="w-14 h-14 rounded-full bg-[#dbeafe]/80 flex items-center justify-center mx-auto mb-4 text-[#0284c7]">
                <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
            </div>
            <p class="text-base font-bold text-gray-800 mb-1">{{ __('Belum ada rekening tersimpan') }}</p>
            <p class="text-xs text-gray-500 max-w-sm mx-auto mb-5">
                {{ __('Tambahkan rekening bank untuk menerima pencairan dana galang dana Anda secara aman.') }}
            </p>
            <button type="button"
                    id="btn-buka-tambah-empty"
                    class="inline-flex items-center gap-2 py-2 px-4 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white font-semibold text-xs transition cursor-pointer">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
                <span>{{ __('Tambah Rekening Baru') }}</span>
            </button>
        </div>
    @endif

    {{-- KOTAK INFORMASI PENTING: VERIFIKASI REKENING (PLEK SESUAI DESAIN) --}}
    <div class="bg-[#eff6ff] border border-[#bfdbfe] rounded-2xl p-5 flex items-start gap-3.5">
        <svg class="w-6 h-6 text-[#0284c7] flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <circle cx="12" cy="12" r="9"/>
            <line x1="12" y1="8" x2="12" y2="8.01" stroke-width="3" stroke-linecap="round"/>
            <line x1="12" y1="11" x2="12" y2="16" stroke-width="2" stroke-linecap="round"/>
        </svg>
        <div>
            <h4 class="text-sm font-bold text-gray-900 mb-1">{{ __('Penting: Verifikasi Rekening') }}</h4>
            <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                {{ __('Pastikan nama pemilik rekening bank sesuai dengan nama identitas (KTP) yang terdaftar di akun BeriPeduli Anda. Ketidaksesuaian data dapat menyebabkan penundaan atau penolakan pencairan dana galang dana Anda.') }}
            </p>
        </div>
    </div>

</div>

{{-- ==================== 1. MODAL TAMBAH REKENING BARU ==================== --}}
<div id="modal-tambah-rekening"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-title-tambah">

    {{-- Backdrop --}}
    <div class="modal-backdrop absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Panel Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 sm:p-7 w-full max-w-md z-10 animate-in fade-in zoom-in-95 duration-150">

        {{-- Header Modal --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#dbeafe]/80 flex items-center justify-center flex-shrink-0 text-[#0284c7]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                </div>
                <div>
                    <h3 id="modal-title-tambah" class="text-base font-bold text-gray-900">{{ __('Tambah Rekening Baru') }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('Rekening akan diverifikasi sebelum digunakan') }}</p>
                </div>
            </div>
            <button type="button"
                    class="btn-close-modal w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="{{ route('profile.rekening.store') }}" method="POST" id="form-tambah-rekening">
            @csrf

            <div class="space-y-4">
                {{-- NAMA BANK --}}
                <div>
                    <label for="add_nama_bank" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ __('Nama Bank') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="add_nama_bank" name="nama_bank" required
                                class="w-full appearance-none px-3.5 py-2.5 pr-10 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition cursor-pointer">
                            <option value="">{{ __('Pilih Bank') }}</option>
                            @foreach($bankList as $bank)
                                <option value="{{ $bank }}" {{ old('nama_bank') === $bank ? 'selected' : '' }}>
                                    Bank {{ $bank }}
                                </option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- NOMOR REKENING --}}
                <div>
                    <label for="add_nomor_rekening" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ __('Nomor Rekening') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="add_nomor_rekening"
                           name="nomor_rekening"
                           value="{{ old('nomor_rekening') }}"
                           placeholder="{{ __('Contoh: 1234567890') }}"
                           inputmode="numeric"
                           required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition font-mono">
                </div>

                {{-- NAMA PEMILIK --}}
                <div>
                    <label for="add_nama_pemilik" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ __('Nama Pemilik Rekening') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="add_nama_pemilik"
                           name="nama_pemilik"
                           value="{{ old('nama_pemilik', $user->name) }}"
                           placeholder="{{ __('Nama lengkap sesuai buku tabungan') }}"
                           required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition">
                    <p class="text-[11px] text-gray-400 mt-1">{{ __('Pastikan sama persis dengan nama di KTP dan rekening buku tabungan') }}</p>
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button"
                        class="btn-batal-modal px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-sm font-semibold text-gray-700 transition cursor-pointer">
                    {{ __('Batal') }}
                </button>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white text-sm font-semibold shadow-sm transition cursor-pointer">
                    {{ __('Tambah Rekening') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== 2. MODAL EDIT REKENING ==================== --}}
<div id="modal-edit-rekening"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-title-edit">

    {{-- Backdrop --}}
    <div class="modal-backdrop absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Panel Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 sm:p-7 w-full max-w-md z-10 animate-in fade-in zoom-in-95 duration-150">

        {{-- Header Modal --}}
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-[#dbeafe]/80 flex items-center justify-center flex-shrink-0 text-[#0284c7]">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                </div>
                <div>
                    <h3 id="modal-title-edit" class="text-base font-bold text-gray-900">{{ __('Edit Rekening Bank') }}</h3>
                    <p class="text-xs text-gray-500 mt-0.5">{{ __('Perubahan rekening memerlukan verifikasi ulang') }}</p>
                </div>
            </div>
            <button type="button"
                    class="btn-close-modal w-8 h-8 flex items-center justify-center rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition cursor-pointer">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form action="" method="POST" id="form-edit-rekening">
            @csrf
            @method('PUT')

            <div class="space-y-4">
                {{-- NAMA BANK --}}
                <div>
                    <label for="edit_nama_bank" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ __('Nama Bank') }} <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <select id="edit_nama_bank" name="nama_bank" required
                                class="w-full appearance-none px-3.5 py-2.5 pr-10 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition cursor-pointer">
                            <option value="">{{ __('Pilih Bank') }}</option>
                            @foreach($bankList as $bank)
                                <option value="{{ $bank }}">Bank {{ $bank }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- NOMOR REKENING --}}
                <div>
                    <label for="edit_nomor_rekening" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ __('Nomor Rekening') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="edit_nomor_rekening"
                           name="nomor_rekening"
                           placeholder="{{ __('Nomor rekening') }}"
                           inputmode="numeric"
                           required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition font-mono">
                </div>

                {{-- NAMA PEMILIK --}}
                <div>
                    <label for="edit_nama_pemilik" class="block text-xs font-semibold text-gray-700 mb-1.5">
                        {{ __('Nama Pemilik Rekening') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="edit_nama_pemilik"
                           name="nama_pemilik"
                           placeholder="{{ __('Nama pemilik rekening') }}"
                           required
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition">
                </div>
            </div>

            {{-- TOMBOL SUBMIT --}}
            <div class="mt-6 flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                <button type="button"
                        class="btn-batal-modal px-4 py-2.5 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-sm font-semibold text-gray-700 transition cursor-pointer">
                    {{ __('Batal') }}
                </button>
                <button type="submit"
                        class="px-5 py-2.5 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white text-sm font-semibold shadow-sm transition cursor-pointer">
                    {{ __('Simpan Perubahan') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ==================== 3. MODAL KONFIRMASI HAPUS REKENING ==================== --}}
<div id="modal-hapus-rekening"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-title-hapus">

    {{-- Backdrop --}}
    <div class="modal-backdrop absolute inset-0 bg-black/40 backdrop-blur-sm"></div>

    {{-- Panel Modal --}}
    <div class="relative bg-white rounded-2xl shadow-2xl p-6 sm:p-7 w-full max-w-sm z-10 animate-in fade-in zoom-in-95 duration-150">

        {{-- Header Modal --}}
        <div class="flex items-center gap-3 mb-4">
            <div class="w-11 h-11 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                </svg>
            </div>
            <div>
                <h3 id="modal-title-hapus" class="text-base font-bold text-gray-900">{{ __('Hapus Rekening') }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Tindakan ini tidak dapat dibatalkan') }}</p>
            </div>
        </div>

        <p class="text-sm text-gray-600 mb-6 leading-relaxed">
            {{ __('Apakah Anda yakin ingin menghapus rekening') }} <strong id="hapus-nama-bank" class="text-gray-900"></strong> (<span id="hapus-nomor-rekening" class="font-mono text-gray-700"></span>)?
        </p>

        <form action="" method="POST" id="form-hapus-rekening">
            @csrf
            @method('DELETE')

            <div class="flex items-center gap-3">
                <button type="button"
                        class="btn-batal-modal flex-1 py-2.5 px-4 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold text-sm transition cursor-pointer">
                    {{ __('Batal') }}
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-red-600 hover:bg-red-700 text-white font-semibold text-sm shadow-sm transition cursor-pointer">
                    {{ __('Ya, Hapus') }}
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT INTERAKTIF LENGKAP: POP-UP MODAL, MENU TITIK TIGA, & SALIN NOMOR REKENING --}}
<script>
// Fungsi global untuk membuka modal hapus rekening (top-level agar selalu registrasi)
window.openHapusRekeningModal = function (id, bank, nomor) {
    document.querySelectorAll('.dropdown-menu').forEach(function (menu) {
        menu.classList.add('hidden');
    });

    var formHapus = document.getElementById('form-hapus-rekening');
    var labelBank = document.getElementById('hapus-nama-bank');
    var labelNomor = document.getElementById('hapus-nomor-rekening');
    var modalHapus = document.getElementById('modal-hapus-rekening');

    formHapus.action = '{{ url('/pengaturan-akun/rekening') }}/' + id;
    labelBank.textContent = @js(__('Bank ')) + bank;
    labelNomor.textContent = nomor;

    modalHapus.classList.remove('hidden');
    modalHapus.classList.add('flex');
    document.body.style.overflow = 'hidden';
};

document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. MODAL MANAGEMENT (TAMBAH, EDIT, HAPUS)
    // ==========================================
    const modalTambah = document.getElementById('modal-tambah-rekening');
    const modalEdit   = document.getElementById('modal-edit-rekening');
    const modalHapus  = document.getElementById('modal-hapus-rekening');

    const btnBukaTambah = document.getElementById('btn-buka-tambah-rekening');
    const btnBukaEmpty  = document.getElementById('btn-buka-tambah-empty');

    function showModal(modal) {
        if (!modal) return;
        closeAllDropdowns();
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function hideModal(modal) {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    // Tombol Buka Tambah
    if (btnBukaTambah) {
        btnBukaTambah.addEventListener('click', function () {
            showModal(modalTambah);
        });
    }
    if (btnBukaEmpty) {
        btnBukaEmpty.addEventListener('click', function () {
            showModal(modalTambah);
        });
    }

    // Tombol Batal & Tombol X Close di Semua Modal
    document.querySelectorAll('.btn-batal-modal, .btn-close-modal').forEach(function (btn) {
        btn.addEventListener('click', function () {
            hideModal(modalTambah);
            hideModal(modalEdit);
            hideModal(modalHapus);
        });
    });

    // Klik Backdrop untuk Tutup
    document.querySelectorAll('.modal-backdrop').forEach(function (backdrop) {
        backdrop.addEventListener('click', function () {
            hideModal(modalTambah);
            hideModal(modalEdit);
            hideModal(modalHapus);
        });
    });

    // Tutup Modal dengan Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            hideModal(modalTambah);
            hideModal(modalEdit);
            hideModal(modalHapus);
            closeAllDropdowns();
        }
    });

    // ==========================================
    // 2. DROPDOWN MENU TITIK TIGA (⋮)
    // ==========================================
    function closeAllDropdowns() {
        document.querySelectorAll('.dropdown-menu').forEach(function (menu) {
            menu.classList.add('hidden');
        });
    }

    document.querySelectorAll('.btn-dropdown-toggle').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const targetId = this.dataset.dropdownTarget;
            const targetMenu = document.getElementById(targetId);

            if (!targetMenu) return;

            const isHidden = targetMenu.classList.contains('hidden');
            closeAllDropdowns();

            if (isHidden) {
                targetMenu.classList.remove('hidden');
            }
        });
    });

    // Tutup dropdown saat klik di luar
    document.addEventListener('click', function (e) {
        if (!e.target.closest('.dropdown-container')) {
            closeAllDropdowns();
        }
    });

    // ==========================================
    // 3. AKSI-AKSI MENU TITIK TIGA
    // ==========================================

    // A. Salin Nomor Rekening
    document.querySelectorAll('.btn-action-copy').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const nomor = this.dataset.nomor;
            closeAllDropdowns();

            navigator.clipboard.writeText(nomor).then(function () {
                showToast(@js(__('Nomor rekening')) + ' ' + nomor + ' ' + @js(__('berhasil disalin!')));
            }).catch(function () {
                showToast(@js(__('Gagal menyalin nomor rekening.')));
            });
        });
    });

    // B. Edit Rekening (Isi Form Edit dan Buka Modal)
    document.querySelectorAll('.btn-action-edit').forEach(function (btn) {
        btn.addEventListener('click', function () {
            closeAllDropdowns();

            const formEdit = document.getElementById('form-edit-rekening');
            const selBank = document.getElementById('edit_nama_bank');
            const inpNomor = document.getElementById('edit_nomor_rekening');
            const inpPemilik = document.getElementById('edit_nama_pemilik');

            formEdit.action = this.dataset.action;
            selBank.value = this.dataset.bank;
            inpNomor.value = this.dataset.nomor;
            inpPemilik.value = this.dataset.pemilik;

            showModal(modalEdit);
        });
    });

    // ==========================================
    // 4. TOAST NOTIFICATION
    // ==========================================
    const toast = document.getElementById('toast-notification');
    const toastMsg = document.getElementById('toast-message');
    let toastTimeout = null;

    function showToast(message) {
        if (!toast || !toastMsg) return;

        toastMsg.textContent = message;
        toast.classList.remove('hidden');
        toast.classList.add('flex');

        // Trigger animasi masuk
        setTimeout(function () {
            toast.classList.remove('opacity-0', 'translate-y-2');
            toast.classList.add('opacity-100', 'translate-y-0');
        }, 10);

        if (toastTimeout) clearTimeout(toastTimeout);

        toastTimeout = setTimeout(function () {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-2');
            setTimeout(function () {
                toast.classList.add('hidden');
                toast.classList.remove('flex');
            }, 300);
        }, 3000);
    }

    // ==========================================
    // 5. BUKA MODAL OTOMATIS JIKA ADA ERROR VALIDASI
    // ==========================================
    @if($errors->any())
        @if(old('_method') === 'PUT')
            showModal(modalEdit);
        @else
            showModal(modalTambah);
        @endif
    @endif

});
</script>
@endsection
