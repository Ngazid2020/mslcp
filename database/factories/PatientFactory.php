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
            'numero' => $this->faker->unique()->numerify('P####'),
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'age' => $this->faker->numberBetween(1, 90),
            'lieu_naissance' => $this->faker->city(),
            'domicile' => $this->faker->streetAddress(),
            'sexe' => $this->faker->randomElement(['M', 'F']),
            'tel' => $this->faker->phoneNumber(),
        ];
    }
}
