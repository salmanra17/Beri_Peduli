<?php

namespace App\Http\Controllers;

use App\Models\BuktiPenyaluran;
use App\Models\PenarikanDana;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class BuktiPenyaluranController extends Controller
{
    /**
     * Tampilkan halaman Bukti Penyaluran Dana.
     * Hanya menampilkan penarikan berstatus 'berhasil' milik user.
     */
    public function index(Request $request): View
    {
        $user = auth()->user();

        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        // Ambil semua penarikan berhasil milik user + bukti penyalurannya
        $query = PenarikanDana::with(['kampanye', 'buktiPenyaluran'])
            ->where('user_id', $user->id)
            ->where('status', 'berhasil');

        // Filter pencarian
        if ($request->filled('cari')) {
            $cari = trim((string) $request->cari);
            $query->whereHas('kampanye', fn ($q) => $q->where('judul', 'like', "%{$cari}%"))
                ->orWhere('kode_transaksi', 'like', "%{$cari}%");
        }

        // Filter status laporan
        if ($request->filled('status_laporan') && $request->status_laporan !== 'semua') {
            $statusLaporan = $request->status_laporan;
            if ($statusLaporan === 'belum') {
                $query->whereDoesntHave('buktiPenyaluran');
            } else {
                $query->whereHas('buktiPenyaluran', fn ($q) => $q->where('status', $statusLaporan));
            }
        }

        $penarikans = $query->orderBy('disetujui_pada', 'desc')
            ->paginate(8)
            ->withQueryString();

        // Summary stats
        $totalPenarikanBerhasil = PenarikanDana::where('user_id', $user->id)
            ->where('status', 'berhasil')
            ->count();

        $totalDanaTersalurkan = (float) PenarikanDana::where('user_id', $user->id)
            ->where('status', 'berhasil')
            ->sum('jumlah');

        $jumlahBelumDilaporkan = PenarikanDana::where('user_id', $user->id)
            ->where('status', 'berhasil')
            ->whereDoesntHave('buktiPenyaluran')
            ->count();

        $jumlahTerverifikasi = BuktiPenyaluran::where('user_id', $user->id)
            ->where('status', 'disetujui')
            ->count();

        $jumlahMenungguReview = BuktiPenyaluran::where('user_id', $user->id)
            ->where('status', 'menunggu')
            ->count();

        return view('bukti-penyaluran.index', compact(
            'user',
            'roleLabel',
            'penarikans',
            'totalDanaTersalurkan',
            'totalPenarikanBerhasil',
            'jumlahBelumDilaporkan',
            'jumlahTerverifikasi',
            'jumlahMenungguReview',
        ));
    }

    /**
     * Simpan bukti penyaluran dana yang diunggah.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $validator = Validator::make($request->all(), [
            'penarikan_dana_id' => 'required|exists:penarikan_danas,id',
            'deskripsi' => 'required|string|min:20|max:2000',
            'foto_bukti' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ], [
            'penarikan_dana_id.required' => __('Pilih penarikan dana yang ingin dilaporkan.'),
            'deskripsi.required' => __('Deskripsi penyaluran wajib diisi.'),
            'deskripsi.min' => __('Deskripsi minimal 20 karakter agar laporan informatif.'),
            'foto_bukti.required' => __('File bukti wajib diunggah.'),
            'foto_bukti.mimes' => __('Format file harus JPG, PNG, atau PDF.'),
            'foto_bukti.max' => __('Ukuran file maksimal 5 MB.'),
        ]);

        if ($validator->fails()) {
            $penarikanUntukModal = PenarikanDana::with(['kampanye', 'buktiPenyaluran'])
                ->find($request->penarikan_dana_id);

            $modalPenarikanData = $penarikanUntukModal ? [
                'kode' => $penarikanUntukModal->kode_transaksi,
                'judul' => $penarikanUntukModal->kampanye->judul ?? __('Kampanye Dihapus'),
                'jumlah' => (float) $penarikanUntukModal->jumlah,
                'is_revisi' => $penarikanUntukModal->buktiPenyaluran?->status === 'ditolak',
            ] : null;

            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('modal_penarikan', $modalPenarikanData);
        }

        $validated = $validator->validated();

        // Pastikan penarikan milik user dan statusnya berhasil
        $penarikan = PenarikanDana::where('id', $validated['penarikan_dana_id'])
            ->where('user_id', $user->id)
            ->where('status', 'berhasil')
            ->firstOrFail();

        // Pastikan belum pernah upload bukti untuk penarikan ini, kecuali laporan sebelumnya ditolak
        $buktiLama = $penarikan->buktiPenyaluran;

        if ($buktiLama && $buktiLama->status !== 'ditolak') {
            return back()
                ->withInput()
                ->withErrors(['penarikan_dana_id' => __('Bukti penyaluran untuk penarikan ini sudah pernah diunggah dan sedang/sudah diproses.')]);
        }

        $path = $request->file('foto_bukti')->store('bukti-penyaluran', 'public');

        if ($buktiLama) {
            $buktiLama->update([
                'deskripsi' => trim($validated['deskripsi']),
                'foto_bukti' => $path,
                'status' => 'menunggu',
                'catatan_admin' => null,
            ]);
        } else {
            BuktiPenyaluran::create([
                'penarikan_dana_id' => $penarikan->id,
                'user_id' => $user->id,
                'deskripsi' => trim($validated['deskripsi']),
                'foto_bukti' => $path,
                'status' => 'menunggu',
            ]);
        }

        return redirect()
            ->route('bukti-penyaluran.index')
            ->with('success', $buktiLama
                ? __('Bukti penyaluran berhasil diunggah ulang dan sedang menunggu verifikasi tim BeriPeduli.')
                : __('Bukti penyaluran berhasil diunggah dan sedang menunggu verifikasi tim BeriPeduli.'));
    }
}
