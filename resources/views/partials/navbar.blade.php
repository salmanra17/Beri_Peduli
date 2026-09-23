<nav class="sticky top-0 z-50 bg-white border-b">

    <div class="max-w-[1320px] mx-auto px-4 lg:px-10 py-3">

        <div class="flex items-center justify-between">


            {{-- LOGO --}}
            <a href="{{ route('beranda') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" class="w-24 object-contain" alt="BeriPeduli">
            </a>


            {{-- MENU DESKTOP --}}
            <div class="hidden md:flex gap-6 text-sm">

                <a href="{{ route('beranda') }}"
                    class="{{ request()->is('beranda', '/') ? 'font-bold text-[#134F4F] underline decoration-[#134F4F] decoration-2 underline-offset-6' : 'text-gray-700 hover:text-[#134F4F]' }} transition">
                    {{ __('Beranda') }}
                </a>

                <a href="{{ route('kampanye.index') }}"
                    class="{{ ((request()->is('kampanye*') && !request()->is('kampanye/create*')) || request()->is('donasi*')) ? 'font-bold text-[#134F4F] underline decoration-[#134F4F] decoration-2 underline-offset-6' : 'text-gray-700 hover:text-[#134F4F]' }} transition">
                    {{ __('Donasi') }}
                </a>

                <a href="{{ route('kampanye.create') }}"
                    class="{{ request()->is('kampanye/create*') ? 'font-bold text-[#134F4F] underline decoration-[#134F4F] decoration-2 underline-offset-6' : 'text-gray-700 hover:text-[#134F4F]' }} transition">
                    {{ __('Galang Dana') }}
                </a>

                <a href="{{ route('tentang') }}"
                    class="{{ request()->routeIs('tentang') ? 'font-bold text-[#134F4F] underline decoration-[#134F4F] decoration-2 underline-offset-6' : 'text-gray-700 hover:text-[#134F4F]' }} transition">
                    {{ __('Tentang Kami') }}
                </a>

            </div>



            {{-- RIGHT --}}
            <div class="flex items-center gap-3">

                {{-- LANGUAGE --}}
                <div class="hidden md:flex items-center border rounded-full p-0.5 w-[68px]">

                    <a href="{{ route('bahasa.set', 'en') }}"
                        class="w-1/2 text-center text-xs py-1 rounded-full {{ app()->getLocale() === 'en' ? 'bg-[#D8F0EC] text-[#134F4F] font-bold' : 'text-gray-500 hover:text-[#134F4F]' }}">
                        EN
                    </a>

                    <a href="{{ route('bahasa.set', 'id') }}"
                        class="w-1/2 text-center text-xs py-1 rounded-full {{ app()->getLocale() === 'id' ? 'bg-[#D8F0EC] text-[#134F4F] font-bold' : 'text-gray-500 hover:text-[#134F4F]' }}">
                        ID
                    </a>

                </div>


                {{-- USER PROFILE --}}
                @auth

                    <a href="{{ route('dashboard') }}" class="flex items-center justify-center">

                        @if(auth()->user()->foto_profil)

                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                class="w-8 h-8 rounded-full object-cover border border-[#134F4F]" alt="Profile">

                        @else

                            <div class="w-8 h-8 rounded-full bg-[#D8F0EC]
                                            flex items-center justify-center
                                            text-[#134F4F]
                                            font-bold text-xs">

                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                            </div>

                        @endif

                    </a>


                @else

                    <a href="{{ route('login', ['redirect' => url()->full()]) }}"
                       class="hidden md:inline-block bg-[#134F4F] text-white px-4 py-1.5 rounded-lg text-sm font-medium hover:bg-[#0c4444] transition">
                        {{ __('Masuk') }}
                    </a>

                @endauth

                {{-- HAMBURGER (mobile) --}}
                <button id="nav-hamburger"
                        class="md:hidden flex items-center justify-center w-8 h-8 rounded-lg text-gray-600 hover:bg-gray-100 transition"
                        aria-label="Menu">
                    <svg id="hamburger-icon" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                    </svg>
                    <svg id="close-icon" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>

            </div>


        </div>


        {{-- MOBILE MENU --}}
        <div id="mobile-menu" class="hidden md:hidden border-t mt-3 pt-3 pb-2 flex flex-col gap-1">

            <a href="{{ route('beranda') }}"
               class="px-3 py-2 rounded-lg text-sm {{ request()->is('beranda', '/') ? 'font-bold text-[#134F4F] bg-[#f0fafa]' : 'text-gray-700' }}">
                {{ __('Beranda') }}
            </a>

            <a href="{{ route('kampanye.index') }}"
               class="px-3 py-2 rounded-lg text-sm {{ (request()->is('kampanye*') && !request()->is('kampanye/create*')) ? 'font-bold text-[#134F4F] bg-[#f0fafa]' : 'text-gray-700' }}">
                {{ __('Donasi') }}
            </a>

            <a href="{{ route('kampanye.create') }}"
               class="px-3 py-2 rounded-lg text-sm {{ request()->is('kampanye/create*') ? 'font-bold text-[#134F4F] bg-[#f0fafa]' : 'text-gray-700' }}">
                {{ __('Galang Dana') }}
            </a>

            <a href="{{ route('tentang') }}"
               class="px-3 py-2 rounded-lg text-sm {{ request()->routeIs('tentang') ? 'font-bold text-[#134F4F] bg-[#f0fafa]' : 'text-gray-700' }}">
                {{ __('Tentang Kami') }}
            </a>

            {{-- Language mobile --}}
            <div class="flex items-center gap-2 px-3 pt-2 mt-1 border-t">
                <span class="text-xs text-gray-500">{{ __('Bahasa:') }}</span>
                <a href="{{ route('bahasa.set', 'en') }}"
                   class="text-xs px-2.5 py-1 rounded-full {{ app()->getLocale() === 'en' ? 'bg-[#D8F0EC] text-[#134F4F] font-bold' : 'text-gray-500' }}">EN</a>
                <a href="{{ route('bahasa.set', 'id') }}"
                   class="text-xs px-2.5 py-1 rounded-full {{ app()->getLocale() === 'id' ? 'bg-[#D8F0EC] text-[#134F4F] font-bold' : 'text-gray-500' }}">ID</a>
            </div>

            @guest
                <a href="{{ route('login', ['redirect' => url()->full()]) }}"
                   class="mt-2 mx-3 text-center bg-[#134F4F] text-white px-4 py-2 rounded-lg text-sm font-medium">
                    {{ __('Masuk') }}
                </a>
            @endguest

        </div>

    </div>

</nav>

<script>
    (function () {
        const btn    = document.getElementById('nav-hamburger');
        const menu   = document.getElementById('mobile-menu');
        const iconHam = document.getElementById('hamburger-icon');
        const iconX   = document.getElementById('close-icon');

        if (!btn || !menu) return;

        btn.addEventListener('click', function () {
            const open = !menu.classList.contains('hidden');
            menu.classList.toggle('hidden', open);
            iconHam.classList.toggle('hidden', !open);
            iconX.classList.toggle('hidden', open);
        });
    })();
</script>