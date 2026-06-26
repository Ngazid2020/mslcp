<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeder idempotent : à lancer sur une base existante pour ajouter la
 * permission "view Rapports" et les maladies par défaut.
 *
 * Usage :
 *   php artisan db:seed --class=RapportsPermissionSeeder
 */
class RapportsPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name'       => 'view Rapports',
            'guard_name' => 'web',
        ]);

        foreach (['administrateur', 'laborantin'] as $roleName) {
            $role = Role::findByName($roleName, 'web');
            if ($role && !$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }

        $this->command->info('Permission "view Rapports" créée et assignée à administrateur et laborantin.');

        // Peupler les maladies par défaut
        $this->call(MaladieSeeder::class);
    }
}
