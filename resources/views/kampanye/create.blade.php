@extends('layouts.app')

@section('content')

    <main class="bg-[#F8FAFC] min-h-screen py-7 text-gray-900">

        <div class="max-w-[1240px] mx-auto px-4 lg:px-8">

            {{-- HEADER DINAMIS SESUAI TAHAP --}}
            <div class="text-center mb-6">
                <h1 id="header-judul" class="text-2xl md:text-3xl font-bold text-gray-900 mb-1.5 transition-all">
                    {{ __('Mulai Galang Dana') }}
                </h1>
                <p id="header-deskripsi" class="text-gray-500 text-xs md:text-sm max-w-xl mx-auto transition-all">
                    {{ __('Lengkapi identitas Anda untuk membangun kepercayaan bagi para calon donatur.') }}
                </p>
            </div>

            {{-- STEPPER --}}
            <div class="max-w-md mx-auto mb-7">
                <div class="flex items-center justify-between relative">
                    
                    {{-- Connecting Line 1 to 2 --}}
                    <div class="absolute left-[16%] right-[50%] top-4 -translate-y-1/2 h-[2px] bg-gray-200 -z-0">
                        <div id="line-1-2" class="h-full bg-[#134F4F] w-0 transition-all duration-300"></div>
                    </div>

                    {{-- Connecting Line 2 to 3 --}}
                    <div class="absolute left-[50%] right-[16%] top-4 -translate-y-1/2 h-[2px] bg-gray-200 -z-0">
                        <div id="line-2-3" class="h-full bg-[#134F4F] w-0 transition-all duration-300"></div>
                    </div>

                    {{-- STEP 1: IDENTITAS --}}
                    <div class="flex flex-col items-center relative z-10 cursor-pointer" onclick="keTahap(1)">
                        <div id="step-circle-1"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-[#134F4F] text-white shadow-xs transition-all duration-300">
                            <span id="step-num-1">1</span>
                            <svg id="step-check-1" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span id="step-label-1" class="text-xs font-bold text-[#134F4F] mt-1.5 transition-colors">
                            {{ __('Identitas') }}
                        </span>
                    </div>

                    {{-- STEP 2: DETAIL --}}
                    <div class="flex flex-col items-center relative z-10 cursor-pointer" onclick="cobaKeTahap(2)">
                        <div id="step-circle-2"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-gray-200 text-gray-500 transition-all duration-300">
                            <span id="step-num-2">2</span>
                            <svg id="step-check-2" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span id="step-label-2" class="text-xs font-medium text-gray-400 mt-1.5 transition-colors">
                            {{ __('Detail') }}
                        </span>
                    </div>

                    {{-- STEP 3: VERIFIKASI --}}
                    <div class="flex flex-col items-center relative z-10 cursor-pointer" onclick="cobaKeTahap(3)">
                        <div id="step-circle-3"
                             class="w-8 h-8 rounded-full flex items-center justify-center font-bold text-xs bg-gray-200 text-gray-500 transition-all duration-300">
                            <span id="step-num-3">3</span>
                            <svg id="step-check-3" class="w-4 h-4 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <span id="step-label-3" class="text-xs font-medium text-gray-400 mt-1.5 transition-colors">
                            {{ __('Verifikasi') }}
                        </span>
                    </div>

                </div>
            </div>

            {{-- ALERT ERROR VALIDASI DARI BACKEND JIKA ADA --}}
            @if ($errors->any())
                <div class="max-w-4xl mx-auto mb-5 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-xs">
                    <p class="font-bold mb-1">{{ __('Terdapat kesalahan pada formulir:') }}</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM MULTI-STEP UTAMA --}}
            <form id="form-galang-dana" action="{{ route('kampanye.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- ================================================================ --}}
                {{-- TAHAP 1: IDENTITAS                                               --}}
                {{-- ================================================================ --}}
                <div id="tahap-1" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {{-- KIRI: FORM IDENTITAS --}}
                    <div class="lg:col-span-8 bg-white rounded-2xl p-5 sm:p-6 shadow-xs border border-gray-100">
                        
                        {{-- PILIH JENIS AKUN --}}
                        <div class="mb-5">
                            <label class="block text-xs font-semibold text-gray-700 mb-2">
                                {{ __('Pilih Jenis Akun') }}
                            </label>
                            
                            <input type="hidden" name="jenis_akun" id="input_jenis_akun" value="{{ old('jenis_akun', 'perorangan') }}">
                            
                            <div class="grid grid-cols-3 gap-3">
                                
                                {{-- Option 1: Perorangan --}}
                                <button type="button" onclick="pilihJenisAkun('perorangan')"
                                        id="btn-jenis-perorangan"
                                        class="jenis-akun-btn border-2 rounded-xl p-3 flex flex-col items-center justify-center gap-2 transition-all text-center border-[#134F4F] bg-[#F2FAF8] text-[#134F4F]">
                                    <svg class="w-5 h-5 text-inherit" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="text-xs font-semibold">{{ __('Perorangan') }}</span>
                                </button>

                                {{-- Option 2: Komunitas --}}
                                <button type="button" onclick="pilihJenisAkun('komunitas')"
                                        id="btn-jenis-komunitas"
                                        class="jenis-akun-btn border-2 border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-2 transition-all text-center bg-white text-gray-700 hover:border-gray-300">
                                    <svg class="w-5 h-5 text-inherit" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    </svg>
                                    <span class="text-xs font-semibold">{{ __('Komunitas') }}</span>
                                </button>

                                {{-- Option 3: Lembaga --}}
                                <button type="button" onclick="pilihJenisAkun('lembaga')"
                                        id="btn-jenis-lembaga"
                                        class="jenis-akun-btn border-2 border-gray-200 rounded-xl p-3 flex flex-col items-center justify-center gap-2 transition-all text-center bg-white text-gray-700 hover:border-gray-300">
                                    <svg class="w-5 h-5 text-inherit" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    </svg>
                                    <span class="text-xs font-semibold">{{ __('Lembaga') }}</span>
                                </button>

                            </div>
                        </div>

                        {{-- NAMA LENGKAP --}}
                        <div class="mb-4">
                            <label for="input_nama_lengkap" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Nama Lengkap') }}
                            </label>
                            <input type="text" id="input_nama_lengkap" name="nama_lengkap"
                                       value="{{ old('nama_lengkap') }}"
                                       placeholder="{{ __('Masukkan nama penggalang / nama lembaga') }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                        </div>

                        {{-- EMAIL --}}
                        <div class="mb-4">
                            <label for="input_email" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Email') }}
                            </label>
                            <input type="email" id="input_email" name="email"
                                   value="{{ old('email', auth()->user()->email ?? '') }}"
                                   placeholder="{{ __('contoh@email.com') }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                        </div>

                        {{-- ALAMAT LENGKAP --}}
                        <div class="mb-6">
                            <label for="input_alamat" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Alamat Lengkap') }}
                            </label>
                            <textarea id="input_alamat" name="alamat" rows="2.5"
                                      placeholder="{{ __('Jl. Nama Jalan No. 00, Kota, Provinsi, Kode Pos') }}"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400 resize-none">{{ old('alamat') }}</textarea>
                        </div>

                        {{-- TOMBOL LANJUT KE TAHAP 2 --}}
                        <button type="button" onclick="keTahap(2)"
                                class="w-full bg-[#134F4F] text-white font-semibold py-3 rounded-xl hover:bg-[#0c4a3d] transition-colors shadow-xs text-xs sm:text-sm">
                            {{ __('Lanjut ke Tahap 2') }}
                        </button>

                        <p class="text-[11px] text-gray-400 text-center mt-3">
                            {{ __('Informasi Anda akan dijaga kerahasiaannya sesuai dengan') }} <a href="#" class="underline text-gray-600 hover:text-gray-900">{{ __('Kebijakan Privasi') }}</a> kami.
                        </p>

                    </div>

                    {{-- KANAN: PANDUAN & TIPS --}}
                    <div class="lg:col-span-4 bg-white rounded-2xl p-5 shadow-xs border border-gray-100">
                        
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-[#134F4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                            </svg>
                            <h3 class="text-sm font-bold text-gray-900">{{ __('Panduan & Tips') }}</h3>
                        </div>

                        <div class="space-y-4">
                            
                            {{-- Item 1 --}}
                            <div class="flex items-start gap-2.5">
                                <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-gray-900 mb-0.5">{{ __('Identitas Asli') }}</p>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        {{ __('Gunakan nama lengkap sesuai KTP agar memudahkan proses verifikasi dan penarikan dana nantinya.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Item 2 --}}
                            <div class="flex items-start gap-2.5">
                                <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-gray-900 mb-0.5">{{ __('Keamanan Data') }}</p>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        {{ __('Data Anda dienkripsi dan disimpan dengan aman. Kami tidak akan membagikan informasi pribadi Anda tanpa izin.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Item 3 --}}
                            <div class="flex items-start gap-2.5">
                                <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-bold text-xs text-gray-900 mb-0.5">{{ __('Email Aktif') }}</p>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        {{ __('Pastikan email yang didaftarkan aktif karena semua informasi terkait kampanye akan dikirimkan melalui email.') }}
                                    </p>
                                </div>
                            </div>

                        </div>

                        <div class="border-t border-gray-100 mt-6 pt-4 text-center">
                            <p class="text-[11px] text-gray-500">
                                {{ __('Butuh bantuan?') }} <a href="#" class="font-bold text-[#134F4F] hover:underline">{{ __('Hubungi Support') }}</a>
                            </p>
                        </div>

                    </div>

                </div>

                {{-- ================================================================ --}}
                {{-- TAHAP 2: VERIFIKASI IDENTITAS & DOKUMEN                         --}}
                {{-- ================================================================ --}}
                <div id="tahap-2" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {{-- KIRI: INPUT NO HP, NIK & UPLOAD DOKUMEN --}}
                    <div class="lg:col-span-8 bg-white rounded-2xl p-5 sm:p-6 shadow-xs border border-gray-100">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                            
                            {{-- NO HP --}}
                            <div>
                                <label for="input_no_hp" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Nomor HP Aktif') }}
                                </label>
                                <input type="tel" id="input_no_hp" name="no_hp"
                                       value="{{ old('no_hp') }}"
                                       placeholder="{{ __('Contoh: 081234567890') }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                            </div>

                            {{-- NIK --}}
                            <div>
                                <label for="input_nik" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Nomor KTP (NIK)') }}
                                </label>
                                <input type="text" id="input_nik" name="nik" maxlength="16"
                                       value="{{ old('nik') }}"
                                       placeholder="{{ __('16 Digit Nomor Induk Kependudukan') }}"
                                       class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                            </div>

                        </div>

                        {{-- UNGGAH DOKUMEN PENDUKUNG --}}
                        <div class="mb-6">
                            <h4 class="text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-3">
                                {{ __('UNGGAH DOKUMEN PENDUKUNG') }}
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                
                                {{-- FOTO KTP --}}
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1.5">{{ __('Foto KTP') }}</p>
                                    <div onclick="document.getElementById('file_foto_ktp').click()"
                                         id="box_foto_ktp"
                                         class="border-2 border-dashed border-gray-200 hover:border-[#134F4F] rounded-xl p-3 text-center cursor-pointer transition-all flex flex-col items-center justify-center min-h-[120px] bg-gray-50/50">
                                        
                                        <div id="preview_wrap_foto_ktp" class="hidden mb-1.5">
                                            <img id="preview_foto_ktp" class="w-14 h-10 object-cover rounded-lg mx-auto shadow-sm">
                                        </div>

                                        <svg id="icon_foto_ktp" class="w-6 h-6 text-gray-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                        <p id="label_foto_ktp" class="text-[11px] text-gray-500 font-medium leading-relaxed">
                                            {{ __('Klik atau geser file Foto KTP') }}
                                        </p>
                                    </div>
                                    <input type="file" id="file_foto_ktp" name="foto_ktp" accept="image/*" class="hidden"
                                           onchange="handlePreview(this, 'preview_foto_ktp', 'preview_wrap_foto_ktp', 'icon_foto_ktp', 'label_foto_ktp')">
                                </div>

                                {{-- FOTO MEMEGANG KTP --}}
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1.5">{{ __('Foto Memegang KTP') }}</p>
                                    <div onclick="document.getElementById('file_foto_memegang_ktp').click()"
                                         id="box_foto_memegang_ktp"
                                         class="border-2 border-dashed border-gray-200 hover:border-[#134F4F] rounded-xl p-3 text-center cursor-pointer transition-all flex flex-col items-center justify-center min-h-[120px] bg-gray-50/50">
                                        
                                        <div id="preview_wrap_foto_memegang_ktp" class="hidden mb-1.5">
                                            <img id="preview_foto_memegang_ktp" class="w-14 h-10 object-cover rounded-lg mx-auto shadow-sm">
                                        </div>

                                        <svg id="icon_foto_memegang_ktp" class="w-6 h-6 text-gray-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                        <p id="label_foto_memegang_ktp" class="text-[11px] text-gray-500 font-medium leading-relaxed">
                                            {{ __('Wajah & KTP terlihat jelas') }}
                                        </p>
                                    </div>
                                    <input type="file" id="file_foto_memegang_ktp" name="foto_memegang_ktp" accept="image/*" class="hidden"
                                           onchange="handlePreview(this, 'preview_foto_memegang_ktp', 'preview_wrap_foto_memegang_ktp', 'icon_foto_memegang_ktp', 'label_foto_memegang_ktp')">
                                </div>

                                {{-- FOTO DIRI (PROFIL) --}}
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1.5">{{ __('Foto Diri (Profil)') }}</p>
                                    <div onclick="document.getElementById('file_foto_diri').click()"
                                         id="box_foto_diri"
                                         class="border-2 border-dashed border-gray-200 hover:border-[#134F4F] rounded-xl p-3 text-center cursor-pointer transition-all flex flex-col items-center justify-center min-h-[120px] bg-gray-50/50">
                                        
                                        <div id="preview_wrap_foto_diri" class="hidden mb-1.5">
                                            <img id="preview_foto_diri" class="w-14 h-10 object-cover rounded-lg mx-auto shadow-sm">
                                        </div>

                                        <svg id="icon_foto_diri" class="w-6 h-6 text-gray-400 mb-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        <p id="label_foto_diri" class="text-[11px] text-gray-500 font-medium leading-relaxed">
                                            {{ __('Foto terbaru tanpa kacamata') }}
                                        </p>
                                    </div>
                                    <input type="file" id="file_foto_diri" name="foto_diri" accept="image/*" class="hidden"
                                           onchange="handlePreview(this, 'preview_foto_diri', 'preview_wrap_foto_diri', 'icon_foto_diri', 'label_foto_diri')">
                                </div>

                            </div>
                        </div>

                        {{-- TOMBOL KEMBALI & LANJUT KE TAHAP 3 --}}
                        <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                            <button type="button" onclick="keTahap(1)"
                                    class="px-5 py-2.5 rounded-xl border border-gray-300 font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-xs sm:text-sm">
                                {{ __('Kembali') }}
                            </button>

                            <button type="button" onclick="keTahap(3)"
                                    class="px-6 py-2.5 rounded-xl bg-[#134F4F] text-white font-semibold hover:bg-[#0c4a3d] transition-colors shadow-xs text-xs sm:text-sm">
                                {{ __('Lanjut ke Tahap 3') }}
                            </button>
                        </div>

                    </div>

                    {{-- KANAN: PRIVASI & PANDUAN FOTO --}}
                    <div class="lg:col-span-4 space-y-4">
                        
                        {{-- CARD 1: PRIVASI & KEAMANAN DATA (Warm Beige Box) --}}
                        <div class="bg-[#FDF8F0] border border-[#F6E7D2] rounded-2xl p-4 sm:p-5 shadow-xs">
                            <div class="flex items-start gap-3">
                                <div class="w-7 h-7 rounded-full bg-[#FAECD5] flex items-center justify-center shrink-0 mt-0.5 text-[#B47818]">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs text-[#784E0B] mb-1">
                                        {{ __('Privasi & Keamanan Data') }}
                                    </h4>
                                    <p class="text-[11px] text-[#996515] leading-relaxed">
                                        {{ __('Kami menggunakan enkripsi standar industri untuk melindungi dokumen Anda. Data hanya digunakan untuk proses verifikasi identitas dan tidak akan disebarluaskan.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- CARD 2: PANDUAN FOTO --}}
                        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-xs border border-gray-100">
                            <div class="flex items-center gap-2 mb-3.5">
                                <svg class="w-4 h-4 text-[#134F4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <h4 class="font-bold text-xs text-gray-900">{{ __('Panduan Foto') }}</h4>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        {{ __('Pastikan foto diambil di tempat yang terang agar teks pada KTP terbaca jelas.') }}
                                    </p>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        {{ __('KTP harus asli, bukan fotokopi atau hasil scan yang dicetak ulang.') }}
                                    </p>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <p class="text-[11px] text-gray-500 leading-relaxed">
                                        {{ __('Untuk foto memegang KTP, pastikan wajah Anda dan KTP berada dalam satu bingkai dan tidak tertutup jari.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                {{-- ================================================================ --}}
                {{-- TAHAP 3: DETAIL KAMPANYE & TARGET DANA                           --}}
                {{-- ================================================================ --}}
                <div id="tahap-3" class="hidden grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                    
                    {{-- KIRI: INFORMASI CAMPAIGN & BUKTI --}}
                    <div class="lg:col-span-7 bg-white rounded-2xl p-5 sm:p-6 shadow-xs border border-gray-100">
                        
                        <div class="pb-2.5 border-b border-gray-100 mb-5">
                            <h4 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider">
                                {{ __('INFORMASI CAMPAIGN') }}
                            </h4>
                        </div>

                        {{-- JUDUL CAMPAIGN --}}
                        <div class="mb-4">
                            <label for="input_judul" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Judul Campaign') }}
                            </label>
                            <input type="text" id="input_judul" name="judul"
                                   value="{{ old('judul') }}"
                                   placeholder="{{ __('Contoh: Bantuan Logistik Gempa Bumi Cianjur') }}"
                                   class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                        </div>

                        {{-- KATEGORI & LOKASI --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 mb-4">
                            
                            {{-- Kategori --}}
                            <div>
                                <label for="select_kategori" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Kategori') }}
                                </label>
                                <div class="relative">
                                    <select id="select_kategori" name="kategori"
                                            class="w-full appearance-none px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm bg-white cursor-pointer pr-9">
                                        <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>{{ __('Pilih kategori...') }}</option>
                                        <option value="Bencana Alam" {{ old('kategori') == 'Bencana Alam' ? 'selected' : '' }}>Bencana Alam</option>
                                        <option value="Pendidikan" {{ old('kategori') == 'Pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                        <option value="Kesehatan" {{ old('kategori') == 'Kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                        <option value="Lingkungan" {{ old('kategori') == 'Lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                                        <option value="Sosial" {{ old('kategori') == 'Sosial' ? 'selected' : '' }}>Sosial</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Lokasi --}}
                            <div>
                                <label for="input_lokasi" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                    {{ __('Lokasi Kejadian') }}
                                </label>
                                <div class="relative">
                                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <input type="text" id="input_lokasi" name="lokasi"
                                           value="{{ old('lokasi') }}"
                                           placeholder="{{ __('Kota/Kabupaten') }}"
                                           class="w-full pl-9 pr-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                                </div>
                            </div>

                        </div>

                        {{-- DESKRIPSI LENGKAP --}}
                        <div class="mb-6">
                            <label for="input_deskripsi" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                {{ __('Deskripsi Lengkap') }}
                            </label>
                            <textarea id="input_deskripsi" name="deskripsi" rows="4"
                                      placeholder="{{ __('Ceritakan kondisi bencana saat ini, siapa saja yang terdampak, dan untuk apa dana tersebut akan digunakan...') }}"
                                      class="w-full px-3.5 py-2.5 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400 resize-none">{{ old('deskripsi') }}</textarea>
                        </div>

                        {{-- BUKTI KONDISI BENCANA --}}
                        <div class="mb-6">
                            <div class="pb-2.5 border-b border-gray-100 mb-3.5">
                                <h4 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider">
                                    {{ __('BUKTI KONDISI BENCANA') }}
                                </h4>
                            </div>

                            <div onclick="document.getElementById('file_gambar').click()"
                                 id="box_gambar"
                                 class="border-2 border-dashed border-gray-200 hover:border-[#134F4F] rounded-2xl p-5 text-center cursor-pointer transition-all flex flex-col items-center justify-center min-h-[140px] bg-gray-50/50">
                                
                                <div id="preview_wrap_gambar" class="hidden mb-2">
                                    <img id="preview_gambar" class="max-h-32 object-cover rounded-lg mx-auto shadow-sm">
                                </div>

                                <svg id="icon_gambar" class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                
                                <p id="label_gambar_title" class="font-bold text-gray-800 text-xs mb-0.5">
                                    {{ __('Unggah Foto atau Video') }}
                                </p>
                                <p id="label_gambar_sub" class="text-[11px] text-gray-400">
                                    {{ __('Format JPG, PNG, atau MP4 (Maks. 10MB)') }}
                                </p>
                            </div>
                            <input type="file" id="file_gambar" name="gambar" accept="image/*,video/mp4" class="hidden"
                                   onchange="handlePreview(this, 'preview_gambar', 'preview_wrap_gambar', 'icon_gambar', 'label_gambar_title')">
                        </div>

                        {{-- TOMBOL KEMBALI & AJUKAN GALANG DANA --}}
                        <div class="flex items-center justify-between pt-5 border-t border-gray-100">
                            <button type="button" onclick="keTahap(2)"
                                    class="px-5 py-2.5 rounded-xl border border-gray-300 font-semibold text-gray-700 hover:bg-gray-50 transition-colors text-xs sm:text-sm">
                                {{ __('Kembali') }}
                            </button>

                            <button type="submit"
                                    class="px-6 py-2.5 rounded-xl bg-[#134F4F] text-white font-semibold hover:bg-[#0c4a3d] transition-colors shadow-xs text-xs sm:text-sm flex items-center gap-2">
                                <span>{{ __('Ajukan Galang Dana') }}</span>
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                    <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                                </svg>
                            </button>
                        </div>

                    </div>

                    {{-- KANAN: LANGKAH TERAKHIR, TARGET DANA & PENYALURAN --}}
                    <div class="lg:col-span-5 space-y-4">
                        
                        {{-- CARD 1: LANGKAH TERAKHIR --}}
                        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-xs border border-gray-100">
                            <div class="flex items-center gap-2 mb-3.5">
                                <svg class="w-4 h-4 text-[#134F4F]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                </svg>
                                <h4 class="font-bold text-xs text-gray-900">{{ __('Langkah Terakhir') }}</h4>
                            </div>

                            <div class="space-y-3">
                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs text-gray-900 mb-0.5">{{ __('Cek Ulang Detail') }}</p>
                                        <p class="text-[11px] text-gray-500 leading-relaxed">
                                            {{ __('Pastikan informasi yang diberikan akurat dan mudah dipahami.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs text-gray-900 mb-0.5">{{ __('Kualitas Foto') }}</p>
                                        <p class="text-[11px] text-gray-500 leading-relaxed">
                                            {{ __('Foto yang jelas akan meningkatkan kepercayaan donatur.') }}
                                        </p>
                                    </div>
                                </div>

                                <div class="flex items-start gap-2.5">
                                    <div class="w-4 h-4 rounded-full bg-[#D8F0EC] text-[#134F4F] flex items-center justify-center shrink-0 mt-0.5">
                                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-bold text-xs text-gray-900 mb-0.5">{{ __('Siap Disubmit') }}</p>
                                        <p class="text-[11px] text-gray-500 leading-relaxed">
                                            {{ __('Tim kami akan memverifikasi kampanye Anda dalam 1x24 jam.') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- CARD 2: TARGET DANA & WAKTU --}}
                        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-xs border border-gray-100">
                            <h4 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-3">
                                {{ __('TARGET DANA & WAKTU') }}
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                
                                {{-- Target Dana --}}
                                <div>
                                    <label for="input_target_dana" class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Target Dana (Rp)') }}
                                    </label>
                                    <div class="relative">
                                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 text-xs font-bold">
                                            Rp
                                        </span>
                                        <input type="number" id="input_target_dana" name="target_dana"
                                               value="{{ old('target_dana') }}"
                                               placeholder="0" min="1000"
                                               class="w-full pl-9 pr-3 py-2 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm">
                                    </div>
                                </div>

                                {{-- Jangka Waktu --}}
                                <div>
                                    <label for="input_jangka_waktu" class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Jangka Waktu (Hari)') }}
                                    </label>
                                    <input type="number" id="input_jangka_waktu" name="jangka_waktu"
                                           value="{{ old('jangka_waktu', 30) }}"
                                           placeholder="{{ __('Contoh: 30') }}" min="1" max="365"
                                           class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm">
                                </div>

                            </div>
                        </div>

                        {{-- CARD 3: PENYALURAN DANA --}}
                        <div class="bg-white rounded-2xl p-4 sm:p-5 shadow-xs border border-gray-100">
                            <h4 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-3">
                                {{ __('PENYALURAN DANA') }}
                            </h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-3">
                                
                                {{-- Bank / E-Wallet --}}
                                <div>
                                    <label for="select_bank" class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Pilih Bank / E-Wallet') }}
                                    </label>
                                    <div class="relative">
                                        <select id="select_bank" name="bank_penyaluran"
                                                class="w-full appearance-none px-3 py-2 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm bg-white cursor-pointer pr-7">
                                            <option value="Bank Mandiri" {{ old('bank_penyaluran') == 'Bank Mandiri' ? 'selected' : '' }}>Bank Mandiri</option>
                                            <option value="Bank BCA" {{ old('bank_penyaluran') == 'Bank BCA' ? 'selected' : '' }}>Bank BCA</option>
                                            <option value="Bank BRI" {{ old('bank_penyaluran') == 'Bank BRI' ? 'selected' : '' }}>Bank BRI</option>
                                            <option value="Bank BNI" {{ old('bank_penyaluran') == 'Bank BNI' ? 'selected' : '' }}>Bank BNI</option>
                                            <option value="Bank BSI" {{ old('bank_penyaluran') == 'Bank BSI' ? 'selected' : '' }}>Bank BSI</option>
                                            <option value="GoPay" {{ old('bank_penyaluran') == 'GoPay' ? 'selected' : '' }}>GoPay</option>
                                            <option value="OVO" {{ old('bank_penyaluran') == 'OVO' ? 'selected' : '' }}>OVO</option>
                                            <option value="DANA" {{ old('bank_penyaluran') == 'DANA' ? 'selected' : '' }}>DANA</option>
                                        </select>
                                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                                {{-- Nomor Rekening --}}
                                <div>
                                    <label for="input_nomor_rekening" class="block text-xs font-semibold text-gray-700 mb-1">
                                        {{ __('Nomor Rekening / HP') }}
                                    </label>
                                    <input type="text" id="input_nomor_rekening" name="nomor_rekening"
                                           value="{{ old('nomor_rekening') }}"
                                           placeholder="{{ __('Masukkan nomor') }}"
                                           class="w-full px-3 py-2 rounded-xl border border-gray-200 focus:border-[#134F4F] focus:ring-1 focus:ring-[#134F4F] outline-none text-gray-900 text-xs sm:text-sm placeholder:text-gray-400">
                                </div>

                            </div>

                            {{-- Notice box --}}
                            <div class="bg-[#FDF8F0] border border-[#F6E7D2] rounded-xl p-3 flex items-start gap-2">
                                <svg class="w-3.5 h-3.5 text-[#C28E10] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <p class="text-[11px] text-[#8A6308] leading-relaxed">
                                    {{ __('Pastikan nomor rekening sesuai dengan identitas penanggung jawab kampanye.') }}
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </main>

    {{-- SCRIPT KONTROL STEPPER & PREVIEW --}}
    <script>
        let tahapAktif = 1;

        const infoTahap = {
            1: {
                judul: @js(__('Mulai Galang Dana')),
                deskripsi: @js(__('Lengkapi identitas Anda untuk membangun kepercayaan bagi para calon donatur.'))
            },
            2: {
                judul: @js(__('Verifikasi Identitas')),
                deskripsi: @js(__('Kami memerlukan data ini untuk memastikan transparansi dan keamanan penggalangan dana Anda.'))
            },
            3: {
                judul: @js(__('Buat Galang Dana Baru')),
                deskripsi: @js(__('Lengkapi detail kampanye Anda untuk mulai mengumpulkan dukungan.'))
            }
        };

        function pilihJenisAkun(jenis) {
            document.getElementById('input_jenis_akun').value = jenis;

            const buttons = {
                'perorangan': document.getElementById('btn-jenis-perorangan'),
                'komunitas': document.getElementById('btn-jenis-komunitas'),
                'lembaga': document.getElementById('btn-jenis-lembaga')
            };

            for (const [key, btn] of Object.entries(buttons)) {
                if (key === jenis) {
                    btn.className = 'jenis-akun-btn border-2 rounded-2xl p-4 flex flex-col items-center justify-center gap-2.5 transition-all text-center border-[#134F4F] bg-[#F2FAF8] text-[#134F4F]';
                } else {
                    btn.className = 'jenis-akun-btn border-2 border-gray-200 rounded-2xl p-4 flex flex-col items-center justify-center gap-2.5 transition-all text-center bg-white text-gray-700 hover:border-gray-300';
                }
            }
        }

        function keTahap(nomor) {
            // Validasi sederhana sebelum maju
            if (nomor > tahapAktif) {
                if (tahapAktif === 1) {
                    const nama = document.getElementById('input_nama_lengkap').value.trim();
                    const email = document.getElementById('input_email').value.trim();
                    if (!nama) {
                        alert(@js(__('Silakan masukkan Nama Lengkap Anda.')));
                        document.getElementById('input_nama_lengkap').focus();
                        return;
                    }
                    if (!email) {
                        alert(@js(__('Silakan masukkan Email aktif Anda.')));
                        document.getElementById('input_email').focus();
                        return;
                    }
                } else if (tahapAktif === 2 && nomor === 3) {
                    const nik = document.getElementById('input_nik').value.trim();
                    const ktpFile = document.getElementById('file_foto_ktp').files.length;
                    const diriFile = document.getElementById('file_foto_diri').files.length;

                    if (!nik || nik.length !== 16) {
                        alert(@js(__('Silakan masukkan 16 digit NIK yang valid.')));
                        document.getElementById('input_nik').focus();
                        return;
                    }
                    if (!ktpFile) {
                        alert(@js(__('Silakan unggah Foto KTP Anda.')));
                        return;
                    }
                    if (!diriFile) {
                        alert(@js(__('Silakan unggah Foto Diri (Profil) Anda.')));
                        return;
                    }
                }
            }

            tahapAktif = nomor;

            // Update Header
            document.getElementById('header-judul').textContent = infoTahap[nomor].judul;
            document.getElementById('header-deskripsi').textContent = infoTahap[nomor].deskripsi;

            // Sembunyikan semua tahap dan tampilkan yang dituju
            document.getElementById('tahap-1').classList.toggle('hidden', nomor !== 1);
            document.getElementById('tahap-2').classList.toggle('hidden', nomor !== 2);
            document.getElementById('tahap-3').classList.toggle('hidden', nomor !== 3);

            // Update Tampilan Stepper
            updateStepperUI(nomor);

            // Scroll ke atas halaman dengan halus
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function cobaKeTahap(target) {
            if (target < tahapAktif) {
                keTahap(target);
            } else if (target === tahapAktif + 1) {
                keTahap(target);
            }
        }

        function updateStepperUI(nomor) {
            // Lines
            document.getElementById('line-1-2').style.width = nomor >= 2 ? '100%' : '0%';
            document.getElementById('line-2-3').style.width = nomor >= 3 ? '100%' : '0%';

            // Step 1
            const circle1 = document.getElementById('step-circle-1');
            const num1 = document.getElementById('step-num-1');
            const check1 = document.getElementById('step-check-1');
            const label1 = document.getElementById('step-label-1');

            if (nomor > 1) {
                circle1.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-[#134F4F] text-white shadow-sm transition-all duration-300';
                num1.classList.add('hidden');
                check1.classList.remove('hidden');
                label1.className = 'text-xs md:text-sm font-bold text-[#134F4F] mt-2';
            } else {
                circle1.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-[#134F4F] text-white shadow-sm transition-all duration-300';
                num1.classList.remove('hidden');
                check1.classList.add('hidden');
                label1.className = 'text-xs md:text-sm font-bold text-[#134F4F] mt-2';
            }

            // Step 2
            const circle2 = document.getElementById('step-circle-2');
            const num2 = document.getElementById('step-num-2');
            const check2 = document.getElementById('step-check-2');
            const label2 = document.getElementById('step-label-2');

            if (nomor > 2) {
                circle2.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-[#134F4F] text-white shadow-sm transition-all duration-300';
                num2.classList.add('hidden');
                check2.classList.remove('hidden');
                label2.className = 'text-xs md:text-sm font-bold text-[#134F4F] mt-2';
            } else if (nomor === 2) {
                circle2.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-[#134F4F] text-white shadow-sm transition-all duration-300';
                num2.classList.remove('hidden');
                check2.classList.add('hidden');
                label2.className = 'text-xs md:text-sm font-bold text-[#134F4F] mt-2';
            } else {
                circle2.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-gray-200 text-gray-500 transition-all duration-300';
                num2.classList.remove('hidden');
                check2.classList.add('hidden');
                label2.className = 'text-xs md:text-sm font-medium text-gray-400 mt-2';
            }

            // Step 3
            const circle3 = document.getElementById('step-circle-3');
            const num3 = document.getElementById('step-num-3');
            const check3 = document.getElementById('step-check-3');
            const label3 = document.getElementById('step-label-3');

            if (nomor === 3) {
                circle3.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-[#134F4F] text-white shadow-sm transition-all duration-300';
                num3.classList.remove('hidden');
                check3.classList.add('hidden');
                label3.className = 'text-xs md:text-sm font-bold text-[#134F4F] mt-2';
            } else {
                circle3.className = 'w-11 h-11 rounded-full flex items-center justify-center font-bold text-sm bg-gray-200 text-gray-500 transition-all duration-300';
                num3.classList.remove('hidden');
                check3.classList.add('hidden');
                label3.className = 'text-xs md:text-sm font-medium text-gray-400 mt-2';
            }
        }

        function handlePreview(input, imgId, wrapId, iconId, labelId) {
            const file = input.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.getElementById(imgId);
                    if (img) {
                        img.src = e.target.result;
                        document.getElementById(wrapId).classList.remove('hidden');
                    }
                    if (iconId && document.getElementById(iconId)) {
                        document.getElementById(iconId).classList.add('hidden');
                    }
                    if (labelId && document.getElementById(labelId)) {
                        document.getElementById(labelId).textContent = file.name;
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Inisialisasi jika ada error validation dari backend (misal error di field tahap 2 / 3)
        @if ($errors->has('nik') || $errors->has('foto_ktp') || $errors->has('foto_diri') || $errors->has('no_hp'))
            keTahap(2);
        @elseif ($errors->has('judul') || $errors->has('deskripsi') || $errors->has('kategori') || $errors->has('target_dana') || $errors->has('gambar'))
            keTahap(3);
        @endif
    </script>

@endsection