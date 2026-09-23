<?php

use App\Models\Kampanye;
use App\Models\User;
use Illuminate\Http\UploadedFile;

test('membuat kampanye menyimpan nama penggalang dari formulir', function () {
    $user = User::factory()->create(['name' => 'Akun Login']);
    $namaLembaga = 'Yayasan Harapan Indonesia';

    $response = $this->actingAs($user)->post(route('kampanye.store'), [
        'judul' => 'Bantu Korban Banjir',
        'deskripsi' => 'Donasi untuk korban banjir.',
        'kategori' => 'Bencana Alam',
        'lokasi' => 'Jakarta',
        'target_dana' => 10_000_000,
        'jangka_waktu' => 30,
        'nik' => '3201010101010001',
        'foto_ktp' => UploadedFile::fake()->image('ktp.jpg'),
        'foto_diri' => UploadedFile::fake()->image('foto.jpg'),
        'jenis_akun' => 'lembaga',
        'nama_lengkap' => $namaLembaga,
    ]);

    $response->assertRedirect(route('kampanye.index'));

    $kampanye = Kampanye::where('judul', 'Bantu Korban Banjir')->first();
    $this->assertNotNull($kampanye);
    expect($kampanye->nama_lengkap)->toBe($namaLembaga);
    expect($kampanye->status)->toBe('menunggu');
});

test('halaman detail menampilkan nama penggalang dari nama_lengkap, bukan nama akun login', function () {
    $user = User::factory()->create(['name' => 'Akun Login']);
    $kampanye = Kampanye::factory()->create([
        'user_id' => $user->id,
        'nama_lengkap' => 'Yayasan Harapan Indonesia',
    ]);

    $response = $this->get(route('kampanye.show', $kampanye->id));

    $response->assertOk()
        ->assertSee('Yayasan Harapan Indonesia')
        ->assertDontSee('Akun Login');
});

test('filter kategori tidak sensitif huruf besar/kecil', function () {
    $kampanye = Kampanye::factory()->create([
        'judul' => 'Bantu Korban Longsor',
        'kategori' => 'bencana alam',
        'status' => 'aktif',
    ]);

    $response = $this->get(route('kampanye.index', ['kategori' => 'Bencana Alam']));

    $response->assertOk()
        ->assertSee('Bantu Korban Longsor');
});

test('membuat kampanye menolak kategori di luar pilihan resmi', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('kampanye.store'), [
        'judul' => 'Bantu Korban Banjir',
        'deskripsi' => 'Donasi untuk korban banjir.',
        'kategori' => 'Banjir Bandang',
        'lokasi' => 'Jakarta',
        'target_dana' => 10_000_000,
        'jangka_waktu' => 30,
        'nik' => '3201010101010001',
        'foto_ktp' => UploadedFile::fake()->image('ktp.jpg'),
        'foto_diri' => UploadedFile::fake()->image('foto.jpg'),
        'jenis_akun' => 'lembaga',
        'nama_lengkap' => 'Yayasan Harapan Indonesia',
    ]);

    $response->assertSessionHasErrors('kategori');
    $this->assertDatabaseMissing('kampanyes', ['judul' => 'Bantu Korban Banjir']);
});
