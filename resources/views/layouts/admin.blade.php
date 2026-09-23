<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') · BeriPeduli</title>
    <meta name="description" content="Panel admin BeriPeduli">
    <link rel="icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logosetengah-transparent.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logosetengah-transparent.png') }}">
    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-[#F6F7F8] text-gray-900 antialiased">

<div class="min-h-screen flex">

    {{-- ============ SIDEBAR ADMIN (PUTIH, w-[280px]) ============ --}}
    <aside class="w-[280px] flex-shrink-0 bg-white border-r border-gray-100 flex flex-col sticky top-0 h-screen overflow-y-auto">

        {{-- BRAND --}}
        <div class="px-6 pt-6 pb-4 flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-[#134F4F] flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z"/>
                </svg>
            </div>
            <div class="min-w-0 leading-tight">
                <p class="text-[15px] font-bold text-gray-900 truncate">BeriPeduli</p>
                <p class="text-xs text-gray-500 mt-0.5">Panel Admin</p>
            </div>
        </div>

        {{-- MENU SIDEBAR --}}
        <nav class="px-4 space-y-1">

            {{-- GRUP: VERIFIKASI --}}
            <p class="px-3.5 pt-2 pb-1.5 text-[11px] font-semibold uppercase tracking-wider text-gray-400">Verifikasi</p>

            {{-- DASHBOARD --}}
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center justify-between gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.dashboard') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z"/>
                    </svg>
                    <span class="truncate">Dashboard</span>
                </span>
            </a>

            {{-- VERIFIKASI KAMPANYE --}}
            <a href="{{ route('admin.kampanye.index') }}"
               class="flex items-center justify-between gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.kampanye.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
                    </svg>
                    <span class="truncate">Verifikasi Kampanye</span>
                </span>
                <span class="rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5">{{ $sidebarKampanyeMenunggu }}</span>
            </a>

            {{-- VERIFIKASI REKENING --}}
            <a href="{{ route('admin.rekening.index') }}"
               class="flex items-center justify-between gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.rekening.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-19.5 0a.75.75 0 0 0-1.5 0v15c0 .414.336.75.75.75h19.5a.75.75 0 0 0 .75-.75v-15a.75.75 0 0 0-1.5 0m2.25 0v7.5h-3a3 3 0 0 1-6 0H3.75"/>
                    </svg>
                    <span class="truncate">Verifikasi Rekening</span>
                </span>
                <span class="rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5">{{ $sidebarRekeningMenunggu }}</span>
            </a>

            {{-- PENARIKAN DANA --}}
            <a href="{{ route('admin.penarikan.index') }}"
               class="flex items-center justify-between gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.penarikan.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                    </svg>
                    <span class="truncate">Penarikan Dana</span>
                </span>
                <span class="rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5">{{ $sidebarPenarikanDiproses }}</span>
            </a>

            {{-- BUKTI PENYALURAN --}}
            <a href="{{ route('admin.bukti.index') }}"
               class="flex items-center justify-between gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.bukti.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <span class="flex items-center gap-3 min-w-0">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
                    </svg>
                    <span class="truncate">Bukti Penyaluran</span>
                </span>
                <span class="rounded-full bg-gray-100 text-gray-600 text-xs font-semibold px-2 py-0.5">{{ $sidebarBuktiMenunggu }}</span>
            </a>

            {{-- GARIS PEMISAH --}}
            <div class="my-3 border-t border-gray-100"></div>

            {{-- GRUP: KELOLA --}}
            <p class="px-3.5 pt-2 pb-1.5 text-[11px] font-semibold uppercase tracking-wider text-gray-400">Kelola</p>

            {{-- MANAJEMEN KAMPANYE --}}
            <a href="{{ route('admin.manajemen-kampanye.index') }}"
               class="flex items-center gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.manajemen-kampanye.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/>
                </svg>
                <span class="truncate">Manajemen Kampanye</span>
            </a>

            {{-- MANAJEMEN USER --}}
            <a href="{{ route('admin.user.index') }}"
               class="flex items-center gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.user.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"/>
                </svg>
                <span class="truncate">Manajemen User</span>
            </a>

            {{-- MODERASI KOMENTAR --}}
            <a href="{{ route('admin.komentar.index') }}"
               class="flex items-center gap-3 rounded-[11px] px-3.5 py-2.5 text-sm {{ request()->routeIs('admin.komentar.*') ? 'bg-[#E4EEEE] text-[#135B59] font-semibold' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z"/>
                </svg>
                <span class="truncate">Moderasi Komentar</span>
            </a>

        </nav>

        {{-- TOMBOL LOGOUT ADMIN --}}
        <div class="mt-auto p-4 border-t border-gray-100">
            <form method="POST" action="{{ route('admin.logout') }}" onsubmit="return confirm('Apakah Anda yakin ingin logout?');">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-3 rounded-[11px] px-3.5 py-2.5 text-sm font-medium text-red-600 hover:bg-red-50 transition cursor-pointer">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0-3-3m0 0-3-3m3 3V12"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    {{-- ============ MAIN CONTENT ============ --}}
    <div class="flex-1 min-w-0 flex flex-col">

        @yield('content')

    </div>

</div>

@vite(['resources/js/app.js'])

</body>
</html>