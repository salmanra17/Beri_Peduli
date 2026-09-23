<?php

namespace App\Http\Controllers;

use App\Models\Kampanye;
use App\Models\PenarikanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PenarikanController extends Controller
{
    /**
     * Tampilkan halaman riwayat penarikan dana
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        // Hitung total saldo tersedia real (dana terkumpul dari semua kampanye milik user dikurangi penarikan aktif)
        $danaTerkumpul = (float) Kampanye::where('user_id', $user->id)->sum('dana_terkumpul');
        $danaDitarik = (float) PenarikanDana::where('user_id', $user->id)
            ->whereIn('status', ['berhasil', 'diproses'])
            ->sum('jumlah');

        $totalSaldoTersedia = max(0, $danaTerkumpul - $danaDitarik);

        // Kampanye yang siap ditarik (status selesai & ada sisa saldo)
        $kampanyesSiapTarik = Kampanye::where('user_id', $user->id)
            ->where('status', 'selesai')
            ->get()
            ->filter(fn ($k) => $k->saldo_siap_ditarik > 0);

        $query = PenarikanDana::with(['kampanye', 'user'])
            ->where('user_id', $user->id);

        // Filter pencarian (bisa mencari nominal, nama bank, nomor rekening, atas nama, atau kode transaksi)
        if ($request->filled('cari')) {
            $cari = trim((string) $request->cari);
            $numericCari = preg_replace('/[^0-9]/', '', $cari);

            $query->where(function ($q) use ($cari, $numericCari) {
                $q->where('bank_tujuan', 'like', "%{$cari}%")
                    ->orWhere('nomor_rekening', 'like', "%{$cari}%")
                    ->orWhere('nama_pemilik_rekening', 'like', "%{$cari}%")
                    ->orWhere('kode_transaksi', 'like', "%{$cari}%");

                if (! empty($numericCari)) {
                    $q->orWhere('jumlah', 'like', "%{$numericCari}%");
                }
            });
        }

        // Filter status: semua, berhasil, diproses, ditolak
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status', strtolower((string) $request->status));
        }

        // 4 item per halaman sesuai contoh desain: "Menampilkan 4 dari 28 riwayat penarikan"
        $penarikans = $query->orderBy('id', 'desc')
            ->paginate(4)
            ->withQueryString();

        return view('penarikan.history', compact(
            'user',
            'roleLabel',
            'totalSaldoTersedia',
            'kampanyesSiapTarik',
            'penarikans'
        ));
    }

    /**
     * Simpan pengajuan penarikan dana baru
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        // Bersihkan nominal dari format ribuan (misal: "25.000.000" atau "Rp 25.000.000")
        $cleanJumlah = preg_replace('/[^0-9]/', '', (string) $request->input('jumlah'));
        $request->merge(['jumlah' => $cleanJumlah]);

        $validated = $request->validate([
            'kampanye_id' => 'required|exists:kampanyes,id',
            'jumlah' => 'required|numeric|min:50000',
            'bank_tujuan' => 'required|string|max:50',
            'nomor_rekening' => 'required|string|max:50',
            'nama_pemilik_rekening' => 'required|string|max:100',
            'catatan' => 'nullable|string|max:1000',
        ], [
            'kampanye_id.required' => __('Pilihan kampanye wajib dipilih.'),
            'jumlah.required' => __('Nominal penarikan wajib diisi.'),
            'jumlah.min' => __('Minimal penarikan dana adalah Rp 50.000.'),
            'bank_tujuan.required' => __('Bank tujuan wajib diisi.'),
            'nomor_rekening.required' => __('Nomor rekening tujuan wajib diisi.'),
            'nama_pemilik_rekening.required' => __('Nama pemilik rekening wajib diisi.'),
        ]);

        $kampanye = Kampanye::where('id', $validated['kampanye_id'])
            ->where('user_id', $user->id)
            ->firstOrFail();

        $saldoTersedia = (float) $kampanye->saldo_siap_ditarik;

        $nominalPenarikan = 'Rp '.number_format((float) $validated['jumlah'], 0, ',', '.');
        $nominalSaldo = 'Rp '.number_format($saldoTersedia, 0, ',', '.');

        if ((float) $validated['jumlah'] > $saldoTersedia) {
            return back()
                ->withInput()
                ->withErrors(['jumlah' => __('Nominal penarikan (:nominal) melebihi saldo kampanye yang siap ditarik (:saldo).', [
                    'nominal' => $nominalPenarikan,
                    'saldo' => $nominalSaldo,
                ])]);
        }

        // Generate unik kode transaksi: WD-YYYYMMDD-XXXXX
        $kodeTransaksi = 'WD-'.date('Ymd').'-'.strtoupper(Str::random(5));
        while (PenarikanDana::where('kode_transaksi', $kodeTransaksi)->exists()) {
            $kodeTransaksi = 'WD-'.date('Ymd').'-'.strtoupper(Str::random(5));
        }

        PenarikanDana::create([
            'user_id' => $user->id,
            'kampanye_id' => $kampanye->id,
            'kode_transaksi' => $kodeTransaksi,
            'jumlah' => (float) $validated['jumlah'],
            'bank_tujuan' => strtoupper(trim((string) $validated['bank_tujuan'])),
            'nomor_rekening' => trim((string) $validated['nomor_rekening']),
            'nama_pemilik_rekening' => trim((string) $validated['nama_pemilik_rekening']),
            'status' => 'diproses',
            'catatan' => $validated['catatan'] ?? null,
        ]);

        $nominalBerhasil = 'Rp '.number_format((float) $validated['jumlah'], 0, ',', '.');

        return redirect()
            ->route('penarikan.index')
            ->with('success', __('Pengajuan pencairan dana sebesar :nominal untuk kampanye ":judul" berhasil diajukan dan sedang diproses!', [
                'nominal' => $nominalBerhasil,
                'judul' => $kampanye->judul,
            ]));
    }
}
