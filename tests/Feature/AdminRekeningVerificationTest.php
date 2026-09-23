<?php

use App\Models\RekeningBank;
use App\Models\User;

test('halaman verifikasi rekening dapat dicari berdasarkan nama bank atau nama pemilik', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik' => 'Budi Santoso',
        'status' => 'menunggu',
    ]);
    RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BNI',
        'nomor_rekening' => '0987654321',
        'nama_pemilik' => 'Ani Wijaya',
        'status' => 'menunggu',
    ]);

    $responseBank = $this->actingAs($admin)->get(route('admin.rekening.index', [
        'status' => 'menunggu',
        'cari' => 'BCA',
    ]));

    $responseBank->assertOk()
        ->assertSee('Budi Santoso')
        ->assertDontSee('Ani Wijaya');

    $responsePemilik = $this->actingAs($admin)->get(route('admin.rekening.index', [
        'status' => 'menunggu',
        'cari' => 'Ani',
    ]));

    $responsePemilik->assertOk()
        ->assertSee('Ani Wijaya')
        ->assertDontSee('Budi Santoso');
});

test('pagination rekening mempertahankan status dan kata kunci pencarian', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    foreach (range(1, 11) as $i) {
        RekeningBank::create([
            'user_id' => $admin->id,
            'nama_bank' => "BCA $i",
            'nomor_rekening' => "1234$i",
            'nama_pemilik' => "Pemilik $i",
            'status' => 'menunggu',
        ]);
    }

    $halamanPertama = $this->actingAs($admin)->get(route('admin.rekening.index', [
        'status' => 'menunggu',
        'cari' => 'BCA',
    ]));

    $halamanPertama->assertOk()
        ->assertSee('Menampilkan 1–10 dari 11 rekening');

    $halamanDua = $this->actingAs($admin)->get(route('admin.rekening.index', [
        'status' => 'menunggu',
        'cari' => 'BCA',
        'page' => 2,
    ]));

    $halamanDua->assertOk()
        ->assertSee('Menampilkan 11–11 dari 11 rekening')
        ->assertSee('cari=BCA')
        ->assertSee('status=menunggu');
});

test('halaman verifikasi rekening menampilkan pesan reset saat pencarian tidak menemukan hasil', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik' => 'Budi Santoso',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.rekening.index', [
        'status' => 'menunggu',
        'cari' => 'tidakada',
    ]));

    $response->assertOk()
        ->assertSee('Tidak ada rekening yang cocok dengan pencarian')
        ->assertSee('Reset pencarian');
});

test('admin dapat memverifikasi rekening yang menunggu', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $rekening = RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik' => 'Budi Santoso',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.rekening.verify', $rekening->id));

    $response->assertRedirect(route('admin.rekening.index', ['status' => 'terverifikasi']));
    expect($rekening->fresh()->status)->toBe('terverifikasi');
});

test('admin dapat menolak rekening yang menunggu', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $rekening = RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik' => 'Budi Santoso',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.rekening.reject', $rekening->id));

    $response->assertRedirect(route('admin.rekening.index', ['status' => 'ditolak']));
    expect($rekening->fresh()->status)->toBe('ditolak');
});

test('halaman verifikasi rekening memberi highlight pada baris yang baru ditinjau', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $rekening = RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik' => 'Budi Santoso',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.rekening.index', [
        'status' => 'menunggu',
        'highlight' => $rekening->id,
    ]));

    $response->assertOk()
        ->assertSee("id=\"rekening-{$rekening->id}\"", false)
        ->assertSee('animation: rekening-flash 2s ease-in-out 1 both;', false);
});
