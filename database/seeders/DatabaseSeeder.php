<?php

namespace Database\Seeders;

use App\Models\Bilan;
use App\Models\Category;
use App\Models\Element;
use App\Models\Patient;
use App\Models\Prescripteur;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        $userReceptionniste->assignRole('receptionniste');

        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ElementSeeder::class);
        $this->call(BilanSeeder::class);
        $this->call(PrescripteurSeeder::class);
        $this->call(PatientSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(MaladieSeeder::class);

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

            // Statistiques
            'view Statistiques',

            // Rapports épidémiologiques
            'view Rapports',
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

            // Statistiques
            'view Statistiques',

            // Rapports épidémiologiques
            'view Rapports',
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

        // ── Prescripteurs de démo ────────────────────────────────────────────
        Prescripteur::factory(10)->create();

        // ── Patients de démo ─────────────────────────────────────────────────
        $patients = Patient::factory(50)->create();

        // ── Catégories et éléments d'analyse ────────────────────────────────
        $elementsByCategory = [
            'NUMERATION GLOBULAIRE' => [
                ['nom' => 'Hémoglobine',      'unite' => 'g/dL',  'ref_inf_h' => 13.0, 'ref_sup_h' => 17.5, 'ref_inf_f' => 12.0, 'ref_sup_f' => 16.0, 'ref_inf_enf' => 11.0, 'ref_sup_enf' => 14.5, 'ref_inf_nour' => 10.5, 'ref_sup_nour' => 13.5, 'ref_inf_nne' => 14.0, 'ref_sup_nne' => 20.0],
                ['nom' => 'Hématocrite',      'unite' => '%',     'ref_inf_h' => 40.0, 'ref_sup_h' => 54.0, 'ref_inf_f' => 37.0, 'ref_sup_f' => 47.0, 'ref_inf_enf' => 34.0, 'ref_sup_enf' => 44.0, 'ref_inf_nour' => 32.0, 'ref_sup_nour' => 42.0, 'ref_inf_nne' => 44.0, 'ref_sup_nne' => 64.0],
                ['nom' => 'Globules rouges',  'unite' => 'M/µL',  'ref_inf_h' => 4.5,  'ref_sup_h' => 6.2,  'ref_inf_f' => 4.0,  'ref_sup_f' => 5.4,  'ref_inf_enf' => 3.8,  'ref_sup_enf' => 5.2,  'ref_inf_nour' => 3.6,  'ref_sup_nour' => 5.0,  'ref_inf_nne' => 4.5,  'ref_sup_nne' => 6.5],
                ['nom' => 'VGM',              'unite' => 'fL',    'ref_inf_h' => 80.0, 'ref_sup_h' => 100.0,'ref_inf_f' => 80.0, 'ref_sup_f' => 100.0,'ref_inf_enf' => 78.0, 'ref_sup_enf' => 98.0, 'ref_inf_nour' => 70.0, 'ref_sup_nour' => 90.0, 'ref_inf_nne' => 100.0,'ref_sup_nne' => 128.0],
                ['nom' => 'TCMH',             'unite' => 'pg',    'ref_inf_h' => 27.0, 'ref_sup_h' => 33.0, 'ref_inf_f' => 27.0, 'ref_sup_f' => 33.0, 'ref_inf_enf' => 25.0, 'ref_sup_enf' => 31.0, 'ref_inf_nour' => 24.0, 'ref_sup_nour' => 30.0, 'ref_inf_nne' => 30.0, 'ref_sup_nne' => 37.0],
                ['nom' => 'CCMH',             'unite' => 'g/dL',  'ref_inf_h' => 32.0, 'ref_sup_h' => 36.0, 'ref_inf_f' => 32.0, 'ref_sup_f' => 36.0, 'ref_inf_enf' => 32.0, 'ref_sup_enf' => 36.0, 'ref_inf_nour' => 30.0, 'ref_sup_nour' => 36.0, 'ref_inf_nne' => 30.0, 'ref_sup_nne' => 36.0],
            ],
            'FORMULE SANGUINE' => [
                ['nom' => 'Leucocytes',       'unite' => 'G/L',   'ref_inf_h' => 4.0,  'ref_sup_h' => 10.0, 'ref_inf_f' => 4.0,  'ref_sup_f' => 10.0, 'ref_inf_enf' => 6.0,  'ref_sup_enf' => 17.0, 'ref_inf_nour' => 6.0,  'ref_sup_nour' => 17.0, 'ref_inf_nne' => 9.0,  'ref_sup_nne' => 30.0],
                ['nom' => 'Neutrophiles',     'unite' => '%',     'ref_inf_h' => 50.0, 'ref_sup_h' => 70.0, 'ref_inf_f' => 50.0, 'ref_sup_f' => 70.0, 'ref_inf_enf' => 35.0, 'ref_sup_enf' => 65.0, 'ref_inf_nour' => 20.0, 'ref_sup_nour' => 50.0, 'ref_inf_nne' => 45.0, 'ref_sup_nne' => 80.0],
                ['nom' => 'Lymphocytes',      'unite' => '%',     'ref_inf_h' => 20.0, 'ref_sup_h' => 40.0, 'ref_inf_f' => 20.0, 'ref_sup_f' => 40.0, 'ref_inf_enf' => 30.0, 'ref_sup_enf' => 65.0, 'ref_inf_nour' => 40.0, 'ref_sup_nour' => 75.0, 'ref_inf_nne' => 10.0, 'ref_sup_nne' => 40.0],
                ['nom' => 'Monocytes',        'unite' => '%',     'ref_inf_h' => 2.0,  'ref_sup_h' => 10.0, 'ref_inf_f' => 2.0,  'ref_sup_f' => 10.0, 'ref_inf_enf' => 2.0,  'ref_sup_enf' => 10.0, 'ref_inf_nour' => 2.0,  'ref_sup_nour' => 10.0, 'ref_inf_nne' => 2.0,  'ref_sup_nne' => 10.0],
                ['nom' => 'Éosinophiles',     'unite' => '%',     'ref_inf_h' => 0.0,  'ref_sup_h' => 6.0,  'ref_inf_f' => 0.0,  'ref_sup_f' => 6.0,  'ref_inf_enf' => 0.0,  'ref_sup_enf' => 6.0,  'ref_inf_nour' => 0.0,  'ref_sup_nour' => 6.0,  'ref_inf_nne' => 0.0,  'ref_sup_nne' => 6.0],
            ],
            'NUMERATION DES PLAQUETTES' => [
                ['nom' => 'Plaquettes',       'unite' => 'G/L',   'ref_inf_h' => 150.0,'ref_sup_h' => 400.0,'ref_inf_f' => 150.0,'ref_sup_f' => 400.0,'ref_inf_enf' => 150.0,'ref_sup_enf' => 400.0,'ref_inf_nour' => 150.0,'ref_sup_nour' => 400.0,'ref_inf_nne' => 150.0,'ref_sup_nne' => 450.0],
            ],
            'BILAN PROSTATIQUE' => [
                ['nom' => 'PSA total',        'unite' => 'ng/mL', 'ref_inf_h' => 0.0,  'ref_sup_h' => 4.0,  'ref_inf_f' => null,  'ref_sup_f' => null],
                ['nom' => 'PSA libre',        'unite' => 'ng/mL', 'ref_inf_h' => 0.0,  'ref_sup_h' => 1.0,  'ref_inf_f' => null,  'ref_sup_f' => null],
            ],
            'FSH' => [
                ['nom' => 'FSH',              'unite' => 'mUI/mL','ref_inf_h' => 1.5,  'ref_sup_h' => 12.4, 'ref_inf_f' => 3.5,  'ref_sup_f' => 12.5],
            ],
            'LH' => [
                ['nom' => 'LH',               'unite' => 'mUI/mL','ref_inf_h' => 1.7,  'ref_sup_h' => 8.6,  'ref_inf_f' => 2.4,  'ref_sup_f' => 12.6],
            ],
            'HBA1c' => [
                ['nom' => 'HbA1c',            'unite' => '%',     'ref_inf_h' => null, 'ref_sup_h' => 5.7,  'ref_inf_f' => null, 'ref_sup_f' => 5.7],
            ],
            'BetaHCG' => [
                ['nom' => 'β-HCG',            'unite' => 'mUI/mL','ref_inf_h' => null, 'ref_sup_h' => 5.0,  'ref_inf_f' => null, 'ref_sup_f' => 5.0],
            ],
            'OESTRADIOLE (E2)' => [
                ['nom' => 'Œstradiol (E2)',   'unite' => 'pg/mL', 'ref_inf_h' => 10.0, 'ref_sup_h' => 40.0, 'ref_inf_f' => 20.0, 'ref_sup_f' => 400.0],
            ],
            'PRL' => [
                ['nom' => 'Prolactine (PRL)', 'unite' => 'ng/mL', 'ref_inf_h' => 3.0,  'ref_sup_h' => 18.0, 'ref_inf_f' => 3.0,  'ref_sup_f' => 30.0],
            ],
        ];

        $createdElements = [];
        foreach ($elementsByCategory as $categoryName => $elements) {
            $category = Category::create(['name' => $categoryName]);
            foreach ($elements as $elementData) {
                $createdElements[] = Element::create(array_merge(
                    ['category_id' => $category->id, 'type_valeur' => 'numerique'],
                    $elementData
                ));
            }
        }

        // ── Bilans de démo (5 bilans avec analyses NFS) ──────────────────────
        $nfsElements = array_slice($createdElements, 0, 6); // NFS = 6 premiers éléments
        $prescripteurs = Prescripteur::all();

        foreach ($patients->take(5) as $patient) {
            $bilan = Bilan::create([
                'patient_id' => $patient->id,
                'prescripteur_id' => $prescripteurs->random()->id,
            ]);

            foreach ($nfsElements as $element) {
                $bilan->elements()->attach($element->id, [
                    'resultat' => round(
                        fake()->randomFloat(1, (float) ($element->ref_inf_h ?? 1), (float) ($element->ref_sup_h ?? 20)),
                        1
                    ),
                ]);
            }
        }
    }
}
