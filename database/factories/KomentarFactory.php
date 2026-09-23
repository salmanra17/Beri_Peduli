<?php

namespace Database\Factories;

use App\Models\Kampanye;
use App\Models\Komentar;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Komentar>
 */
class KomentarFactory extends Factory
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
            'pesan' => fake()->sentence(12),
            'anonim' => false,
        ];
    }

    /**
     * Indicate that the comment was posted anonymously.
     */
    public function anonim(): static
    {
        return $this->state(fn (array $attributes) => [
            'anonim' => true,
        ]);
    }
}
