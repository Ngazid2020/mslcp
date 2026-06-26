<?php

namespace Database\Seeders;

use App\Models\Maladie;
use Illuminate\Database\Seeder;

class MaladieSeeder extends Seeder
{
    public function run(): void
    {
        $maladies = [
            ['nom' => 'Paludisme',                  'code' => 'PAL'],
            ['nom' => 'Typhoïde',                   'code' => 'TYP'],
            ['nom' => 'Anémie',                     'code' => 'ANE'],
            ['nom' => 'Diabète',                    'code' => 'DIA'],
            ['nom' => 'Infection urinaire',         'code' => 'IU'],
            ['nom' => 'Parasitose intestinale',     'code' => 'PAR'],
            ['nom' => 'Infection respiratoire aiguë', 'code' => 'IRA'],
            ['nom' => 'Hépatite',                   'code' => 'HEP'],
            ['nom' => 'Tuberculose',                'code' => 'TUB'],
            ['nom' => 'Autres',                     'code' => null],
        ];

        foreach ($maladies as $data) {
            Maladie::firstOrCreate(
                ['nom' => $data['nom']],
                ['code' => $data['code'], 'actif' => true]
            );
        }
    }
}
