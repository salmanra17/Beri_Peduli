<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\Kampanye;
use App\Models\PenarikanDana;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // FORMATTER ANGKA RINGKAS (Rp 25,7 Jt / Rp 1,2 M) -- dipakai di kartu ringkasan
        $fmtRingkas = static function (float $n): string {
            $n = round($n);
            $neg = $n < 0 ? '-' : '';
            $n = abs($n);

            $satuan = [
                1_000_000_000_000 => 'T',
                1_000_000_000 => 'M',
                1_000_000 => 'Jt',
                1_000 => 'rb',
            ];

            foreach ($satuan as $pembagi => $label) {
                if ($n >= $pembagi) {
                    $num = $n / $pembagi;

                    return $neg.($num >= 100
                        ? number_format($num, 0, ',', '.')
                        : number_format($num, 1, ',', '.')).' '.$label;
                }
            }

            return $neg.number_format($n, 0, ',', '.');
        };

        // TOTAL JUMLAH DONASI (semua donasi milik user)
        $totalDonasi = (float) Donasi::where('user_id', $user->id)
            ->sum('jumlah_donasi');

        // DONASI BULAN INI vs BULAN LALU (untuk badge "Naik %")
        $donasiBulanIni = (float) Donasi::where('user_id', $user->id)
            ->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('jumlah_donasi');

        $donasiBulanLalu = (float) Donasi::where('user_id', $user->id)
            ->whereBetween('created_at', [
                now()->subMonth()->startOfMonth(),
                now()->subMonth()->endOfMonth(),
            ])
            ->sum('jumlah_donasi');

        $naikBulanIni = null;

        if ($donasiBulanLalu > 0) {
            $naikBulanIni = round((($donasiBulanIni - $donasiBulanLalu) / $donasiBulanLalu) * 100);
        }

        // JUMLAH GALANG DANA AKTIF
        $galangDanaAktif = Kampanye::where('user_id', $user->id)
            ->where('status', 'aktif')
            ->count();

        // RIWAYAT DONASI TERBARU (5)
        $riwayatDonasi = Donasi::with('kampanye')
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        // TOTAL PENARIKAN — dihitung dari penarikan dana berhasil & diproses
        $totalPenarikan = (float) PenarikanDana::where('user_id', $user->id)
            ->where('status', 'berhasil')
            ->sum('jumlah');
        $penarikanDiproses = (int) PenarikanDana::where('user_id', $user->id)
            ->where('status', 'diproses')
            ->count();

        $roleLabel = match ($user->role) {
            'admin' => __('Administrator'),
            'penggalang' => __('Penggalang Dana'),
            default => __('Relawan Kemanusiaan'),
        };

        return response()
            ->view('dashboard', compact(
                'user',
                'totalDonasi',
                'donasiBulanIni',
                'donasiBulanLalu',
                'naikBulanIni',
                'galangDanaAktif',
                'riwayatDonasi',
                'totalPenarikan',
                'penarikanDiproses',
                'roleLabel',
            ))
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
    }
}
