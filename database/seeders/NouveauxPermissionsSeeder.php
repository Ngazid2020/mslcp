<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

/**
 * Seeder idempotent — peut être lancé sur une base existante.
 *
 * Usage :
 *   php artisan db:seed --class=NouveauxPermissionsSeeder
 */
class NouveauxPermissionsSeeder extends Seeder
{
    private function crud(string $entity): array
    {
        return [
            "view-any {$entity}",
            "view {$entity}",
            "create {$entity}",
            "update {$entity}",
            "delete {$entity}",
            "delete-any {$entity}",
            "restore {$entity}",
            "restore-any {$entity}",
            "replicate {$entity}",
            "reorder {$entity}",
            "force-delete {$entity}",
            "force-delete-any {$entity}",
        ];
    }

    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Créer toutes les permissions manquantes ──────────────────────────
        $toutes = array_merge(
            $this->crud('Reactif'),
            $this->crud('LotReactif'),
            $this->crud('Bacteriologie'),
            $this->crud('BilanUrinaire'),
            ['download BilanUrinaire'],
        );

        foreach ($toutes as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // ── Charger les rôles ────────────────────────────────────────────────
        $admin          = Role::findByName('administrateur', 'web');
        $laborantin     = Role::findByName('laborantin', 'web');
        $receptionniste = Role::findByName('receptionniste', 'web');

        // ── Administrateur : accès total sur tous les nouveaux modèles ───────
        if ($admin) {
            $admin->givePermissionTo(array_merge(
                $this->crud('Reactif'),
                $this->crud('LotReactif'),
                $this->crud('Bacteriologie'),
                $this->crud('BilanUrinaire'),
                ['download BilanUrinaire'],
            ));
        }

        // ── Laborantin ───────────────────────────────────────────────────────
        // Réactifs : lecture seule (voir le stock, pas gérer)
        // Lots     : aucun accès (stock agrégé visible via ReactifResource)
        // Bactério : CRUD complet (c'est leur domaine d'analyse)
        // Urinaire : lecture seule
        if ($laborantin) {
            $laborantin->givePermissionTo([
                'view-any Reactif',
                'view Reactif',

                'view-any Bacteriologie',
                'view Bacteriologie',
                'create Bacteriologie',
                'update Bacteriologie',
                'delete Bacteriologie',
                'delete-any Bacteriologie',

                'view-any BilanUrinaire',
                'view BilanUrinaire',
            ]);
        }

        // ── Réceptionniste ───────────────────────────────────────────────────
        // Bilan urinaire : CRUD + téléchargement PDF (même profil que Bilan général)
        // Réactifs, Lots, Bactériologie : aucun accès
        if ($receptionniste) {
            $receptionniste->givePermissionTo([
                'view-any BilanUrinaire',
                'view BilanUrinaire',
                'create BilanUrinaire',
                'update BilanUrinaire',
                'delete BilanUrinaire',
                'delete-any BilanUrinaire',
                'download BilanUrinaire',
            ]);
        }

        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $this->command->info('Permissions créées et assignées :');
        $this->command->info('  - Reactif      → administrateur (tout), laborantin (lecture)');
        $this->command->info('  - LotReactif   → administrateur (tout)');
        $this->command->info('  - Bacteriologie → administrateur (tout), laborantin (CRUD)');
        $this->command->info('  - BilanUrinaire → administrateur (tout), receptionniste (CRUD + PDF), laborantin (lecture)');
    }
}
