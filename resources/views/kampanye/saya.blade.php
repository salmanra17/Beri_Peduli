@extends('layouts.dashboard')

@section('title', __('Galang Dana Saya'))

@section('content')

    @php
        $badges = [
            'aktif' => ['bg-[#FBB532]', 'text-[#0f4947]', __('SEDANG BERJALAN')],
            'selesai' => ['bg-[#135B59]', 'text-white', __('TERCAPAI')],
            'menunggu' => ['bg-[#E4F0EE]', 'text-[#135B59]', __('MENUNGGU VERIFIKASI')],
            'ditolak' => ['bg-[#F1F1F1]', 'text-[#0f4947]', __('DITOLAK')],
        ];

        $tabs = [
            'all' => ['label' => __('Semua'), 'count' => $counts['semua'], 'active' => $statusFilter === null],
            'berjalan' => ['label' => __('Sedang Berjalan'), 'count' => $counts['berjalan'], 'active' => $statusFilter === 'aktif'],
            'selesai' => ['label' => __('Selesai'), 'count' => $counts['selesai'], 'active' => $statusFilter === 'selesai'],
            'menunggu' => ['label' => __('Menunggu Verifikasi'), 'count' => $counts['menunggu'], 'active' => $statusFilter === 'menunggu'],
        ];

        $currentSearch = request('search');
    @endphp

    <main class="flex-1 min-w-0 bg-[#F1F1F1]">

        <div class="max-w-[1180px] mx-auto px-6 lg:px-8 pt-7 pb-16">

            {{-- HEADER --}}
            <header class="flex flex-wrap items-center justify-between gap-4">

                <div>
                    <h1 class="text-xl sm:text-2xl font-bold text-[#1A1A1A] leading-tight">
                        {{ __('Galang Dana') }}
                    </h1>
                    <p class="mt-1 text-xs sm:text-sm text-gray-500">
                        {{ __('Pantau dan kelola kampanye kemanusiaan yang Anda inisiasi.') }}
                    </p>
                </div>

                <a href="{{ route('kampanye.create') }}"
                    class="inline-flex items-center gap-1.5 bg-[#135B59] hover:bg-[#0f4947] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    {{ __('Buat Galang Dana') }}
                </a>

            </header>

            {{-- FLASH MESSAGES --}}
            <x-flash-message class="mt-5" />

            {{-- TABS --}}
            <nav class="mt-6 flex flex-wrap items-center gap-x-6 gap-y-3 border-b border-[#E5E5E5]">
                @foreach ($tabs as $key => $tab)
                    @php
                        $params = array_filter([
                            'status' => $key === 'all' ? null : $key,
                            'search' => $currentSearch,
                        ]);
                    @endphp
                    <a href="{{ route('kampanye.saya', $params) }}"
                        class="-mb-px inline-flex items-baseline gap-1.5 pb-3 text-xs sm:text-sm border-b-2 transition-colors
                                                      {{ $tab['active'] ? 'border-[#135B59] text-[#135B59] font-bold' : 'border-transparent text-[#64748B] hover:text-[#135B59] font-medium' }}">
                        {{ $tab['label'] }}
                        <span class="{{ $tab['active'] ? 'text-[#135B59]' : 'text-[#64748B]' }}">
                            ({{ $tab['count'] }})
                        </span>
                    </a>
                @endforeach
            </nav>

            {{-- SEARCH + FILTER (1 BARIS MEMANJANG) --}}
            <form method="GET" action="{{ route('kampanye.saya') }}"
    class="mt-6 bg-white rounded-2xl shadow-sm border border-[#E5E5E5] px-6 py-5">

    <div class="grid grid-cols-1 md:grid-cols-[1fr_380px_auto] gap-4 items-end">


        <div>

            <label for="search" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                {{ __('Cari Campaign') }}
            </label>

            <div class="relative">

                <svg class="w-4 h-4 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"
                    fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />

                </svg>


                <input type="text"
                    name="search"
                    id="search"
                    value="{{ $currentSearch }}"
                    placeholder="{{ __('Masukkan nama campaign...') }}"
                    class="w-full h-[42px] pl-11 pr-4 rounded-xl border border-[#E5E5E5] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none">

            </div>

        </div>



        <div>

            <label for="status" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                {{ __('Status') }}
            </label>


            <select name="status"
                id="status"
                class="w-full h-[42px] px-4 rounded-xl border border-[#E5E5E5] text-sm focus:ring-2 focus:ring-[#135B59] focus:border-[#135B59] focus:outline-none">

                <option value="" {{ $statusFilter === null ? 'selected' : '' }}>{{ __('Semua Status') }}</option>
                <option value="berjalan" {{ $statusFilter === 'aktif' ? 'selected' : '' }}>{{ __('Sedang Berjalan') }}</option>
                <option value="selesai" {{ $statusFilter === 'selesai' ? 'selected' : '' }}>{{ __('Selesai') }}</option>
                <option value="menunggu" {{ $statusFilter === 'menunggu' ? 'selected' : '' }}>{{ __('Menunggu Verifikasi') }}</option>

            </select>

        </div>




        <div>

            <button type="submit"
                class="h-[42px] inline-flex items-center justify-center gap-2 px-8 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white text-sm font-semibold transition-colors whitespace-nowrap">

                <svg class="w-4 h-4"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="2.2"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M12 3c2.755 0 5.455.232 8.083.678.533.09.917.556.917 1.096v1.044a2.25 2.25 0 0 1-.659 1.591l-5.432 5.432a2.25 2.25 0 0 0-.659 1.591v2.927a2.25 2.25 0 0 1-1.244 2.013L9.75 21v-6.568a2.25 2.25 0 0 0-.659-1.591L3.659 7.409A2.25 2.25 0 0 1 3 5.818V4.774c0-.54.384-1.006.917-1.096A48.32 48.32 0 0 1 12 3Z"/>

                </svg>

                {{ __('Terapkan Filter') }}

            </button>

        </div>


    </div>

