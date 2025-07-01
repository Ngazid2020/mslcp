<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
