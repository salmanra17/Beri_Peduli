@extends('layouts.admin')

@section('content')

<div class="w-full max-w-[1320px] mx-auto px-6 lg:px-10 py-10">

    {{-- HEADER --}}

    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-neutral-900">Manajemen Kampanye</h1>
        <p class="mt-1.5 text-sm text-gray-500">
            @if ($status)
                {{ $kampanyes->total() }} kampanye berstatus {{ $status }}
            @else
                {{ $kampanyes->total() }} kampanye terdaftar
            @endif
        </p>
    </div>

    {{-- FLASH MESSAGE --}}

    <x-flash-message class="mt-6 mb-4" />

    {{-- SEARCH --}}

    <form method="GET" action="{{ route('admin.manajemen-kampanye.index') }}" class="mt-6 flex gap-3">
        <input type="hidden" name="status" value="{{ $status }}">
        <div class="relative flex-1 max-w-md">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </span>
            <input type="text" name="q" value="{{ request('q') }}"
                   placeholder="Cari nama kampanye atau penggalang..."
                   class="w-full h-[46px] pl-10 pr-4 rounded-xl bg-white border border-gray-200 text-sm focus:ring-2 focus:ring-[#134F4F] focus:border-[#134F4F] focus:outline-none">
        </div>
        <button type="submit" class="h-[46px] px-6 rounded-xl bg-[#134F4F] hover:bg-[#0c4444] text-white text-sm font-semibold transition-colors">
            Cari
        </button>
    </form>

    {{-- TAB BAR --}}

    @php
        $tabParams = fn ($s) => array_filter(['status' => $s, 'q' => request('q')]);
    @endphp

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.manajemen-kampanye.index', $tabParams(null)) }}"
           class="{{ $status === null ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Semua ({{ $countSemua }})
        </a>
        <a href="{{ route('admin.manajemen-kampanye.index', $tabParams('aktif')) }}"
           class="{{ $status === 'aktif' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Aktif ({{ $countAktif }})
        </a>
        <a href="{{ route('admin.manajemen-kampanye.index', $tabParams('menunggu')) }}"
           class="{{ $status === 'menunggu' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Menunggu ({{ $countMenunggu }})
        </a>
        <a href="{{ route('admin.manajemen-kampanye.index', $tabParams('ditolak')) }}"
           class="{{ $status === 'ditolak' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Ditolak ({{ $countDitolak }})
        </a>
        <a href="{{ route('admin.manajemen-kampanye.index', $tabParams('selesai')) }}"
           class="{{ $status === 'selesai' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[132px] py-2 rounded-full text-sm font-semibold transition">
            Selesai ({{ $countSelesai }})
        </a>
    </div>

    {{-- TABEL --}}

    <div class="mt-6 w-full bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full text-left table-fixed">
            <thead>
                <tr class="border-b border-gray-100 bg-[#FAFAFA]">
                    <th class="w-[28%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Kampanye</th>
                    <th class="w-[16%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Penggalang</th>
                    <th class="w-[12%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Kategori</th>
                    <th class="w-[20%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Terkumpul / Target</th>
                    <th class="w-[11%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Status</th>
                    <th class="w-[13%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($kampanyes as $kampanye)
                    <tr class="border-b border-gray-50 last:border-0 hover:bg-[#FAFFF9]/40 transition-colors">
                        <td class="px-6 py-4 min-w-0">
                            <p class="font-semibold text-gray-900 truncate" title="{{ $kampanye->judul }}">{{ $kampanye->judul }}</p>
                            <p class="mt-0.5 text-xs text-gray-400 capitalize">{{ $kampanye->kategori }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate" title="{{ $kampanye->user->name }}">{{ $kampanye->user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $kampanye->kategori }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">Rp {{ number_format($kampanye->dana_terkumpul, 0, ',', '.') }} / Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                                @switch($kampanye->status)
                                    @case('aktif') bg-emerald-50 text-emerald-600 border border-emerald-200/60 @break
                                    @case('menunggu') bg-amber-50 text-amber-600 border border-amber-200/60 @break
                                    @case('ditolak') bg-red-50 text-red-600 border border-red-200/60 @break
                                    @default bg-gray-100 text-gray-500
                                @endswitch">
                                {{ ucfirst($kampanye->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            @php
                                $deleteMessage = match ($kampanye->status) {
                                    'aktif' => 'Kampanye ini MASIH AKTIF dan mungkin sedang menerima donasi. Yakin ingin menghapusnya?',
                                    'selesai' => 'Kampanye ini sudah SELESAI dengan sukses. Yakin ingin menghapusnya?',
                                    default => 'Yakin ingin menghapus kampanye ini?',
                                };
                            @endphp
                            <div class="inline-flex items-center gap-2">
                                <button type="button"
                                        onclick="document.getElementById('modal-kelola-{{ $kampanye->id }}').classList.remove('hidden'); document.getElementById('modal-kelola-{{ $kampanye->id }}').classList.add('flex');"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </button>

                                <form action="{{ route('admin.manajemen-kampanye.hapus', $kampanye->id) }}" method="POST" class="inline-flex">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm({{ \Illuminate\Support\Js::from($deleteMessage) }})"
                                            aria-label="Hapus kampanye"
                                            class="inline-flex items-center justify-center rounded-lg border border-red-200 p-2 text-red-600 transition hover:bg-red-50 cursor-pointer">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-sm text-gray-400">
                            @if ($q)
                                Tidak ada kampanye yang cocok dengan pencarian "{{ $q }}".
                                <a href="{{ route('admin.manajemen-kampanye.index', $status ? ['status' => $status] : []) }}" class="text-[#134F4F] hover:underline font-semibold">Reset pencarian</a>
                            @else
                                Tidak ada kampanye di kategori ini.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer tabel: info + pagination --}}
        @if ($kampanyes->total() > 0)
            <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">

                <p class="text-sm text-gray-400">
                    Menampilkan {{ $kampanyes->firstItem() }}–{{ $kampanyes->lastItem() }} dari {{ $kampanyes->total() }} kampanye
                </p>

                {{-- Pagination custom --}}
                <div class="flex items-center gap-1">

                    {{-- Prev --}}
                    @if ($kampanyes->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $kampanyes->previousPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Halaman --}}
                    @foreach ($kampanyes->getUrlRange(1, $kampanyes->lastPage()) as $page => $url)
                        @if ($page === $kampanyes->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#134F4F] text-white text-sm font-bold">
                                {{ $page }}
                            </span>
                        @elseif ($page === 1 || $page === $kampanyes->lastPage() || abs($page - $kampanyes->currentPage()) <= 1)
                            <a href="{{ $url }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                {{ $page }}
                            </a>
                        @elseif (abs($page - $kampanyes->currentPage()) === 2)
                            <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($kampanyes->hasMorePages())
                        <a href="{{ $kampanyes->nextPageUrl() }}"
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

    {{-- ============ MODAL DETAIL KAMPANYE ============ --}}

    @foreach ($kampanyes as $kampanye)
        <div id="modal-kelola-{{ $kampanye->id }}"
             class="fixed inset-0 z-[999] hidden items-center justify-center p-4"
             role="dialog" aria-modal="true">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                 onclick="document.getElementById('modal-kelola-{{ $kampanye->id }}').classList.add('hidden'); document.getElementById('modal-kelola-{{ $kampanye->id }}').classList.remove('flex');"></div>

            {{-- Card --}}
            <div class="relative bg-white w-full max-w-2xl max-h-[85vh] overflow-y-auto rounded-2xl shadow-xl z-10 p-8">

                {{-- Tombol tutup --}}
                <button type="button"
                        onclick="document.getElementById('modal-kelola-{{ $kampanye->id }}').classList.add('hidden'); document.getElementById('modal-kelola-{{ $kampanye->id }}').classList.remove('flex');"
                        aria-label="Tutup"
                        class="absolute top-4 right-4 rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Gambar kampanye --}}
                @if ($kampanye->gambar)
                    <img src="{{ asset('storage/' . $kampanye->gambar) }}"
                         alt="{{ $kampanye->judul }}"
                         class="w-full h-[180px] object-cover -mt-8 -mx-8 mb-6 rounded-t-2xl">
                @else
                    <div class="w-full h-[160px] -mt-8 -mx-8 mb-6 rounded-t-2xl bg-gray-100 flex items-center justify-center">
                        <span class="text-sm text-gray-400">Tidak ada gambar</span>
                    </div>
                @endif

                {{-- Judul --}}
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Detail Kampanye</p>
                <h2 class="mt-2 text-xl font-bold text-neutral-900">{{ $kampanye->judul }}</h2>
                <p class="mt-1 text-sm text-gray-500">Dikelola oleh {{ $kampanye->user->name }}</p>

                {{-- Info kampanye --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Kategori</p>
                        <p class="mt-1 text-gray-900">{{ $kampanye->kategori }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Lokasi</p>
                        <p class="mt-1 text-gray-900">{{ $kampanye->lokasi ?? '-' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Target Dana</p>
                        <p class="mt-1 text-gray-900">Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Dana Terkumpul</p>
                        <p class="mt-1 text-gray-900">Rp {{ number_format($kampanye->dana_terkumpul, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Batas Waktu</p>
                        <p class="mt-1 text-gray-900">{{ $kampanye->batas_tanggal->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Penggalang</p>
                        <p class="mt-1 text-gray-900">{{ $kampanye->user->name }}</p>
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mt-4">
                    <p class="text-xs font-semibold text-gray-400">Deskripsi</p>
                    <p class="mt-1 text-sm leading-relaxed text-gray-700">{{ $kampanye->deskripsi }}</p>
                </div>

            </div>
        </div>
    @endforeach

    {{-- Tutup modal saat tombol Escape ditekan --}}
    <script>
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-kelola-"]').forEach(function (m) {
                    if (!m.classList.contains('hidden')) {
                        m.classList.add('hidden');
                        m.classList.remove('flex');
                    }
                });
            }
        });
    </script>

</div>

@endsection