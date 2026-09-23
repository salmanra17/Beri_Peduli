<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kampanye;
use Illuminate\Http\Request;

class KampanyeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'menunggu');

        $countMenunggu = Kampanye::where('status', 'menunggu')->count();
        $countAktif = Kampanye::where('status', 'aktif')->count();
        $countDitolak = Kampanye::where('status', 'ditolak')->count();
        $countSelesai = Kampanye::where('status', 'selesai')->count();

        $query = Kampanye::with('user')->where('status', $status);

        if ($request->filled('cari')) {
            $cari = $request->cari;
            $query->where(function ($q) use ($cari) {
                $q->where('judul', 'like', "%{$cari}%")
                    ->orWhereHas('user', function ($u) use ($cari) {
                        $u->where('name', 'like', "%{$cari}%");
                    });
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

        $kampanyes = $query->paginate(10, ['*'], 'page', $page)->withQueryString();

        return view('admin.kampanye.index', compact(
            'kampanyes',
            'status',
            'highlight',
            'countMenunggu',
            'countAktif',
            'countDitolak',
            'countSelesai',
        ));
    }

    public function show(string $id)
    {
        $kampanye = Kampanye::with('user')->findOrFail($id);

        return view('admin.kampanye.show', compact('kampanye'));
    }

    public function approve(string $id)
    {
        $kampanye = Kampanye::findOrFail($id);

        $kampanye->update([
            'status' => 'aktif',
        ]);

        return redirect()
            ->route('admin.kampanye.index', ['status' => 'aktif'])
            ->with('success', 'Kampanye berhasil disetujui.');
    }

    public function reject(string $id)
    {
        $kampanye = Kampanye::findOrFail($id);

        $kampanye->update([
            'status' => 'ditolak',
        ]);

        return redirect()
            ->route('admin.kampanye.index', ['status' => 'ditolak'])
            ->with('success', 'Kampanye berhasil ditolak.');
    }
}
