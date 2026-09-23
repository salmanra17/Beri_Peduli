<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuktiPenyaluran;
use Illuminate\Http\Request;

class BuktiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'menunggu');

        $countMenunggu = BuktiPenyaluran::where('status', 'menunggu')->count();
        $countDisetujui = BuktiPenyaluran::where('status', 'disetujui')->count();
        $countDitolak = BuktiPenyaluran::where('status', 'ditolak')->count();

        $query = BuktiPenyaluran::with(['user', 'penarikanDana' => fn ($q) => $q->with(['kampanye' => fn ($q2) => $q2->withTrashed()])])->where('status', $status);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('deskripsi', 'like', "%{$cari}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$cari}%"))
                    ->orWhereHas('penarikanDana', fn ($p) => $p->where('kode_transaksi', 'like', "%{$cari}%"))
                    ->orWhereHas('penarikanDana.kampanye', fn ($k) => $k->where('judul', 'like', "%{$cari}%"));
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

        $buktis = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return view('admin.bukti.index', compact(
            'buktis',
            'status',
            'highlight',
            'countMenunggu',
            'countDisetujui',
            'countDitolak',
        ));
    }

    public function setujui(string $id)
    {
        BuktiPenyaluran::findOrFail($id)->update([
            'status' => 'disetujui',
        ]);

        return redirect()
            ->route('admin.bukti.index', ['status' => 'disetujui'])
            ->with('success', 'Bukti penyaluran berhasil disetujui.');
    }

    public function tolak(Request $request, string $id)
    {
        $validated = $request->validate([
            'catatan_admin' => 'nullable|string|max:500',
        ]);

        BuktiPenyaluran::findOrFail($id)->update([
            'status' => 'ditolak',
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ]);

        return redirect()
            ->route('admin.bukti.index', ['status' => 'ditolak'])
            ->with('success', 'Bukti penyaluran berhasil ditolak.');
    }

    public function destroy(string $id)
    {
        $bukti = BuktiPenyaluran::findOrFail($id);

        if ($bukti->status !== 'ditolak') {
            return back()->withErrors('Hanya data berstatus Ditolak yang bisa dihapus.');
        }

        $bukti->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
