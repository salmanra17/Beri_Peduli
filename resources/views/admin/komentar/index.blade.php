@extends('layouts.admin')

@section('content')

<div class="w-full max-w-[1320px] mx-auto px-6 lg:px-10 py-10">

    {{-- HEADER --}}

    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-neutral-900">Moderasi Komentar</h1>
        <p class="mt-1.5 text-sm text-gray-500">{{ $komentars->total() }} komentar</p>
    </div>

    {{-- FLASH MESSAGE --}}

    <x-flash-message class="mt-6 mb-4" />

    {{-- SEARCH --}}

    <form method="GET" action="{{ route('admin.komentar.index') }}" class="mt-6 flex gap-3">
        <div class="relative flex-1 max-w-md">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </span>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari isi komentar atau nama kampanye..."
                   class="w-full h-[46px] pl-10 pr-4 rounded-xl bg-white border border-gray-200 text-sm focus:ring-2 focus:ring-[#134F4F] focus:border-[#134F4F] focus:outline-none">
        </div>
        <button type="submit" class="h-[46px] px-6 rounded-xl bg-[#134F4F] hover:bg-[#0c4444] text-white text-sm font-semibold transition-colors">
            Cari
        </button>
    </form>

    {{-- LIST KOMENTAR --}}

    <div class="mt-6 w-full bg-white rounded-2xl border border-gray-100 shadow-sm divide-y divide-gray-100">
        @forelse ($komentars as $komentar)
            <div class="flex items-center justify-between gap-4 p-5">

                <div class="flex items-start gap-4 min-w-0">
                    <div class="flex items-center justify-center w-11 h-11 rounded-lg bg-teal-50 text-teal-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                        </svg>
                    </div>

                    <div class="min-w-0 leading-snug">
                        <p class="text-sm text-neutral-900 leading-relaxed">{{ \Illuminate\Support\Str::limit($komentar->pesan, 120) }}</p>
                        <p class="mt-1 text-xs text-gray-500">
                            @if ($komentar->anonim)
                                Anonim
                            @else
                                {{ $komentar->user->name }}
                            @endif
                            · pada kampanye {{ $komentar->kampanye->judul }}
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="text-xs text-gray-400 whitespace-nowrap">{{ $komentar->created_at->diffForHumans() }}</span>

                    <form action="{{ route('admin.komentar.destroy', $komentar->id) }}" method="POST" class="inline-flex">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Yakin ingin menghapus komentar ini? Tindakan ini tidak bisa dibatalkan.')"
                                aria-label="Hapus komentar"
                                class="inline-flex items-center justify-center rounded-lg border border-red-200 p-2 text-red-600 transition hover:bg-red-50 cursor-pointer">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <p class="p-8 text-center text-sm text-gray-400">Tidak ada komentar ditemukan.</p>
        @endforelse

        {{-- Footer list: info + pagination --}}
        @if ($komentars->total() > 0)
            <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">

                <p class="text-sm text-gray-400">
                    Menampilkan {{ $komentars->firstItem() }}–{{ $komentars->lastItem() }} dari {{ $komentars->total() }} komentar
                </p>

                {{-- Pagination custom --}}
                <div class="flex items-center gap-1">

                    {{-- Prev --}}
                    @if ($komentars->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $komentars->previousPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Halaman --}}
                    @foreach ($komentars->getUrlRange(1, $komentars->lastPage()) as $page => $url)
                        @if ($page === $komentars->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#134F4F] text-white text-sm font-bold">
                                {{ $page }}
                            </span>
                        @elseif ($page === 1 || $page === $komentars->lastPage() || abs($page - $komentars->currentPage()) <= 1)
                            <a href="{{ $url }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                {{ $page }}
                            </a>
                        @elseif (abs($page - $komentars->currentPage()) === 2)
                            <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($komentars->hasMorePages())
                        <a href="{{ $komentars->nextPageUrl() }}"
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

</div>

@endsection