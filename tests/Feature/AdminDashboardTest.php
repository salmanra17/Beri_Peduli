<?php

use App\Models\BuktiPenyaluran;
use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\RekeningBank;
use App\Models\User;

test('halaman dashboard memecah daftar perlu tindakan dengan pagination', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    Kampanye::factory()->count(3)->create(['status' => 'menunggu']);
    foreach (range(1, 3) as $i) {
        RekeningBank::create([
            'user_id' => $admin->id,
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'nama_pemilik' => "Pemilik $i",
            'status' => 'menunggu',
        ]);
    }
    PenarikanDana::factory()->create(['status' => 'diproses']);

    $halamanPertama = $this->actingAs($admin)->get(route('admin.dashboard'));

    $halamanPertama->assertOk()
        ->assertSee('Menampilkan 1–5 dari 7 tindakan');

    $halamanDua = $this->actingAs($admin)->get(route('admin.dashboard', ['page' => 2]));

    $halamanDua->assertOk()
        ->assertSee('Menampilkan 6–7 dari 7 tindakan');
});

test('halaman dashboard menyertakan bukti penyaluran dalam perlu tindakan', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $kampanye = Kampanye::factory()->create(['judul' => 'Bantu Korban Banjir']);
    $penarikan = PenarikanDana::factory()->create([
        'kampanye_id' => $kampanye->id,
        'user_id' => $admin->id,
        'kode_transaksi' => 'WD-0001-ABCDE',
    ]);
    BuktiPenyaluran::create([
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $admin->id,
        'deskripsi' => 'Penyaluran dana untuk belanja sembako.',
        'foto_bukti' => 'bukti/sembako.jpg',
        'status' => 'menunggu',
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('Bukti penyaluran menunggu verifikasi')
        ->assertSee('/admin/bukti?status=menunggu&highlight=');
});

test('tautan tinjau rekening dan penarikan di dashboard tidak lagi placeholder', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    RekeningBank::create([
        'user_id' => $admin->id,
        'nama_bank' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik' => 'Pemilik',
        'status' => 'menunggu',
    ]);
    PenarikanDana::factory()->create(['status' => 'diproses']);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk()
        ->assertSee('/admin/rekening?status=menunggu&highlight=')
        ->assertSee('/admin/penarikan?status=diproses&highlight=')
        ->assertDontSee('href="#"');
});
