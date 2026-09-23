@extends('layouts.admin')

@section('content')

<div class="w-full max-w-[1320px] mx-auto px-6 lg:px-10 py-10">

    {{-- HEADER --}}

    <div>
        <h1 class="text-2xl lg:text-3xl font-bold text-neutral-900">Penarikan Dana</h1>
        <p class="mt-1.5 text-sm text-gray-500">
            @if ($status === 'diproses')
                {{ $penarikans->total() }} pengajuan menunggu diproses
            @elseif ($status === 'berhasil')
                {{ $penarikans->total() }} penarikan berhasil
            @else
                {{ $penarikans->total() }} penarikan ditolak
            @endif
        </p>
    </div>

    {{-- FLASH MESSAGE --}}

    <x-flash-message class="mt-6 mb-4" />

    {{-- SEARCH --}}

    <form method="GET" action="{{ route('admin.penarikan.index') }}" class="mt-6 flex gap-3">
        <input type="hidden" name="status" value="{{ $status }}">
        <div class="relative flex-1 max-w-md">
            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                </svg>
            </span>
            <input type="text" name="cari" value="{{ request('cari') }}"
                   placeholder="Cari kode transaksi, kampanye, atau nama..."
                   class="w-full h-[46px] pl-10 pr-4 rounded-xl bg-white border border-gray-200 text-sm focus:ring-2 focus:ring-[#134F4F] focus:border-[#134F4F] focus:outline-none">
        </div>
        <button type="submit" class="h-[46px] px-6 rounded-xl bg-[#134F4F] hover:bg-[#0c4444] text-white text-sm font-semibold transition-colors">
            Cari
        </button>
    </form>

    {{-- TAB BAR --}}

    @php
        $tabParams = fn ($s) => array_filter(['status' => $s, 'cari' => request('cari')]);
    @endphp

    <div class="mt-6 flex flex-wrap gap-2">
        <a href="{{ route('admin.penarikan.index', $tabParams('diproses')) }}"
           class="{{ $status === 'diproses' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[176px] py-2 rounded-full text-sm font-semibold transition">
            Diproses ({{ $countDiproses }})
        </a>
        <a href="{{ route('admin.penarikan.index', $tabParams('berhasil')) }}"
           class="{{ $status === 'berhasil' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[176px] py-2 rounded-full text-sm font-semibold transition">
            Berhasil ({{ $countBerhasil }})
        </a>
        <a href="{{ route('admin.penarikan.index', $tabParams('ditolak')) }}"
           class="{{ $status === 'ditolak' ? 'bg-[#134F4F] text-white border border-transparent' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }} inline-flex items-center justify-center w-[176px] py-2 rounded-full text-sm font-semibold transition">
            Ditolak ({{ $countDitolak }})
        </a>
    </div>

    {{-- TABEL --}}

    <div class="mt-6 w-full bg-white rounded-2xl border border-gray-100 shadow-sm overflow-x-auto">
        <table class="w-full text-left table-fixed min-w-[880px]">
            <thead>
                <tr class="border-b border-gray-100 bg-[#FAFAFA]">
                    <th class="w-[16%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Kode Transaksi</th>
                    <th class="w-[19%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Kampanye</th>
                    <th class="w-[14%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Jumlah</th>
                    <th class="w-[14%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Bank Tujuan</th>
                    <th class="w-[13%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Pengaju</th>
                    <th class="w-[11%] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold">Status</th>
                    <th class="w-[13%] min-w-[110px] px-6 py-4 text-xs uppercase tracking-wider text-gray-400 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penarikans as $penarikan)
                    <tr id="penarikan-{{ $penarikan->id }}"
                        class="border-b border-gray-50 last:border-0 hover:bg-[#FAFFF9]/40 transition-colors"
                        @if ($highlight === $penarikan->id) style="animation: penarikan-flash 2s ease-in-out 1 both;" @endif>
                        <td class="px-6 py-4 min-w-0">
                            <p class="font-semibold text-gray-900 truncate" title="{{ $penarikan->kode_transaksi }}">{{ $penarikan->kode_transaksi }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate" title="{{ $penarikan->kampanye?->judul ?? 'Kampanye telah dihapus' }}">{{ $penarikan->kampanye?->judul ?? 'Kampanye telah dihapus' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate" title="{{ $penarikan->bank_tujuan }}">{{ $penarikan->rekening_masked }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 truncate" title="{{ $penarikan->user->name }}">{{ $penarikan->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-block rounded-full px-3 py-1 text-xs font-semibold
                                @switch($penarikan->status)
                                    @case('diproses') bg-amber-50 text-amber-600 border border-amber-200/60 @break
                                    @case('berhasil') bg-emerald-50 text-emerald-600 border border-emerald-200/60 @break
                                    @case('ditolak') bg-red-50 text-red-600 border border-red-200/60 @break
                                @endswitch">
                                {{ ucfirst($penarikan->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center whitespace-nowrap">
                            <div class="inline-flex items-center justify-center gap-2">
                                <button type="button"
                                        onclick="document.getElementById('modal-penarikan-{{ $penarikan->id }}').classList.remove('hidden'); document.getElementById('modal-penarikan-{{ $penarikan->id }}').classList.add('flex');"
                                        class="inline-flex items-center justify-center rounded-lg border border-gray-200 p-2 text-gray-500 transition hover:bg-gray-50 hover:text-gray-700 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                                    </svg>
                                </button>
                                @if ($penarikan->status === 'ditolak')
                                    <form action="{{ route('admin.penarikan.hapus', $penarikan->id) }}" method="POST" class="inline-flex">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus data ini? Tindakan ini bisa dipulihkan lewat database jika diperlukan.')"
                                                aria-label="Hapus penarikan"
                                                class="inline-flex items-center justify-center rounded-lg border border-red-200 p-2 text-red-600 transition hover:bg-red-50 cursor-pointer">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-400">
                            @if(request('cari'))
                                Tidak ada pengajuan yang cocok dengan pencarian "{{ request('cari') }}".
                                <a href="{{ route('admin.penarikan.index', ['status' => $status]) }}" class="text-[#134F4F] hover:underline font-semibold">Reset pencarian</a>
                            @else
                                Tidak ada pengajuan di kategori ini.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Footer tabel: info + pagination --}}
        @if ($penarikans->total() > 0)
            <div class="px-6 py-4 border-t border-gray-100 flex flex-col sm:flex-row items-center justify-between gap-3">

                <p class="text-sm text-gray-400">
                    Menampilkan {{ $penarikans->firstItem() }}–{{ $penarikans->lastItem() }} dari {{ $penarikans->total() }} pengajuan
                </p>

                {{-- Pagination custom --}}
                <div class="flex items-center gap-1">

                    {{-- Prev --}}
                    @if ($penarikans->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-300 cursor-not-allowed">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </span>
                    @else
                        <a href="{{ $penarikans->previousPageUrl() }}"
                           class="w-8 h-8 flex items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
                            </svg>
                        </a>
                    @endif

                    {{-- Halaman --}}
                    @foreach ($penarikans->getUrlRange(1, $penarikans->lastPage()) as $page => $url)
                        @if ($page === $penarikans->currentPage())
                            <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#134F4F] text-white text-sm font-bold">
                                {{ $page }}
                            </span>
                        @elseif ($page === 1 || $page === $penarikans->lastPage() || abs($page - $penarikans->currentPage()) <= 1)
                            <a href="{{ $url }}"
                               class="w-8 h-8 flex items-center justify-center rounded-lg text-sm text-gray-600 hover:bg-gray-100 transition-colors">
                                {{ $page }}
                            </a>
                        @elseif (abs($page - $penarikans->currentPage()) === 2)
                            <span class="w-8 h-8 flex items-center justify-center text-sm text-gray-400">…</span>
                        @endif
                    @endforeach

                    {{-- Next --}}
                    @if ($penarikans->hasMorePages())
                        <a href="{{ $penarikans->nextPageUrl() }}"
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

    {{-- Blink hijau halus 2 detik untuk penarikan yang baru ditinjau --}}
    <style>
        @keyframes penarikan-flash {
            0% {
                background-color: rgba(16, 185, 129, 0);
            }
            25% {
                background-color: rgba(16, 185, 129, 0.16);
            }
            70% {
                background-color: rgba(16, 185, 129, 0.16);
            }
            100% {
                background-color: rgba(16, 185, 129, 0);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if ($highlight)
                var row = document.getElementById('penarikan-{{ $highlight }}');
                if (row) {
                    row.scrollIntoView({ block: 'center', behavior: 'smooth' });
                }
            @endif
        });
    </script>

    {{-- ============ MODAL DETAIL PENARIKAN ============ --}}

    @foreach ($penarikans as $penarikan)
        <div id="modal-penarikan-{{ $penarikan->id }}"
             class="fixed inset-0 z-[999] hidden items-center justify-center p-4"
             role="dialog" aria-modal="true">

            {{-- Backdrop --}}
            <div class="fixed inset-0 bg-black/40 backdrop-blur-sm"
                 onclick="document.getElementById('modal-penarikan-{{ $penarikan->id }}').classList.add('hidden'); document.getElementById('modal-penarikan-{{ $penarikan->id }}').classList.remove('flex');"></div>

            {{-- Card --}}
            <div class="relative bg-white w-full max-w-2xl max-h-[85vh] overflow-y-auto rounded-2xl shadow-xl z-10 p-8">

                {{-- Tombol tutup --}}
                <button type="button"
                        onclick="document.getElementById('modal-penarikan-{{ $penarikan->id }}').classList.add('hidden'); document.getElementById('modal-penarikan-{{ $penarikan->id }}').classList.remove('flex');"
                        aria-label="Tutup"
                        class="absolute top-4 right-4 rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>

                {{-- Judul --}}
                <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Penarikan Dana</p>
                <h2 class="mt-2 text-xl font-bold text-neutral-900">{{ $penarikan->kode_transaksi }}</h2>
                <p class="mt-1 text-sm text-gray-500">Diajukan oleh {{ $penarikan->user->name }} · {{ $penarikan->created_at->diffForHumans() }}</p>

                {{-- Info penarikan --}}
                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Kampanye</p>
                        <p class="mt-1 text-gray-900">{{ $penarikan->kampanye?->judul ?? 'Kampanye telah dihapus' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Jumlah</p>
                        <p class="mt-1 text-gray-900">Rp {{ number_format($penarikan->jumlah, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Bank Tujuan</p>
                        <p class="mt-1 text-gray-900">{{ $penarikan->bank_tujuan }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Nomor Rekening</p>
                        <p class="mt-1 text-gray-900">{{ $penarikan->nomor_rekening }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400">Nama Pemilik Rekening</p>
                        <p class="mt-1 text-gray-900">{{ $penarikan->nama_pemilik_rekening }}</p>
                    </div>
                    @if ($penarikan->catatan)
                        <div>
                            <p class="text-xs font-semibold text-gray-400">Catatan</p>
                            <p class="mt-1 text-gray-900">{{ $penarikan->catatan }}</p>
                        </div>
                    @endif
                </div>

                {{-- Aksi verifikasi --}}
                @if ($penarikan->status === 'diproses')
                    <div class="mt-8 flex gap-4">
                        <form action="{{ route('admin.penarikan.tolak', $penarikan->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit" onclick="return confirm('Yakin ingin menolak penarikan ini?')"
                                    class="w-full rounded-xl border border-red-200 py-3 font-semibold text-red-600 transition hover:bg-red-50">
                                Tolak
                            </button>
                        </form>

                        <form action="{{ route('admin.penarikan.proses', $penarikan->id) }}" method="POST" class="flex-1">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="w-full rounded-xl bg-[#134F4F] py-3 font-semibold text-white transition hover:bg-[#0c4444]">
                                Proses Penarikan
                            </button>
                        </form>
                    </div>
                @endif

            </div>
        </div>
    @endforeach

    {{-- Tutup modal saat tombol Escape ditekan --}}
    <script>
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                document.querySelectorAll('[id^="modal-penarikan-"]').forEach(function (m) {
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