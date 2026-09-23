<?php

use App\Models\Kampanye;
use App\Models\User;

test('halaman verifikasi dapat mencari kampanye berdasarkan judul', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->create([
        'judul' => 'Bantu Korban Banjir',
        'status' => 'menunggu',
    ]);
    Kampanye::factory()->create([
        'judul' => 'Bantu Pendidikan Anak',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.kampanye.index', [
        'status' => 'menunggu',
        'cari' => 'banjir',
    ]));

    $response->assertOk()
        ->assertSee('Bantu Korban Banjir')
        ->assertDontSee('Bantu Pendidikan Anak');
});

test('halaman verifikasi dapat mencari kampanye berdasarkan nama penggalang', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penggalang = User::factory()->create(['name' => 'Yayasan Harapan Kita']);
    $lainnya = User::factory()->create(['name' => 'Komunitas Peduli Sesama']);

    Kampanye::factory()->create([
        'user_id' => $penggalang->id,
        'judul' => 'Bantu Anak Yatim',
        'status' => 'menunggu',
    ]);
    Kampanye::factory()->create([
        'user_id' => $lainnya->id,
        'judul' => 'Bantu Rumah Ibadah',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.kampanye.index', [
        'status' => 'menunggu',
        'cari' => 'Harapan',
    ]));

    $response->assertOk()
        ->assertSee('Bantu Anak Yatim')
        ->assertDontSee('Bantu Rumah Ibadah');
});

test('jumlah di tab tetap total per status meskipun pencarian aktif', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->count(2)->create([
        'judul' => 'Bantu Anak Yatim',
        'status' => 'menunggu',
    ]);
    Kampanye::factory()->create(['status' => 'aktif']);

    $response = $this->actingAs($admin)->get(route('admin.kampanye.index', [
        'status' => 'menunggu',
        'cari' => 'Yatim',
    ]));

    $response->assertOk()
        ->assertSee('Menunggu (2)')
        ->assertSee('Aktif (1)')
        ->assertSee('Ditolak (0)')
        ->assertSee('Selesai (0)');
});

test('pagination kampanye mempertahankan status dan kata kunci pencarian', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->count(11)->create([
        'judul' => 'Bantu Korban Banjir',
        'status' => 'menunggu',
    ]);

    $halamanPertama = $this->actingAs($admin)->get(route('admin.kampanye.index', [
        'status' => 'menunggu',
        'cari' => 'banjir',
    ]));

    $halamanPertama->assertOk()
        ->assertSee('Menampilkan 1–10 dari 11 kampanye');

    $halamanDua = $this->actingAs($admin)->get(route('admin.kampanye.index', [
        'status' => 'menunggu',
        'cari' => 'banjir',
        'page' => 2,
    ]));

    $halamanDua->assertOk()
        ->assertSee('Menampilkan 11–11 dari 11 kampanye')
        ->assertSee('cari=banjir')
        ->assertSee('status=menunggu');
});

test('halaman verifikasi menampilkan pesan reset saat pencarian tidak menemukan hasil', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->create([
        'judul' => 'Bantu Anak Yatim',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.kampanye.index', [
        'status' => 'menunggu',
        'cari' => 'tidakada',
    ]));

    $response->assertOk()
        ->assertSee('Tidak ada kampanye yang cocok dengan pencarian')
        ->assertSee('Reset pencarian');
});
