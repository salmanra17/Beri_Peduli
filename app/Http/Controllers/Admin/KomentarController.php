<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

        $query = Komentar::with(['user', 'kampanye']);

        if ($q !== null && $q !== '') {
            $query->where(function ($builder) use ($q) {
                $builder->where('pesan', 'like', "%{$q}%")
                    ->orWhereHas('kampanye', function ($kampanye) use ($q) {
                        $kampanye->where('judul', 'like', "%{$q}%");
                    });
            });
        }

        $komentars = $query->latest()->paginate(15)->withQueryString();

        return view('admin.komentar.index', compact('komentars', 'q'));
    }

    public function destroy(string $id)
    {
        $komentar = Komentar::findOrFail($id);

        $komentar->delete();

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil dihapus.');
    }
}
