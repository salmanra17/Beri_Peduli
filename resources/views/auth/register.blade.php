<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ __('Daftar') }} | BeriPeduli</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logosetengah-transparent.png') }}">

    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#f1f1f1] font-sans antialiased">

    <div class="grid min-h-screen lg:grid-cols-2">

        {{-- ============ KIRI: BRAND PANEL ============ --}}

        <aside class="relative hidden overflow-hidden bg-gradient-to-br from-[#105b59] via-[#0d4f4e] to-[#093d3c] px-8 py-10 lg:flex lg:items-center xl:px-14">
            {{-- Watermark dekorasi logo di background --}}
            <img src="{{ asset('images/logosetengah-transparent.png') }}" class="pointer-events-none absolute -bottom-10 -right-10 w-72 select-none opacity-10 brightness-0 invert" alt="">
            <div class="pointer-events-none absolute -top-20 -left-20 h-64 w-64 rounded-full bg-white/5 blur-3xl"></div>

            <div class="relative z-10 w-full max-w-md">
                <div class="mb-7">
                    <img src="{{ asset('images/logo.png') }}" class="w-32 object-contain brightness-0 invert" alt="BeriPeduli">
                </div>

                <h1 class="text-2xl font-bold leading-snug text-white">
                    {{ __('Mulai Langkah Kebaikan Anda.') }}
                </h1>

                <p class="mt-3 text-sm leading-relaxed text-white/80">
                    {{ __('Daftar sekarang untuk mulai membantu sesama yang membutuhkan bantuan Anda.') }}
                </p>

                {{-- Nilai Keunggulan --}}
                <div class="mt-7 space-y-4">
                    <div class="flex items-start gap-3.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-emerald-300 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">{{ __('100% Transparan & Terbuka') }}</h3>
                            <p class="text-xs leading-relaxed text-white/75">{{ __('Setiap donasi tercatat rapi disertai bukti penyaluran sah di lapangan.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-emerald-300 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.979-3.199a4.5 4.5 0 119.04 0 4.5 4.5 0 01-9.04 0zM12 6.75a3 3 0 100-6 3 3 0 000 6z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">{{ __('Relawan & Mitra Terpercaya') }}</h3>
                            <p class="text-xs leading-relaxed text-white/75">{{ __('Penyaluran bantuan dilakukan langsung kepada penerima yang membutuhkan.') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3.5">
                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white/10 text-emerald-300 backdrop-blur-sm">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-white">{{ __('Dampak Kebaikan Nyata') }}</h3>
                            <p class="text-xs leading-relaxed text-white/75">{{ __('Ribuan senyum telah terukir berkat uluran tangan orang-orang baik.') }}</p>
                        </div>
                    </div>
                </div>

                {{-- Social Proof Card --}}
                <div class="mt-7 flex items-center gap-3.5 rounded-2xl border border-white/15 bg-white/10 p-3.5 backdrop-blur-md">
                    <div class="flex -space-x-2">
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-200 text-[11px] font-bold text-amber-900 ring-2 ring-[#0d4f4e]">BP</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-teal-200 text-[11px] font-bold text-teal-900 ring-2 ring-[#0d4f4e]">AD</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-sky-200 text-[11px] font-bold text-sky-900 ring-2 ring-[#0d4f4e]">SN</div>
                        <div class="flex h-8 w-8 items-center justify-center rounded-full bg-emerald-400 text-[10px] font-bold text-emerald-950 ring-2 ring-[#0d4f4e]">+5k</div>
                    </div>
                    <div class="text-xs">
                        <p class="font-semibold text-white">{{ __('5.000+ Orang Baik Bergabung') }}</p>
                        <p class="text-white/70">{{ __('Mari bersama hadirkan senyum untuk sesama.') }}</p>
                    </div>
                </div>
            </div>
        </aside>

        {{-- ============ KANAN: FORM ============ --}}

        <main class="flex items-center justify-center px-5 py-8 sm:px-8">
            <div class="w-full max-w-sm">

                {{-- Brand ringkas versi mobile --}}
                <div class="mb-5 flex items-center justify-center lg:hidden">
                    <img src="{{ asset('images/logo.png') }}" class="w-28 object-contain" alt="BeriPeduli">
                </div>

                <div class="text-center">
                    <h2 class="text-2xl font-bold text-[#111827]">{{ __('Buat Akun Baru') }}</h2>
                    <p class="mt-1 text-sm text-[#6B7280]">{{ __('Isi detail Anda untuk menjadi bagian dari perubahan.') }}</p>
                </div>

                @if ($errors->any())
                    <div class="mt-4 rounded-xl border border-red-200 bg-red-50 px-4 py-2.5 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}" class="mt-5 flex flex-col gap-3.5">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <x-auth-field
                        name="name"
                        label="{{ __('Nama Lengkap') }}"
                        placeholder="{{ __('Masukkan Nama Lengkap Anda') }}"
                        autocomplete="name"
                        :autofocus="true"
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    {{-- Email --}}
                    <x-auth-field
                        name="email"
                        label="{{ __('Email') }}"
                        type="email"
                        placeholder="{{ __('Contoh@gmail.com') }}"
                        autocomplete="email"
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    {{-- No Handphone --}}
                    <x-auth-field
                        name="no_hp"
                        label="{{ __('No Handphone') }}"
                        type="tel"
                        placeholder="0812xxxx"
                        autocomplete="tel"
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    {{-- Password --}}
                    <x-auth-field
                        name="password"
                        label="{{ __('Password') }}"
                        type="password"
                        placeholder="{{ __('Masukkan Password') }}"
                        autocomplete="new-password"
                        viewable
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    {{-- Konfirmasi Password --}}
                    <x-auth-field
                        name="password_confirmation"
                        label="{{ __('Konfirmasi Password') }}"
                        type="password"
                        placeholder="{{ __('Ulangi Password Anda') }}"
                        autocomplete="new-password"
                        viewable
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    <button
                        type="submit"
                        class="mt-1 w-full rounded-xl bg-[#105b59] py-2.5 text-sm font-bold text-white transition hover:bg-[#0c4a3d]"
                    >
                        {{ __('Daftar Sekarang') }}
                    </button>
                </form>

                {{-- Divider --}}
                <div class="mt-4 flex items-center gap-3 text-xs font-medium text-[#6B7280]">
                    <span class="h-px flex-1 bg-[#B7C8C5]"></span>
                    {{ __('Atau Daftar Dengan') }}
                    <span class="h-px flex-1 bg-[#B7C8C5]"></span>
                </div>

                {{-- Social --}}
                <div class="mt-3 grid grid-cols-2 gap-3">
                    <a
                        href="{{ route('auth.redirect', 'google') }}"
                        class="flex items-center justify-center gap-2 rounded-xl bg-[#105b59] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0c4a3d]"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="white">
                            <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .48 5.387.48 12s5.387 12 12 12c3.493 0 6.36-1.193 8.48-3.413 2.267-2.227 2.987-5.453 2.987-8.027 0-.617-.056-1.16-.133-1.64H12.48Z" />
                        </svg>
                        Google
                    </a>

                    <a
                        href="{{ route('auth.redirect', 'apple') }}"
                        class="flex items-center justify-center gap-2 rounded-xl bg-[#105b59] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#0c4a3d]"
                    >
                        <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12.152 6.896c-.948 0-2.415-1.078-3.96-1.04-2.04.027-3.91 1.183-4.961 3.014-2.117 3.675-.546 9.103 1.519 12.09 1.013 1.454 2.208 3.09 3.792 3.03 1.52-.065 2.09-.987 3.935-.987 1.831 0 2.35.987 3.96.948 1.637-.026 2.676-1.48 3.676-2.948 1.156-1.688 1.636-3.325 1.662-3.415-.039-.013-3.182-1.221-3.22-4.857-.026-3.04 2.48-4.494 2.597-4.559-1.429-2.09-3.623-2.324-4.39-2.376-2-.156-3.675 1.09-4.61 1.09ZM15.53 3.83c.843-1.012 1.4-2.427 1.245-3.83-1.207.052-2.662.805-3.532 1.818-.78.896-1.454 2.338-1.273 3.714 1.338.104 2.715-.688 3.56-1.702" />
                        </svg>
                        Apple
                    </a>
                </div>

                {{-- Footer --}}
                <p class="mt-4 text-center text-xs text-[#6B7280]">
                    {{ __('Sudah Punya Akun?') }}
                    <a href="{{ route('login') }}" class="font-bold text-[#105b59] transition hover:underline">
                        {{ __('Masuk Sekarang') }}
                    </a>
                </p>
            </div>
        </main>
    </div>

    <script>
        document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
            button.addEventListener('click', function () {
                var input = document.getElementById(button.getAttribute('data-password-toggle'));
                var turningVisible = input.type === 'password';

                input.type = turningVisible ? 'text' : 'password';

                button.querySelector('[data-icon="eye"]').classList.toggle('hidden', turningVisible);
                button.querySelector('[data-icon="eye-slash"]').classList.toggle('hidden', !turningVisible);
            });
        });
    </script>

</body>

</html>