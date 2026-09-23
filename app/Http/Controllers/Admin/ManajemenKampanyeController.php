<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kampanye;
use App\Models\Komentar;
use Illuminate\Http\Request;

class ManajemenKampanyeController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');
        $q = $request->query('q');

        $countSemua = Kampanye::count();
        $countAktif = Kampanye::where('status', 'aktif')->count();
        $countMenunggu = Kampanye::where('status', 'menunggu')->count();
        $countDitolak = Kampanye::where('status', 'ditolak')->count();
        $countSelesai = Kampanye::where('status', 'selesai')->count();

        $query = Kampanye::with('user');

        if ($status && $status !== 'semua') {
            $query->where('status', $status);
        }

        if ($q !== null && $q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('judul', 'like', "%{$q}%")
                    ->orWhereHas('user', function ($user) use ($q) {
                        $user->where('name', 'like', "%{$q}%");
                    });
            });
        }

        $kampanyes = $query->latest()->paginate(10)->withQueryString();

        return view('admin.manajemen-kampanye.index', compact(
            'kampanyes',
            'status',
            'q',
            'countSemua',
            'countAktif',
            'countMenunggu',
            'countDitolak',
            'countSelesai',
        ));
    }

    public function destroy(string $id)
    {
        $kampanye = Kampanye::findOrFail($id);

        Komentar::where('kampanye_id', $kampanye->id)->delete();

        $kampanye->delete();

        return redirect()
            ->back()
            ->with('success', 'Kampanye berhasil dihapus.');
    }
}
