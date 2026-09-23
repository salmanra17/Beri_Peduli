<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenarikanDana;
use Illuminate\Http\Request;

class PenarikanController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'diproses');

        $countDiproses = PenarikanDana::where('status', 'diproses')->count();
        $countBerhasil = PenarikanDana::where('status', 'berhasil')->count();
        $countDitolak = PenarikanDana::where('status', 'ditolak')->count();

        $query = PenarikanDana::with(['user', 'kampanye' => fn ($q) => $q->withTrashed()])->where('status', $status);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('kode_transaksi', 'like', "%{$cari}%")
                    ->orWhere('bank_tujuan', 'like', "%{$cari}%")
                    ->orWhere('nama_pemilik_rekening', 'like', "%{$cari}%")
                    ->orWhereHas('kampanye', fn ($k) => $k->where('judul', 'like', "%{$cari}%"))
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$cari}%"));
            });
        }

        $query->latest();

        $highlight = (int) $request->query('highlight', 0);
        $page = null;

        if ($highlight > 0 && ! $request->filled('page')) {
            $position = (clone $query)->pluck('id')->search($highlight);

            if ($position !== false) {
                $page = intdiv($position, 10) + 1;
            }
        }

        $penarikans = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return view('admin.penarikan.index', compact(
            'penarikans',
            'status',
            'highlight',
            'countDiproses',
            'countBerhasil',
            'countDitolak',
        ));
    }

    public function proses(string $id)
    {
        PenarikanDana::findOrFail($id)->update([
            'status' => 'berhasil',
            'disetujui_pada' => now(),
        ]);

        return redirect()
            ->route('admin.penarikan.index', ['status' => 'berhasil'])
            ->with('success', 'Penarikan dana berhasil diproses.');
    }

    public function tolak(string $id)
    {
        PenarikanDana::findOrFail($id)->update([
            'status' => 'ditolak',
        ]);

        return redirect()
            ->route('admin.penarikan.index', ['status' => 'ditolak'])
            ->with('success', 'Penarikan dana berhasil ditolak.');
    }

    public function destroy(string $id)
    {
        $penarikan = PenarikanDana::findOrFail($id);

        if ($penarikan->status !== 'ditolak') {
            return back()->withErrors('Hanya data berstatus Ditolak yang bisa dihapus.');
        }

        $penarikan->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
