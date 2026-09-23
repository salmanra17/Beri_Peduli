<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Admin Masuk | BeriPeduli</title>

    <link rel="icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logosetengah-transparent.png') }}">

    @vite(['resources/css/app.css'])
</head>

<body class="bg-[#f1f1f1] font-sans antialiased">

    <div class="grid min-h-screen lg:grid-cols-2">

        {{-- ============ KIRI: BRAND PANEL ============ --}}

        <aside class="hidden items-center bg-[#105b59] px-10 py-16 lg:flex xl:px-24">
            <div class="max-w-2xl">
                <div class="mb-20">
                    <img src="{{ asset('images/logo.png') }}" class="w-40 object-contain brightness-0 invert" alt="BeriPeduli">
                </div>

                <h1 class="text-4xl font-bold leading-tight text-white">
                    Buka Dasbor Pengelolaan Kampanye BeriPeduli
                </h1>

                <p class="mt-6 max-w-md text-lg leading-relaxed text-white/80">
                    Masuk menggunakan akun admin untuk menyetujui, meninjau, dan mengelola seluruh kampanye di BeriPeduli.
                </p>
            </div>
        </aside>

        {{-- ============ KANAN: FORM ============ --}}

        <main class="flex items-center justify-center px-5 py-12 sm:px-8">
            <div class="w-full max-w-md">

                {{-- Brand ringkas versi mobile --}}

                <div class="mb-10 flex items-center justify-center lg:hidden">
                    <img src="{{ asset('images/logo.png') }}" class="w-36 object-contain" alt="BeriPeduli">
                </div>

                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#111827]">Masuk Sebagai Admin</h2>
                    <p class="mt-2 text-[#6B7280]">Silahkan Masuk Untuk Mengelola Kampanye</p>
                </div>

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="/admin/login" class="mt-8 flex flex-col gap-6">
                    @csrf

                    {{-- Email --}}

                    <x-auth-field
                        name="email"
                        label="Email"
                        type="email"
                        placeholder="admin@beripeduli.com"
                        autocomplete="username"
                        :autofocus="true"
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    {{-- Password --}}

                    <x-auth-field
                        name="password"
                        label="Password"
                        type="password"
                        placeholder="********"
                        autocomplete="current-password"
                        viewable
                        required
                    >
                        <x-slot name="icon">
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                            </svg>
                        </x-slot>
                    </x-auth-field>

                    <button
                        type="submit"
                        class="mt-2 w-full rounded-xl bg-[#105b59] py-4 text-base font-bold text-white transition hover:bg-[#0c4a3d]"
                    >
                        Masuk Admin
                    </button>
                </form>
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