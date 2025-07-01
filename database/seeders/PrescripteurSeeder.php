<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PrescripteurSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
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
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'guard_name' => 'web']);
        }
    }
}
