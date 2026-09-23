<?php

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

test('guests are redirected from profile settings to login', function () {
    $response = $this->get(route('profile.edit'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can access profile settings page', function () {
    $user = User::factory()->create([
        'name' => 'Budi Santoso',
        'email' => 'budi.santoso@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->get(route('profile.edit'));
    $response->assertOk();
    $response->assertSee('Pengaturan Akun');
    $response->assertSee('Profil Personal');
    $response->assertSee('Keamanan & Password');
    $response->assertSee('Rekening Bank');
    $response->assertSee('Informasi Dasar');
    $response->assertSee('Nama Depan');
    $response->assertSee('Nama Belakang');
    $response->assertSee('Nomor Telepon');
    $response->assertSee('Tanggal Lahir');
    $response->assertSee('Alamat Domisili');
    $response->assertSee('Alamat Lengkap');
    $response->assertSee('Provinsi');
    $response->assertSee('Kota / Kabupaten');
    $response->assertSee('Kode Pos');
    $response->assertSee('Foto Profil');
    $response->assertSee('Ubah Foto');
    $response->assertSee('Preferensi');
    $response->assertSee('Bahasa Antarmuka');
    $response->assertSee(route('bahasa.set', 'id'))
        ->assertSee(route('bahasa.set', 'en'));
    $response->assertSee('Simpan Perubahan');
    $response->assertSee('Batal');
    $response->assertSee('budi.santoso@example.com');
});

test('users can update personal profile information', function () {
    $user = User::factory()->create([
        'name' => 'Budi Lama',
        'email' => 'budi.lama@example.com',
    ]);

    $this->actingAs($user);

    $response = $this->put(route('profile.update'), [
        'nama_depan' => 'Budi',
        'nama_belakang' => 'Santoso',
        'email' => 'budi.baru@example.com',
        'no_hp' => '+62 812 3456 7890',
        'tanggal_lahir' => '1990-12-05',
        'alamat' => 'Jl. Kebon Jeruk Raya No. 27',
        'provinsi' => 'DKI Jakarta',
        'kota' => 'Jakarta Barat',
        'kode_pos' => '11530',
        'bahasa' => 'id',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('success');

    $user->refresh();
    expect($user->name)->toBe('Budi Santoso')
        ->and($user->nama_depan)->toBe('Budi')
        ->and($user->nama_belakang)->toBe('Santoso')
        ->and($user->email)->toBe('budi.baru@example.com')
        ->and($user->no_hp)->toBe('+62 812 3456 7890')
        ->and($user->tanggal_lahir->format('Y-m-d'))->toBe('1990-12-05')
        ->and($user->alamat)->toBe('Jl. Kebon Jeruk Raya No. 27')
        ->and($user->provinsi)->toBe('DKI Jakarta')
        ->and($user->kota)->toBe('Jakarta Barat')
        ->and($user->kode_pos)->toBe('11530')
        ->and($user->bahasa)->toBe('id');
});

test('users can upload and delete profile photo', function () {
    Storage::fake('public');

    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('avatar.jpg', 400, 400);

    $response = $this->put(route('profile.update'), [
        'email' => $user->email,
        'foto_profil' => $file,
    ]);

    $response->assertRedirect(route('profile.edit'));
    $user->refresh();

    expect($user->foto_profil)->not->toBeNull();
    Storage::disk('public')->assertExists($user->foto_profil);

    // Sekarang hapus foto
    $deleteResponse = $this->put(route('profile.update'), [
        'email' => $user->email,
        'hapus_foto' => '1',
    ]);

    $deleteResponse->assertRedirect(route('profile.edit'));
    $user->refresh();

    expect($user->foto_profil)->toBeNull();
});

test('user cannot update to already taken email', function () {
    $otherUser = User::factory()->create(['email' => 'other@example.com']);
    $user = User::factory()->create(['email' => 'me@example.com']);

    $this->actingAs($user);

    $response = $this->put(route('profile.update'), [
        'email' => 'other@example.com',
    ]);

    $response->assertSessionHasErrors('email');
    $user->refresh();
    expect($user->email)->toBe('me@example.com');
});
