<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RekeningBank;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'menunggu');

        $countMenunggu = RekeningBank::where('status', 'menunggu')->count();
        $countTerverifikasi = RekeningBank::where('status', 'terverifikasi')->count();
        $countDitolak = RekeningBank::where('status', 'ditolak')->count();

        $query = RekeningBank::with('user')->where('status', $status);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('nama_bank', 'like', "%{$cari}%")
                    ->orWhere('nomor_rekening', 'like', "%{$cari}%")
                    ->orWhere('nama_pemilik', 'like', "%{$cari}%")
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

        $rekenings = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return view('admin.rekening.index', compact(
            'rekenings',
            'status',
            'highlight',
            'countMenunggu',
            'countTerverifikasi',
            'countDitolak',
        ));
    }

    public function verify(string $id)
    {
        RekeningBank::findOrFail($id)->update([
            'status' => 'terverifikasi',
        ]);

        return redirect()
            ->route('admin.rekening.index', ['status' => 'terverifikasi'])
            ->with('success', 'Rekening berhasil diverifikasi.');
    }

    public function reject(string $id)
    {
        RekeningBank::findOrFail($id)->update([
            'status' => 'ditolak',
        ]);

        return redirect()
            ->route('admin.rekening.index', ['status' => 'ditolak'])
            ->with('success', 'Rekening berhasil ditolak.');
    }

    public function destroy(string $id)
    {
        $rekening = RekeningBank::findOrFail($id);

        if ($rekening->status !== 'ditolak') {
            return back()->withErrors('Hanya data berstatus Ditolak yang bisa dihapus.');
        }

        $rekening->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
