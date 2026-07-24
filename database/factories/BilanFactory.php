<?php

namespace Database\Factories;

use App\Models\Patient;
use App\Models\Prescripteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bilan>
 */
class BilanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'patient_id'      => Patient::factory(),
            'prescripteur_id' => Prescripteur::factory(),
            'statut'          => $this->faker->randomElement([
                'en_attente_prelevement',
                'preleve',
                'en_cours_analyse',
                'termine',
            ]),
            'type'       => null,
            'prix_total' => 0,
        ];
    }

    public function hormonal(): static
    {
        return $this->state(['type' => 'hormonal']);
    }

    public function termine(): static
    {
        return $this->state(['statut' => 'termine']);
    }
}
