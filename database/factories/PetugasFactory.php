<?php

namespace Database\Factories;

use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Petugas>
 */
class PetugasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'role_title' => fake()->randomElement(['Pembina UKS', 'Tenaga Medis UKS', 'Petugas P3K', 'Ketua PMR']),
            'gender' => fake()->randomElement(['L', 'P']),
            'phone' => fake()->phoneNumber(),
            'schedule' => 'Senin - Jumat (07:30 - 15:30)',
            'status' => 'aktif',
            'bio' => fake()->sentence(),
            'photo' => null,
        ];
    }
}
