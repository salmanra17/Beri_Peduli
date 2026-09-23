<?php

namespace App\Http\Controllers;

use App\Models\Kampanye;
use App\Models\User;
use Illuminate\Http\Request;

class KampanyeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kampanye::whereIn('status', ['aktif', 'selesai']);

        // SEARCH
        if ($request->filled('search')) {

            $query->where(function ($q) use ($request) {

                $q->where('judul', 'like', '%'.$request->search.'%')
                    ->orWhere('deskripsi', 'like', '%'.$request->search.'%');

            });

        }

        // FILTER KATEGORI
        if ($request->filled('kategori') && $request->kategori != 'Semua') {

            $query->whereRaw('LOWER(kategori) = ?', [strtolower($request->kategori)]);

        }

        // FILTER STATUS
        if ($request->filled('status') && $request->status != 'Semua') {

            $status = strtolower($request->status);

            if (in_array($status, ['aktif', 'selesai'])) {
                $query->where('status', $status);
            }

        }

        $kampanyes = $query
            ->latest()
            ->paginate(6)
            ->withQueryString();

        return response()
            ->view('kampanye.index', compact('kampanyes'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');

    }

    /**
     * Display the campaigns owned by the authenticated user.
     */
    public function saya(Request $request)
    {
        $user = auth()->user();

        $query = Kampanye::withTrashed()->where('user_id', $user->id);

        if ($request->filled('search')) {
            $query->where('judul', 'like', '%'.$request->search.'%');
        }

        $statusFilter = match (strtolower(trim((string) $request->query('status')))) {
            'berjalan', 'aktif', 'sedang berjalan', 'sedang_berjalan' => 'aktif',
            'selesai', 'tercapai' => 'selesai',
            'menunggu', 'menunggu verifikasi', 'menunggu_verifikasi' => 'menunggu',
            'ditolak' => 'ditolak',
            default => null,
        };

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $kampanyes = $query->latest()->paginate(6)->withQueryString();

        $counts = [
            'semua' => Kampanye::withTrashed()->where('user_id', $user->id)->count(),
            'berjalan' => Kampanye::withTrashed()->where('user_id', $user->id)->where('status', 'aktif')->count(),
            'selesai' => Kampanye::withTrashed()->where('user_id', $user->id)->where('status', 'selesai')->count(),
            'menunggu' => Kampanye::withTrashed()->where('user_id', $user->id)->where('status', 'menunggu')->count(),
        ];

        $roleLabel = $this->roleLabel($user);

        return response()
            ->view('kampanye.saya', compact(
                'user',
                'kampanyes',
                'counts',
                'statusFilter',
                'roleLabel',
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Display a campaign owned by the authenticated user as preview.
     */
    public function sayaShow(string $id)
    {
        $kampanye = Kampanye::with([
            'user',
            'donasis',
            'komentars.user',
            'komentars.donasi',
        ])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return response()
            ->view('kampanye.show', compact('kampanye'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('kampanye.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->filled('jangka_waktu') && ! $request->filled('batas_tanggal')) {
            $request->merge([
                'batas_tanggal' => now()->addDays((int) $request->input('jangka_waktu'))->format('Y-m-d'),
            ]);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Bencana Alam,Pendidikan,Kesehatan,Lingkungan,Sosial',
            'lokasi' => 'nullable|string|max:255',
            'target_dana' => 'required|numeric|min:1',
            'batas_tanggal' => 'required|date',
            'gambar' => 'nullable|file|mimes:jpg,jpeg,png,mp4|max:10240',
            'nik' => 'required|digits:16',
            'foto_ktp' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_diri' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'foto_memegang_ktp' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'jenis_akun' => 'nullable|string|max:50',
            'no_hp' => 'nullable|string|max:25',
            'nama_lengkap' => 'required|string|max:255',
            'alamat' => 'nullable|string',
            'bank_penyaluran' => 'nullable|string|max:100',
            'nomor_rekening' => 'nullable|string|max:100',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['dana_terkumpul'] = 0;
        $validated['status'] = 'menunggu';

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kampanye', 'public');
        }

        if ($request->hasFile('foto_ktp')) {
            $validated['foto_ktp'] = $request->file('foto_ktp')
                ->store('ktp', 'public');
        }

        if ($request->hasFile('foto_diri')) {
            $validated['foto_diri'] = $request->file('foto_diri')
                ->store('foto-diri', 'public');
        }

        if ($request->hasFile('foto_memegang_ktp')) {
            $validated['foto_memegang_ktp'] = $request->file('foto_memegang_ktp')
                ->store('ktp', 'public');
        }

        Kampanye::create($validated);

        if (auth()->user()->role === 'donatur') {
            auth()->user()->update(['role' => 'penggalang']);
        }

        return redirect()
            ->route('kampanye.index')
            ->with('success', __('Campaign berhasil dibuat dan menunggu verifikasi admin.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kampanye = Kampanye::with([
            'user',
            'donasis',
            'komentars.user',
            'komentars.donasi',
        ])
            ->whereIn('status', ['aktif', 'selesai'])
            ->findOrFail($id);

        return response()
            ->view('kampanye.show', compact('kampanye'))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kampanye = Kampanye::findOrFail($id);

        if ($kampanye->user_id !== auth()->id()) {
            abort(403);
        }

        $user = auth()->user();
        $roleLabel = $this->roleLabel($user);

        return view('kampanye.edit', compact('kampanye', 'user', 'roleLabel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kampanye = Kampanye::findOrFail($id);

        if ($kampanye->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'kategori' => 'required|in:Bencana Alam,Pendidikan,Kesehatan,Lingkungan,Sosial',
            'lokasi' => 'nullable|string|max:255',
            'target_dana' => 'required|numeric|min:1',
            'batas_tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('kampanye', 'public');
        }

        $kampanye->update($validated);

        return redirect()
            ->route('kampanye.saya')
            ->with('success', __('Campaign berhasil diperbarui.'));
    }

    /**
     * Resolve the human-friendly role label for the sidebar.
     */
    private function roleLabel(User $user): string
    {
        return match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kampanye = Kampanye::findOrFail($id);

        if ($kampanye->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $kampanye->forceDelete();

        return redirect()
            ->route('kampanye.saya')
            ->with('success', __('Galang dana berhasil dihapus.'));
    }
}
