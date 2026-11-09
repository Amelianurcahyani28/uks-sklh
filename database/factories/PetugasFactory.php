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
            'class_name' => fake()->randomElement(['X PPLG 1', 'XI BCF 2', 'XII ANIM 1', null]),
            'major' => fake()->randomElement(['PPLG', 'BCF', 'ANIM', 'TO', 'TPFL', null]),
            'gender' => fake()->randomElement(['L', 'P']),
            'phone' => fake()->phoneNumber(),
            'schedule' => 'Senin - Jumat (06:30 - 15:00)',
            'status' => 'aktif',
            'bio' => fake()->sentence(),
            'photo' => null,
        ];
    }
}
