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
        $roleLaborantin = Role::create(['name' => 'laborantin']);
        $roleReceptionniste = Role::create(['name' => 'receptionniste']);

        $userAdmin->assignRole('administrateur');

        $userLaborantin = User::factory()->create([
            'name' => 'labo1',
            'email' => 'labo1@example.com',
        ]);
        $userReceptionniste = User::factory()->create([
            'name' => 'receptionniste 1',
            'email' => 'receptionniste1@example.com',
        ]);

        $userLaborantin->assignRole('receptionniste');
        $userLaborantin->assignRole('laborantin');

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ElementSeeder::class);
        $this->call(BilanSeeder::class);
        $this->call(PrescripteurSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(CategorySeeder::class);

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
            'download Bilan',
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
        $roleLaborantin->givePermissionTo([


            // Permissions pour Element
            // 'create Element',
            'update Element',
            'view-any Element',
            'view Element',


            // Permissions pour Bilan
            // 'create Bilan',
            'update Bilan',
            'view-any Bilan',
            'view Bilan',
        ]);

        $roleReceptionniste->givePermissionTo([
            
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
            'download Bilan',
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
            'NUMERATION GLOBULAIRE',
            'NUMERATION DES PLAQUETTES',
            'BILAN PROSTATIQUE',
            'FSH',
            'LH',
            'Semaine D\'Amenorhée',
            'HBA1c',
            'BetaHCG',
            'OESTRADIOLE (E2)',
            'PRL',
        ];
        foreach ($categories as $category) {
            $macategory = Category::factory()->create([
                'name' => $category,
            ]);

            $macategory->save();
            $elements = [];

            
        }


        Patient::factory(50)->create();
    }
}
