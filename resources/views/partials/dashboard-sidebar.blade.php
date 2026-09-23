@auth
    <div class="w-64 lg:w-[280px] flex-shrink-0 bg-white border-e border-gray-100 flex flex-col min-h-screen">

        {{-- LOGO --}}
        <div class="px-5 pt-5 pb-4">

            <a href="{{ route('beranda') }}" class="inline-block">
                <img src="{{ asset('images/logo.png') }}" alt="BeriPeduli"
                     class="w-[190px] h-auto object-contain">
            </a>

        </div>

        {{-- PROFILE CHIP --}}
        <div class="mx-5 mb-2 flex items-center gap-3 rounded-xl px-2.5 py-2">

            @if(auth()->user()->foto_profil)
                <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="{{ auth()->user()->name }}"
                     class="w-10 h-10 rounded-full object-cover flex-shrink-0 border border-gray-100 shadow-sm">
            @else
                <div class="w-10 h-10 rounded-full bg-[#134F4F] text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif

            <div class="min-w-0 leading-tight">
                <p class="text-sm font-bold text-gray-900 truncate">
                    Halo, {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-gray-500 mt-0.5">
                    {{ $roleLabel ?? 'Relawan Kemanusiaan' }}
                </p>
            </div>

        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 mt-2 space-y-1">

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 rounded-xl bg-[#E5EEEE] text-[#134F4F] px-3.5 py-2.5 text-sm font-semibold">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75"/>
                </svg>
                Beranda Dashboard
            </a>

            <a href="{{ route('kampanye.index') }}"
               class="flex items-center gap-3 rounded-xl text-gray-600 hover:bg-gray-50 px-3.5 py-2.5 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Galang Dana
            </a>

            <a href="{{ route('donasi.history') }}"
               class="flex items-center gap-3 rounded-xl text-gray-600 hover:bg-gray-50 px-3.5 py-2.5 text-sm font-medium">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="m21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                </svg>
                Riwayat Donasi
            </a>

            <span class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm font-medium text-gray-400 cursor-not-allowed">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0-3-3m0 0-3 3m3-3v11m0 0h.008v.008H15V21Z"/>
                </svg>
                Riwayat Penarikan
            </span>

        </nav>

        {{-- PENGATURAN + LOGOUT --}}
        <div class="px-4 pt-3 mt-2 border-t border-gray-100 space-y-1">

            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 rounded-xl px-3.5 py-2.5 text-sm {{ request()->routeIs('profile.*') ? 'bg-[#E5EEEE] text-[#134F4F] font-semibold' : 'text-gray-600 hover:bg-gray-50 font-medium' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.6 6.6 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>
                Pengaturan Akun
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 rounded-xl text-gray-600 hover:bg-gray-50 px-3.5 py-2.5 text-sm font-medium">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0-3-3m0 0-3 3m3-3v11m0 0h.008v.008H15v-.008Z"/>
                    </svg>
                    Keluar
                </button>
            </form>

        </div>

    </div>
@endauth
