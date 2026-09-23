<?php

use App\Models\User;

test('halaman manajemen user menampilkan semua user dan jumlah per role', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    User::factory()->count(2)->create(['role' => 'penggalang']);
    User::factory()->create(['role' => 'donatur']);

    $response = $this->actingAs($admin)->get(route('admin.user.index'));

    $response->assertOk()
        ->assertSee('Semua (4)')
        ->assertSee('Penggalang (2)')
        ->assertSee('Donatur (1)')
        ->assertSee('Admin (1)')
        ->assertSee('4 user terdaftar');
});

test('halaman manajemen user memfilter berdasarkan role lewat query string', function () {
    $admin = User::factory()->create(['role' => 'admin', 'name' => 'Admin Utama']);
    $penggalang = User::factory()->create(['role' => 'penggalang', 'name' => 'Budi Sanggalang']);
    $donatur = User::factory()->create(['role' => 'donatur', 'name' => 'Siti Donatur']);

    $response = $this->actingAs($admin)->get(route('admin.user.index', ['role' => 'penggalang']));

    $response->assertOk()
        ->assertSee('Budi Sanggalang')
        ->assertDontSee('Siti Donatur')
        ->assertSee('1 user berperan penggalang');
});

test('halaman manajemen user dapat mencari berdasarkan nama atau email', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create(['name' => 'Siti Nurhaliza', 'email' => 'siti@example.com']);
    $lainnya = User::factory()->create(['name' => 'Andi Wijaya', 'email' => 'andi@example.com']);

    $response = $this->actingAs($admin)->get(route('admin.user.index', ['q' => 'siti@example.com']));

    $response->assertOk()
        ->assertSee('Siti Nurhaliza')
        ->assertDontSee('Andi Wijaya');

    $response = $this->actingAs($admin)->get(route('admin.user.index', ['q' => 'Andi']));

    $response->assertOk()
        ->assertSee('Andi Wijaya')
        ->assertDontSee('Siti Nurhaliza');
});

test('pagination manajemen user mempertahankan role dan kata kunci pencarian', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    User::factory()->count(11)->create(['role' => 'penggalang', 'name' => 'Budi Penggalang']);

    $response = $this->actingAs($admin)->get(route('admin.user.index', [
        'role' => 'penggalang',
        'q' => 'Budi',
        'page' => 2,
    ]));

    $response->assertOk()
        ->assertSee('Menampilkan 11–11 dari 11 user')
        ->assertSee('q=Budi')
        ->assertSee('role=penggalang');
});

test('tombol aksi menyesuaikan status: nonaktifkan merah untuk aktif, aktifkan hijau untuk nonaktif, tersembunyi untuk akun sendiri', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penggalang = User::factory()->create(['role' => 'penggalang']);
    $donatur = User::factory()->create(['role' => 'donatur', 'is_active' => false]);

    $response = $this->actingAs($admin)->get(route('admin.user.index'));

    $response->assertOk()
        ->assertSee(route('admin.user.toggle-status', $penggalang->id))
        ->assertSee(route('admin.user.toggle-status', $donatur->id))
        ->assertSee('Yakin ingin menonaktifkan akun ini?')
        ->assertSee('Yakin ingin mengaktifkan kembali akun ini?')
        ->assertDontSee(route('admin.user.toggle-status', $admin->id));
});

test('admin dapat menonaktifkan akun user lain', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $penggalang = User::factory()->create(['role' => 'penggalang']);

    $response = $this->actingAs($admin)
        ->withHeader('referer', route('admin.user.index'))
        ->patch(route('admin.user.toggle-status', $penggalang->id));

    $response->assertRedirect(route('admin.user.index'))
        ->assertSessionHas('success', 'Akun berhasil dinonaktifkan.');

    expect($penggalang->fresh()->is_active)->toBeFalse();
});

test('admin dapat mengaktifkan kembali akun user yang nonaktif', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $donatur = User::factory()->create(['role' => 'donatur', 'is_active' => false]);

    $response = $this->actingAs($admin)
        ->withHeader('referer', route('admin.user.index'))
        ->patch(route('admin.user.toggle-status', $donatur->id));

    $response->assertRedirect(route('admin.user.index'))
        ->assertSessionHas('success', 'Akun berhasil diaktifkan kembali.');

    expect($donatur->fresh()->is_active)->toBeTrue();
});

test('admin tidak bisa menonaktifkan akunnya sendiri', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)
        ->withHeader('referer', route('admin.user.index'))
        ->patch(route('admin.user.toggle-status', $admin->id));

    $response->assertRedirect(route('admin.user.index'))
        ->assertSessionHas('error', 'Anda tidak bisa menonaktifkan akun Anda sendiri.');

    expect($admin->fresh()->is_active)->toBeTrue();
});

test('user non admin tidak bisa mengakses manajemen user', function () {
    $user = User::factory()->create(['role' => 'penggalang']);

    $this->actingAs($user)->get(route('admin.user.index'))->assertForbidden();
    $this->actingAs($user)->patch(route('admin.user.toggle-status', 1))->assertForbidden();
});

test('popup detail user menampilkan semua data profil', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $user = User::factory()->create([
        'role' => 'penggalang',
        'nama_depan' => 'Siti',
        'nama_belakang' => 'Nurhaliza',
        'no_hp' => '08123456789',
        'tanggal_lahir' => '2000-01-15',
        'alamat' => 'Jl. Melati No. 1',
        'provinsi' => 'Jawa Barat',
        'kota' => 'Kota Bandung',
        'kode_pos' => '40123',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.user.index'));

    $response->assertOk()
        ->assertSee('Detail User')
        ->assertSee('Siti')
        ->assertSee('Nurhaliza')
        ->assertSee('08123456789')
        ->assertSee('15 Jan 2000')
        ->assertSee('Jl. Melati No. 1')
        ->assertSee('Jawa Barat')
        ->assertSee('Kota Bandung')
        ->assertSee('40123');
});

test('user yang dinonaktifkan tidak bisa login', function () {
    $user = User::factory()->create(['is_active' => false]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasErrors('email');
    expect(auth()->check())->toBeFalse();
});

test('user aktif tetap bisa login', function () {
    $user = User::factory()->create(['is_active' => true]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => 'password',
    ]);

    $response->assertSessionHasNoErrors();
    expect(auth()->check())->toBeTrue();
});
