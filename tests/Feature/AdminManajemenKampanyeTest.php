<?php

use App\Models\Kampanye;
use App\Models\Komentar;
use App\Models\User;

test('halaman manajemen kampanye menampilkan semua kampanye dan jumlah per status', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->count(2)->create(['status' => 'aktif']);
    Kampanye::factory()->create(['status' => 'menunggu']);
    Kampanye::factory()->create(['status' => 'selesai']);

    $response = $this->actingAs($admin)->get(route('admin.manajemen-kampanye.index'));

    $response->assertOk()
        ->assertSee('Semua (4)')
        ->assertSee('Aktif (2)')
        ->assertSee('Menunggu (1)')
        ->assertSee('Ditolak (0)')
        ->assertSee('Selesai (1)');
});

test('halaman manajemen kampanye memfilter berdasarkan status lewat query string', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->create(['judul' => 'Kampanye Aktif', 'status' => 'aktif']);
    Kampanye::factory()->create(['judul' => 'Kampanye Menunggu', 'status' => 'menunggu']);

    $response = $this->actingAs($admin)->get(route('admin.manajemen-kampanye.index', ['status' => 'aktif']));

    $response->assertOk()
        ->assertSee('Kampanye Aktif')
        ->assertDontSee('Kampanye Menunggu');
});

test('halaman manajemen kampanye dapat mencari berdasarkan judul', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->create(['judul' => 'Bantu Korban Banjir']);
    Kampanye::factory()->create(['judul' => 'Bantu Pendidikan Anak']);

    $response = $this->actingAs($admin)->get(route('admin.manajemen-kampanye.index', ['q' => 'banjir']));

    $response->assertOk()
        ->assertSee('Bantu Korban Banjir')
        ->assertDontSee('Bantu Pendidikan Anak');
});

test('admin dapat menghapus kampanye semua status, tersimpan soft delete, dan komentar ikut terhapus permanen', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $aktif = Kampanye::factory()->create(['status' => 'aktif']);
    $komentar = Komentar::factory()->create(['kampanye_id' => $aktif->id]);

    $response = $this->actingAs($admin)
        ->withHeader('referer', route('admin.manajemen-kampanye.index'))
        ->delete(route('admin.manajemen-kampanye.hapus', $aktif->id));

    $response->assertRedirect(route('admin.manajemen-kampanye.index'))
        ->assertSessionHas('success', 'Kampanye berhasil dihapus.');

    expect(Kampanye::withTrashed()->find($aktif->id)->trashed())->toBeTrue();
    expect(Komentar::find($komentar->id))->toBeNull();
});

test('pengguna selain admin tidak dapat mengakses manajemen kampanye', function () {
    $user = User::factory()->create(['role' => 'penggalang']);

    $this->actingAs($user)->get(route('admin.manajemen-kampanye.index'))->assertForbidden();
});
