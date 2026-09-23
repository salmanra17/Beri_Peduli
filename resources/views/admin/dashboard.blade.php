@extends('layouts.admin')

@section('content')

<div class="w-full max-w-[1320px] mx-auto px-6 lg:px-10 py-10">

    {{-- JUDUL --}}

    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-neutral-900">Dashboard</h1>
        <p class="mt-1.5 text-sm text-gray-500">Ringkasan aktivitas platform hari ini</p>
    </div>

    {{-- KARTU RINGKASAN --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mt-8">

        {{-- 1. Total Pengguna --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 transition hover:shadow-md hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Total Pengguna</p>
                    <p class="mt-2 text-2xl lg:text-3xl font-bold text-gray-900">{{ number_format($totalPengguna) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center gap-1.5">
                <span class="inline-flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                    +{{ $penggunaBaruMingguIni }}
                </span>
                <span class="text-xs text-gray-400">minggu ini</span>
            </div>
        </div>

        {{-- 2. Kampanye Aktif --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 transition hover:shadow-md hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Kampanye Aktif</p>
                    <p class="mt-2 text-2xl lg:text-3xl font-bold text-gray-900">{{ number_format($kampanyeAktif) }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center gap-1.5">
                <span class="inline-flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md">
                    +{{ $kampanyeAktifBaruMingguIni }}
                </span>
                <span class="text-xs text-gray-400">minggu ini</span>
            </div>
        </div>

        {{-- 3. Dana Terkumpul --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 transition hover:shadow-md hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div class="min-w-0 pr-2">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Dana Terkumpul</p>
                    <p class="mt-2 text-xl lg:text-2xl font-bold text-[#135B59] truncate" title="Rp {{ number_format($danaTerkumpul, 0, ',', '.') }}">
                        Rp {{ number_format($danaTerkumpul, 0, ',', '.') }}
                    </p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-[#E4EEEE] text-[#135B59] flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center gap-1.5 min-w-0">
                <span class="inline-flex items-center text-xs font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-md truncate">
                    +Rp {{ number_format($danaTerkumpulMingguIni, 0, ',', '.') }}
                </span>
                <span class="text-xs text-gray-400 flex-shrink-0">minggu ini</span>
            </div>
        </div>

        {{-- 4. Menunggu Verifikasi --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 transition hover:shadow-md hover:-translate-y-0.5 flex flex-col justify-between">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Perlu Verifikasi</p>
                    <p class="mt-2 text-2xl lg:text-3xl font-bold text-amber-600">{{ $totalMenungguVerifikasi }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                    </svg>
                </div>
            </div>
            <div class="mt-4 pt-3 border-t border-gray-50 flex items-center gap-1.5">
                <span class="inline-flex items-center text-xs font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-md">
                    {{ $totalMenungguVerifikasi > 0 ? 'Segera Tinjau' : 'Semua Beres' }}
                </span>
                <span class="text-xs text-gray-400">di 4 kategori</span>
            </div>
        </div>

    </div>

    {{-- PERLU TINDAKAN --}}

    <section class="mt-10">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-bold text-neutral-900">Perlu Tindakan</h2>
        </div>

        <div class="mt-4 bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100">
            @forelse ($perluTindakan as $item)
                <div class="flex items-center justify-between gap-4 p-5">

                    <div class="flex items-center gap-4 min-w-0">
                        <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-gray-50 flex-shrink-0">
                            @if ($item['type'] === 'kampanye')
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5"/>
                                </svg>
                            @elseif ($item['type'] === 'rekening')
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-19.5 0a.75.75 0 0 0-1.5 0v15c0 .414.336.75.75.75h19.5a.75.75 0 0 0 .75-.75v-15a.75.75 0 0 0-1.5 0m2.25 0v7.5h-3a3 3 0 0 1-6 0H3.75"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/>
                                </svg>
                            @endif
                        </div>

                        <div class="min-w-0 leading-tight">
                            <p class="text-sm font-semibold text-neutral-900 truncate">{{ $item['title'] }}</p>
                            <p class="mt-0.5 text-xs text-gray-500 truncate">{{ $item['subtitle'] }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 flex-shrink-0">
                        <span class="text-xs text-gray-400">{{ $item['waktu'] }}</span>
                        <a href="{{ $item['url_tinjau'] }}"
                           class="bg-[#134F4F] text-white text-sm font-medium px-4 py-2 rounded-lg transition hover:bg-[#0c4444]">
                            Tinjau
                        </a>
                    </div>
                </div>
            @empty
                <p class="p-5 text-sm text-gray-400">Tidak ada tindakan yang perlu ditinjau saat ini.</p>
            @endforelse

            {{-- Footer tabel: info + pagination --}}
            @if ($perluTindakan->total() > 0)
                <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">

                    <p class="text-sm text-gray-400">
                        Menampilkan {{ $perluTindakan->firstItem() }}–{{ $perluTindakan->lastItem() }} dari {{ $perluTindakan->total() }} tindakan
                    </p>

                    {{-- Pagination custom --}}
                    <div class="flex items-center gap-1">

                        {{-- Prev --}}
                        @if ($perluTindakan->onFirstPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                </svg>
                            </span>
                        @else
                            <a href="{{ $perluTindakan->previousPageUrl() }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                                </svg>
                            </a>
                        @endif

                        {{-- Halaman --}}
                        @foreach ($perluTindakan->getUrlRange(1, $perluTindakan->lastPage()) as $page => $url)
                            @if ($page === $perluTindakan->currentPage())
                                <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#134F4F] text-white text-sm font-bold">
                                    {{ $page }}
                                </span>
                            @elseif ($page === 1 || $page === $perluTindakan->lastPage() || abs($page - $perluTindakan->currentPage()) <= 1)
                                <a href="{{ $url }}"
                                   class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                    {{ $page }}
                                </a>
                            @elseif (abs($page - $perluTindakan->currentPage()) === 2)
                                <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($perluTindakan->hasMorePages())
                            <a href="{{ $perluTindakan->nextPageUrl() }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                </svg>
                            </a>
                        @else
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                </svg>
                            </span>
                        @endif

                    </div>

                </div>
            @endif
        </div>
    </section>

    </div>

@endsection