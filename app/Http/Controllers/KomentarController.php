<?php

namespace App\Http\Controllers;

use App\Models\Komentar;
use Illuminate\Http\Request;

class KomentarController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kampanye_id' => 'required|exists:kampanyes,id',
            'pesan' => 'required|string|max:500',
        ]);

        Komentar::create([
            'user_id' => auth()->id(),
            'kampanye_id' => $validated['kampanye_id'],
            'pesan' => $validated['pesan'],
        ]);

        return redirect()
            ->route('kampanye.show', $validated['kampanye_id'])
            ->with('success_komentar', __('Komentar berhasil dikirim.'));
    }
}