</form>

            {{-- TABLE --}}
            <section class="mt-6 bg-white rounded-2xl shadow-sm border border-[#E5E5E5] overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[900px] text-left text-sm">

                        <thead>
                            <tr
                                class="text-[11px] uppercase tracking-widest text-[#64748B] border-b border-[#E5E5E5] bg-[#F1F1F1]">
                                <th class="px-6 py-3.5 font-bold">{{ __('Kampanye') }}</th>
                                <th class="px-6 py-3.5 font-bold">{{ __('Status / Target') }}</th>
                                <th class="px-6 py-3.5 font-bold">{{ __('Perkembangan') }}</th>
                                <th class="px-6 py-3.5 font-bold text-center w-[160px]">{{ __('Aksi') }}</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-[#E5E5E5]">

                            @forelse ($kampanyes as $kampanye)
                                @php
                                    $persen = 0;
                                    if ($kampanye->target_dana > 0) {
                                        $persen = ($kampanye->dana_terkumpul / $kampanye->target_dana) * 100;
                                    }
                                    $persen = min($persen, 100);
                                    $badge = $badges[$kampanye->status] ?? $badges['ditolak'];
                                @endphp

                                <tr class="hover:bg-gray-50/60 transition-colors">

                                    {{-- KAMPANYE --}}
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">

                                            <div
                                                class="w-[90px] h-[70px] rounded-lg bg-gray-100 flex-shrink-0 overflow-hidden border border-[#E5E5E5]">
                                                @if ($kampanye->gambar)
                                                    <img src="{{ asset('storage/' . $kampanye->gambar) }}"
                                                        alt="{{ $kampanye->judul }}" class="w-full h-full object-cover">
                                                @else
                                                    <div class="w-full h-full flex items-center justify-center bg-[#E4F0EE]">
                                                        <svg class="w-6 h-6 text-[#135B59]" fill="none" viewBox="0 0 24 24"
                                                            stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="min-w-0">
                                                <p class="text-[17px] font-bold text-[#135B59] leading-snug">
                                                    {{ $kampanye->judul }}
                                                </p>
                                                <p class="mt-1 text-xs text-gray-500 line-clamp-2 max-w-[320px]">
                                                    {{ \Illuminate\Support\Str::limit($kampanye->deskripsi ?? '—', 60) }}
                                                </p>
                                                @if ($kampanye->trashed())
                                                    <p class="mt-2 inline-flex items-center gap-1.5 text-[12px] font-semibold text-red-600">
                                                        <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.008v.008H12v-.008Z"/>
                                                        </svg>
                                                        {{ __('Kampanye dihentikan oleh admin') }}
                                                    </p>
                                                @endif
                                            </div>

                                        </div>
                                    </td>

                                    {{-- STATUS / TARGET --}}
                                    <td class="px-6 py-4 whitespace-nowrap align-middle">
                                        @if ($kampanye->trashed())
                                            <span class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold rounded-md tracking-wide bg-red-100 text-red-700">
                                                {{ __('DIHENTIKAN ADMIN') }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 text-[10px] font-bold rounded-md tracking-wide {{ $badge[0] }} {{ $badge[1] }}">
                                                {{ $badge[2] }}
                                            </span>
                                        @endif

                                        <p class="mt-2 text-sm text-gray-700">
                                            {{ __('Target: Rp') }} {{ number_format($kampanye->target_dana, 0, ',', '.') }}
                                        </p>
                                    </td>

                                    {{-- PERKEMBANGAN --}}
                                    <td class="px-6 py-4 min-w-[240px] align-middle">
                                        <div class="flex items-baseline justify-between gap-4">
                                            <p class="font-bold text-gray-900 whitespace-nowrap">
                                                Rp {{ number_format($kampanye->dana_terkumpul, 0, ',', '.') }}
                                            </p>
                                            <span class="text-sm font-semibold text-[#135B59] whitespace-nowrap">
                                                {{ number_format($persen, 0) }}%
                                            </span>
                                        </div>

                                        <div class="mt-2 h-[6px] bg-[#E4F0EE] rounded-full overflow-hidden">
                                            <div class="h-full rounded-full bg-[#135B59]" style="width: {{ $persen }}%"></div>
                                        </div>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="px-6 py-4 whitespace-nowrap align-middle">
                                        @if ($kampanye->trashed())
                                            <span class="text-xs text-gray-400">{{ __('Tidak tersedia') }}</span>
                                        @else
                                        <div class="flex items-center justify-center gap-1.5">

                                            @php
                                                $bisaTarik = ($kampanye->status === 'selesai' || ($kampanye->target_dana > 0 && $kampanye->dana_terkumpul >= $kampanye->target_dana));
                                            @endphp

                                            {{-- Tombol Tarik Dana (Konsisten di semua baris: Hijau jika selesai, Abu-abu jika belum selesai) --}}
                                            @if ($bisaTarik)
                                                @php
                                                    $tarikKampanyeData = [
                                                        'id' => $kampanye->id,
                                                        'judul' => $kampanye->judul,
                                                        'saldo' => (float) $kampanye->saldo_siap_ditarik,
                                                        'bank' => $kampanye->bank_penyaluran ?: 'BCA',
                                                        'rekening' => $kampanye->nomor_rekening ?: '8820192831',
                                                        'pemilik' => $kampanye->nama_lengkap ?: ($kampanye->user->name ?? __('Penggalang Dana'))
                                                    ];
                                                @endphp
                                                <button type="button"
                                                    onclick='openTarikDanaModal(@json($tarikKampanyeData))'
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#135B59] hover:bg-[#0e4846] text-white text-xs font-bold transition-all shadow-xs cursor-pointer mr-1"
                                                    title="{{ __('Ajukan Penarikan Dana') }}">
                                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                    <span>{{ __('Tarik Dana') }}</span>
                                                </button>
                                            @else
                                                <button type="button"
                                                    disabled
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100 border border-gray-200 text-gray-400 text-xs font-semibold cursor-not-allowed mr-1 opacity-80 select-none"
                                                    title="{{ __('Tarik dana dapat diajukan setelah kampanye selesai atau target tercapai') }}">
                                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                    </svg>
                                                    <span>{{ __('Tarik Dana') }}</span>
                                                </button>
                                            @endif

                                            <a href="{{ route('kampanye.edit', $kampanye->id) }}" title="{{ __('Edit Campaign') }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-600 hover:text-[#135B59] hover:bg-[#E4F0EE] transition-colors">
                                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125" />
                                                </svg>
                                            </a>

                                            {{-- Icon Mata (Lihat Campaign) --}}
                                            <a href="{{ route('kampanye.saya.show', $kampanye->id) }}" title="{{ __('Lihat Campaign') }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-600 hover:text-[#135B59] hover:bg-[#E4F0EE] transition-colors">
                                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>

                                            {{-- Icon Hapus (Hapus Campaign) --}}
                                            <button type="button"
                                                onclick="openHapusKampanyeModal({{ $kampanye->id }}, '{{ addslashes($kampanye->judul) }}')"
                                                title="{{ __('Hapus Galang Dana') }}"
                                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-500 hover:text-red-600 hover:bg-red-50 transition-colors cursor-pointer">
                                                <svg class="w-[18px] h-[18px]" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="1.8" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>

                                        </div>
                                        @endif
                                    </td>

                                </tr>

                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-20 text-center">
                                        <p class="text-lg font-semibold text-gray-700">
                                            {{ __('Belum ada campaign') }}
                                        </p>
                                        <p class="mt-2 text-sm text-gray-400">
                                            {{ __('Coba ubah kata kunci pencarian atau filter statusmu.') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

            {{-- FOOTER: INFO + PAGINATION --}}
            <div class="mt-8 mb-4 flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">

                <p>
                    {{ __('Menampilkan') }}
                    <span class="font-semibold text-gray-700">{{ $kampanyes->firstItem() ?? 0 }}</span>–<span
                        class="font-semibold text-gray-700">{{ $kampanyes->lastItem() ?? 0 }}</span>
                    {{ __('dari') }}
                    <span class="font-semibold text-gray-700">{{ $kampanyes->total() }}</span>
                    {{ __('kampanye') }}
                </p>

                @if ($kampanyes->hasPages())
                    <div class="flex items-center gap-1">
                        {{-- Prev --}}
                        @if ($kampanyes->onFirstPage())
                            <span class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-300">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                </svg>
                            </span>
                        @else
                            <a href="{{ $kampanyes->previousPageUrl() }}"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                </svg>
                            </a>
                        @endif

                        {{-- Numbers --}}
                        @foreach ($kampanyes->getUrlRange(max(1, $kampanyes->currentPage() - 2), min($kampanyes->lastPage(), $kampanyes->currentPage() + 2)) as $page => $url)
                            @if ($page == $kampanyes->currentPage())
                                <span
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-[#135B59] text-white font-bold">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-700 hover:bg-gray-100 font-semibold transition-colors">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($kampanyes->hasMorePages())
                            <a href="{{ $kampanyes->nextPageUrl() }}"
                                class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-gray-600 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        @endif
                    </div>
                @endif

            </div>

        </div>

    </main>

    @include('partials.modal-tarik-dana')

    {{-- MODAL KONFIRMASI HAPUS GALANG DANA --}}
    <div id="modal-hapus-kampanye"
         class="fixed inset-0 z-[999] hidden items-center justify-center p-4 transition-opacity duration-200"
         style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">

        {{-- Backdrop --}}
        <div class="fixed inset-0" onclick="closeHapusKampanyeModal()"></div>

        {{-- Modal Card --}}
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl p-6 sm:p-7 z-10 animate-in fade-in zoom-in-95 duration-150">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-11 h-11 rounded-full bg-red-100 text-red-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-gray-900">{{ __('Hapus Galang Dana') }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ __('Tindakan ini tidak dapat dibatalkan') }}</p>
                </div>
            </div>

            <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                {{ __('Apakah Anda yakin ingin menghapus galang dana') }} <strong id="hapus-kampanye-judul" class="text-gray-900"></strong>? {{ __('Seluruh data kampanye ini akan dihapus secara permanen.') }}
            </p>

            <form action="" method="POST" id="form-hapus-kampanye">
                @csrf
                @method('DELETE')

                <div class="flex items-center gap-3">
                    <button type="button"
                            onclick="closeHapusKampanyeModal()"
                            class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold text-sm transition cursor-pointer">
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

    <script>
    function openHapusKampanyeModal(id, judul) {
        const modal = document.getElementById('modal-hapus-kampanye');
        const form = document.getElementById('form-hapus-kampanye');
        const titleEl = document.getElementById('hapus-kampanye-judul');

        if (!modal || !form || !titleEl) return;

        form.action = '{{ url('/kampanye') }}/' + id;
        titleEl.textContent = judul;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeHapusKampanyeModal() {
        const modal = document.getElementById('modal-hapus-kampanye');
        if (!modal) return;

        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeHapusKampanyeModal();
        }
    });
    </script>

@endsection