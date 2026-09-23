{{-- MODAL AJUKAN PENARIKAN DANA (PLEK KETIPLEK SESUAI DESAIN MOCKUP) --}}
<div id="modal-tarik-dana"
     class="fixed inset-0 z-[999] hidden items-center justify-center p-4 sm:p-6 transition-opacity duration-200"
     style="background: rgba(0,0,0,0.5); backdrop-filter: blur(4px);">

    {{-- Backdrop click area --}}
    <div class="fixed inset-0" onclick="closeTarikDanaModal()"></div>

    {{-- Modal Card (Lebar 500px luas, lega, dan proporsional persis sesuai desain) --}}
    <div id="modal-tarik-card"
         class="relative w-full max-w-[500px] max-h-[92vh] flex flex-col bg-white rounded-3xl shadow-2xl overflow-hidden z-10 animate-modal-pop">

        {{-- Scrollable Body --}}
        <div class="p-7 overflow-y-auto custom-modal-scroll">

            {{-- Form action --}}
            <form method="POST" action="{{ route('penarikan.store') }}" id="form-penarikan-dana">
                @csrf

                <input type="hidden" name="kampanye_id" id="modal-kampanye-id" value="">
                <input type="hidden" name="bank_tujuan" id="modal-bank-input" value="BCA">
                <input type="hidden" name="nomor_rekening" id="modal-rekening-input" value="8820192831">
                <input type="hidden" name="nama_pemilik_rekening" id="modal-pemilik-input" value="Budi Santoso">

                {{-- ── 1. HEADER MODAL ── --}}
                <div class="flex items-start justify-between mb-4">
                    <div class="min-w-0 pr-3">
                        <h3 class="text-[22px] font-black text-gray-900 tracking-tight leading-tight">
                            {{ __('Ajukan Penarikan Dana') }}
                        </h3>
                        <div class="flex items-center gap-1.5 mt-2 text-xs text-gray-500 font-medium">
                            <svg class="w-3.5 h-3.5 text-[#135B59] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 2c-.4 0-.8.2-1 .5l-4.5 7c-1.3 2-1.5 4-.5 6 1 2 3.2 3.5 6 3.5s5-1.5 6-3.5c1-2 .8-4-.5-6l-4.5-7c-.2-.3-.6-.5-1-.5z" clip-rule="evenodd"/>
                            </svg>
                            <span class="text-gray-400 font-normal">{{ __('Kampanye:') }}</span>
                            <span id="modal-kampanye-judul" class="font-bold text-gray-700 truncate max-w-[300px]">
                                Bantuan Air Bersih untuk Desa Sukatani
                            </span>
                        </div>
                    </div>

                    {{-- Close button --}}
                    <button type="button"
                            onclick="closeTarikDanaModal()"
                            class="w-8 h-8 rounded-full flex items-center justify-center text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition-colors flex-shrink-0 cursor-pointer -mt-1 -mr-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Divider tipis --}}
                <div class="border-b border-gray-100 -mx-7 mb-6"></div>

                {{-- ── 2. KARTU SALDO SIAP DITARIK ── --}}
                <div class="bg-[#EAF6F4] border border-[#D2EAE5] rounded-2xl p-4 flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-2xl bg-[#D2EDE8] text-[#135B59] flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-500">{{ __('Saldo Siap Ditarik') }}</p>
                            <p class="text-[22px] font-black text-[#135B59] tracking-tight leading-tight mt-0.5" id="modal-saldo-text">
                                Rp 0
                            </p>
                        </div>
                    </div>

                    <button type="button"
                            id="btn-tarik-semua"
                            class="px-4 py-2 text-xs font-bold text-[#135B59] bg-white border border-[#BDE1DC] rounded-xl hover:bg-[#F3FAF9] transition shadow-2xs cursor-pointer">
                        {{ __('Tarik Semua') }}
                    </button>
                </div>

                {{-- ── 3. NOMINAL PENARIKAN ── --}}
                <div class="mb-6">
                    <label class="block text-xs font-extrabold text-gray-800 uppercase tracking-wider mb-2">
                        {{ __('NOMINAL PENARIKAN') }}
                    </label>
                    <div class="relative flex items-center h-[52px] px-4 rounded-xl border border-gray-200 bg-white focus-within:border-[#135B59] focus-within:ring-2 focus-within:ring-[#135B59]/20 transition shadow-2xs">
                        <span class="text-base font-bold text-gray-900 mr-2.5 select-none">Rp</span>
                        <input type="text"
                               id="modal-nominal-input"
                               class="w-full text-base font-bold text-gray-900 bg-transparent focus:outline-none placeholder-gray-300"
                               placeholder="0"
                               autocomplete="off">
                        <input type="hidden" name="jumlah" id="modal-nominal-raw" value="0">
                    </div>

                    <div class="flex justify-between items-center text-xs mt-2 font-medium">
                        <span class="text-gray-400 font-normal">{{ __('Min. penarikan Rp 50.000') }}</span>
                        <span id="modal-tersisa-text" class="text-[#135B59] font-bold">{{ __('Tersisa: Rp ') }}0</span>
                    </div>
                </div>

                {{-- ── 4. REKENING TUJUAN ── --}}
                <div class="mb-6">
                    <div class="flex justify-between items-center mb-2">
                        <label class="block text-xs font-extrabold text-gray-800 uppercase tracking-wider">
                            {{ __('REKENING TUJUAN') }}
                        </label>
                        <button type="button"
                                id="btn-toggle-edit-rekening"
                                class="inline-flex items-center gap-1 text-xs font-bold text-[#135B59] hover:underline cursor-pointer">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z"/>
                            </svg>
                            <span id="text-toggle-rekening">{{ __('Ubah Rekening') }}</span>
                        </button>
                    </div>

                    {{-- Tampilan Rekening Terpilih --}}
                    <div id="card-rekening-display"
                         class="border-2 border-[#135B59] bg-white rounded-2xl p-3.5 flex items-center justify-between shadow-2xs transition">
                        <div class="flex items-center gap-3.5 min-w-0">
                            <div id="badge-bank"
                                 class="w-14 h-10 px-2 rounded-xl bg-gray-50 border border-gray-200 flex items-center justify-center font-extrabold text-xs text-gray-800 tracking-wider flex-shrink-0">
                                BCA
                            </div>
                            <div class="min-w-0">
                                <div class="flex items-center gap-1.5">
                                    <span id="text-bank-rekening" class="font-extrabold text-[14px] text-gray-900 truncate">
                                        Bank BCA - 8820192831
                                    </span>
                                    <svg class="w-4 h-4 text-emerald-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <p id="text-pemilik-rekening" class="text-xs text-gray-500 font-medium mt-0.5 truncate">
                                    a.n Budi Santoso
                                </p>
                            </div>
                        </div>

                        <div class="w-6 h-6 rounded-full bg-[#135B59] text-white flex items-center justify-center flex-shrink-0 ml-2">
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                            </svg>
                        </div>
                    </div>

                    {{-- Form Ubah Rekening (Slide/Toggle) --}}
                    <div id="drawer-edit-rekening" class="hidden mt-2.5 p-4 bg-gray-50 border border-gray-200 rounded-2xl space-y-3 text-xs">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">{{ __('Bank / E-Wallet Tujuan') }}</label>
                            <select id="select-bank-edit" class="w-full h-[40px] px-3 rounded-xl border border-gray-200 bg-white text-xs font-semibold focus:ring-2 focus:ring-[#135B59] focus:outline-none">
                                <option value="BCA">Bank BCA</option>
                                <option value="BRI">Bank BRI</option>
                                <option value="BNI">Bank BNI</option>
                                <option value="Mandiri">Bank Mandiri</option>
                                <option value="BSI">Bank Syariah Indonesia (BSI)</option>
                                <option value="CIMB">CIMB Niaga</option>
                                <option value="Permata">Bank Permata</option>
                                <option value="Danamon">Bank Danamon</option>
                                <option value="Seabank">SeaBank</option>
                                <option value="Jago">Bank Jago</option>
                                <option value="GoPay">GoPay</option>
                                <option value="OVO">OVO</option>
                                <option value="DANA">DANA</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">{{ __('Nomor Rekening / No. HP') }}</label>
                            <input type="text"
                                   id="input-rekening-edit"
                                   class="w-full h-[40px] px-3 rounded-xl border border-gray-200 bg-white text-xs font-semibold focus:ring-2 focus:ring-[#135B59] focus:outline-none"
                                   placeholder="{{ __('Contoh: 8820192831') }}">
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-gray-700 mb-1">{{ __('Nama Pemilik Rekening') }}</label>
                            <input type="text"
                                   id="input-pemilik-edit"
                                   class="w-full h-[40px] px-3 rounded-xl border border-gray-200 bg-white text-xs font-semibold focus:ring-2 focus:ring-[#135B59] focus:outline-none"
                                   placeholder="{{ __('Nama sesuai buku rekening / KTP') }}">
                        </div>

                        <button type="button"
                                id="btn-simpan-edit-rekening"
                                class="w-full py-2 bg-[#135B59] text-white text-xs font-bold rounded-xl hover:bg-[#0e4846] transition cursor-pointer">
                            {{ __('Gunakan Rekening Ini') }}
                        </button>
                    </div>
                </div>

                {{-- ── 5. RENCANA ALOKASI DANA (OPSIONAL) ── --}}
                <div class="mb-6">
                    <label class="block text-xs font-extrabold text-gray-800 uppercase tracking-wider mb-2">
                        {{ __('RENCANA ALOKASI DANA') }} <span class="text-gray-400 font-normal">({{ __('OPSIONAL') }})</span>
                    </label>
                    <textarea name="catatan"
                              id="modal-catatan-input"
                              rows="3"
                              class="w-full rounded-2xl border border-gray-200 p-3.5 text-sm text-gray-800 placeholder-gray-400 focus:outline-none focus:border-[#135B59] focus:ring-2 focus:ring-[#135B59]/20 transition resize-none leading-relaxed"
                              placeholder="Pembelian pipa PVC 4 dim 80 batang dan operasional pengeboran titik ke-2."></textarea>
                    <p class="text-xs text-gray-400 mt-2 leading-relaxed">
                        {{ __('Rencana penggunaan akan dipublikasikan di tab transparansi untuk para donatur.') }}
                    </p>
                </div>

                {{-- ── 6. INFORMASI BIAYA & ESTIMASI ── --}}
                <div class="bg-[#F4F8FA] border border-gray-100 rounded-2xl p-4 space-y-2.5 text-xs mb-7">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">{{ __('Biaya Administrasi Bank') }}</span>
                        <span class="font-bold text-[#135B59]">{{ __('Gratis (Rp 0)') }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-500 font-medium">{{ __('Estimasi Dana Masuk') }}</span>
                        <span class="font-bold text-gray-700">{{ __('1-2 hari kerja') }}</span>
                    </div>
                </div>

                {{-- ── 7. TOMBOL AKSI (BATAL & AJUKAN PENCAIRAN) ── --}}
                <div class="flex items-center justify-end gap-3 pt-2">
                    <button type="button"
                            onclick="closeTarikDanaModal()"
                            class="px-6 h-[44px] rounded-xl border border-gray-200 bg-white hover:bg-gray-50 text-sm font-semibold text-gray-700 transition cursor-pointer">
                        {{ __('Batal') }}
                    </button>

                    <button type="submit"
                            id="btn-submit-pencairan"
                            class="inline-flex items-center justify-center gap-2 px-7 h-[44px] rounded-xl bg-[#135B59] hover:bg-[#0e4846] text-white text-sm font-bold transition shadow-sm cursor-pointer">
                        <svg class="w-4 h-4 fill-white -rotate-45 relative -top-[1px]" viewBox="0 0 24 24">
                            <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                        </svg>
                        <span>{{ __('Ajukan Pencairan') }}</span>
                    </button>
                </div>

            </form>

        </div>

    </div>

</div>

{{-- SCRIPT PENGENDALI MODAL & FORMULIR --}}
<script>
    (function () {
        let currentSaldo = 0;

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(Math.max(0, number));
        }

        function parseRawNominal(str) {
            if (!str) return 0;
            return parseInt(str.toString().replace(/[^0-9]/g, ''), 10) || 0;
        }

        // Buka modal dengan parameter kampanye
        window.openTarikDanaModal = function (data) {
            const modal = document.getElementById('modal-tarik-dana');
            if (!modal) return;

            currentSaldo = parseFloat(data.saldo) || 0;

            document.getElementById('modal-kampanye-id').value = data.id || '';
            document.getElementById('modal-kampanye-judul').textContent = data.judul || @js(__('Kampanye'));
            document.getElementById('modal-saldo-text').textContent = 'Rp ' + formatRupiah(currentSaldo);

            // Set data rekening
            const bank = data.bank || 'BCA';
            const rekening = data.rekening || '8820192831';
            const pemilik = data.pemilik || @js(__('Penggalang Dana'));

            updateRekeningInfo(bank, rekening, pemilik);

            // Reset input nominal (default kosong)
            const inputNominal = document.getElementById('modal-nominal-input');
            const hiddenRaw = document.getElementById('modal-nominal-raw');

            inputNominal.value = '';
            hiddenRaw.value = 0;
            updateTersisa(0);

            // Buka modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';

            setTimeout(() => {
                inputNominal.focus();
            }, 100);
        };

        // Tutup modal
        window.closeTarikDanaModal = function () {
            const modal = document.getElementById('modal-tarik-dana');
            if (!modal) return;

            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        };

        // Update sisa dana saat mengetik
        function updateTersisa(nominal) {
            const tersisa = Math.max(0, currentSaldo - nominal);
            const textTersisa = document.getElementById('modal-tersisa-text');
            if (textTersisa) {
                textTersisa.textContent = @js(__('Tersisa: Rp ')) + formatRupiah(tersisa);
                if (nominal > currentSaldo) {
                    textTersisa.classList.remove('text-[#135B59]');
                    textTersisa.classList.add('text-rose-600');
                    textTersisa.textContent = @js(__('Melebihi saldo (Max Rp ')) + formatRupiah(currentSaldo) + ')';
                } else {
                    textTersisa.classList.add('text-[#135B59]');
                    textTersisa.classList.remove('text-rose-600');
                }
            }
        }

        // Listener input nominal
        const inputNominal = document.getElementById('modal-nominal-input');
        const hiddenRaw = document.getElementById('modal-nominal-raw');

        if (inputNominal) {
            inputNominal.addEventListener('input', function (e) {
                let raw = parseRawNominal(this.value);
                if (raw > currentSaldo) {
                    raw = currentSaldo;
                }
                hiddenRaw.value = raw;
                this.value = raw > 0 ? formatRupiah(raw) : '';
                updateTersisa(raw);
            });
        }

        // Tombol "Tarik Semua"
        const btnTarikSemua = document.getElementById('btn-tarik-semua');
        if (btnTarikSemua) {
            btnTarikSemua.addEventListener('click', function () {
                if (currentSaldo <= 0) return;
                inputNominal.value = formatRupiah(currentSaldo);
                hiddenRaw.value = currentSaldo;
                updateTersisa(currentSaldo);
            });
        }

        // Fungsi update data rekening
        function updateRekeningInfo(bank, rekening, pemilik) {
            // Bersihkan jika ada awalan kata 'bank' ganda
            const cleanBank = (bank || 'BCA').toString().replace(/^bank\s+/i, '').trim();

            document.getElementById('modal-bank-input').value = cleanBank;
            document.getElementById('modal-rekening-input').value = rekening;
            document.getElementById('modal-pemilik-input').value = pemilik;

            const badge = document.getElementById('badge-bank');
            if (badge) badge.textContent = cleanBank.toUpperCase();

            const textBankRekening = document.getElementById('text-bank-rekening');
            if (textBankRekening) textBankRekening.textContent = @js(__('Bank ')) + cleanBank.toUpperCase() + ' - ' + rekening;

            const textPemilik = document.getElementById('text-pemilik-rekening');
            if (textPemilik) textPemilik.textContent = @js(__('a.n ')) + pemilik;

            // Sync ke form edit
            const selBank = document.getElementById('select-bank-edit');
            if (selBank) selBank.value = cleanBank.toUpperCase();

            const inpRek = document.getElementById('input-rekening-edit');
            if (inpRek) inpRek.value = rekening;

            const inpPem = document.getElementById('input-pemilik-edit');
            if (inpPem) inpPem.value = pemilik;
        }

        // Toggle edit rekening drawer
        const btnToggleRekening = document.getElementById('btn-toggle-edit-rekening');
        const drawerEdit = document.getElementById('drawer-edit-rekening');
        const textToggleRekening = document.getElementById('text-toggle-rekening');

        if (btnToggleRekening && drawerEdit) {
            btnToggleRekening.addEventListener('click', function () {
                const isHidden = drawerEdit.classList.contains('hidden');
                if (isHidden) {
                    drawerEdit.classList.remove('hidden');
                    textToggleRekening.textContent = @js(__('Tutup'));
                } else {
                    drawerEdit.classList.add('hidden');
                    textToggleRekening.textContent = @js(__('Ubah Rekening'));
                }
            });
        }

        // Simpan edit rekening
        const btnSimpanRekening = document.getElementById('btn-simpan-edit-rekening');
        if (btnSimpanRekening) {
            btnSimpanRekening.addEventListener('click', function () {
                const rawBank = document.getElementById('select-bank-edit').value || 'BCA';
                const bank = rawBank.replace(/^bank\s+/i, '').trim();
                const rekening = document.getElementById('input-rekening-edit').value.trim() || '8820192831';
                const pemilik = document.getElementById('input-pemilik-edit').value.trim() || @js(__('Penggalang Dana'));

                updateRekeningInfo(bank, rekening, pemilik);

                drawerEdit.classList.add('hidden');
                textToggleRekening.textContent = @js(__('Ubah Rekening'));
            });
        }

        // Validasi form sebelum submit
        const form = document.getElementById('form-penarikan-dana');
        if (form) {
            form.addEventListener('submit', function (e) {
                const raw = parseRawNominal(hiddenRaw.value);
                if (raw < 50000) {
                    e.preventDefault();
                    alert(@js(__('Minimal nominal penarikan dana adalah Rp 50.000')));;
                    inputNominal.focus();
                    return false;
                }
                if (raw > currentSaldo) {
                    e.preventDefault();
                    alert(@js(__('Nominal penarikan melebihi saldo yang siap ditarik!')));
                    return false;
                }
            });
        }

        // Close on ESC key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeTarikDanaModal();
            }
        });
    })();
</script>
