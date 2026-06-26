<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Element;
use Illuminate\Database\Seeder;

/**
 * Crée la catégorie PARASITOLOGIE et ses éléments qualitatifs.
 * Idempotent : peut être lancé plusieurs fois sans créer de doublons.
 *
 * Usage :
 *   php artisan db:seed --class=ParasitologieSeeder
 */
class ParasitologieSeeder extends Seeder
{
    public function run(): void
    {
        $category = Category::firstOrCreate(['name' => 'PARASITOLOGIE']);

        $elements = [
            [
                'nom'         => 'Goutte épaisse / Frottis sanguin',
                'unite'       => null,
                'type_valeur' => 'qualitatif',
            ],
            [
                'nom'         => 'Widal — Salmonella typhi O',
                'unite'       => 'titre',
                'type_valeur' => 'qualitatif',
            ],
            [
                'nom'         => 'Widal — Salmonella typhi H',
                'unite'       => 'titre',
                'type_valeur' => 'qualitatif',
            ],
            [
                'nom'         => 'Test de Weil-Félix',
                'unite'       => null,
                'type_valeur' => 'qualitatif',
            ],
        ];

        foreach ($elements as $data) {
            Element::firstOrCreate(
                ['nom' => $data['nom'], 'category_id' => $category->id],
                [
                    'unite'       => $data['unite'],
                    'type_valeur' => $data['type_valeur'],
                ]
            );
        }

        $this->command->info('Catégorie PARASITOLOGIE et éléments qualitatifs créés.');
    }
}
