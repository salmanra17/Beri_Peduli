@extends('layouts.app')

@section('content')
    <main class="bg-[#F0F0F0] min-h-screen">
        <div class="max-w-[1320px] mx-auto px-4 lg:px-10 py-7">

            {{-- HEADER --}}
            <header class="mb-5">
                <h1 class="text-2xl lg:text-3xl font-bold leading-tight text-neutral-900">
                    {{ __('Daftar Kampanye') }}
                </h1>
                <p class="text-sm text-gray-600 max-w-2xl mt-1">
                    {{ __('Setiap rupiah yang Anda berikan adalah harapan baru bagi mereka yang sedang membutuhkan.') }}
                </p>
            </header>

            {{-- FILTER --}}
            <form method="GET" action="{{ route('kampanye.index') }}" class="bg-white rounded-2xl shadow-sm p-4 mb-6">

                <div class="flex flex-col lg:flex-row gap-3 items-end">

                    {{-- SEARCH --}}
                    <div class="flex-1">
                        <label class="block text-xs text-gray-500 mb-1">
                            {{ __('Cari Kampanye') }}
                        </label>

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Contoh: Bencana Alam, Pendidikan...') }}"
                            class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 bg-gray-50 focus:ring-2 focus:ring-[#134F4F] focus:outline-none">
                    </div>

                    {{-- KATEGORI --}}
                    <div class="w-full lg:w-44">
                        <label class="block text-xs text-gray-500 mb-1">
                            {{ __('Kategori') }}
                        </label>

                        <select name="kategori" class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 bg-gray-50">

                            <option value="{{ __('Semua') }}">
                                {{ __('Semua') }}
                            </option>

                            <option value="Bencana Alam" {{ request('kategori') == 'Bencana Alam' ? 'selected' : '' }}>
                                Bencana Alam
                            </option>

                            <option value="Pendidikan" {{ request('kategori') == 'Pendidikan' ? 'selected' : '' }}>
                                Pendidikan
                            </option>

                            <option value="Kesehatan" {{ request('kategori') == 'Kesehatan' ? 'selected' : '' }}>
                                Kesehatan
                            </option>

                            <option value="Lingkungan" {{ request('kategori') == 'Lingkungan' ? 'selected' : '' }}>
                                Lingkungan
                            </option>

                            <option value="Sosial" {{ request('kategori') == 'Sosial' ? 'selected' : '' }}>
                                Sosial
                            </option>

                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div class="w-full lg:w-40">
                        <label class="block text-xs text-gray-500 mb-1">
                            {{ __('Status') }}
                        </label>

                        <select name="status" class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 bg-gray-50">

                            <option value="{{ __('Semua') }}">
                                {{ __('Semua') }}
                            </option>

                            <option value="Aktif">
                                Aktif
                            </option>

                            <option value="Selesai">
                                Selesai
                            </option>

                        </select>
                    </div>

                    <button type="submit"
                        class="bg-[#134F4F] hover:bg-[#0c4444] text-white text-sm font-semibold px-5 py-2 rounded-xl">
                        {{ __('Terapkan') }}
                    </button>

                </div>
            </form>

            {{-- CARD CAMPAIGN --}}
            <section class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">

                @forelse($kampanyes as $kampanye)

                        <a href="{{ route('kampanye.show', $kampanye->id) }}">

                            <article class="bg-white rounded-2xl shadow-sm overflow-hidden hover:shadow-lg transition">

                                {{-- GAMBAR --}}
                                <div class="relative">

                                    <img src="{{ asset('storage/' . $kampanye->gambar) }}" class="w-full h-44 object-cover"
                                        alt="{{ $kampanye->judul_tampil }}">

                                    {{-- KATEGORI DI KIRI --}}
                                    <span class="absolute top-3 left-3 bg-[#134F4F] text-white text-xs px-3 py-1 rounded-full">
                                        {{ $kampanye->kategori }}
                                    </span>

                                    {{-- STATUS SELESAI DI KANAN --}}
                                    @if($kampanye->isSelesai())

                                        <span style="position: absolute; top: 16px; right: 16px;"
                                            class="bg-[#D7A31B] text-white text-xs font-semibold px-3 py-1.5 rounded-full">
                                            {{ __('✓ Selesai') }}
                                        </span>

                                    @endif

                                </div>

                                {{-- ISI CARD --}}
                                <div class="p-4">

                                    <h3 class="text-sm font-bold mb-3">
                                        {{ $kampanye->judul_tampil }}
                                    </h3>

                                    @php
                                        $persen = 0;

                                        if ($kampanye->target_dana > 0) {
                                            $persen =
                                                ($kampanye->dana_terkumpul / $kampanye->target_dana) * 100;
                                        }
                                    @endphp

                                    {{-- DANA TERKUMPUL --}}
                                    <div class="flex justify-between mb-2">

                                        <span class="text-gray-600 text-sm">
                                            {{ __('Terkumpul') }}
                                        </span>

                                        <span class="text-sm">
                                            <span class="font-bold text-[#134F4F]">
                                                Rp {{ number_format($kampanye->dana_terkumpul, 0, ',', '.') }}
                                            </span>
                                        </span>

                                    </div>

                                    {{-- PROGRESS --}}
                                    <div class="flex items-center gap-3">

                                        <div class="flex-1 h-2.5 bg-gray-200 rounded-full overflow-hidden">

                                            <div class="h-2.5 bg-[#134F4F] rounded-full" style="width: {{ min($persen, 100) }}%">
                                            </div>

                                        </div>

                                        <span class="text-sm font-bold whitespace-nowrap
                                                    {{ $kampanye->isSelesai()
                    ? 'text-[#134F4F]'
                    : 'text-[#D7A31B]' }}">

                                            {{ number_format(min($persen, 100), 0) }}%

                                        </span>

                                    </div>

                                    {{-- TARGET --}}
                                    <p class="text-sm text-gray-500 mt-3">
                                        {{ __('Target: Rp') }} {{ number_format($kampanye->target_dana, 0, ',', '.') }}
                                    </p>

                                    {{-- TOMBOL --}}
                                    @if($kampanye->isSelesai())

                                        <div class="mt-4 w-full bg-[#134F4F] text-white text-sm font-bold py-2.5 rounded-xl text-center">
                                            {{ __('✓ Terkumpul & Selesai') }}
                                        </div>

                                    @else

                                        <button
                                            class="mt-4 w-full bg-[#134F4F] hover:bg-[#0c4444] text-white text-sm font-bold py-2.5 rounded-xl">
                                            {{ __('DONASI') }}
                                        </button>

                                    @endif

                                </div>

                            </article>

                        </a>

                @empty

                    <div class="col-span-3 text-center py-20">

                        <h3 class="text-xl font-semibold">
                            {{ __('Campaign tidak ditemukan') }}
                        </h3>

                        <p class="text-gray-500 mt-2">
                            {{ __('Coba gunakan kata kunci lain.') }}
                        </p>

                    </div>

                @endforelse

            </section>

            {{-- PAGINATION --}}
            <div class="mt-8">
                {{ $kampanyes->links() }}
            </div>

        </div>
    </main>
@endsection