<?php

namespace Database\Seeders;

use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PenarikanDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->isEmpty()) {
            return;
        }

        // Cari kampanye acuan jika ada
        $kampanye = Kampanye::first();
        $kampanyeId = $kampanye?->id;

        foreach ($users as $user) {
            // Hapus data penarikan sebelumnya milik user ini agar bersih
            PenarikanDana::where('user_id', $user->id)->delete();

            // 4 data utama persis sesuai desain
            $primaryData = [
                [
                    'kode' => 'WD-20241024-001',
                    'tanggal' => Carbon::create(2024, 10, 24, 14, 20),
                    'jumlah' => 5000000,
                    'bank' => 'BCA',
                    'rekening' => '8820128912',
                    'nama' => 'A.N. Ahmad Subarjo',
                    'status' => 'berhasil',
                    'alasan' => null,
                ],
                [
                    'kode' => 'WD-20241028-002',
                    'tanggal' => Carbon::create(2024, 10, 28, 9, 15),
                    'jumlah' => 2500000,
                    'bank' => 'Mandiri',
                    'rekening' => '1240007823',
                    'nama' => 'A.N. Yayasan Bantu Sesama',
                    'status' => 'diproses',
                    'alasan' => null,
                ],
                [
                    'kode' => 'WD-20241015-003',
                    'tanggal' => Carbon::create(2024, 10, 15, 16, 45),
                    'jumlah' => 10000000,
                    'bank' => 'BNI',
                    'rekening' => '0987114321',
                    'nama' => 'A.N. Ahmad Subarjo',
                    'status' => 'ditolak',
                    'alasan' => 'Nama pemilik rekening tidak sesuai dengan identitas penanggung jawab kampanye. Harap perbarui data rekening atau hubungi support jika ada kekeliruan.',
                ],
                [
                    'kode' => 'WD-20241002-004',
                    'tanggal' => Carbon::create(2024, 10, 2, 11, 30),
                    'jumlah' => 1200000,
                    'bank' => 'BCA',
                    'rekening' => '8820128912',
                    'nama' => 'A.N. Ahmad Subarjo',
                    'status' => 'berhasil',
                    'alasan' => null,
                ],
            ];

            // Masukkan 4 data utama
            foreach ($primaryData as $index => $item) {
                PenarikanDana::create([
                    'user_id' => $user->id,
                    'kampanye_id' => $kampanyeId,
                    'kode_transaksi' => $item['kode'].'-'.$user->id,
                    'jumlah' => $item['jumlah'],
                    'bank_tujuan' => $item['bank'],
                    'nomor_rekening' => $item['rekening'],
                    'nama_pemilik_rekening' => $item['nama'],
                    'status' => $item['status'],
                    'alasan_penolakan' => $item['alasan'],
                    'catatan' => 'Pencairan dana donasi kampanye untuk operasional penyaluran.',
                    'disetujui_pada' => $item['status'] === 'berhasil' ? $item['tanggal']->copy()->addHours(6) : null,
                    'created_at' => $item['tanggal'],
                    'updated_at' => $item['tanggal'],
                ]);
            }

            // Tambahkan 24 data pendukung sehingga total transaksi = 28 (persis "Menampilkan 4 dari 28 riwayat penarikan" di desain)
            $banks = [
                ['bank' => 'BCA', 'rek' => '8820129988', 'nama' => 'A.N. Ahmad Subarjo'],
                ['bank' => 'Mandiri', 'rek' => '1240005544', 'nama' => 'A.N. Yayasan Bantu Sesama'],
                ['bank' => 'BRI', 'rek' => '0341010023', 'nama' => 'A.N. Ahmad Subarjo'],
                ['bank' => 'BNI', 'rek' => '0987118833', 'nama' => 'A.N. Ahmad Subarjo'],
                ['bank' => 'BSI', 'rek' => '7123984411', 'nama' => 'A.N. Yayasan Bantu Sesama'],
            ];

            $nominalList = [1500000, 2000000, 3500000, 4000000, 7500000, 1800000, 6000000, 2200000];
            $statusList = ['berhasil', 'berhasil', 'berhasil', 'diproses', 'ditolak'];

            for ($i = 5; $i <= 28; $i++) {
                $bankObj = $banks[($i - 1) % count($banks)];
                $status = $statusList[($i - 1) % count($statusList)];
                $nominal = $nominalList[($i - 1) % count($nominalList)];
                $tgl = Carbon::create(2024, 9, 28, 10, 0)->subDays($i - 4)->subHours($i % 5);

                PenarikanDana::create([
                    'user_id' => $user->id,
                    'kampanye_id' => $kampanyeId,
                    'kode_transaksi' => 'WD-202409'.str_pad((string) $i, 2, '0', STR_PAD_LEFT).'-'.str_pad((string) $i, 3, '0', STR_PAD_LEFT).'-'.$user->id,
                    'jumlah' => $nominal,
                    'bank_tujuan' => $bankObj['bank'],
                    'nomor_rekening' => $bankObj['rek'],
                    'nama_pemilik_rekening' => $bankObj['nama'],
                    'status' => $status,
                    'alasan_penolakan' => $status === 'ditolak' ? 'Nomor rekening penerima sedang dalam status dorman atau tidak aktif menurut sistem perbankan.' : null,
                    'catatan' => 'Pencairan berkala untuk pelaksanaan kegiatan sosial.',
                    'disetujui_pada' => $status === 'berhasil' ? $tgl->copy()->addHours(12) : null,
                    'created_at' => $tgl,
                    'updated_at' => $tgl,
                ]);
            }
        }
    }
}
