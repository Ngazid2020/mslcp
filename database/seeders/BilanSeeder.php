<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class BilanSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
