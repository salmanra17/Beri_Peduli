@extends('layouts.dashboard')

@section('title', __('Pengaturan Akun'))

@section('content')
<div class="p-5 sm:p-6 lg:px-8 max-w-6xl">

    {{-- ALERT SUKSES / ERROR --}}
    <x-flash-message class="mb-5" />

    {{-- HEADER HALAMAN --}}
    <div class="mb-5">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900 tracking-tight">
            {{ __('Pengaturan Akun') }}
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-1 leading-relaxed">
            {{ __('Kelola preferensi, keamanan, dan informasi profil Anda.') }}
        </p>
    </div>

    {{-- TABS BAR --}}
    <div class="border-b border-gray-200 mb-6">
        <div class="flex items-center gap-6 text-xs sm:text-sm">
            {{-- TAB 1: PROFIL PERSONAL (AKTIF) --}}
            <a href="{{ route('profile.edit') }}"
               class="pb-3 font-bold text-[#135B59] border-b-2 border-[#135B59] transition flex items-center gap-1.5">
                {{ __('Profil Personal') }}
            </a>

            {{-- TAB 2: KEAMANAN & PASSWORD --}}
            <a href="{{ route('profile.security') }}"
               class="pb-3 font-medium text-gray-400 hover:text-gray-600 transition">
                {{ __('Keamanan & Password') }}
            </a>

            {{-- TAB 3: REKENING BANK --}}
            <a href="{{ route('profile.rekening') }}"
               class="pb-3 font-medium text-gray-400 hover:text-gray-600 transition">
                {{ __('Rekening Bank') }}
            </a>
        </div>
    </div>

    {{-- FORM UTAMA PENGATURAN PROFIL --}}
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="form-profil">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

            {{-- ==================== KOLOM KIRI (INFORMASI DASAR & ALAMAT DOMISILI) ==================== --}}
            <div class="lg:col-span-8 space-y-6">

                {{-- KARTU 1: INFORMASI DASAR --}}
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-2.5 mb-5">
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <h2 class="text-base font-bold text-gray-900">
                            {{ __('Informasi Dasar') }}
                        </h2>
                    </div>

                    <div class="space-y-4">
                        {{-- NAMA DEPAN & NAMA BELAKANG --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="nama_depan" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Nama Depan') }}
                                </label>
                                <input type="text" id="nama_depan" name="nama_depan"
                                       value="{{ old('nama_depan', $user->resolved_nama_depan) }}"
                                       placeholder="{{ __('Nama Depan') }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                            </div>

                            <div>
                                <label for="nama_belakang" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Nama Belakang') }}
                                </label>
                                <input type="text" id="nama_belakang" name="nama_belakang"
                                       value="{{ old('nama_belakang', $user->resolved_nama_belakang) }}"
                                       placeholder="{{ __('Nama Belakang') }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                            </div>
                        </div>

                        {{-- EMAIL ADDRESS --}}
                        <div>
                            <label for="email" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Email Address') }}
                            </label>
                            <div class="relative">
                                <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                                <input type="email" id="email" name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       placeholder="nama@example.com"
                                       class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                            </div>
                        </div>

                        {{-- NOMOR TELEPON & TANGGAL LAHIR --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="no_hp" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Nomor Telepon') }}
                                </label>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                    <input type="tel" id="no_hp" name="no_hp"
                                           value="{{ old('no_hp', $user->no_hp) }}"
                                           placeholder="+62 812 3456 7890"
                                           class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                                </div>
                            </div>

                            <div>
                                <label for="tanggal_lahir" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Tanggal Lahir') }}
                                </label>
                                <div class="relative">
                                    <svg class="w-5 h-5 text-gray-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 9v7.5" />
                                    </svg>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir"
                                           value="{{ old('tanggal_lahir', $user->tanggal_lahir ? $user->tanggal_lahir->format('Y-m-d') : '') }}"
                                           class="w-full pl-11 pr-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU 2: ALAMAT DOMISILI --}}
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <div class="flex items-center gap-2.5 mb-5">
                        <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <h2 class="text-base font-bold text-gray-900">
                            {{ __('Alamat Domisili') }}
                        </h2>
                    </div>

                    <div class="space-y-4">
                        {{-- ALAMAT LENGKAP --}}
                        <div>
                            <label for="alamat" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Alamat Lengkap') }}
                            </label>
                            <textarea id="alamat" name="alamat" rows="3"
                                      placeholder="Jl. Kebon Jeruk Raya No. 27, RT 01/RW 03, Kebon Jeruk"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition resize-none placeholder:text-gray-400">{{ old('alamat', $user->alamat) }}</textarea>
                        </div>

                        {{-- PROVINSI & KOTA / KABUPATEN --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="provinsi" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Provinsi') }}
                                </label>
                                <div class="relative">
                                    <select id="provinsi" name="provinsi"
                                            class="w-full appearance-none px-3.5 py-2.5 pr-10 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition cursor-pointer">
                                        <option value="">{{ __('Pilih Provinsi') }}</option>
                                        @php
                                            $provinsiList = [
                                                'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur',
                                                'Banten', 'DI Yogyakarta', 'Bali', 'Sumatera Utara',
                                                'Sumatera Barat', 'Riau', 'Kepulauan Riau', 'Jambi',
                                                'Sumatera Selatan', 'Lampung', 'Kalimantan Barat',
                                                'Kalimantan Selatan', 'Kalimantan Timur', 'Sulawesi Selatan',
                                                'Sulawesi Utara', 'Nusa Tenggara Barat', 'Papua'
                                            ];
                                            $selectedProv = old('provinsi', $user->provinsi ?? 'DKI Jakarta');
                                        @endphp
                                        @foreach($provinsiList as $prov)
                                            <option value="{{ $prov }}" {{ $selectedProv === $prov ? 'selected' : '' }}>
                                                {{ $prov }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg class="w-4 h-4 text-gray-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>

                            <div>
                                <label for="kota" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Kota / Kabupaten') }}
                                </label>
                                <div class="relative">
                                    <select id="kota" name="kota"
                                            class="w-full appearance-none px-3.5 py-2.5 pr-10 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition cursor-pointer">
                                        <option value="">{{ __('Pilih Kota / Kabupaten') }}</option>
                                        @php
                                            $kotaList = [
                                                'Jakarta Barat', 'Jakarta Pusat', 'Jakarta Selatan',
                                                'Jakarta Timur', 'Jakarta Utara', 'Kepulauan Seribu',
                                                'Kota Bandung', 'Kota Bogor', 'Kota Depok', 'Kota Bekasi',
                                                'Kota Tangerang', 'Kota Tangerang Selatan', 'Kota Semarang',
                                                'Kota Surabaya', 'Kota Malang', 'Kota Surakarta (Solo)',
                                                'Kota Yogyakarta', 'Kota Medan', 'Kota Padang', 'Kota Makassar',
                                                'Kota Denpasar', 'Kota Palembang', 'Kota Balikpapan'
                                            ];
                                            $selectedKota = old('kota', $user->kota ?? 'Jakarta Barat');
                                        @endphp
                                        @foreach($kotaList as $kt)
                                            <option value="{{ $kt }}" {{ $selectedKota === $kt ? 'selected' : '' }}>
                                                {{ $kt }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <svg class="w-4 h-4 text-gray-400 absolute right-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        {{-- KODE POS --}}
                        <div class="w-full sm:w-1/2">
                            <label for="kode_pos" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Kode Pos') }}
                            </label>
                            <input type="text" id="kode_pos" name="kode_pos"
                                   value="{{ old('kode_pos', $user->kode_pos) }}"
                                   placeholder="11530"
                                   maxlength="10"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                        </div>
                    </div>
                </div>

            </div>

            {{-- ==================== KOLOM KANAN (FOTO PROFIL & PREFERENSI) ==================== --}}
            <div class="lg:col-span-4 space-y-6">

                {{-- KARTU 3: FOTO PROFIL --}}
                <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <h2 class="text-base font-bold text-gray-900 mb-6 text-left">
                        {{ __('Foto Profil') }}
                    </h2>

                    <div class="flex flex-col items-center text-center">
                        {{-- AVATAR LINGKARAN BESAR DENGAN BADGE HIJAU --}}
                        <div class="relative w-28 h-28 mx-auto">
                            @if($user->foto_profil)
                                <img id="avatar-preview"
                                     src="{{ asset('storage/' . $user->foto_profil) }}"
                                     alt="{{ __('Foto Profil') }}"
                                     class="w-28 h-28 rounded-full object-cover shadow-sm mx-auto border-2 border-gray-100">
                                <div id="avatar-fallback"
                                     class="w-28 h-28 rounded-full bg-[#134F4F] text-white flex items-center justify-center font-bold text-3xl mx-auto shadow-sm hidden">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </div>
                            @else
                                <img id="avatar-preview"
                                     src=""
                                     alt="{{ __('Foto Profil') }}"
                                     class="w-28 h-28 rounded-full object-cover shadow-sm mx-auto border-2 border-gray-100 hidden">
                                <div id="avatar-fallback"
                                     class="w-28 h-28 rounded-full bg-[#134F4F] text-white flex items-center justify-center font-bold text-3xl mx-auto shadow-sm">
                                    {{ strtoupper(mb_substr($user->name, 0, 1)) }}
                                </div>
                            @endif

                            {{-- BADGE CENTANG HIJAU (SEPERTI MOCKUP) --}}
                            <div class="absolute bottom-0 right-1 w-6 h-6 bg-[#135B59] text-white rounded-full flex items-center justify-center border-2 border-white shadow-sm"
                                 title="{{ __('Akun Terverifikasi') }}">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            </div>
                        </div>

                        {{-- KETERANGAN FORMAT FILE --}}
                        <p class="text-xs text-gray-500 mt-4 leading-relaxed max-w-[230px] mx-auto">
                            {{ __('Gunakan format JPG, PNG, atau WEBP. Maksimal ukuran file 5MB. Resolusi disarankan 500×500px.') }}
                        </p>

                        {{-- INPUT FILE HIDDEN & HAPUS FOTO FLAG --}}
                        <input type="file" id="foto_profil_input" name="foto_profil"
                               accept="image/jpeg,image/png,image/webp"
                               class="hidden">
                        <input type="hidden" id="hapus_foto_input" name="hapus_foto" value="0">

                        {{-- TOMBOL UBAH FOTO & HAPUS FOTO --}}
                        <div class="flex items-center gap-2.5 w-full mt-5">
                            <button type="button" id="btn-pilih-foto"
                                    class="flex-1 py-2.5 px-4 rounded-xl bg-[#EAF2FF] hover:bg-[#dce9fd] text-[#135B59] font-semibold text-sm transition text-center cursor-pointer shadow-none">
                                {{ __('Ubah Foto') }}
                            </button>

                            <button type="button" id="btn-hapus-foto"
                                    title="{{ __('Hapus foto profil') }}"
                                    class="w-10 h-10 rounded-xl border border-red-200 text-red-500 hover:bg-red-50 flex items-center justify-center flex-shrink-0 transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- KARTU 4: PREFERENSI --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
                    <h2 class="text-base font-bold text-gray-900 mb-4">
                        {{ __('Preferensi') }}
                    </h2>

                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ __('Bahasa Antarmuka') }}
                            </p>
                            <p class="text-xs text-gray-400 mt-0.5">
                                {{ __('Pilih bahasa utama') }}
                            </p>
                        </div>

                        {{-- TOGGLE PILL ID / EN (instan, langsung ubah bahasa) --}}
                        <div class="bg-gray-100 p-1 rounded-full flex items-center text-xs font-semibold select-none">
                            <a href="{{ route('bahasa.set', 'id') }}"
                               class="px-3 py-1 rounded-full transition {{ app()->getLocale() === 'id' ? 'bg-white text-[#135B59] shadow-sm font-bold' : 'text-gray-400 hover:text-gray-600' }}">
                                ID
                            </a>
                            <a href="{{ route('bahasa.set', 'en') }}"
                               class="px-3 py-1 rounded-full transition {{ app()->getLocale() === 'en' ? 'bg-white text-[#135B59] shadow-sm font-bold' : 'text-gray-400 hover:text-gray-600' }}">
                                EN
                            </a>
                        </div>
                    </div>
                </div>

                {{-- TOMBOL AKSI (DI BAWAH PREFERENSI) --}}
                <div class="flex items-center gap-3 pt-1">
                    <button type="button"
                            onclick="window.location.reload()"
                            class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 bg-[#EFEFEF] hover:bg-gray-200 text-gray-700 font-semibold text-sm transition text-center cursor-pointer">
                        {{ __('Batal') }}
                    </button>

                    <button type="submit"
                            class="flex-[1.4] py-2.5 px-4 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white font-semibold text-sm shadow-sm transition flex items-center justify-center gap-2 cursor-pointer">
                        <span>{{ __('Simpan Perubahan') }}</span>
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

{{-- SCRIPT INTERAKTIF CLIENT-SIDE --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('foto_profil_input');
    const btnPilihFoto = document.getElementById('btn-pilih-foto');
    const btnHapusFoto = document.getElementById('btn-hapus-foto');
    const avatarPreview = document.getElementById('avatar-preview');
    const avatarFallback = document.getElementById('avatar-fallback');
    const hapusFotoInput = document.getElementById('hapus_foto_input');

    // Trigger input file saat klik Ubah Foto
    btnPilihFoto.addEventListener('click', function() {
        fileInput.click();
    });

    // Preview langsung saat file dipilih
    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Validasi ukuran 5MB
            if (file.size > 5 * 1024 * 1024) {
                alert(@js(__('Ukuran file maksimal 5MB.')));
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                avatarPreview.src = event.target.result;
                avatarPreview.classList.remove('hidden');
                if (avatarFallback) {
                    avatarFallback.classList.add('hidden');
                }
                hapusFotoInput.value = '0';
            };
            reader.readAsDataURL(file);
        }
    });

    // Hapus Foto Profil
    btnHapusFoto.addEventListener('click', function() {
        fileInput.value = '';
        hapusFotoInput.value = '1';
        avatarPreview.classList.add('hidden');
        avatarPreview.src = '';
        if (avatarFallback) {
            avatarFallback.classList.remove('hidden');
        }
    });

    // Toggle Bahasa ID / EN kini berupa link langsung ke route bahasa.set
    // (tidak perlu submit form profil).
});
</script>
@endsection
