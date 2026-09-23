<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('Dashboard')) · BeriPeduli</title>
    <meta name="description" content="{{ __('Dashboard pengguna BeriPeduli') }}">
    <link rel="icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logosetengah-transparent.png') }}">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#F6F7F8] text-gray-900 antialiased">

<div class="min-h-screen flex">

    {{-- ============ SIDEBAR (PUTIH, COMPACT ~w-[245px]) ============ --}}
    <aside class="w-[245px] flex-shrink-0 bg-white border-r border-gray-100 flex flex-col sticky top-0 h-screen overflow-y-auto">
        {{-- LOGO ASLI PROJECT (CENTER) --}}
        <div class="px-5 pt-6 pb-3.5 flex justify-center">
            <a href="{{ route('beranda') }}" class="inline-block">
                <img src="{{ asset('images/logo.png') }}" alt="BeriPeduli"
                     class="w-[115px] h-auto object-contain">
            </a>
        </div>

        {{-- PILIH BAHASA --}}
        <div class="mx-5 mb-4">
            <p class="text-[10px] font-semibold uppercase tracking-wider text-gray-400 mb-1.5 text-center">{{ __('Bahasa') }}</p>
            <div class="flex items-center border border-gray-200 rounded-full p-0.5">
                <a href="{{ route('bahasa.set', 'id') }}"
                   class="flex-1 text-center text-xs py-0.5 rounded-full {{ app()->getLocale() === 'id' ? 'bg-[#134F4F] text-white font-bold' : 'text-gray-500 hover:text-[#134F4F]' }}">
                    ID
                </a>
                <a href="{{ route('bahasa.set', 'en') }}"
                   class="flex-1 text-center text-xs py-0.5 rounded-full {{ app()->getLocale() === 'en' ? 'bg-[#134F4F] text-white font-bold' : 'text-gray-500 hover:text-[#134F4F]' }}">
                    EN
                </a>
            </div>
        </div>

        {{-- PROFILE USER (chip kecil) --}}
        <div class="mx-5 mb-5 flex items-center gap-2.5">

            @if($user->foto_profil)
                <img src="{{ asset('storage/' . $user->foto_profil) }}" alt="{{ $user->name }}"
                     class="w-9 h-9 rounded-full object-cover flex-shrink-0 border border-gray-100 shadow-sm">
            @else
                <div class="w-9 h-9 rounded-full bg-[#134F4F] text-white flex items-center justify-center font-bold text-xs flex-shrink-0">
                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0 leading-tight">
                <p class="text-[13px] font-bold text-gray-900 truncate">
                    {{ __('Halo') }}, {{ $user->name }}
                </p>
                <p class="text-[11px] text-gray-500 mt-0.5">
                    {{ $roleLabel ?? __('Relawan Kemanusiaan') }}
                </p>
            </div>

        </div>

        {{-- MENU SIDEBAR --}}
        <nav class="px-3.5 space-y-1.5">

            {{-- BERANDA DASHBOARD (AKTIF) --}}
            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] {{ request()->routeIs('dashboard') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                </svg>
                <span>{{ __('Beranda Dashboard') }}</span>
            </a>

            {{-- GALANG DANA SAYA --}}
            <a href="{{ route('kampanye.saya') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] {{ request()->routeIs('kampanye.saya*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                <span>{{ __('Galang Dana') }}</span>
            </a>

            {{-- RIWAYAT DONASI --}}
            <a href="{{ route('donasi.history') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] {{ request()->routeIs('donasi.history') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span>{{ __('Riwayat Donasi') }}</span>
            </a>

            {{-- RIWAYAT PENARIKAN --}}
            <a href="{{ route('penarikan.index') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] {{ request()->routeIs('penarikan.*') || request()->is('riwayat-penarikan*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <rect x="2" y="6" width="20" height="12" rx="3" stroke-width="1.7"/>
                    <circle cx="12" cy="12" r="2.5" stroke-width="1.7"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 12h.01M18 12h.01"/>
                </svg>
                <span>{{ __('Riwayat Penarikan') }}</span>
            </a>

            {{-- BUKTI PENYALURAN --}}
            <a href="{{ route('bukti-penyaluran.index') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] {{ request()->routeIs('bukti-penyaluran.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                </svg>
                <span>{{ __('Bukti Penyaluran') }}</span>
            </a>

            {{-- GARIS PEMISAH --}}
            <div class="my-3 border-t border-gray-100"></div>


            {{-- PENGATURAN AKUN --}}
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] {{ request()->routeIs('profile.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.6 6.6 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                <span>{{ __('Pengaturan Akun') }}</span>
            </a>

            {{-- KELUAR --}}
            <form id="form-logout" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
            <button type="button"
                    onclick="document.getElementById('modal-logout').classList.remove('hidden'); document.getElementById('modal-logout').classList.add('flex');"
                    class="flex w-full items-center gap-3 rounded-xl px-3.5 py-2.5 text-[13px] text-gray-500 hover:bg-gray-50 text-left cursor-pointer font-medium">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3V12"/>
                </svg>
                <span>{{ __('Keluar') }}</span>
            </button>

        </nav>

    </aside>

    {{-- ============ MAIN CONTENT ============ --}}
    <div class="flex-1 min-w-0 flex flex-col">

        @yield('content')

    </div>

</div>

{{-- ══════════════════════ MODAL KONFIRMASI LOGOUT ══════════════════════ --}}
<div id="modal-logout"
     class="fixed inset-0 z-[999] hidden items-center justify-center p-4"
     role="dialog" aria-modal="true">

    {{-- Backdrop --}}
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
         onclick="document.getElementById('modal-logout').classList.add('hidden'); document.getElementById('modal-logout').classList.remove('flex');"></div>

    {{-- Card --}}
    <div class="relative bg-white w-full max-w-[380px] rounded-2xl shadow-xl z-10 overflow-hidden animate-in fade-in zoom-in-95 duration-150 p-6 text-center">

        {{-- Ikon --}}
        <div class="w-12 h-12 rounded-full bg-red-50 text-red-500 flex items-center justify-center mx-auto mb-3.5">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3V12"/>
            </svg>
        </div>

        {{-- Judul & Deskripsi --}}
        <h3 class="text-base font-semibold text-gray-800 mb-1.5">{{ __('Keluar dari BeriPeduli?') }}</h3>
        <p class="text-xs text-gray-500 leading-relaxed max-w-[280px] mx-auto mb-6">
            {{ __('Sesi kamu akan diakhiri. Kamu bisa masuk kembali kapan saja.') }}
        </p>

        {{-- Tombol --}}
        <div class="flex gap-3">
            <button type="button"
                    onclick="document.getElementById('modal-logout').classList.add('hidden'); document.getElementById('modal-logout').classList.remove('flex');"
                    class="flex-1 py-2.5 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-xs font-medium text-gray-600 transition cursor-pointer">
                {{ __('Batal') }}
            </button>
            <button type="button"
                    onclick="document.getElementById('form-logout').submit();"
                    class="flex-1 py-2.5 rounded-xl bg-red-500 hover:bg-red-600 text-white text-xs font-medium shadow-sm transition cursor-pointer">
                {{ __('Ya, Keluar') }}
            </button>
        </div>

    </div>
</div>

<script>
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            const m = document.getElementById('modal-logout');
            if (m && !m.classList.contains('hidden')) {
                m.classList.add('hidden');
                m.classList.remove('flex');
            }
        }
    });
</script>

@vite(['resources/js/app.js'])

</body>
</html>