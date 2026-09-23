<?php

use App\Models\Kampanye;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('tamu diarahkan ke halaman login saat mengakses halaman edit kampanye', function () {
    $kampanye = Kampanye::factory()->create();

    $this->get(route('kampanye.edit', $kampanye->id))
        ->assertRedirect(route('login'));
});

test('pemilik kampanye melihat form terisi data lama di halaman edit', function () {
    $user = User::factory()->create(['name' => 'Akun Pemilik']);
    $kampanye = Kampanye::factory()->create([
        'user_id' => $user->id,
        'judul' => 'Judul Kampanye Lama',
        'kategori' => 'Pendidikan',
    ]);

    $response = $this->actingAs($user)->get(route('kampanye.edit', $kampanye->id));

    $response->assertOk()
        ->assertSee('Edit Kampanye')
        ->assertSee('Perbarui informasi kampanye kemanusiaan Anda.')
        ->assertSee('Judul Kampanye Lama')
        ->assertSee(route('kampanye.saya'));
});

test('pengguna lain tidak bisa mengedit kampanye milik orang lain', function () {
    $pemilik = User::factory()->create();
    $penyusup = User::factory()->create();
    $kampanye = Kampanye::factory()->create(['user_id' => $pemilik->id]);

    $this->actingAs($penyusup)->get(route('kampanye.edit', $kampanye->id))
        ->assertForbidden();
});

test('memperbarui kampanye menyimpan perubahan dan kembali ke galang dana saya', function () {
    $user = User::factory()->create();
    $kampanye = Kampanye::factory()->create([
        'user_id' => $user->id,
        'judul' => 'Judul Lama',
    ]);

    $response = $this->actingAs($user)->put(route('kampanye.update', $kampanye->id), [
        'judul' => 'Judul Baru',
        'deskripsi' => 'Deskripsi baru.',
        'kategori' => 'Kesehatan',
        'lokasi' => 'Bandung',
        'target_dana' => 25_000_000,
        'batas_tanggal' => now()->addMonths(3)->format('Y-m-d'),
    ]);

    $response->assertRedirect(route('kampanye.saya'));

    $kampanye->refresh();
    expect($kampanye->judul)->toBe('Judul Baru')
        ->and($kampanye->kategori)->toBe('Kesehatan')
        ->and($kampanye->lokasi)->toBe('Bandung');
});

test('memperbarui kampanye menyimpan gambar baru', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $kampanye = Kampanye::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)->put(route('kampanye.update', $kampanye->id), [
        'judul' => $kampanye->judul,
        'deskripsi' => $kampanye->deskripsi,
        'kategori' => $kampanye->kategori,
        'target_dana' => $kampanye->target_dana,
        'batas_tanggal' => $kampanye->batas_tanggal,
        'gambar' => UploadedFile::fake()->image('gambar-update.jpg'),
    ])->assertRedirect(route('kampanye.saya'));

    $kampanye->refresh();
    Storage::disk('public')->assertExists($kampanye->gambar);
});
