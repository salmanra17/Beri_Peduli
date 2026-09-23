<?php

use App\Models\Kampanye;
use App\Models\User;

test('guest is redirected from galang dana saya page', function () {
    $this->get(route('kampanye.saya'))
        ->assertRedirect(route('login'));
});

test('halaman galang dana saya hanya menampilkan campaign milik user yang login', function () {
    $user = User::factory()->create();
    $userLain = User::factory()->create();

    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Campaign Milik Saya']);
    Kampanye::factory()->create(['user_id' => $userLain->id, 'judul' => 'Campaign Orang Lain']);

    $this->actingAs($user)
        ->get(route('kampanye.saya'))
        ->assertOk()
        ->assertSee('Campaign Milik Saya')
        ->assertDontSee('Campaign Orang Lain');
});

test('pencarian menyaring campaign berdasarkan judul', function () {
    $user = User::factory()->create();

    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Bantu Korban Banjir']);
    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Renovasi Masjid Desa']);

    $this->actingAs($user)
        ->get(route('kampanye.saya', ['search' => 'Banjir']))
        ->assertOk()
        ->assertSee('Bantu Korban Banjir')
        ->assertDontSee('Renovasi Masjid Desa');
});

test('filter tab sedang berjalan hanya menampilkan campaign berstatus aktif', function () {
    $user = User::factory()->create();

    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Campaign Aktif', 'status' => 'aktif']);
    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Campaign Selesai', 'status' => 'selesai']);

    $this->actingAs($user)
        ->get(route('kampanye.saya', ['status' => 'berjalan']))
        ->assertOk()
        ->assertSee('Campaign Aktif')
        ->assertDontSee('Campaign Selesai');
});

test('filter dropdown status sama dengan tab status', function () {
    $user = User::factory()->create();

    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Campaign Menunggu', 'status' => 'menunggu']);
    Kampanye::factory()->create(['user_id' => $user->id, 'judul' => 'Campaign Aktif', 'status' => 'aktif']);

    $this->actingAs($user)
        ->get(route('kampanye.saya', ['status' => 'menunggu']))
        ->assertOk()
        ->assertSee('Campaign Menunggu')
        ->assertDontSee('Campaign Aktif');
});

test('tab menampilkan jumlah campaign per status', function () {
    $user = User::factory()->create();

    Kampanye::factory()->create(['user_id' => $user->id, 'status' => 'aktif']);
    Kampanye::factory()->create(['user_id' => $user->id, 'status' => 'aktif']);
    Kampanye::factory()->create(['user_id' => $user->id, 'status' => 'selesai']);

    $this->actingAs($user)
        ->get(route('kampanye.saya'))
        ->assertOk()
        ->assertSee('Galang Dana Saya');
});

test('halaman galang dana saya melakukan pagination data campaign', function () {
    $user = User::factory()->create();

    $last = null;

    foreach (range(1, 7) as $i) {
        $last = Kampanye::factory()->create([
            'user_id' => $user->id,
            'judul' => 'Campaign Pagination '.$i,
        ]);
    }

    $this->actingAs($user)
        ->get(route('kampanye.saya', ['page' => 2]))
        ->assertOk()
        ->assertSee($last->judul);
});

test('pengguna dapat melihat detail campaign miliknya walau status masih menunggu', function () {
    $user = User::factory()->create();

    $kampanye = Kampanye::factory()->create([
        'user_id' => $user->id,
        'status' => 'menunggu',
        'judul' => 'Campaign Preview Sendiri',
    ]);

    $this->actingAs($user)
        ->get(route('kampanye.saya.show', $kampanye->id))
        ->assertOk()
        ->assertSee('Campaign Preview Sendiri');
});

test('pengguna tidak dapat melihat detail campaign milik orang lain', function () {
    $user = User::factory()->create();
    $userLain = User::factory()->create();

    $kampanye = Kampanye::factory()->create(['user_id' => $userLain->id]);

    $this->actingAs($user)
        ->get(route('kampanye.saya.show', $kampanye->id))
        ->assertNotFound();
});

test('dropdown status mencerminkan status tab yang aktif', function () {
    $user = User::factory()->create();

    Kampanye::factory()->create(['user_id' => $user->id, 'status' => 'selesai']);

    $this->actingAs($user)
        ->get(route('kampanye.saya', ['status' => 'selesai']))
        ->assertOk()
        ->assertSee('<option value="selesai" selected>', false)
        ->assertDontSee('<option value="berjalan" selected>', false);
});
