<?php

namespace Database\Factories;

use App\Models\Donasi;
use App\Models\Kampanye;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Donasi>
 */
class DonasiFactory extends Factory
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
            'jumlah_donasi' => fake()->randomElement([50_000, 100_000, 250_000]),
            'metode_pembayaran' => fake()->randomElement(['QRIS', 'BCA Virtual Account']),
            'status_pembayaran' => 'berhasil',
            'pesan' => null,
            'anonim' => false,
        ];
    }
}
