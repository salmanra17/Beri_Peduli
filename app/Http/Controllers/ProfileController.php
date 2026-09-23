<?php

namespace App\Http\Controllers;

use App\Models\RekeningBank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman pengaturan akun (Profil Personal).
     */
    public function edit(): View
    {
        $user = Auth::user();

        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        return view('profile.edit', compact('user', 'roleLabel'));
    }

    /**
     * Perbarui data profil personal pengguna.
     */
    public function update(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'nama_depan' => ['nullable', 'string', 'max:100'],
            'nama_belakang' => ['nullable', 'string', 'max:100'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'no_hp' => ['nullable', 'string', 'max:25'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'provinsi' => ['nullable', 'string', 'max:100'],
            'kota' => ['nullable', 'string', 'max:100'],
            'kode_pos' => ['nullable', 'string', 'max:10'],
            'foto_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'hapus_foto' => ['nullable', 'boolean'],
            'bahasa' => ['nullable', 'string', 'in:id,en'],
        ]);

        // Hapus foto jika diminta
        if ($request->boolean('hapus_foto')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $user->foto_profil = null;
        }

        // Upload foto profil baru jika ada
        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil && Storage::disk('public')->exists($user->foto_profil)) {
                Storage::disk('public')->delete($user->foto_profil);
            }

            $path = $request->file('foto_profil')->store('foto-profil', 'public');
            $user->foto_profil = $path;
        }

        // Sinkronisasi nama depan & belakang ke kolom name
        $namaDepan = $validated['nama_depan'] ?? null;
        $namaBelakang = $validated['nama_belakang'] ?? null;
        $namaGabungan = trim(($namaDepan ?? '').' '.($namaBelakang ?? ''));

        if ($namaGabungan !== '') {
            $user->name = $namaGabungan;
        }

        $user->nama_depan = $namaDepan;
        $user->nama_belakang = $namaBelakang;
        $user->email = $validated['email'];
        $user->no_hp = $validated['no_hp'] ?? null;
        $user->tanggal_lahir = $validated['tanggal_lahir'] ?? null;
        $user->alamat = $validated['alamat'] ?? null;
        $user->provinsi = $validated['provinsi'] ?? null;
        $user->kota = $validated['kota'] ?? null;
        $user->kode_pos = $validated['kode_pos'] ?? null;

        if (isset($validated['bahasa'])) {
            $user->bahasa = $validated['bahasa'];
        }

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()
            ->route('profile.edit')
            ->with('success', __('Profil personal berhasil diperbarui!'));
    }

    /**
     * Tampilkan halaman keamanan & password beserta sesi aktif.
     */
    public function security(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        $currentSessionId = session()->getId();

        // Ambil semua sesi aktif milik user dari tabel sessions
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderByDesc('last_activity')
            ->get()
            ->map(function (object $session) use ($currentSessionId): object {
                $agent = $session->user_agent ?? '';

                // Deteksi browser dari user-agent
                $browser = 'Browser Tidak Dikenal';
                if (str_contains($agent, 'Edg')) {
                    $browser = 'Microsoft Edge';
                } elseif (str_contains($agent, 'Chrome')) {
                    $browser = 'Chrome';
                } elseif (str_contains($agent, 'Firefox')) {
                    $browser = 'Firefox';
                } elseif (str_contains($agent, 'Safari')) {
                    $browser = 'Safari';
                } elseif (str_contains($agent, 'OPR') || str_contains($agent, 'Opera')) {
                    $browser = 'Opera';
                }

                // Deteksi OS / platform dari user-agent
                $platform = 'Perangkat Tidak Dikenal';
                if (str_contains($agent, 'iPhone')) {
                    $platform = 'iPhone';
                } elseif (str_contains($agent, 'iPad')) {
                    $platform = 'iPad';
                } elseif (str_contains($agent, 'Android')) {
                    $platform = 'Android';
                } elseif (str_contains($agent, 'Windows')) {
                    $platform = 'Windows';
                } elseif (str_contains($agent, 'Macintosh') || str_contains($agent, 'Mac OS')) {
                    $platform = 'Mac OS';
                } elseif (str_contains($agent, 'Linux')) {
                    $platform = 'Linux';
                }

                $isMobile = str_contains($agent, 'Mobile')
                    || str_contains($agent, 'Android')
                    || str_contains($agent, 'iPhone')
                    || str_contains($agent, 'iPad');

                return (object) [
                    'id' => $session->id,
                    'browser' => $browser,
                    'platform' => $platform,
                    'ip_address' => $session->ip_address ?? '—',
                    'last_activity' => Carbon::createFromTimestamp($session->last_activity),
                    'is_current' => $session->id === $currentSessionId,
                    'is_mobile' => $isMobile,
                ];
            });

        return view('profile.security', compact('user', 'roleLabel', 'sessions'));
    }

    /**
     * Perbarui password pengguna.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.current_password' => __('Password saat ini tidak sesuai.'),
            'password.min' => __('Password baru minimal 8 karakter.'),
            'password.confirmed' => __('Konfirmasi password baru tidak cocok.'),
        ]);

        $user->password = bcrypt($request->string('password'));
        $user->save();

        return redirect()
            ->route('profile.security')
            ->with('success', __('Password berhasil diperbarui!'));
    }

    /**
     * Keluarkan semua sesi lain kecuali sesi saat ini.
     */
    public function destroyOtherSessions(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'password' => ['required', 'string', 'current_password'],
        ], [
            'password.current_password' => __('Password tidak sesuai.'),
        ]);

        $currentSessionId = session()->getId();

        DB::table('sessions')
            ->where('user_id', $user->id)
            ->where('id', '!=', $currentSessionId)
            ->delete();

        return redirect()
            ->route('profile.security')
            ->with('success', __('Semua sesi lain berhasil diakhiri!'));
    }

    /**
     * Tampilkan halaman rekening bank.
     */
    public function rekeningBank(): View
    {
        /** @var User $user */
        $user = Auth::user();

        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        $rekenings = RekeningBank::where('user_id', $user->id)
            ->orderByDesc('is_utama')
            ->latest()
            ->get();

        if ($rekenings->isNotEmpty() && ! $rekenings->contains('is_utama', true)) {
            $first = $rekenings->first();
            $first?->update(['is_utama' => true]);
            if ($first !== null) {
                $first->is_utama = true;
            }
        }

        $bankList = [
            'BCA', 'Mandiri', 'BNI', 'BRI', 'CIMB Niaga', 'Danamon',
            'Permata', 'Panin', 'BTN', 'Maybank', 'OCBC NISP', 'BSI',
            'Bank Jago', 'Jenius (BTPN)', 'Neo Commerce', 'Allo Bank',
        ];

        return view('profile.rekening', compact('user', 'roleLabel', 'rekenings', 'bankList'));
    }

    /**
     * Simpan rekening bank baru.
     */
    public function storeRekeningBank(Request $request): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'nama_bank' => ['required', 'string', 'max:100'],
            'nomor_rekening' => ['required', 'string', 'max:50'],
            'nama_pemilik' => ['required', 'string', 'max:150'],
        ], [
            'nama_bank.required' => __('Nama bank wajib dipilih.'),
            'nomor_rekening.required' => __('Nomor rekening wajib diisi.'),
            'nama_pemilik.required' => __('Nama pemilik rekening wajib diisi.'),
        ]);

        $hasRekening = RekeningBank::where('user_id', $user->id)->exists();

        RekeningBank::create([
            'user_id' => $user->id,
            'nama_bank' => $request->string('nama_bank'),
            'nomor_rekening' => $request->string('nomor_rekening'),
            'nama_pemilik' => $request->string('nama_pemilik'),
            'status' => 'menunggu',
            'is_utama' => ! $hasRekening,
        ]);

        return redirect()
            ->route('profile.rekening')
            ->with('success', __('Rekening bank berhasil ditambahkan dan sedang menunggu verifikasi.'));
    }

    /**
     * Perbarui rekening bank milik user.
     */
    public function updateRekeningBank(Request $request, RekeningBank $rekeningBank): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($rekeningBank->user_id === $user->id, 403);

        $request->validate([
            'nama_bank' => ['required', 'string', 'max:100'],
            'nomor_rekening' => ['required', 'string', 'max:50'],
            'nama_pemilik' => ['required', 'string', 'max:150'],
        ], [
            'nama_bank.required' => __('Nama bank wajib dipilih.'),
            'nomor_rekening.required' => __('Nomor rekening wajib diisi.'),
            'nama_pemilik.required' => __('Nama pemilik rekening wajib diisi.'),
        ]);

        $rekeningBank->update([
            'nama_bank' => $request->string('nama_bank'),
            'nomor_rekening' => $request->string('nomor_rekening'),
            'nama_pemilik' => $request->string('nama_pemilik'),
            'status' => 'menunggu',
        ]);

        return redirect()
            ->route('profile.rekening')
            ->with('success', __('Rekening bank berhasil diperbarui dan sedang menunggu verifikasi ulang.'));
    }

    /**
     * Jadikan rekening bank sebagai rekening utama.
     */
    public function setUtamaRekeningBank(RekeningBank $rekeningBank): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($rekeningBank->user_id === $user->id, 403);

        RekeningBank::where('user_id', $user->id)->update(['is_utama' => false]);
        $rekeningBank->update(['is_utama' => true]);

        return redirect()
            ->route('profile.rekening')
            ->with('success', __('Rekening :bank berhasil dijadikan sebagai rekening utama.', ['bank' => strtoupper($rekeningBank->nama_bank)]));
    }

    /**
     * Hapus rekening bank milik user.
     */
    public function destroyRekeningBank(RekeningBank $rekeningBank): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        abort_unless($rekeningBank->user_id === $user->id, 403);

        $wasUtama = $rekeningBank->is_utama;
        $rekeningBank->delete();

        if ($wasUtama) {
            $next = RekeningBank::where('user_id', $user->id)->latest()->first();
            $next?->update(['is_utama' => true]);
        }

        return redirect()
            ->route('profile.rekening')
            ->with('success', __('Rekening bank berhasil dihapus.'));
    }
}
