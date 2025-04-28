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

        $roleAdmin = Role::create(['name' => 'administrateur']);

        $userAdmin->assignRole('administrateur');

        User::factory()->create([
            'name' => 'labo1',
            'email' => 'labo1@example.com',
        ]);

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);

        $roleAdmin->givePermissionTo([
            // Permissions pour Role
            'create Role',
            'update Role',
            'view-any Role',
            'view Role',
            'delete Role',
            'delete-any Role',
            'restore Role',
            'restore-any Role',
            'replicate Role',
            'reorder Role',
            'force-delete Role',
            'force-delete-any Role',

            // Permissions pour Permission
            'create Permission',
            'update Permission',
            'view-any Permission',
            'view Permission',
            'delete Permission',
            'delete-any Permission',
            'restore Permission',
            'restore-any Permission',
            'replicate Permission',
            'reorder Permission',
            'force-delete Permission',
            'force-delete-any Permission',

            // Permissions pour User
            'create User',
            'update User',
            'view-any User',
            'view User',
            'delete User',
            'delete-any User',
            'restore User',
            'restore-any User',
            'replicate User',
            'reorder User',
            'force-delete User',
            'force-delete-any User',
            
            // Permissions pour Element
            'create Element',
            'update Element',
            'view-any Element',
            'view Element',
            'delete Element',
            'delete-any Element',
            'restore Element',
            'restore-any Element',
            'replicate Element',
            'reorder Element',
            'force-delete Element',
            'force-delete-any Element',

            // Permissions pour Bilan
            'create Bilan',
            'update Bilan',
            'view-any Bilan',
            'view Bilan',
            'delete Bilan',
            'delete-any Bilan',
            'restore Bilan',
            'restore-any Bilan',
            'replicate Bilan',
            'reorder Bilan',
            'force-delete Bilan',
            'force-delete-any Bilan',

            // Permissions pour Category
            'create Category',
            'update Category',
            'view-any Category',
            'view Category',
            'delete Category',
            'delete-any Category',
            'restore Category',
            'restore-any Category',
            'replicate Category',
            'reorder Category',
            'force-delete Category',
            'force-delete-any Category',

            // Permissions pour Prescripteur
            'create Prescripteur',
            'update Prescripteur',
            'view-any Prescripteur',
            'view Prescripteur',
            'delete Prescripteur',
            'delete-any Prescripteur',
            'restore Prescripteur',
            'restore-any Prescripteur',
            'replicate Prescripteur',
            'reorder Prescripteur',
            'force-delete Prescripteur',
            'force-delete-any Prescripteur',

            // Permissions pour Patient
            'create Patient',
            'update Patient',
            'view-any Patient',
            'view Patient',
            'delete Patient',
            'delete-any Patient',
            'restore Patient',
            'restore-any Patient',
            'replicate Patient',
            'reorder Patient',
            'force-delete Patient',
            'force-delete-any Patient',
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
