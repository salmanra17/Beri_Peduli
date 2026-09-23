<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BuktiController as AdminBuktiController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\KampanyeController as AdminKampanyeController;
use App\Http\Controllers\Admin\KomentarController as AdminKomentarController;
use App\Http\Controllers\Admin\ManajemenKampanyeController;
use App\Http\Controllers\Admin\PenarikanController as AdminPenarikanController;
use App\Http\Controllers\Admin\RekeningController as AdminRekeningController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\OAuthController;
use App\Http\Controllers\BuktiPenyaluranController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\KampanyeController;
use App\Http\Controllers\KomentarController;
use App\Http\Controllers\PenarikanController;
use App\Models\Kampanye;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    return redirect('/beranda');

})->name('home');

Route::get('/tentang', function () {
    return view('pages.tentang');
})->name('tentang');

// ================= BAHASA =================

Route::get('/bahasa/{locale}', function (string $locale) {
    if (! in_array($locale, ['id', 'en'], true)) {
        abort(404);
    }

    if (auth()->check()) {
        auth()->user()->update(['bahasa' => $locale]);
    }

    session(['locale' => $locale]);

    return back();
})->name('bahasa.set');

// ================= AUTH OAUTH (GOOGLE / APPLE) =================

Route::middleware('guest')->group(function () {

    Route::get('/auth/{provider}/redirect', [OAuthController::class, 'redirect'])
        ->name('auth.redirect');

    Route::get('/auth/{provider}/callback', [OAuthController::class, 'callback'])
        ->name('auth.callback');

});

// ================= BERANDA =================

Route::get('/beranda', function () {

    $kampanyeAktif = Kampanye::where('status', 'aktif')
        ->latest()
        ->take(3)
        ->get();

    return view('pages.beranda', compact(
        'kampanyeAktif'
    ));

})->name('beranda');

// ================= USER DASHBOARD =================

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

});

// ================= KAMPANYE =================

// daftar campaign (public)

Route::get('/kampanye', [KampanyeController::class, 'index'])
    ->name('kampanye.index');

// detail campaign (public)

Route::get('/kampanye/{kampanye}', [KampanyeController::class, 'show'])
    ->whereNumber('kampanye')
    ->name('kampanye.show');

// campaign user

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/kampanye/create', [KampanyeController::class, 'create'])
        ->name('kampanye.create');

    Route::post('/kampanye', [KampanyeController::class, 'store'])
        ->name('kampanye.store');

    Route::get('/kampanye/{kampanye}/edit', [KampanyeController::class, 'edit'])
        ->whereNumber('kampanye')
        ->name('kampanye.edit');

    Route::put('/kampanye/{kampanye}', [KampanyeController::class, 'update'])
        ->whereNumber('kampanye')
        ->name('kampanye.update');

    Route::delete('/kampanye/{kampanye}', [KampanyeController::class, 'destroy'])
        ->whereNumber('kampanye')
        ->name('kampanye.destroy');

    // galang dana saya

    Route::get('/galang-dana-saya', [KampanyeController::class, 'saya'])
        ->name('kampanye.saya');

    Route::get('/galang-dana-saya/{kampanye}', [KampanyeController::class, 'sayaShow'])
        ->whereNumber('kampanye')
        ->name('kampanye.saya.show');

});

// ================= DONASI =================

Route::middleware(['auth', 'verified'])->group(function () {

    // buka halaman donasi

    Route::get('/donasi/{kampanye}', [DonasiController::class, 'create'])
        ->name('donasi.create');

    // simpan donasi

    Route::post('/donasi', [DonasiController::class, 'store'])
        ->name('donasi.store');

    // riwayat donasi

    Route::get('/riwayat-donasi', [DonasiController::class, 'history'])
        ->name('donasi.history');

    // download laporan donasi

    Route::get('/riwayat-donasi/download', [DonasiController::class, 'downloadLaporan'])
        ->name('donasi.download');

});

// ================= PENARIKAN DANA =================

Route::middleware(['auth', 'verified'])->group(function () {

    // riwayat penarikan dana
    Route::get('/riwayat-penarikan', [PenarikanController::class, 'index'])
        ->name('penarikan.index');

    // simpan pengajuan penarikan dana
    Route::post('/penarikan', [PenarikanController::class, 'store'])
        ->name('penarikan.store');

});

