<?php

use App\Models\BuktiPenyaluran;
use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

// ── Helpers ────────────────────────────────────────────────────────────────

function makePenggalang(): User
{
    return User::factory()->create(['role' => 'penggalang', 'email_verified_at' => now()]);
}

function makePenarikanBerhasil(User $user): PenarikanDana
{
    $kampanye = Kampanye::factory()->selesai()->create(['user_id' => $user->id, 'dana_terkumpul' => 5_000_000]);

    return PenarikanDana::factory()->create([
        'user_id' => $user->id,
        'kampanye_id' => $kampanye->id,
        'jumlah' => 1_000_000,
        'status' => 'berhasil',
        'bank_tujuan' => 'BCA',
        'nomor_rekening' => '1234567890',
        'nama_pemilik_rekening' => $user->name,
        'kode_transaksi' => 'WD-TEST-001',
        'disetujui_pada' => now(),
    ]);
}

// ── Halaman Index ──────────────────────────────────────────────────────────

it('penggalang dapat membuka halaman bukti penyaluran', function () {
    $user = makePenggalang();

    $this->actingAs($user)
        ->get(route('bukti-penyaluran.index'))
        ->assertOk()
        ->assertSee('Bukti Penyaluran Dana');
});

it('tamu tidak dapat mengakses halaman bukti penyaluran', function () {
    $this->get(route('bukti-penyaluran.index'))
        ->assertRedirect(route('login'));
});

it('halaman menampilkan daftar penarikan berhasil milik user', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    $this->actingAs($user)
        ->get(route('bukti-penyaluran.index'))
        ->assertOk()
        ->assertSee($penarikan->kode_transaksi);
});

it('halaman tidak menampilkan penarikan milik user lain', function () {
    $owner = makePenggalang();
    $lain = makePenggalang();
    $penarikan = makePenarikanBerhasil($lain);

    $this->actingAs($owner)
        ->get(route('bukti-penyaluran.index'))
        ->assertOk()
        ->assertDontSee($penarikan->kode_transaksi);
});

// ── Upload Bukti ───────────────────────────────────────────────────────────

it('penggalang dapat mengunggah bukti penyaluran dengan gambar', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);
    $file = UploadedFile::fake()->image('bukti.jpg', 400, 300);

    $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Dana digunakan untuk membeli obat-obatan dan distribusi ke 50 penerima manfaat.',
            'foto_bukti' => $file,
        ])
        ->assertRedirect(route('bukti-penyaluran.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseHas('bukti_penyalurans', [
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $user->id,
        'status' => 'menunggu',
    ]);

    Storage::disk('public')->assertExists('bukti-penyaluran/'.$file->hashName());
});

it('penggalang dapat mengunggah bukti penyaluran dengan PDF', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);
    $file = UploadedFile::fake()->create('laporan.pdf', 500, 'application/pdf');

    $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Laporan pertanggungjawaban penggunaan dana bantuan bencana alam wilayah terdampak.',
            'foto_bukti' => $file,
        ])
        ->assertRedirect(route('bukti-penyaluran.index'));

    $this->assertDatabaseHas('bukti_penyalurans', [
        'penarikan_dana_id' => $penarikan->id,
        'status' => 'menunggu',
    ]);
});

it('tidak bisa upload bukti untuk penarikan yang sudah punya bukti', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    BuktiPenyaluran::create([
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $user->id,
        'deskripsi' => 'Laporan pertama sudah diunggah sebelumnya.',
        'foto_bukti' => 'bukti-penyaluran/existing.jpg',
        'status' => 'menunggu',
    ]);

    $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Coba upload kedua yang seharusnya ditolak karena duplikat.',
            'foto_bukti' => UploadedFile::fake()->image('bukti2.jpg'),
        ])
        ->assertSessionHasErrors('penarikan_dana_id');
});

it('penggalang dapat mengunggah ulang bukti penyaluran yang sebelumnya ditolak', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    $buktiLama = BuktiPenyaluran::create([
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $user->id,
        'deskripsi' => 'Laporan lama yang ditolak karena bukti tidak jelas.',
        'foto_bukti' => 'bukti-penyaluran/ditolak.jpg',
        'status' => 'ditolak',
        'catatan_admin' => 'Struk tidak jelas, mohon unggah ulang.',
    ]);

    $file = UploadedFile::fake()->image('bukti-baru.jpg', 400, 300);

    $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Unggahan ulang bukti yang jelas dengan struk terlampir semua rincian lengkap.',
            'foto_bukti' => $file,
        ])
        ->assertRedirect(route('bukti-penyaluran.index'))
        ->assertSessionHas('success');

    $this->assertDatabaseCount('bukti_penyalurans', 1);

    $buktiLama->refresh();

    expect($buktiLama->status)->toBe('menunggu');
    expect($buktiLama->catatan_admin)->toBeNull();
    expect($buktiLama->deskripsi)->toBe('Unggahan ulang bukti yang jelas dengan struk terlampir semua rincian lengkap.');
    expect($buktiLama->foto_bukti)->toBe('bukti-penyaluran/'.$file->hashName());

    Storage::disk('public')->assertExists('bukti-penyaluran/'.$file->hashName());
});

