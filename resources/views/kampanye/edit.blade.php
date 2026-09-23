@extends('layouts.dashboard')

@section('title', __('Edit Kampanye'))

@section('content')

    <main class="flex-1 min-w-0 bg-[#F1F1F1]">

        <div class="max-w-[1100px] mx-auto px-6 lg:px-8 pt-7 pb-16">

            {{-- HEADER --}}
            <header>

                <a href="{{ route('kampanye.saya') }}"
                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-[#105B59] hover:text-[#064D4C] transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    {{ __('Kembali ke Galang Dana') }}
                </a>

                <h1 class="mt-3.5 text-xl sm:text-2xl font-bold text-[#1A1A1A] leading-tight">
                    {{ __('Edit Kampanye') }}
                </h1>
                <p class="mt-1 text-xs sm:text-sm text-gray-500">
                    {{ __('Perbarui informasi kampanye kemanusiaan Anda.') }}
                </p>

            </header>

            {{-- FORM CARD --}}
            <section class="mt-5 bg-white rounded-xl shadow-xs border border-gray-200 px-5 py-6">

                <form action="{{ route('kampanye.update', $kampanye->id) }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    {{-- JUDUL --}}
                    <div>
                        <label for="judul" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                            {{ __('Judul Campaign') }}
                        </label>
                        <input type="text"
                               name="judul"
                               id="judul"
                               value="{{ old('judul', $kampanye->judul) }}"
                               placeholder="{{ __('Masukkan judul kampanye') }}"
                               class="w-full h-[48px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#105B59] focus:border-[#105B59] focus:outline-none">
                        @error('judul')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="mt-6">
                        <label for="deskripsi" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                            {{ __('Deskripsi') }}
                        </label>
                        <textarea name="deskripsi"
                                  id="deskripsi"
                                  rows="5"
                                  placeholder="{{ __('Ceritakan detail dan tujuan kampanye Anda') }}"
                                  class="w-full px-4 py-3 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#105B59] focus:border-[#105B59] focus:outline-none">{{ old('deskripsi', $kampanye->deskripsi) }}</textarea>
                        @error('deskripsi')
                            <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- KATEGORI + LOKASI --}}
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <label for="kategori" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                                {{ __('Kategori') }}
                            </label>
                            <select name="kategori"
                                    id="kategori"
                                    class="w-full h-[48px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#105B59] focus:border-[#105B59] focus:outline-none">
                                @foreach (['Bencana Alam', 'Pendidikan', 'Kesehatan', 'Lingkungan', 'Sosial'] as $kategoriOption)
                                    <option value="{{ $kategoriOption }}"
                                        {{ old('kategori', $kampanye->kategori) === $kategoriOption ? 'selected' : '' }}>
                                        {{ $kategoriOption }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="lokasi" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                                {{ __('Lokasi') }}
                            </label>
                            <input type="text"
                                   name="lokasi"
                                   id="lokasi"
                                   value="{{ old('lokasi', $kampanye->lokasi) }}"
                                   placeholder="{{ __('Misalnya: Jakarta Utara') }}"
                                   class="w-full h-[48px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#105B59] focus:border-[#105B59] focus:outline-none">
                            @error('lokasi')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- TARGET DANA + BATAS TANGGAL --}}
                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6">

                        <div>
                            <label for="target_dana" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                                {{ __('Target Dana') }}
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-semibold text-[#64748B]">
                                    Rp
                                </span>
                                <input type="number"
                                       name="target_dana"
                                       id="target_dana"
                                       value="{{ old('target_dana', $kampanye->target_dana) }}"
                                       min="1"
                                       placeholder="0"
                                       class="w-full h-[48px] pl-11 pr-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#105B59] focus:border-[#105B59] focus:outline-none">
                            </div>
                            @error('target_dana')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="batas_tanggal" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                                {{ __('Batas Tanggal') }}
                            </label>
                            <input type="date"
                                   name="batas_tanggal"
                                   id="batas_tanggal"
                                   value="{{ old('batas_tanggal', $kampanye->batas_tanggal) }}"
                                   class="w-full h-[48px] px-4 rounded-xl bg-[#F8FAFA] border border-[#D9E2E1] text-sm focus:ring-2 focus:ring-[#105B59] focus:border-[#105B59] focus:outline-none">
                            @error('batas_tanggal')
                                <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- GAMBAR --}}
                    <div class="mt-6">
                        <label for="gambar" class="block text-[13px] font-semibold text-[#64748B] mb-2">
                            {{ __('Gambar Kampanye') }}
                        </label>

                        <div class="flex flex-wrap items-center gap-5">

                            <div class="w-[140px] h-[105px] rounded-xl bg-gray-100 border border-[#E5E5E5] overflow-hidden flex-shrink-0">
                                @if ($kampanye->gambar)
                                    <img id="gambar-preview"
                                         src="{{ asset('storage/' . $kampanye->gambar) }}"
                                         alt="{{ $kampanye->judul }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div id="gambar-preview"
                                         class="w-full h-full flex items-center justify-center text-xs text-gray-400">
                                        {{ __('Belum ada gambar') }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <input type="file"
                                       name="gambar"
                                       id="gambar"
                                       accept="image/jpeg,image/png,image/jpg"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:bg-[#E4F0EE] file:text-[#105B59] file:text-sm file:font-semibold hover:file:bg-[#D3E5E2]">
                                <p class="mt-2 text-xs text-gray-400">
                                    {{ __('Kosongkan jika tidak ingin mengubah gambar. Maksimal 2 MB (JPG/PNG).') }}
                                </p>
                                @error('gambar')
                                    <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                    </div>

                    {{-- AKSI --}}
                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-[#E5E5E5] pt-6">

                        <a href="{{ route('kampanye.saya') }}"
                           class="inline-flex items-center justify-center h-[48px] px-6 rounded-xl border border-[#105B59] text-[#105B59] text-sm font-semibold hover:bg-[#E4F0EE] transition-colors">
                            {{ __('Batal') }}
                        </a>

                        <button type="submit"
                                class="inline-flex items-center justify-center h-[48px] px-8 rounded-xl bg-[#105B59] hover:bg-[#064D4C] text-white text-sm font-semibold transition-colors shadow-sm">
                            {{ __('Simpan Perubahan') }}
                        </button>

                    </div>

                </form>

            </section>

        </div>

    </main>

    <script>
        const gambarInput = document.getElementById('gambar');
        const gambarPreview = document.getElementById('gambar-preview');

        if (gambarInput && gambarPreview) {
            gambarInput.addEventListener('change', function () {
                const file = this.files[0];

                if (file) {
                    gambarPreview.src = URL.createObjectURL(file);
                }
            });
        }
    </script>

@endsection