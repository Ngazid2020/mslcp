<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Element>
 */
class ElementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom'         => $this->faker->unique()->word(),
            'category_id' => Category::factory(),
            'unite'       => $this->faker->randomElement(['g/dL', 'mmol/L', 'UI/L', '%', null]),
            'type_valeur' => $this->faker->randomElement(['numerique', 'qualitatif', 'positif/negatif']),
            'prix'        => null,
        ];
    }

    public function avecTarif(int $prix = 2000): static
    {
        return $this->state(['prix' => $prix]);
    }

    public function numerique(): static
    {
        return $this->state([
            'type_valeur' => 'numerique',
            'ref_inf_h'   => '4.5',
            'ref_sup_h'   => '5.5',
            'ref_inf_f'   => '4.0',
            'ref_sup_f'   => '5.0',
        ]);
    }
}