it('validasi: deskripsi wajib minimal 20 karakter', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Terlalu pendek',
            'foto_bukti' => UploadedFile::fake()->image('bukti.jpg'),
        ])
        ->assertSessionHasErrors('deskripsi');
});

it('validasi gagal tetap mengembalikan errors dan data penarikan untuk membuka ulang modal', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    $response = $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Pendek',
            'foto_bukti' => UploadedFile::fake()->image('bukti.jpg'),
        ]);

    $response->assertSessionHasErrors(['deskripsi' => 'Deskripsi minimal 20 karakter agar laporan informatif.'])
        ->assertSessionHasInput('penarikan_dana_id', $penarikan->id);

    $modalPenarikan = session('modal_penarikan');
    expect($modalPenarikan)->toBeArray()
        ->and($modalPenarikan['kode'])->toBe($penarikan->kode_transaksi)
        ->and($modalPenarikan['judul'])->toBe($penarikan->kampanye->judul)
        ->and((float) $modalPenarikan['jumlah'])->toBe((float) $penarikan->jumlah)
        ->and($modalPenarikan['is_revisi'])->toBeFalse();
});

it('validasi gagal tidak error 500 dan halaman dibuka kembali dengan data modal', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    $response = $this->actingAs($user)
        ->from(route('bukti-penyaluran.index'))
        ->followingRedirects()
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Pendek',
            'foto_bukti' => UploadedFile::fake()->image('bukti.jpg'),
        ]);

    $response->assertOk()
        ->assertSee('Deskripsi minimal 20 karakter agar laporan informatif.')
        ->assertSee($penarikan->kode_transaksi)
        ->assertSee($penarikan->kampanye->judul);
});

it('validasi: file bukti wajib ada', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    $this->actingAs($user)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Deskripsi panjang yang sudah lebih dari dua puluh karakter.',
        ])
        ->assertSessionHasErrors('foto_bukti');
});

it('badge status item tampil dalam Bahasa Inggris saat bahasa user EN', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    BuktiPenyaluran::create([
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $user->id,
        'deskripsi' => 'Laporan setelah dana dicairkan untuk kebutuhan penerima manfaat.',
        'foto_bukti' => 'bukti-penyaluran/bukti.jpg',
        'status' => 'menunggu',
    ]);

    $user->update(['bahasa' => 'en']);

    $this->actingAs($user)
        ->get(route('bukti-penyaluran.index', ['status_laporan' => 'menunggu']))
        ->assertOk()
        ->assertSee('Awaiting Review')
        ->assertDontSee('Menunggu Review');
});

it('tombol lihat laporan aman saat deskripsi atau catatan admin mengandung tanda kutip', function () {
    $user = makePenggalang();
    $penarikan = makePenarikanBerhasil($user);

    BuktiPenyaluran::create([
        'penarikan_dana_id' => $penarikan->id,
        'user_id' => $user->id,
        'deskripsi' => 'Konfirmasi pesan "barang" diterima beserta struknya.',
        'foto_bukti' => 'bukti-penyaluran/bukti.jpg',
        'status' => 'menunggu',
        'catatan_admin' => 'Catatan admin dengan "tanda kutip" dua.',
    ]);

    $response = $this->actingAs($user)
        ->get(route('bukti-penyaluran.index', ['status_laporan' => 'menunggu']))
        ->assertOk();

    $html = $response->getContent();

    $this->assertStringContainsString('js-btn-lihat', $html);

    preg_match('/data-deskripsi="([^"]*)"/s', $html, $match);
    $this->assertNotEmpty($match);
    $this->assertStringContainsString('&quot;', $match[1], 'Tanda kutip pada deskripsi harus di-escape di atribut data.');
    expect(html_entity_decode($match[1]))->toBe('Konfirmasi pesan "barang" diterima beserta struknya.');

    preg_match('/data-catatan-admin="([^"]*)"/s', $html, $match);
    $this->assertNotEmpty($match);
    $this->assertStringContainsString('&quot;', $match[1], 'Tanda kutip pada catatan admin harus di-escape di atribut data.');
    expect(html_entity_decode($match[1]))->toBe('Catatan admin dengan "tanda kutip" dua.');
});

it('tidak bisa upload bukti untuk penarikan milik user lain', function () {
    $owner = makePenggalang();
    $penyerang = makePenggalang();
    $penarikan = makePenarikanBerhasil($owner);

    $this->actingAs($penyerang)
        ->post(route('bukti-penyaluran.store'), [
            'penarikan_dana_id' => $penarikan->id,
            'deskripsi' => 'Mencoba upload untuk penarikan milik orang lain.',
            'foto_bukti' => UploadedFile::fake()->image('bukti.jpg'),
        ])
        ->assertStatus(404);
});
