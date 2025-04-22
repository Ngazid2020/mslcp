<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Patient>
 */
class PatientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->name(),
            'prenom' => $this->faker->firstName(),
            'Age' => $this->faker->numberBetween(1, 100),
            'lieu_naissance' => $this->faker->city(),
            'domicile' => $this->faker->address(),
            'sexe' => $this->faker->randomElement(['M', 'F']),
        ];
    }
}
