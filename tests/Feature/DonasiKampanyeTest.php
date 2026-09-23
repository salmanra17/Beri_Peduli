<?php

use App\Models\Donasi;
use App\Models\Kampanye;
use App\Models\Komentar;
use App\Models\User;

test('donasi menandai kampanye selesai saat target tercapai', function () {
    $donor = User::factory()->create();
    $kampanye = Kampanye::factory()->create([
        'target_dana' => 1_000_000,
        'dana_terkumpul' => 950_000,
    ]);

    $response = $this->actingAs($donor)->post(route('donasi.store'), [
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 100_000,
        'metode_pembayaran' => 'QRIS',
    ]);

    $response->assertRedirect(route('kampanye.show', $kampanye->id));

    $kampanye->refresh();
    expect($kampanye->status)->toBe('selesai');
    expect((int) $kampanye->dana_terkumpul)->toBe(1_050_000);
});

test('donasi ditolak untuk kampanye yang sudah selesai', function () {
    $donor = User::factory()->create();
    $kampanye = Kampanye::factory()->selesai()->create();

    $response = $this->actingAs($donor)->post(route('donasi.store'), [
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 100_000,
        'metode_pembayaran' => 'QRIS',
    ]);

    $response->assertSessionHas('error');
    $this->assertDatabaseCount('donasis', 0);
    expect($kampanye->fresh()->status)->toBe('selesai');
});

test('halaman donasi diblokir untuk kampanye yang sudah selesai', function () {
    $donor = User::factory()->create();
    $kampanye = Kampanye::factory()->selesai()->create();

    $response = $this->actingAs($donor)->get(route('donasi.create', $kampanye->id));

    $response->assertSessionHas('error');
});

test('halaman detail kampanye yang selesai tetap bisa diakses', function () {
    $kampanye = Kampanye::factory()->selesai()->create();

    $response = $this->get(route('kampanye.show', $kampanye->id));

    $response->assertOk()
        ->assertSee('Kampanye Selesai');
});

test('daftar kampanye menampilkan kampanye yang sudah selesai dan filter status berfungsi', function () {
    Kampanye::factory()->create(['judul' => 'Kampanye Aktif Uji']);
    Kampanye::factory()->selesai()->create(['judul' => 'Kampanye Selesai Uji']);

    $response = $this->get(route('kampanye.index'));
    $response->assertOk()
        ->assertSee('Kampanye Aktif Uji')
        ->assertSee('Kampanye Selesai Uji');

    $filtered = $this->get(route('kampanye.index', ['status' => 'Selesai']));
    $filtered->assertOk()
        ->assertSee('Kampanye Selesai Uji')
        ->assertDontSee('Kampanye Aktif Uji');
});

test('komentar menampilkan jumlah donasi dari user yang berkomentar', function () {
    $donor = User::factory()->create();
    $kampanye = Kampanye::factory()->create();

    $donasi = Donasi::factory()->create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 50_000,
    ]);

    Komentar::create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'donasi_id' => $donasi->id,
        'pesan' => 'Semoga lekas pulih!',
        'anonim' => false,
    ]);

    $response = $this->get(route('kampanye.show', $kampanye->id));

    $response->assertOk()
        ->assertSee('Berdonasi Rp 50.000');
});

test('dua donasi berbeda menampilkan nominal donasi masing-masing, bukan totalnya', function () {
    $donor = User::factory()->create(['name' => 'Salma']);
    $kampanye = Kampanye::factory()->create();

    $donasiPertama = Donasi::factory()->create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 5_000_000,
    ]);

    Komentar::create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'donasi_id' => $donasiPertama->id,
        'pesan' => 'Donasi pertama.',
        'anonim' => false,
    ]);

    $donasiKedua = Donasi::factory()->create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 2_000_000,
    ]);

    Komentar::create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'donasi_id' => $donasiKedua->id,
        'pesan' => 'Donasi kedua.',
        'anonim' => true,
    ]);

    $response = $this->get(route('kampanye.show', $kampanye->id));

    $response->assertOk()
        ->assertSee('Berdonasi Rp 5.000.000')
        ->assertSee('Berdonasi Rp 2.000.000')
        ->assertDontSee('Berdonasi Rp 7.000.000');
});

test('komentar anonim menampilkan jumlah donasi dengan nama yang dimasking', function () {
    $donor = User::factory()->create(['name' => 'Salma']);
    $kampanye = Kampanye::factory()->create();

    $donasi = Donasi::factory()->create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 50_000,
    ]);

    Komentar::create([
        'user_id' => $donor->id,
        'kampanye_id' => $kampanye->id,
        'donasi_id' => $donasi->id,
        'pesan' => 'Doa terbaik untuk kalian.',
        'anonim' => true,
    ]);

    $response = $this->get(route('kampanye.show', $kampanye->id));

    $response->assertOk()
        ->assertSee('Berdonasi Rp 50.000')
        ->assertSee('S****')
        ->assertDontSee('Salma')
        ->assertDontSee('Anonymous');
});

test('donasi tanpa komentar tidak memunculkan komentar kosong', function () {
    $donor = User::factory()->create();
    $kampanye = Kampanye::factory()->create();

    $this->actingAs($donor)->post(route('donasi.store'), [
        'kampanye_id' => $kampanye->id,
        'jumlah_donasi' => 100_000,
        'metode_pembayaran' => 'QRIS',
        'pesan' => '   ',
    ]);

    $this->assertDatabaseCount('komentars', 0);
    expect((int) $kampanye->fresh()->dana_terkumpul)->toBe(100_000);
});
