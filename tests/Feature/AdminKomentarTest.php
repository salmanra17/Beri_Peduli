<?php

use App\Models\Kampanye;
use App\Models\Komentar;
use App\Models\User;
use Database\Factories\KomentarFactory;

test('halaman moderasi komentar menampilkan daftar komentar dengan penulis dan kampanye', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penggalang = User::factory()->create(['role' => 'penggalang', 'name' => 'Budi Sanggalang']);
    $kampanye = Kampanye::factory()->create(['judul' => 'Bantu Anak Yatim']);
    KomentarFactory::new()->create([
        'user_id' => $penggalang->id,
        'kampanye_id' => $kampanye->id,
        'pesan' => 'Semangat untuk para penggalang dana!',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.komentar.index'));

    $response->assertOk()
        ->assertSee('Semangat untuk para penggalang dana!')
        ->assertSee('Budi Sanggalang')
        ->assertSee('pada kampanye Bantu Anak Yatim');
});

test('komentar anonim menampilkan Anonim dan menyembunyikan nama asli', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['name' => 'Nama Rahasia']);
    $kampanye = Kampanye::factory()->create();
    KomentarFactory::new()->anonim()->create([
        'user_id' => $user->id,
        'kampanye_id' => $kampanye->id,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.komentar.index'));

    $response->assertOk()
        ->assertSee('Anonim')
        ->assertDontSee('Nama Rahasia');
});

test('moderasi komentar dapat mencari berdasarkan isi pesan', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kampanye = Kampanye::factory()->create();

    KomentarFactory::new()->create(['kampanye_id' => $kampanye->id, 'pesan' => 'Komentar tentang bantuan banjir']);
    KomentarFactory::new()->create(['kampanye_id' => $kampanye->id, 'pesan' => 'Komentar tentang pendidikan']);

    $response = $this->actingAs($admin)->get(route('admin.komentar.index', ['q' => 'banjir']));

    $response->assertOk()
        ->assertSee('bantuan banjir')
        ->assertDontSee('pendidikan');
});

test('moderasi komentar dapat mencari berdasarkan nama kampanye', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $kampanye1 = Kampanye::factory()->create(['judul' => 'Bantuan Korban Banjir Bandung']);
    $kampanye2 = Kampanye::factory()->create(['judul' => 'Beasiswa Anak Sekolah']);

    KomentarFactory::new()->create(['kampanye_id' => $kampanye1->id]);
    KomentarFactory::new()->create(['kampanye_id' => $kampanye2->id]);

    $response = $this->actingAs($admin)->get(route('admin.komentar.index', ['q' => 'Banjir Bandung']));

    $response->assertOk()
        ->assertSee('Bantuan Korban Banjir Bandung')
        ->assertDontSee('Beasiswa Anak Sekolah');
});

test('moderasi komentar menampilkan pesan kosong jika tidak ada hasil', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.komentar.index'));

    $response->assertOk()
        ->assertSee('Tidak ada komentar ditemukan.');
});

test('pagination moderasi komentar mempertahankan kata kunci', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kampanye = Kampanye::factory()->create(['judul' => 'Bantu Warga Terdampak']);

    KomentarFactory::new()->count(16)->create(['kampanye_id' => $kampanye->id, 'pesan' => 'Dukungan untuk warga']);

    $response = $this->actingAs($admin)->get(route('admin.komentar.index', ['q' => 'warga', 'page' => 2]));

    $response->assertOk()
        ->assertSee('Menampilkan 16–16 dari 16 komentar')
        ->assertSee('q=warga');
});

test('admin dapat menghapus komentar secara permanen', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $komentar = KomentarFactory::new()->create();

    $response = $this->actingAs($admin)
        ->withHeader('referer', route('admin.komentar.index'))
        ->delete(route('admin.komentar.destroy', $komentar->id));

    $response->assertRedirect(route('admin.komentar.index'))
        ->assertSessionHas('success', 'Komentar berhasil dihapus.');

    expect(Komentar::find($komentar->id))->toBeNull();
});

test('user non admin tidak bisa mengakses moderasi komentar', function () {
    $user = User::factory()->create(['role' => 'penggalang']);

    $this->actingAs($user)->get(route('admin.komentar.index'))->assertForbidden();
    $this->actingAs($user)->delete(route('admin.komentar.destroy', 1))->assertForbidden();
});
