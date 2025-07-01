<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PatientSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
