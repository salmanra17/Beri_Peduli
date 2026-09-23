<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function () {
    Route::get('/pengaturan-akun', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/pengaturan-akun', [ProfileController::class, 'update'])->name('profile.update');

    Route::get('/pengaturan-akun/keamanan', [ProfileController::class, 'security'])->name('profile.security');
    Route::put('/pengaturan-akun/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::delete('/pengaturan-akun/sesi', [ProfileController::class, 'destroyOtherSessions'])->name('profile.sessions.destroy');

    Route::get('/pengaturan-akun/rekening', [ProfileController::class, 'rekeningBank'])->name('profile.rekening');
    Route::post('/pengaturan-akun/rekening', [ProfileController::class, 'storeRekeningBank'])->name('profile.rekening.store');
    Route::put('/pengaturan-akun/rekening/{rekeningBank}', [ProfileController::class, 'updateRekeningBank'])->name('profile.rekening.update');
    Route::patch('/pengaturan-akun/rekening/{rekeningBank}/utama', [ProfileController::class, 'setUtamaRekeningBank'])->name('profile.rekening.utama');
    Route::delete('/pengaturan-akun/rekening/{rekeningBank}', [ProfileController::class, 'destroyRekeningBank'])->name('profile.rekening.destroy');

    Route::redirect('settings', '/pengaturan-akun');
    Route::redirect('settings/profile', '/pengaturan-akun');
});
