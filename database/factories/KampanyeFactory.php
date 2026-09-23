<?php

namespace Database\Factories;

use App\Models\Kampanye;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Kampanye>
 */
class KampanyeFactory extends Factory
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
            'judul' => fake()->sentence(3),
            'deskripsi' => fake()->paragraph(),
            'kategori' => fake()->randomElement(['Bencana Alam', 'Pendidikan', 'Kesehatan', 'Lingkungan', 'Sosial']),
            'lokasi' => fake()->city(),
            'target_dana' => fake()->randomElement([5_000_000, 10_000_000, 50_000_000]),
            'dana_terkumpul' => 0,
            'batas_tanggal' => now()->addDays(30)->toDateString(),
            'status' => 'aktif',
        ];
    }

    /**
     * Indicate that the campaign is finished and no longer accepts donations.
     */
    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
        ]);
    }
}