// ================= BUKTI PENYALURAN DANA =================

Route::middleware(['auth', 'verified'])->group(function () {

    // halaman bukti penyaluran (hanya penggalang dana)
    Route::get('/bukti-penyaluran', [BuktiPenyaluranController::class, 'index'])
        ->name('bukti-penyaluran.index');

    // simpan unggahan bukti penyaluran
    Route::post('/bukti-penyaluran', [BuktiPenyaluranController::class, 'store'])
        ->name('bukti-penyaluran.store');

});

// ================= KOMENTAR =================

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/komentar', [KomentarController::class, 'store'])
        ->name('komentar.store');

});

require __DIR__.'/settings.php';

// ================= ADMIN =================

Route::prefix('admin')->group(function () {

    Route::get('/login', [AuthController::class, 'login'])
        ->name('admin.login');

    Route::post('/login', [AuthController::class, 'authenticate'])
        ->name('admin.login.submit');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('admin.logout');

    Route::middleware(['auth', 'admin'])->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');

        Route::get('/kampanye', [AdminKampanyeController::class, 'index'])
            ->name('admin.kampanye.index');

        Route::get('/kampanye/{id}', [AdminKampanyeController::class, 'show'])
            ->name('admin.kampanye.show');

        Route::patch('/kampanye/{id}/setujui', [AdminKampanyeController::class, 'approve'])
            ->name('admin.kampanye.approve');

        Route::patch('/kampanye/{id}/tolak', [AdminKampanyeController::class, 'reject'])
            ->name('admin.kampanye.reject');

        Route::get('/kampanye-kelola', [ManajemenKampanyeController::class, 'index'])
            ->name('admin.manajemen-kampanye.index');

        Route::delete('/kampanye-kelola/{id}/hapus', [ManajemenKampanyeController::class, 'destroy'])
            ->name('admin.manajemen-kampanye.hapus');

        Route::get('/rekening', [AdminRekeningController::class, 'index'])
            ->name('admin.rekening.index');

        Route::patch('/rekening/{id}/verifikasi', [AdminRekeningController::class, 'verify'])
            ->name('admin.rekening.verify');

        Route::patch('/rekening/{id}/tolak', [AdminRekeningController::class, 'reject'])
            ->name('admin.rekening.reject');

        Route::delete('/rekening/{id}/hapus', [AdminRekeningController::class, 'destroy'])
            ->name('admin.rekening.hapus');

        Route::get('/penarikan', [AdminPenarikanController::class, 'index'])
            ->name('admin.penarikan.index');

        Route::patch('/penarikan/{id}/proses', [AdminPenarikanController::class, 'proses'])
            ->name('admin.penarikan.proses');

        Route::patch('/penarikan/{id}/tolak', [AdminPenarikanController::class, 'tolak'])
            ->name('admin.penarikan.tolak');

        Route::delete('/penarikan/{id}/hapus', [AdminPenarikanController::class, 'destroy'])
            ->name('admin.penarikan.hapus');

        Route::get('/bukti', [AdminBuktiController::class, 'index'])
            ->name('admin.bukti.index');

        Route::patch('/bukti/{id}/setujui', [AdminBuktiController::class, 'setujui'])
            ->name('admin.bukti.setujui');

        Route::patch('/bukti/{id}/tolak', [AdminBuktiController::class, 'tolak'])
            ->name('admin.bukti.tolak');

        Route::delete('/bukti/{id}/hapus', [AdminBuktiController::class, 'destroy'])
            ->name('admin.bukti.hapus');

        Route::get('/user', [UserController::class, 'index'])
            ->name('admin.user.index');

        Route::patch('/user/{id}/toggle-status', [UserController::class, 'toggleStatus'])
            ->name('admin.user.toggle-status');

        Route::get('/komentar', [AdminKomentarController::class, 'index'])
            ->name('admin.komentar.index');

        Route::delete('/komentar/{id}', [AdminKomentarController::class, 'destroy'])
            ->name('admin.komentar.destroy');

    });

});
