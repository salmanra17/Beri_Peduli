<?php

use App\Models\PenarikanDana;
use App\Models\User;

test('halaman penarikan dapat dicari berdasarkan kode transaksi', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    PenarikanDana::factory()->create([
        'user_id' => $admin->id,
        'kode_transaksi' => 'WD-0001-ABCDE',
        'status' => 'diproses',
    ]);
    PenarikanDana::factory()->create([
        'user_id' => $admin->id,
        'kode_transaksi' => 'WD-0002-FGHIJ',
        'status' => 'diproses',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.penarikan.index', [
        'status' => 'diproses',
        'cari' => '0001',
    ]));

    $response->assertOk()
        ->assertSee('WD-0001-ABCDE')
        ->assertDontSee('WD-0002-FGHIJ');
});

test('pagination penarikan mempertahankan status dan kata kunci pencarian', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    foreach (range(1, 11) as $i) {
        PenarikanDana::factory()->create([
            'user_id' => $admin->id,
            'kode_transaksi' => "WD-0001-A{$i}",
            'status' => 'diproses',
        ]);
    }

    $halamanPertama = $this->actingAs($admin)->get(route('admin.penarikan.index', [
        'status' => 'diproses',
        'cari' => '0001',
    ]));

    $halamanPertama->assertOk()
        ->assertSee('Menampilkan 1–10 dari 11 pengajuan');

    $halamanDua = $this->actingAs($admin)->get(route('admin.penarikan.index', [
        'status' => 'diproses',
        'cari' => '0001',
        'page' => 2,
    ]));

    $halamanDua->assertOk()
        ->assertSee('Menampilkan 11–11 dari 11 pengajuan')
        ->assertSee('cari=0001')
        ->assertSee('status=diproses');
});

test('halaman penarikan menampilkan pesan reset saat pencarian tidak menemukan hasil', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    PenarikanDana::factory()->create([
        'user_id' => $admin->id,
        'status' => 'diproses',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.penarikan.index', [
        'status' => 'diproses',
        'cari' => 'tidakada',
    ]));

    $response->assertOk()
        ->assertSee('Tidak ada pengajuan yang cocok dengan pencarian')
        ->assertSee('Reset pencarian');
});

test('admin dapat memproses penarikan dana yang diproses', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penarikan = PenarikanDana::factory()->create([
        'user_id' => $admin->id,
        'status' => 'diproses',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.penarikan.proses', $penarikan->id));

    $response->assertRedirect(route('admin.penarikan.index', ['status' => 'berhasil']));
    $penarikan->refresh();

    expect($penarikan->status)->toBe('berhasil');
    expect($penarikan->disetujui_pada)->not->toBeNull();
});

test('admin dapat menolak penarikan dana yang diproses', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penarikan = PenarikanDana::factory()->create([
        'user_id' => $admin->id,
        'status' => 'diproses',
    ]);

    $response = $this->actingAs($admin)->patch(route('admin.penarikan.tolak', $penarikan->id));

    $response->assertRedirect(route('admin.penarikan.index', ['status' => 'ditolak']));
    expect($penarikan->fresh()->status)->toBe('ditolak');
});

test('halaman penarikan memberi highlight pada baris yang baru ditinjau', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penarikan = PenarikanDana::factory()->create([
        'user_id' => $admin->id,
        'status' => 'diproses',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.penarikan.index', [
        'status' => 'diproses',
        'highlight' => $penarikan->id,
    ]));

    $response->assertOk()
        ->assertSee("id=\"penarikan-{$penarikan->id}\"", false)
        ->assertSee('animation: penarikan-flash 2s ease-in-out 1 both;', false);
});
