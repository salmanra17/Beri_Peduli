@extends('layouts.app')

@section('content')

    <main class="bg-[#f1f1f1] min-h-screen text-gray-900">

        <div class="max-w-[1320px] mx-auto px-4 lg:px-6 py-10">

            <form action="{{ route('donasi.store') }}" method="POST">

                @csrf


                <input type="hidden" name="kampanye_id" value="{{ $kampanye->id }}">



                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">



                    {{-- LEFT --}}
                    <div class="lg:col-span-2 space-y-8">



                        {{-- NOMINAL --}}

                        <section class="bg-white rounded-2xl shadow-sm p-8">


                            <div class="flex items-center gap-4 mb-6">

                                <span
                                    class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600">
                                    1
                                </span>


                                <h2 class="text-xl font-bold">
                                    {{ __('Pilih Nominal Donasi') }}
                                </h2>


                            </div>



                            <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">


                                @foreach([50000, 100000, 250000, 500000, 1000000] as $nominal)

                                    <button type="button" onclick="setNominal({{ $nominal }})"
                                        class="py-4 rounded-xl border border-gray-200 font-bold hover:border-[#134F4F]">

                                        Rp{{ number_format($nominal, 0, ',', '.') }}

                                    </button>

                                @endforeach


                            </div>




                            <label class="block text-sm font-bold mb-2">

                                {{ __('Atau masukkan nominal khusus') }}

                            </label>



                            <div class="relative">

                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">
                                    Rp
                                </span>


                                <input id="nominal" type="number" name="jumlah_donasi" min="10000" required
                                    class="w-full pl-12 px-4 py-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-[#134F4F]"
                                    placeholder="100000">


                            </div>


                            <p class="text-sm text-gray-400 mt-2">
                                {{ __('Minimum donasi Rp10.000') }}
                            </p>


                        </section>





                        {{-- PEMBAYARAN --}}

                        <section class="bg-white rounded-2xl shadow-sm p-8">

                            <div class="flex items-center justify-between mb-6">

                                <div class="flex items-center gap-4">

                                    <span
                                        class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600">
                                        2
                                    </span>

                                    <h2 class="text-xl font-bold">
                                        {{ __('Metode Pembayaran') }}
                                    </h2>

                                </div>


                                <button type="button" onclick="bukaModalMetode()"
                                        class="text-sm font-semibold text-[#134F4F] hover:underline">
                                    {{ __('Pilih Metode Lainnya') }} →
                                </button>


                            </div>




                            <div class="grid grid-cols-2 gap-4">



                                <label class="cursor-pointer">

                                    <input type="radio" name="metode_pembayaran" value="QRIS" class="hidden peer" onchange="hapusPilihanModal()" checked>


                                    <div class="relative border rounded-xl p-4 
                peer-checked:border-[#134F4F]
                peer-checked:bg-[#F2FAF8]">


                                        <div class="flex justify-between">


                                            <div>

                                                <p class="font-bold">
                                                    QRIS
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    Gopay, OVO, Dana, LinkAja
                                                </p>

                                            </div>



                                            <span class="hidden peer-checked:block text-[#134F4F] font-bold">
                                                ✓
                                            </span>


                                        </div>


                                    </div>

                                </label>






                                <label class="cursor-pointer">

                                    <input type="radio" name="metode_pembayaran" value="BCA Virtual Account"
                                        class="hidden peer" onchange="hapusPilihanModal()">


                                    <div class="relative border rounded-xl p-4 
                peer-checked:border-[#134F4F]
                peer-checked:bg-[#F2FAF8]">


                                        <div class="flex justify-between">


                                            <div>

                                                <p class="font-bold">
                                                    BCA Virtual Account
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    {{ __('Cek otomatis') }}
                                                </p>


                                            </div>


                                            <span class="hidden peer-checked:block text-[#134F4F] font-bold">
                                                ✓
                                            </span>


                                        </div>


                                    </div>


                                </label>






                                <label class="cursor-pointer">

                                    <input type="radio" name="metode_pembayaran" value="Mandiri Virtual Account"
                                        class="hidden peer" onchange="hapusPilihanModal()">


                                    <div class="relative border rounded-xl p-4 
                peer-checked:border-[#134F4F]
                peer-checked:bg-[#F2FAF8]">


                                        <div class="flex justify-between">


                                            <div>

                                                <p class="font-bold">
                                                    Mandiri Virtual Account
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    {{ __('Cek otomatis') }}
                                                </p>


                                            </div>


                                            <span class="hidden peer-checked:block text-[#134F4F] font-bold">
                                                ✓
                                            </span>


                                        </div>


                                    </div>


                                </label>






                                <label class="cursor-pointer">

                                    <input type="radio" name="metode_pembayaran" value="ShopeePay" class="hidden peer" onchange="hapusPilihanModal()">


                                    <div class="relative border rounded-xl p-4 
                peer-checked:border-[#134F4F]
                peer-checked:bg-[#F2FAF8]">


                                        <div class="flex justify-between">


                                            <div>

                                                <p class="font-bold">
                                                    ShopeePay
                                                </p>

                                                <p class="text-sm text-gray-500">
                                                    {{ __('Otomatis dialihkan') }}
                                                </p>


                                            </div>


                                            <span class="hidden peer-checked:block text-[#134F4F] font-bold">
                                                ✓
                                            </span>


                                        </div>


                                    </div>


                                </label>




                            </div>


                            {{-- Hidden override: diisi JS saat user pilih dari modal --}}
                            <input type="hidden" name="metode_pembayaran" id="metode-override" value="" disabled>

                            {{-- Banner metode dari modal (tersembunyi default) --}}
                            <div id="metode-modal-banner"
                                 class="hidden mt-4 flex items-center justify-between px-4 py-3 rounded-xl bg-[#F2FAF8] border border-[#134F4F]">
                                <div>
                                    <p class="text-xs text-gray-500 mb-0.5">{{ __('Metode dipilih') }}</p>
                                    <p id="metode-modal-nama" class="font-bold text-gray-900"></p>
                                </div>
                                <button type="button" onclick="hapusPilihanModal()"
                                        class="text-xs text-gray-400 hover:text-red-500 transition-colors">
                                    {{ __('Ubah') }}
                                </button>
                            </div>


                        </section>



                        {{-- PESAN & DUKUNGAN --}}

                        <section class="bg-white rounded-2xl shadow-sm p-8">


                            <div class="flex items-center gap-4 mb-6">


                                <span
                                    class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600">
                                    3
                                </span>


                                <h2 class="text-xl font-bold">
                                    {{ __('Pesan & Dukungan') }}
                                </h2>


                            </div>





                            <div class="flex items-center justify-between mb-6">


                                <p class="font-semibold">
                                    {{ __('Sembunyikan nama saya (Anonim)') }}
                                </p>



                                <label class="relative inline-flex cursor-pointer">


                                    <input type="checkbox" name="anonim" value="1" class="sr-only peer">



                                    <div
                                        class="w-12 h-6 bg-gray-200 rounded-full peer-checked:bg-[#134F4F] after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:after:translate-x-6">
                                    </div>



                                </label>


                            </div>





                            <label class="font-semibold block mb-3">

                                {{ __('Beri Pesan atau Komentar') }}

                            </label>



                            <textarea name="pesan" rows="4" class="w-full px-4 py-4 rounded-xl border border-gray-200"
                                placeholder="{{ __('Tuliskan doa atau pesan penyemangat...') }}"></textarea>



                        </section>





                        <button type="submit"
                            class="w-full bg-[#134F4F] text-white font-bold text-base py-3.5 rounded-xl hover:bg-[#0c4a3d]">

                            {{ __('Donasi Sekarang') }}

                        </button>



                    </div>







                    {{-- RIGHT --}}

                    <aside>


                        <div class="bg-white rounded-2xl shadow-sm overflow-hidden sticky top-24">


                            <img src="{{ asset('storage/' . $kampanye->gambar) }}" class="w-full h-56 object-cover">



                            <div class="p-6">


                                <h3 class="font-bold text-base mb-5">

                                    {{ $kampanye->judul }}

                                </h3>




                                <div class="flex justify-between mb-2">

                                    <span>
                                        {{ __('Terkumpul') }}
                                    </span>


                                    <span class="font-bold text-[#134F4F]">

                                        Rp {{ number_format($kampanye->dana_terkumpul, 0, ',', '.') }}

                                    </span>


                                </div>




                                <div class="flex items-center gap-3">


                                    <div class="flex-1 w-full h-2 bg-gray-200 rounded-full">


                                        @php

                                            $progress = $kampanye->target_dana > 0
                                                ? ($kampanye->dana_terkumpul / $kampanye->target_dana) * 100
                                                : 0;

                                        @endphp


                                        <div class="h-2 bg-[#134F4F] rounded-full" style="width: {{ min($progress, 100) }}%">
                                        </div>


                                    </div>


                                    <span class="text-sm font-bold text-[#134F4F]">
                                        {{ number_format(min($progress, 100), 0) }}%
                                    </span>


                                </div>



                                <p class="text-sm text-gray-500 mt-3">

                                    {{ __('Target:') }}
                                    Rp {{ number_format($kampanye->target_dana, 0, ',', '.') }}

                                </p>



                            </div>


                        </div>


                    </aside>



                </div>


            </form>


        </div>

    </main>


    {{-- ================================================================ --}}
    {{-- MODAL PILIH METODE PEMBAYARAN LAINNYA                            --}}
    {{-- ================================================================ --}}

    <div id="modal-metode"
         class="fixed inset-0 z-[200] hidden items-end justify-center sm:items-center"
         onclick="tutupModalJikaLuar(event)">

        <div class="absolute inset-0" style="background:rgba(0,0,0,0.5);backdrop-filter:blur(3px);"></div>

        <div id="modal-metode-card"
             class="relative bg-white w-full max-w-lg rounded-t-3xl sm:rounded-3xl shadow-2xl"
             style="max-height:90vh;overflow-y:auto;transform:translateY(100%);transition:transform 0.35s cubic-bezier(0.32,0.72,0,1);">

            {{-- Handle bar (mobile) --}}
            <div class="flex justify-center pt-3 pb-1 sm:hidden">
                <div class="w-10 h-1 bg-gray-300 rounded-full"></div>
            </div>

            {{-- Header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b">
                <h3 class="text-xl font-bold">{{ __('Pilih Metode Pembayaran') }}</h3>
                <button type="button" onclick="tutupModalMetode()"
                        class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Daftar metode --}}
            <div class="p-6 space-y-6">

                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ __('Dompet Digital & QRIS') }}</p>
                    <div class="space-y-2">
                        <button type="button" onclick="pilihDariModal('QRIS', 'Gopay, OVO, Dana, LinkAja')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">QRIS</p><p class="text-sm text-gray-500">Gopay, OVO, Dana, LinkAja</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('GoPay', @js(__('Bayar via aplikasi Gojek')))" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">GoPay</p><p class="text-sm text-gray-500">{{ __('Bayar via aplikasi Gojek') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('OVO', @js(__('Bayar via aplikasi OVO')))" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">OVO</p><p class="text-sm text-gray-500">{{ __('Bayar via aplikasi OVO') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('DANA', @js(__('Bayar via aplikasi DANA')))" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">DANA</p><p class="text-sm text-gray-500">{{ __('Bayar via aplikasi DANA') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('ShopeePay', @js(__('Otomatis dialihkan ke ShopeePay')))" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">ShopeePay</p><p class="text-sm text-gray-500">{{ __('Otomatis dialihkan ke ShopeePay') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('LinkAja', @js(__('Bayar via aplikasi LinkAja')))" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">LinkAja</p><p class="text-sm text-gray-500">{{ __('Bayar via aplikasi LinkAja') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ __('Transfer Bank') }}</p>
                    <div class="space-y-2">
                        <button type="button" onclick="pilihDariModal('BCA Virtual Account', '{{ __('Cek otomatis dalam 5 menit') }}')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">BCA Virtual Account</p><p class="text-sm text-gray-500">{{ __('Cek otomatis dalam 5 menit') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('Mandiri Virtual Account', '{{ __('Cek otomatis dalam 5 menit') }}')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">Mandiri Virtual Account</p><p class="text-sm text-gray-500">{{ __('Cek otomatis dalam 5 menit') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('BNI Virtual Account', '{{ __('Cek otomatis dalam 5 menit') }}')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">BNI Virtual Account</p><p class="text-sm text-gray-500">{{ __('Cek otomatis dalam 5 menit') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('BRI Virtual Account', '{{ __('Cek otomatis dalam 5 menit') }}')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">BRI Virtual Account</p><p class="text-sm text-gray-500">{{ __('Cek otomatis dalam 5 menit') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                        <button type="button" onclick="pilihDariModal('CIMB Virtual Account', '{{ __('Cek otomatis dalam 5 menit') }}')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">CIMB Virtual Account</p><p class="text-sm text-gray-500">{{ __('Cek otomatis dalam 5 menit') }}</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">{{ __('Kartu Kredit / Debit') }}</p>
                    <div class="space-y-2">
                        <button type="button" onclick="pilihDariModal('Kartu Kredit/Debit', 'Visa, Mastercard, JCB')" class="metode-opt w-full flex items-center justify-between px-4 py-3.5 rounded-xl border border-gray-200 hover:border-[#134F4F] hover:bg-[#F2FAF8] transition-all text-left">
                            <div><p class="font-semibold">{{ __('Kartu Kredit / Debit') }}</p><p class="text-sm text-gray-500">Visa, Mastercard, JCB</p></div>
                            <span class="metode-check hidden text-[#134F4F] font-bold">✓</span>
                        </button>
                    </div>
                </div>

            </div>

            <div class="px-6 pb-6 pt-2 border-t">
                <button type="button" onclick="tutupModalMetode()"
                        class="w-full bg-[#134F4F] text-white font-bold py-3.5 rounded-xl hover:bg-[#0c4a3d] transition-colors">
                    {{ __('Konfirmasi Pilihan') }}
                </button>
            </div>

        </div>

    </div>


    <script>

        function setNominal(value) {
            document.getElementById('nominal').value = value;
        }

        // ── Modal Metode ─────────────────────────────────────────────────
        function bukaModalMetode() {
            const modal = document.getElementById('modal-metode');
            const card  = document.getElementById('modal-metode-card');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            requestAnimationFrame(() => requestAnimationFrame(() => {
                card.style.transform = 'translateY(0)';
            }));
            document.body.style.overflow = 'hidden';
        }

        function tutupModalMetode() {
            const card = document.getElementById('modal-metode-card');
            card.style.transform = 'translateY(100%)';
            setTimeout(() => {
                const modal = document.getElementById('modal-metode');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }, 350);
        }

        function tutupModalJikaLuar(e) {
            if (e.target === document.getElementById('modal-metode')) tutupModalMetode();
        }

        function pilihDariModal(nama, deskripsi) {
            // Aktifkan hidden input override (akan override radio)
            const override = document.getElementById('metode-override');
            override.value   = nama;
            override.disabled = false;

            // Uncheck semua radio agar tidak ikut submit
            document.querySelectorAll('input[name="metode_pembayaran"][type="radio"]').forEach(r => r.checked = false);

            // Tampilkan banner
            document.getElementById('metode-modal-nama').textContent = nama + ' — ' + deskripsi;
            document.getElementById('metode-modal-banner').classList.remove('hidden');

            // Highlight di modal
            document.querySelectorAll('.metode-opt').forEach(b => {
                b.classList.remove('border-[#134F4F]', 'bg-[#F2FAF8]');
                const chk = b.querySelector('.metode-check');
                if (chk) chk.classList.add('hidden');
            });
            if (window.event && window.event.currentTarget) {
                window.event.currentTarget.classList.add('border-[#134F4F]', 'bg-[#F2FAF8]');
                const chk = window.event.currentTarget.querySelector('.metode-check');
                if (chk) chk.classList.remove('hidden');
            }

            setTimeout(tutupModalMetode, 180);
        }

        function hapusPilihanModal() {
            // Disable override, kembalikan ke radio
            const override = document.getElementById('metode-override');
            override.value   = '';
            override.disabled = true;

            // Jika belum ada radio yang tercentang, centang yang pertama (QRIS)
            const anyChecked = document.querySelector('input[name="metode_pembayaran"][type="radio"]:checked');
            if (!anyChecked) {
                const firstRadio = document.querySelector('input[name="metode_pembayaran"][type="radio"]');
                if (firstRadio) firstRadio.checked = true;
            }

            document.getElementById('metode-modal-banner').classList.add('hidden');

            // Reset highlight modal
            document.querySelectorAll('.metode-opt').forEach(b => {
                b.classList.remove('border-[#134F4F]', 'bg-[#F2FAF8]');
                const chk = b.querySelector('.metode-check');
                if (chk) chk.classList.add('hidden');
            });
        }

    </script>


@endsection