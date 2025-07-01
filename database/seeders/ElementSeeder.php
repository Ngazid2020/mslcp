<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ElementSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
