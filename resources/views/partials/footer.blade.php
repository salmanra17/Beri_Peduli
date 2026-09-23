<footer class="bg-[#134F4F] text-white">

    <div class="max-w-[1320px] mx-auto px-6 lg:px-10 pt-14 pb-10">

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8 lg:gap-10">

            {{-- KOLOM 1: BRAND & TENTANG --}}
            <div class="md:col-span-4">
                <a href="{{ route('beranda') }}" class="inline-block mb-4">
                    <img src="{{ asset('images/logo.png') }}"
                         class="w-36 h-auto object-contain brightness-0 invert"
                         alt="BeriPeduli">
                </a>

                <p class="text-sm text-white/75 leading-relaxed max-w-sm">
                    {{ __('Platform kemanusiaan terpercaya untuk membantu penanggulangan bencana dan Bakti sosial di seluruh pelosok Indonesia.') }}
                </p>
            </div>

            {{-- KOLOM 2: NAVIGASI (Diberi jarak dan digeser ke tengah) --}}
            <div class="md:col-span-2 md:col-start-6">
                <h4 class="font-semibold text-white mb-4 text-sm tracking-wide">
                    {{ __('Navigasi') }}
                </h4>

                <ul class="space-y-3 text-sm text-white/75">
                    <li>
                        <a href="{{ route('beranda') }}" class="hover:text-white transition-colors">
                            {{ __('Beranda') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kampanye.index') }}" class="hover:text-white transition-colors">
                            {{ __('Donasi') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('kampanye.create') }}" class="hover:text-white transition-colors">
                            {{ __('Galang Dana') }}
                        </a>
                    </li>
                    <li>
                        <a href="/tentang" class="hover:text-white transition-colors">
                            {{ __('Tentang Kami') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- KOLOM 3: LEGAL --}}
            <div class="md:col-span-2 md:col-start-8">
                <h4 class="font-semibold text-white mb-4 text-sm tracking-wide">
                    {{ __('Legal') }}
                </h4>

                <ul class="space-y-3 text-sm text-white/75">
                    <li>
                        <a href="#" class="hover:text-white transition-colors">
                            {{ __('Kebijakan Privasi') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hover:text-white transition-colors">
                            {{ __('Syarat & Ketentuan') }}
                        </a>
                    </li>
                </ul>
            </div>

            {{-- KOLOM 4: HUBUNGI KAMI & SOSIAL MEDIA --}}
            <div class="md:col-span-3 md:col-start-10">
                <h4 class="font-semibold text-white mb-4 text-sm tracking-wide">
                    {{ __('Hubungi Kami') }}
                </h4>

                <div class="space-y-2 text-sm text-white/75 mb-5">
                    <p>Email: halo@BeriPeduli.id</p>
                    <p>Telp: +62 21 555 1234</p>
                </div>

                {{-- SOSMED: IG, TIKTOK, YOUTUBE --}}
                <div class="flex items-center gap-3">
                    {{-- Instagram (Warna Asli) --}}
                    <a href="https://instagram.com" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] flex items-center justify-center text-white shadow-sm hover:opacity-90 hover:scale-105 transition-all"
                       aria-label="Instagram">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                    </a>

                    {{-- TikTok (Warna Asli) --}}
                    <a href="https://tiktok.com" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-full bg-black flex items-center justify-center text-white shadow-sm hover:opacity-90 hover:scale-105 transition-all"
                       aria-label="TikTok">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64c.298 0 .59.043.87.126V9.4a6.33 6.33 0 00-1-.08A6.34 6.34 0 003 15.66a6.34 6.34 0 009.68 5.43 6.27 6.27 0 003.07-5.42V8.71a8.16 8.16 0 004.84 1.57v-3.59a4.85 4.85 0 01-1-.0z"/>
                        </svg>
                    </a>

                    {{-- YouTube (Pilihan Terbaik & Warna Asli) --}}
                    <a href="https://youtube.com" target="_blank" rel="noopener noreferrer"
                       class="w-9 h-9 rounded-full bg-[#FF0000] flex items-center justify-center text-white shadow-sm hover:opacity-90 hover:scale-105 transition-all"
                       aria-label="YouTube">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                    </a>
                </div>
            </div>

        </div>

        {{-- COPYRIGHT --}}
        <div class="mt-14 pt-6 text-center text-xs text-white/50">
            &copy; 2026 BeriPeduli. {{ __('Melayani Dengan Kemanusiaan.') }}
        </div>

    </div>

</footer>