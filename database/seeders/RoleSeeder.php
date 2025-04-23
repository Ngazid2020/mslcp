<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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

            // ajoutez ici toutes vos autres permissions
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,
        'guard_name' => 'web']);
        }
    }
}
