<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Seeder idempotent : peut être lancé sur une base existante sans tout réinitialiser.
 *
 * Usage :
 *   php artisan db:seed --class=StatistiquesPermissionSeeder
 */
class StatistiquesPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permission = Permission::firstOrCreate([
            'name'       => 'view Statistiques',
            'guard_name' => 'web',
        ]);

        foreach (['administrateur', 'laborantin'] as $roleName) {
            $role = Role::findByName($roleName, 'web');
            if ($role && !$role->hasPermissionTo($permission)) {
                $role->givePermissionTo($permission);
            }
        }

        $this->command->info('Permission "view Statistiques" créée et assignée à administrateur et laborantin.');
    }
}
