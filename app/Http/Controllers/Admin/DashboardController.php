<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuktiPenyaluran;
use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\RekeningBank;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPengguna = User::count();
        $penggunaBaruMingguIni = User::where('created_at', '>=', now()->subDays(7))->count();

        $kampanyeAktif = Kampanye::where('status', 'aktif')->count();
        $kampanyeAktifBaruMingguIni = Kampanye::where('status', 'aktif')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $danaTerkumpul = (float) Kampanye::sum('dana_terkumpul');
        $danaTerkumpulMingguIni = (float) Kampanye::where('updated_at', '>=', now()->subDays(7))
            ->sum('dana_terkumpul');

        $kampanyeMenunggu = Kampanye::where('status', 'menunggu')->count();
        $rekeningMenunggu = RekeningBank::where('status', 'menunggu')->count();
        $penarikanDiproses = PenarikanDana::where('status', 'diproses')->count();
        $buktiMenunggu = BuktiPenyaluran::where('status', 'menunggu')->count();

        $totalMenungguVerifikasi = $kampanyeMenunggu + $rekeningMenunggu + $penarikanDiproses + $buktiMenunggu;

        $kampanyeBaru = Kampanye::with('user')
            ->where('status', 'menunggu')
            ->latest()
            ->take(3)
            ->get();

        $rekeningBaru = RekeningBank::with('user')
            ->where('status', 'menunggu')
            ->latest()
            ->take(3)
            ->get();

        $penarikanBaru = PenarikanDana::with('kampanye')
            ->where('status', 'diproses')
            ->latest()
            ->take(3)
            ->get();

        $buktiBaru = BuktiPenyaluran::with(['user', 'penarikanDana.kampanye'])
            ->where('status', 'menunggu')
            ->latest()
            ->take(3)
            ->get();

        $perluTindakan = collect()
            ->concat($kampanyeBaru->map(fn (Kampanye $kampanye) => [
                'type' => 'kampanye',
                'title' => $kampanye->judul,
                'subtitle' => 'Kampanye menunggu verifikasi',
                'waktu' => $kampanye->created_at?->diffForHumans(),
                'url_tinjau' => route('admin.kampanye.index', ['status' => 'menunggu', 'highlight' => $kampanye->id]),
                'created_at' => $kampanye->created_at,
            ]))
            ->concat($rekeningBaru->map(fn (RekeningBank $rekening) => [
                'type' => 'rekening',
                'title' => $rekening->nama_pemilik ?: ($rekening->user?->name ?? 'Rekening bank'),
                'subtitle' => 'Rekening menunggu verifikasi',
                'waktu' => $rekening->created_at?->diffForHumans(),
                'url_tinjau' => route('admin.rekening.index', ['status' => 'menunggu', 'highlight' => $rekening->id]),
                'created_at' => $rekening->created_at,
            ]))
            ->concat($penarikanBaru->map(fn (PenarikanDana $penarikan) => [
                'type' => 'penarikan',
                'title' => $penarikan->kampanye?->judul ?? 'Penarikan dana',
                'subtitle' => 'Penarikan sedang diproses',
                'waktu' => $penarikan->created_at?->diffForHumans(),
                'url_tinjau' => route('admin.penarikan.index', ['status' => 'diproses', 'highlight' => $penarikan->id]),
                'created_at' => $penarikan->created_at,
            ]))
            ->concat($buktiBaru->map(fn (BuktiPenyaluran $bukti) => [
                'type' => 'bukti',
                'title' => $bukti->penarikanDana?->kampanye?->judul ?? 'Bukti penyaluran',
                'subtitle' => 'Bukti penyaluran menunggu verifikasi',
                'waktu' => $bukti->created_at?->diffForHumans(),
                'url_tinjau' => route('admin.bukti.index', ['status' => 'menunggu', 'highlight' => $bukti->id]),
                'created_at' => $bukti->created_at,
            ]))
            ->sortByDesc('created_at')
            ->values();

        $perluTindakan = new LengthAwarePaginator(
            $perluTindakan->forPage(Paginator::resolveCurrentPage(), 5),
            $perluTindakan->count(),
            5,
            Paginator::resolveCurrentPage(),
            ['path' => Paginator::resolveCurrentPath()],
        );

        $perluTindakan->withQueryString();

        return view('admin.dashboard', compact(
            'totalPengguna',
            'penggunaBaruMingguIni',
            'kampanyeAktif',
            'kampanyeAktifBaruMingguIni',
            'danaTerkumpul',
            'danaTerkumpulMingguIni',
            'kampanyeMenunggu',
            'rekeningMenunggu',
            'penarikanDiproses',
            'buktiMenunggu',
            'totalMenungguVerifikasi',
            'perluTindakan',
        ));
    }
}
