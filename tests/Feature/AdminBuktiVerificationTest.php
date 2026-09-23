<?php

use App\Models\BuktiPenyaluran;
use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\User;

function buatBukti(User $pengaju, array $overrides = []): BuktiPenyaluran
{
    $kampanye = Kampanye::factory()->create();
    $penarikan = PenarikanDana::factory()->create([
        'kampanye_id' => $kampanye->id,
        'user_id' => $pengaju->id,
        'kode_transaksi' => $overrides['kode_transaksi'] ?? 'WD-0001-ABCDE',
        'jumlah' => $overrides['jumlah'] ?? 5_000_000,
    ]);

    return BuktiPenyaluran::create([
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $pengaju->id,
        'deskripsi' => $overrides['deskripsi'] ?? 'Penyaluran dana untuk belanja sembako.',
        'foto_bukti' => $overrides['foto_bukti'] ?? 'bukti/sembako.jpg',
        'status' => $overrides['status'] ?? 'menunggu',
        'catatan_admin' => $overrides['catatan_admin'] ?? null,
    ]);
}

test('halaman bukti penyaluran dapat dicari berdasarkan kode penarikan', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    buatBukti($admin, ['kode_transaksi' => 'WD-0001-ABCDE']);
    buatBukti($admin, ['kode_transaksi' => 'WD-0002-FGHIJ']);

    $response = $this->actingAs($admin)->get(route('admin.bukti.index', [
        'status' => 'menunggu',
        'cari' => '0001',
    ]));

    $response->assertOk()
        ->assertSee('WD-0001-ABCDE')
        ->assertDontSee('WD-0002-FGHIJ');
});

test('pagination bukti mempertahankan status dan kata kunci pencarian', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    foreach (range(1, 11) as $i) {
        buatBukti($admin, ['kode_transaksi' => "WD-0001-A{$i}"]);
    }

    $halamanPertama = $this->actingAs($admin)->get(route('admin.bukti.index', [
        'status' => 'menunggu',
        'cari' => '0001',
    ]));

    $halamanPertama->assertOk()
        ->assertSee('Menampilkan 1–10 dari 11 bukti');

    $halamanDua = $this->actingAs($admin)->get(route('admin.bukti.index', [
        'status' => 'menunggu',
        'cari' => '0001',
        'page' => 2,
    ]));

    $halamanDua->assertOk()
        ->assertSee('Menampilkan 11–11 dari 11 bukti')
        ->assertSee('cari=0001')
        ->assertSee('status=menunggu');
});

test('halaman bukti menampilkan pesan reset saat pencarian tidak menemukan hasil', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    buatBukti($admin);

    $response = $this->actingAs($admin)->get(route('admin.bukti.index', [
        'status' => 'menunggu',
        'cari' => 'tidakada',
    ]));

    $response->assertOk()
        ->assertSee('Tidak ada bukti yang cocok dengan pencarian')
        ->assertSee('Reset pencarian');
});

test('admin dapat menyetujui bukti penyaluran yang menunggu', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $bukti = buatBukti($admin);

    $response = $this->actingAs($admin)->patch(route('admin.bukti.setujui', $bukti->id));

    $response->assertRedirect(route('admin.bukti.index', ['status' => 'disetujui']));
    expect($bukti->fresh()->status)->toBe('disetujui');
});

test('admin dapat menolak bukti penyaluran dengan catatan admin', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $bukti = buatBukti($admin);

    $response = $this->actingAs($admin)->patch(route('admin.bukti.tolak', $bukti->id), [
        'catatan_admin' => 'Struk tidak jelas, mohon unggah ulang.',
    ]);

    $response->assertRedirect(route('admin.bukti.index', ['status' => 'ditolak']));
    $bukti->refresh();

    expect($bukti->status)->toBe('ditolak');
    expect($bukti->catatan_admin)->toBe('Struk tidak jelas, mohon unggah ulang.');
});

test('penolakan bukti tanpa catatan tetap berhasil', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $bukti = buatBukti($admin);

    $response = $this->actingAs($admin)->patch(route('admin.bukti.tolak', $bukti->id));

    $response->assertRedirect(route('admin.bukti.index', ['status' => 'ditolak']));
    expect($bukti->fresh()->status)->toBe('ditolak');
});

test('halaman bukti penyaluran memberi highlight pada baris yang baru ditinjau', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $bukti = buatBukti($admin);

    $response = $this->actingAs($admin)->get(route('admin.bukti.index', [
        'status' => 'menunggu',
        'highlight' => $bukti->id,
    ]));

    $response->assertOk()
        ->assertSee("id=\"bukti-{$bukti->id}\"", false)
        ->assertSee('animation: bukti-flash 2s ease-in-out 1 both;', false);
});
