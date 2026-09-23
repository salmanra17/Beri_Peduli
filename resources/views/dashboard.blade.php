@extends('layouts.dashboard')

@section('title', __('Dashboard'))

@section('content')

    @php
        $fmtRingkas = static function (float $n): string {
            $n = round($n);

            $neg = $n < 0 ? '-' : '';

            $n = abs($n);

            $satuan = [
                1_000_000_000_000 => 'T',
                1_000_000_000 => 'M',
                1_000_000 => 'Jt',
                1_000 => 'rb',
            ];

            foreach ($satuan as $pembagi => $label) {
                if ($n >= $pembagi) {
                    $num = $n / $pembagi;

                    return $neg . (round($num) == $num
                        ? number_format($num, 0, ',', '.')
                        : number_format($num, 1, ',', '.')) . ' ' . $label;
                }
            }

            return $neg . number_format($n, 0, ',', '.');
        };
    @endphp

    <main class="flex-1 min-w-0 bg-[#F2F2F3]">

        <div class="max-w-[1180px] mx-auto px-6 lg:px-8 pt-7 pb-12">

            {{-- HEADER --}}
            <header class="flex flex-wrap items-start justify-between gap-4">

                <div>

                    <h1 class="text-xl sm:text-2xl font-bold text-[#1A1A1A]">
                        {{ __('Hallo') }}, <span class="text-[#134F4F]">{{ $user->name }}</span>!
                    </h1>

                    <p class="mt-1 text-xs sm:text-sm text-gray-500">
                        {{ __('Berikut ringkasan aktivitasmu di BeriPeduli. Teruslah menebar kebaikan.') }}
                    </p>

                </div>

            </header>

            {{-- SUMMARY CARDS --}}
            <section class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">

                {{-- TOTAL DONASI --}}
                <div class="bg-white rounded-xl p-4 sm:p-5 flex items-center gap-3.5 shadow-xs border border-gray-100">

                    <div class="flex items-center gap-3.5">

                        <div class="w-10 h-10 rounded-xl bg-[#FDECEC] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C2574C]" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                {{ __('Total Donasi') }}
                            </p>
                            <p class="text-lg font-bold text-gray-900 mt-0.5">
                                {{ $fmtRingkas($totalDonasi) }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- GALANG DANA AKTIF --}}
                <div class="bg-white rounded-xl p-4 sm:p-5 flex items-center gap-3.5 shadow-xs border border-gray-100">

                    <div class="flex items-center gap-3.5">

                        <div class="w-10 h-10 rounded-xl bg-[#E8F3F1] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#134F4F]" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.76-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a2.25 2.25 0 0 1 0 3.46" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                {{ __('Galang Dana Aktif') }}
                            </p>
                            <p class="text-lg font-bold text-gray-900 mt-0.5">
                                {{ $galangDanaAktif }} {{ __('Kampanye') }}
                            </p>
                        </div>

                    </div>

                </div>

                {{-- TOTAL PENARIKAN --}}
                <div class="bg-white rounded-xl p-4 sm:p-5 flex items-center gap-3.5 shadow-xs border border-gray-100">

                    <div class="flex items-center gap-3.5">

                        <div class="w-10 h-10 rounded-xl bg-[#FDF5E9] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-[#C79A3C]" fill="none" viewBox="0 0 24 24" stroke-width="1.7"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                            </svg>
                        </div>

                        <div>
                            <p class="text-xs text-gray-500">
                                {{ __('Total Penarikan') }}
                            </p>
                            <p class="text-lg font-bold text-gray-900 mt-0.5">
                                {{ $fmtRingkas($totalPenarikan) }}
                            </p>
                        </div>

                    </div>

                </div>

            </section>

            {{-- RIWAYAT DONASI SINGKAT --}}
            <section class="mt-6 bg-white rounded-xl shadow-xs border border-gray-100 overflow-hidden">

                <div class="flex items-center justify-between px-5 py-3.5">

                    <h2 class="text-sm font-bold text-gray-900">
                        {{ __('Riwayat Donasi Singkat') }}
                    </h2>

                    <a href="{{ route('donasi.history') }}" class="text-xs font-semibold text-[#134F4F] hover:underline">
                        {{ __('Lihat Semua →') }}
                    </a>

                </div>

                <div class="border-t border-gray-100"></div>

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[620px] text-left text-xs">

                        <thead>
                            <tr class="text-[10px] uppercase tracking-wider text-gray-400 bg-gray-50/50 border-b border-gray-100">
                                <th class="px-5 py-3 font-semibold">{{ __('Tanggal') }}</th>
                                <th class="px-5 py-3 font-semibold">{{ __('Program') }}</th>
                                <th class="px-5 py-3 font-semibold">{{ __('Jumlah') }}</th>
                                <th class="px-5 py-3 font-semibold">{{ __('Status') }}</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-50">

                            @forelse($riwayatDonasi as $donasi)
                                <tr>
                                    <td class="px-5 py-3 whitespace-nowrap text-gray-500 text-xs">
                                        {{ $donasi->created_at->format('d M Y') }}
                                    </td>
                                    <td class="px-5 py-3 font-medium text-gray-900 text-xs">
                                        {{ $donasi->kampanye?->judul ?? '—' }}
                                    </td>
                                    <td class="px-5 py-3 font-bold whitespace-nowrap text-xs">
                                        Rp {{ number_format($donasi->jumlah_donasi, 0, ',', '.') }}
                                    </td>
                                    <td class="px-5 py-3">
                                        @php
                                            $warna = match ($donasi->status_pembayaran ?? '') {
                                                'berhasil' => ['bg-[#E4F4F0]', 'text-[#134F4F]', __('Berhasil')],
                                                'menunggu' => ['bg-[#FBF3E3]', 'text-[#A97A1B]', __('Menunggu')],
                                                default => ['bg-[#FDECEC]', 'text-[#C2574C]', __('Gagal')],
                                            };
                                        @endphp
                                        <span
                                            class="inline-flex items-center px-2 py-0.5 text-[11px] font-semibold rounded-full {{ $warna[0] }} {{ $warna[1] }}">
                                            {{ $warna[2] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-5 py-10 text-center text-gray-400 text-xs">
                                        {{ __('Belum ada donasi. Saatnya mulai menebar kebaikan.') }}
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </section>

            {{-- 2 CARD BAWAH --}}
            <section class="mt-6 mb-12 grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- KEBAIKAN BARU --}}
                <div class="bg-white rounded-xl border border-gray-100 p-5">

                    <div class="w-9 h-9 rounded-full bg-[#134F4F] flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                        </svg>
                    </div>

                    <h3 class="mt-3 text-base font-bold text-gray-900">
                        {{ __('Kebaikan Baru?') }}
                    </h3>

                    <p class="mt-1 text-xs leading-relaxed text-gray-500">
                        {{ __('Buat kampanye donasi untuk mereka yang membutuhkan bantuanmu hari ini.') }}
                    </p>

                    <a href="{{ route('kampanye.create') }}"
                        class="mt-4 inline-flex items-center justify-center bg-[#134F4F] hover:bg-[#0c3f3f] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                        {{ __('Mulai Galang Dana') }}
                    </a>

                </div>

                {{-- UPDATE PENYALURAN --}}
                <div class="bg-white rounded-xl border border-gray-100 p-5">

                    <div class="w-9 h-9 rounded-full bg-[#C79A3C] flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>

                    <h3 class="mt-3 text-base font-bold text-gray-900">
                        {{ __('Update Penyaluran') }}
                    </h3>

                    <p class="mt-1 text-xs leading-relaxed text-gray-500">
                        {{ __('Lihat bagaimana donasimu membantu perubahan nyata di lapangan.') }}
                    </p>

                    <a href="{{ route('kampanye.index') }}"
                        class="mt-4 inline-flex items-center justify-center bg-[#134F4F] hover:bg-[#0c3f3f] text-white text-xs font-semibold px-4 py-2 rounded-lg transition-colors">
                        {{ __('Lihat Berita') }}
                    </a>

                </div>

            </section>

        </div>

    </main>

@endsection