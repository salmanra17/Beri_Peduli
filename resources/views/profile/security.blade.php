@extends('layouts.dashboard')

@section('title', __('Keamanan & Password'))

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
            {{-- TAB 1: PROFIL PERSONAL --}}
            <a href="{{ route('profile.edit') }}"
               class="pb-3 font-medium text-gray-400 hover:text-gray-600 transition">
                {{ __('Profil Personal') }}
            </a>

            {{-- TAB 2: KEAMANAN & PASSWORD (AKTIF) --}}
            <a href="{{ route('profile.security') }}"
               class="pb-3 font-bold text-[#135B59] border-b-2 border-[#135B59] transition flex items-center gap-1.5">
                {{ __('Keamanan & Password') }}
            </a>

            {{-- TAB 3: REKENING BANK --}}
            <a href="{{ route('profile.rekening') }}"
               class="pb-3 font-medium text-gray-400 hover:text-gray-600 transition">
                {{ __('Rekening Bank') }}
            </a>
        </div>
    </div>

    {{-- KONTEN UTAMA: 2 KOLOM --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">

        {{-- ==================== KOLOM KIRI: UBAH PASSWORD ==================== --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-2xl p-6 sm:p-7 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">

                {{-- Judul Kartu --}}
                <div class="flex items-center gap-2.5 mb-6">
                    <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                    <h2 class="text-base font-bold text-gray-900">{{ __('Ubah Password') }}</h2>
                </div>

                <form action="{{ route('profile.password.update') }}" method="POST" id="form-password">
                    @csrf
                    @method('PUT')

                    <div class="space-y-5">

                        {{-- PASSWORD SAAT INI --}}
                        <div>
                            <label for="current_password" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Password Saat Ini') }}
                            </label>
                            <div class="relative">
                                <input type="password"
                                       id="current_password"
                                       name="current_password"
                                       placeholder="{{ __('Masukkan password saat ini') }}"
                                       autocomplete="current-password"
                                       class="w-full px-3.5 py-2.5 pr-11 rounded-xl border {{ $errors->has('current_password') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                                <button type="button"
                                        class="btn-toggle-pw absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                                        data-target="current_password"
                                        tabindex="-1">
                                    <svg class="w-5 h-5 icon-eye-off" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg class="w-5 h-5 icon-eye hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- PASSWORD BARU --}}
                        <div>
                            <label for="password" class="block text-xs font-semibold text-gray-700 mb-1.5">
{{ __('Password Baru') }}
                            </label>
                            <div class="relative">
                                <input type="password"
                                       id="password"
                                       name="password"
                                       placeholder="{{ __('Minimal 8 karakter') }}"
                                       autocomplete="new-password"
                                       class="w-full px-3.5 py-2.5 pr-11 rounded-xl border {{ $errors->has('password') ? 'border-red-400 bg-red-50' : 'border-gray-200 bg-white' }} text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                                <button type="button"
                                        class="btn-toggle-pw absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                                        data-target="password"
                                        tabindex="-1">
                                    <svg class="w-5 h-5 icon-eye-off" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg class="w-5 h-5 icon-eye hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @else
                                <p class="mt-1.5 text-xs text-gray-400">{{ __('Gunakan kombinasi huruf, angka, dan simbol untuk keamanan maksimal.') }}</p>
                            @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD BARU --}}
                        <div>
                            <label for="password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Konfirmasi Password Baru') }}
                            </label>
                            <div class="relative">
                                <input type="password"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       placeholder="{{ __('Ulangi password baru') }}"
                                       autocomplete="new-password"
                                       class="w-full px-3.5 py-2.5 pr-11 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                                <button type="button"
                                        class="btn-toggle-pw absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                                        data-target="password_confirmation"
                                        tabindex="-1">
                                    <svg class="w-5 h-5 icon-eye-off" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                    <svg class="w-5 h-5 icon-eye hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        {{-- TOMBOL SUBMIT --}}
                        <div class="flex justify-end pt-1">
                            <button type="submit"
                                    id="btn-simpan-password"
                                    class="py-2.5 px-6 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white font-semibold text-sm shadow-sm transition flex items-center gap-2 cursor-pointer">
                                <span>{{ __('Simpan Password Baru') }}</span>
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>

        {{-- ==================== KOLOM KANAN: SESI AKTIF ==================== --}}
        <div class="lg:col-span-4">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">

                {{-- Judul Kartu --}}
                <div class="flex items-center gap-2.5 mb-2">
                    <svg class="w-5 h-5 text-gray-700" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0H3" />
                    </svg>
                    <h2 class="text-base font-bold text-gray-900">{{ __('Sesi Aktif') }}</h2>
                </div>

                <p class="text-xs text-gray-400 mb-4 leading-relaxed">
                    {{ __('Daftar perangkat yang saat ini masuk ke akun Anda.') }}
                </p>

                {{-- DAFTAR SESI --}}
                <div class="space-y-3 mb-5">
                    @forelse($sessions as $session)
                        <div class="flex items-start gap-3">

                            {{-- IKON PERANGKAT --}}
                            <div class="flex-shrink-0 mt-0.5">
                                @if($session->is_mobile)
                                    {{-- Ikon Ponsel --}}
                                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3" />
                                    </svg>
                                @else
                                    {{-- Ikon Laptop/Desktop --}}
                                    <svg class="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0H3" />
                                    </svg>
                                @endif
                            </div>

                            {{-- INFO SESI --}}
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-gray-800 leading-tight truncate">
                                    {{ $session->platform }} &bull; {{ $session->browser }}
                                </p>
                                <p class="text-xs text-gray-400 mt-0.5">
                                    {{ $session->ip_address }}
                                </p>
                                @if($session->is_current)
                                    <span class="inline-flex items-center gap-1 mt-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                        <span class="text-xs text-[#135B59] font-semibold">{{ __('Sesi Ini Aktif') }}</span>
                                    </span>
                                @else
                                    <p class="text-xs text-gray-400 mt-0.5">
                                        {{ __('Terakhir aktif:') }} {{ $session->last_activity->diffForHumans() }}
                                    </p>
                                @endif
                            </div>

                            {{-- BADGE / STATUS --}}
                            @if(!$session->is_current)
                                <div class="flex-shrink-0 mt-0.5">
                                    <svg class="w-4 h-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                </div>
                            @endif

                        </div>
                    @empty
                        <p class="text-xs text-gray-400 text-center py-2">{{ __('Tidak ada sesi aktif ditemukan.') }}</p>
                    @endforelse
                </div>

                {{-- TOMBOL KELUAR DARI SEMUA PERANGKAT --}}
                @if($sessions->where('is_current', false)->count() > 0)
                    <button type="button"
                            id="btn-keluar-semua"
                            class="w-full py-2.5 px-4 rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-semibold text-sm transition text-center cursor-pointer">
                        {{ __('Keluar dari Semua Perangkat') }}
                    </button>
                @else
                    <div class="w-full py-2.5 px-4 rounded-xl border border-gray-100 bg-gray-50 text-gray-400 font-medium text-sm text-center">
                        {{ __('Tidak ada sesi lain aktif') }}
                    </div>
                @endif

            </div>
        </div>

    </div>

</div>

{{-- MODAL KONFIRMASI KELUAR SEMUA SESI --}}
<div id="modal-keluar-sesi"
     class="fixed inset-0 z-50 hidden items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="modal-title-sesi">
    {{-- Backdrop --}}
    <div class="absolute inset-0 bg-black/30 backdrop-blur-sm" id="modal-backdrop-sesi"></div>

    {{-- Panel --}}
    <div class="relative bg-white rounded-2xl shadow-xl p-6 sm:p-7 w-full max-w-sm z-10">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-amber-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                </svg>
            </div>
            <div>
                <h3 id="modal-title-sesi" class="text-base font-bold text-gray-900">{{ __('Keluar dari Semua Perangkat') }}</h3>
                <p class="text-xs text-gray-400 mt-0.5">{{ __('Konfirmasi dengan password Anda') }}</p>
            </div>
        </div>

        <p class="text-sm text-gray-600 mb-5 leading-relaxed">
            {{ __('Tindakan ini akan mengakhiri semua sesi aktif di perangkat lain. Anda tetap masuk di perangkat ini.') }}
        </p>

        <form action="{{ route('profile.sessions.destroy') }}" method="POST" id="form-keluar-sesi">
            @csrf
            @method('DELETE')

            <div class="mb-4">
                <label for="modal_password" class="block text-xs font-semibold text-gray-700 mb-1.5">
                    {{ __('Password') }}
                </label>
                <div class="relative">
                    <input type="password"
                           id="modal_password"
                           name="password"
                           placeholder="{{ __('Masukkan password Anda') }}"
                           autocomplete="current-password"
                           class="w-full px-3.5 py-2.5 pr-11 rounded-xl border border-gray-200 bg-white text-sm text-gray-900 focus:ring-2 focus:ring-[#135B59]/20 focus:border-[#135B59] outline-none transition placeholder:text-gray-400">
                    <button type="button"
                            class="btn-toggle-pw absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition"
                            data-target="modal_password"
                            tabindex="-1">
                        <svg class="w-5 h-5 icon-eye-off" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                        <svg class="w-5 h-5 icon-eye hidden" fill="none" viewBox="0 0 24 24" stroke-width="1.7" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3">
                <button type="button"
                        id="btn-batal-modal"
                        class="flex-1 py-2.5 px-4 rounded-xl border border-gray-200 bg-gray-50 hover:bg-gray-100 text-gray-700 font-semibold text-sm transition cursor-pointer">
                    {{ __('Batal') }}
                </button>
                <button type="submit"
                        class="flex-1 py-2.5 px-4 rounded-xl bg-[#135B59] hover:bg-[#0f4947] text-white font-semibold text-sm shadow-sm transition cursor-pointer">
                    {{ __('Ya, Keluar') }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // ===== TOGGLE SHOW/HIDE PASSWORD =====
    document.querySelectorAll('.btn-toggle-pw').forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = this.dataset.target;
            const input = document.getElementById(targetId);
            if (!input) { return; }

            const eyeOff = this.querySelector('.icon-eye-off');
            const eyeOn  = this.querySelector('.icon-eye');

            if (input.type === 'password') {
                input.type = 'text';
                eyeOff.classList.add('hidden');
                eyeOn.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeOff.classList.remove('hidden');
                eyeOn.classList.add('hidden');
            }
        });
    });

    // ===== MODAL KELUAR SEMUA SESI =====
    const btnKeluar    = document.getElementById('btn-keluar-semua');
    const modal        = document.getElementById('modal-keluar-sesi');
    const backdrop     = document.getElementById('modal-backdrop-sesi');
    const btnBatal     = document.getElementById('btn-batal-modal');

    function openModal() {
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }

    if (btnKeluar) {
        btnKeluar.addEventListener('click', openModal);
    }

    if (backdrop) {
        backdrop.addEventListener('click', closeModal);
    }

    if (btnBatal) {
        btnBatal.addEventListener('click', closeModal);
    }

    // Tutup dengan Escape
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    @if($errors->has('password'))
        // Buka modal otomatis jika ada error password (dari keluar sesi)
        openModal();
    @endif

});
</script>
@endsection
