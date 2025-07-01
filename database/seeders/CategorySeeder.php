<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
