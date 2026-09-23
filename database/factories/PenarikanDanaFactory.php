<?php

namespace Database\Factories;

use App\Models\Kampanye;
use App\Models\PenarikanDana;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PenarikanDana>
 */
class PenarikanDanaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'kampanye_id' => Kampanye::factory(),
            'kode_transaksi' => 'WD-'.date('Ymd').'-'.strtoupper(Str::random(5)),
            'jumlah' => fake()->randomElement([500_000, 1_000_000, 2_500_000, 5_000_000]),
            'bank_tujuan' => fake()->randomElement(['BCA', 'BNI', 'BRI', 'MANDIRI']),
            'nomor_rekening' => fake()->numerify('##########'),
            'nama_pemilik_rekening' => fake()->name(),
            'status' => 'diproses',
            'alasan_penolakan' => null,
            'catatan' => null,
            'disetujui_pada' => null,
        ];
    }

    /**
     * Indicate the withdrawal was approved successfully.
     */
    public function berhasil(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'berhasil',
            'disetujui_pada' => now(),
        ]);
    }

    /**
     * Indicate the withdrawal was rejected.
     */
    public function ditolak(string $alasan = 'Dokumen tidak lengkap.'): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'ditolak',
            'alasan_penolakan' => $alasan,
        ]);
    }
}
