<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Element;
use App\Models\Patient;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $userAdmin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        Role::create(['name' => 'administrateur']);

        $userAdmin->assignRole('administrateur');

        User::factory()->create([
            'name' => 'labo1',
            'email' => 'labo1@example.com',
        ]);

        $categories = [
            'FORMULE SANGUINE',
            'ANALYSE URINAIRE',
            'HEMOGRAMME',
            'BIOCHIMIE',
            'BILAN PARASITAIRE',
            'NUMERATION GLOBULAIRE',
            'NUMERATION DES PLAQUETTES',
        ];
        foreach ($categories as $category) {
            $macategory = Category::factory()->create([
                'name' => $category,
            ]);

            $macategory->save();
            $elements = [];

            if ($macategory->name === "HEMOGRAMME") {
                $elements = [
                    'Hémoglates',
                    'Emacrite',                   
                ];
            }
            if ($macategory->name === "ANALYSE URINAIRE") {
                $elements = [
                    'Hémoglobine',
                    'Hématocrite',                  
                ];
            }
            if ($macategory->name === "BILAN PARASITAIRE") {
                $elements = [
                    'Protéines totales',
                    'Albumine',
                    'Globulines',
                ];
            }
            if ($macategory->name === "NUMERATION DES PLAQUETTES") {
                $elements = [                    
                    'Plaquettes',
                    'VMP',
                ];
            }
            if ($macategory->name === "FORMULE SANGUINE") {
                $elements = [
                    'P.Neutrophiles',
                    'P.Eosinophiles',
                    'P.Basophiles',
                    'Monocytes',
                    'Lymphocytes',
                ];
            }
            if ($macategory->name === "NUMERATION GLOBULAIRE") {
                $elements = [
                    'Globules blancs',
                    'Globules rouges',
                    'VGM',
                    'TGMH',
                    'CCMH'
                ];
            }

            foreach ($elements as $element) {
                $faker = Faker::create();
                Element::factory()->create([
                    'nom' => $element,
                    'ref_inf_h' => $faker->randomFloat(2, 0, 10),
                    'ref_sup_h' => $faker->randomFloat(2, 10, 20),
                    'ref_inf_f' => $faker->randomFloat(2, 0, 10),
                    'ref_sup_f' => $faker->randomFloat(2, 10, 20),
                    'ref_inf_enf' => $faker->randomFloat(2, 0, 10),
                    'ref_sup_enf' => $faker->randomFloat(2, 10, 20),
                    'ref_inf_nour' => $faker->randomFloat(2, 0, 10),
                    'ref_sup_nour' => $faker->randomFloat(2, 10, 20),
                    'unite' => $faker->randomElement(['mg/dl', 'g/l', 'mmol/l','µ/m³','mg/ml']),
                    'category_id' => $macategory->id,
                ]);
            }
        }


        Patient::factory(50)->create();
    }
}
