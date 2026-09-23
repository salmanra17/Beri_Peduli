<?php

use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\User;

test('guests are redirected from riwayat penarikan to login', function () {
    $response = $this->get(route('penarikan.index'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can access riwayat penarikan page', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('penarikan.index'));
    $response->assertOk();
    $response->assertSee('Riwayat Penarikan Dana');
    $response->assertSee('NAMA CAMPAIGN');
    $response->assertSee('Cari Transaksi');
});

test('riwayat penarikan page shows real records and filters by status', function () {
    $user = User::factory()->create();

    PenarikanDana::create([
        'user_id' => $user->id,
        'kode_transaksi' => 'WD-TEST-001',
        'jumlah' => 5000000,
        'bank_tujuan' => 'BCA',
        'nomor_rekening' => '8820124589',
        'nama_pemilik_rekening' => 'Ahmad Subarjo',
        'status' => 'berhasil',
    ]);

    PenarikanDana::create([
        'user_id' => $user->id,
        'kode_transaksi' => 'WD-TEST-002',
        'jumlah' => 10000000,
        'bank_tujuan' => 'BNI',
        'nomor_rekening' => '0987116521',
        'nama_pemilik_rekening' => 'Ahmad Subarjo',
        'status' => 'ditolak',
        'alasan_penolakan' => 'Dokumen tidak valid',
    ]);

    $this->actingAs($user);

    // Test default view
    $response = $this->get(route('penarikan.index'));
    $response->assertOk();
    $response->assertSee('5.000.000');
    $response->assertSee('BERHASIL');
    $response->assertSee('DITOLAK');
    $response->assertSee('Alasan');

    // Test filter status ditolak
    $responseFiltered = $this->get(route('penarikan.index', ['status' => 'ditolak']));
    $responseFiltered->assertOk();
    $responseFiltered->assertSee('10.000.000');
    $responseFiltered->assertDontSee('5.000.000');
});

test('user can submit penarikan dana request successfully', function () {
    $user = User::factory()->create();
    $kampanye = Kampanye::factory()->create([
        'user_id' => $user->id,
        'status' => 'selesai',
        'target_dana' => 10000000,
        'dana_terkumpul' => 10000000,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('penarikan.store'), [
        'kampanye_id' => $kampanye->id,
        'jumlah' => '5.000.000',
        'bank_tujuan' => 'BCA',
        'nomor_rekening' => '8820192831',
        'nama_pemilik_rekening' => 'Budi Santoso',
        'catatan' => 'Pembelian pipa PVC dan perlengkapan',
    ]);

    $response->assertRedirect(route('penarikan.index'));
    $response->assertSessionHas('success');

    $this->assertDatabaseHas('penarikan_danas', [
        'user_id' => $user->id,
        'kampanye_id' => $kampanye->id,
        'jumlah' => 5000000,
        'bank_tujuan' => 'BCA',
        'nomor_rekening' => '8820192831',
        'nama_pemilik_rekening' => 'Budi Santoso',
        'status' => 'diproses',
        'catatan' => 'Pembelian pipa PVC dan perlengkapan',
    ]);
});

test('penarikan dana fails if nominal exceeds available balance', function () {
    $user = User::factory()->create();
    $kampanye = Kampanye::factory()->create([
        'user_id' => $user->id,
        'status' => 'selesai',
        'target_dana' => 1000000,
        'dana_terkumpul' => 500000,
    ]);

    $this->actingAs($user);

    $response = $this->post(route('penarikan.store'), [
        'kampanye_id' => $kampanye->id,
        'jumlah' => '1.000.000',
        'bank_tujuan' => 'BCA',
        'nomor_rekening' => '8820192831',
        'nama_pemilik_rekening' => 'Budi Santoso',
    ]);

    $response->assertSessionHasErrors('jumlah');
    $this->assertDatabaseMissing('penarikan_danas', [
        'kampanye_id' => $kampanye->id,
    ]);
});
