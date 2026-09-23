<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kampanye;
use App\Models\Komentar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class DonasiController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kampanye_id' => 'required|exists:kampanyes,id',
            'jumlah_donasi' => 'required|numeric|min:1000',
            'metode_pembayaran' => 'required|string|max:100',
            'pesan' => 'nullable|string|max:500',
            'anonim' => 'nullable|boolean',
        ]);

        $kampanye = Kampanye::findOrFail($validated['kampanye_id']);

        if ($kampanye->isSelesai()) {
            return back()
                ->with('error', __('Kampanye ini sudah selesai dan tidak menerima donasi lagi.'));
        }

        DB::transaction(function () use ($validated, $kampanye) {

            // SIMPAN DONASI
            $donasi = Donasi::create([
                'user_id' => auth()->id(),
                'kampanye_id' => $kampanye->id,
                'jumlah_donasi' => $validated['jumlah_donasi'],
                'metode_pembayaran' => $validated['metode_pembayaran'],
                'status_pembayaran' => 'berhasil',
                'pesan' => $validated['pesan'] ?? null,
                'anonim' => $validated['anonim'] ?? false,
            ]);

            // SIMPAN DOA / KOMENTAR
            $pesan = trim($validated['pesan'] ?? '');

            if ($pesan !== '') {

                Komentar::create([
                    'user_id' => auth()->id(),
                    'kampanye_id' => $kampanye->id,
                    'donasi_id' => $donasi->id,
                    'pesan' => $pesan,
                    'anonim' => $validated['anonim'] ?? false,
                ]);

            }

            // UPDATE TOTAL DANA
            $kampanye->increment(
                'dana_terkumpul',
                $validated['jumlah_donasi']
            );

            // AUTO-SELESAI JIKA TARGET TERCAPAI
            $kampanye->refresh();

            if ($kampanye->dana_terkumpul >= $kampanye->target_dana) {
                $kampanye->update(['status' => 'selesai']);
            }

        });

        return redirect()
            ->route('kampanye.show', $kampanye->id)
            ->with('donasi_berhasil', true)
            ->with('donasi_jumlah', $validated['jumlah_donasi'])
            ->with('donasi_metode', $validated['metode_pembayaran'])
            ->with('donasi_anonim', $validated['anonim'] ?? false);

    }

    public function history(Request $request)
    {
        $user = auth()->user();
        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        $query = Donasi::with('kampanye')
            ->where('user_id', $user->id);

        // filter pencarian nama kampanye
        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->whereHas('kampanye', function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%");
            });
        }

        // filter status
        if ($request->filled('status') && $request->status !== 'semua') {
            $query->where('status_pembayaran', $request->status);
        }

        $donasis = $query->latest()->paginate(5)->withQueryString();
        $totalDana = Donasi::where('user_id', $user->id)->where('status_pembayaran', 'berhasil')->sum('jumlah_donasi');
        $totalKampanye = Donasi::where('user_id', $user->id)->where('status_pembayaran', 'berhasil')->distinct('kampanye_id')->count('kampanye_id');

        return response()
            ->view('donasi.history', compact('donasis', 'totalDana', 'totalKampanye', 'user', 'roleLabel'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    public function downloadLaporan(): StreamedResponse
    {
        $donasis = Donasi::with('kampanye')
            ->where('user_id', auth()->id())
            ->where('status_pembayaran', 'berhasil')
            ->latest()
            ->get();

        $filename = 'riwayat-donasi-'.now()->format('Ymd').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($donasis) {
            $handle = fopen('php://output', 'w');

            // BOM untuk Excel agar baca UTF-8 dengan benar
            fwrite($handle, "\xEF\xBB\xBF");

            // header kolom
            fputcsv($handle, [
                __('Tanggal'),
                __('Nama Campaign'),
                __('Nominal (Rp)'),
                __('Metode Pembayaran'),
                __('Status'),
            ]);

            foreach ($donasis as $d) {
                fputcsv($handle, [
                    $d->created_at->format('d M Y'),
                    $d->kampanye->judul ?? '-',
                    $d->jumlah_donasi,
                    $d->metode_pembayaran,
                    strtoupper($d->status_pembayaran),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function create($kampanye)
    {
        $kampanye = Kampanye::findOrFail($kampanye);

        if ($kampanye->isSelesai()) {
            return back()
                ->with('error', __('Kampanye ini sudah selesai dan tidak menerima donasi lagi.'));
        }

        return response()
            ->view('donasi.create', compact('kampanye'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}
