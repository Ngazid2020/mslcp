<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Element;
use Illuminate\Database\Seeder;

class AnalysisCatalogSeeder extends Seeder
{
    /**
     * Correspondance type catalogue → type_valeur Element :
     *   numeric / titre          → 'numerique'
     *   qualitative pos/neg      → 'positif/negatif'
     *   blood_group / qualitatif → 'qualitatif'
     *   rhesus                   → 'positif/negatif'
     *
     * Les valeurs de référence génériques (ref_min/ref_max) sont affectées
     * aux tranches homme et femme adulte ; les autres tranches restent null
     * (à compléter manuellement si nécessaire).
     */
    public function run(): void
    {
        // [nom, unite, type_valeur, ref_min, ref_max]
        $catalog = [

            // ── Hématologie (NFS) ─────────────────────────────────────────────
            'Hématologie (NFS)' => [
                ['Hématocrite',                      '%',            'numerique',      null,  null  ],
                ['Hémoglobine',                      'g/dl',         'numerique',      null,  null  ],
                ['Globules rouges',                  '/mm3',         'numerique',      null,  null  ],
                ['MCHC',                             'g/l',          'numerique',      null,  null  ],
                ['Globules blancs',                  '/mm3',         'numerique',      null,  null  ],
                ['MCV (Volume globulaire moyen)',     'µ3',           'numerique',      null,  null  ],
                ['Plaquettes',                       '/mm3',         'numerique',      null,  null  ],
                ['Groupe sanguin',                   null,           'qualitatif',     null,  null  ],
                ['Rhésus',                           null,           'positif/negatif',null,  null  ],
                ['Polynucléaires neutrophiles',      '%',            'numerique',      null,  null  ],
                ['Polynucléaires éosinophiles',      '%',            'numerique',      null,  null  ],
                ['Lymphocytes',                      '%',            'numerique',      null,  null  ],
                ['Monocytes',                        '%',            'numerique',      null,  null  ],
                ['Vitesse de sédimentation',         'mm/h',         'numerique',      null,  null  ],
            ],

            // ── Hémostase ─────────────────────────────────────────────────────
            'Hémostase' => [
                ['Taux de prothrombine',             '%',    'numerique', 75,    100   ],
                ['INR',                              null,   'numerique', 0.9,   1.32  ],
                ['Temps de céphaline kaolin',        's',    'numerique', 25,    45    ],
                ['Temps de Quick',                   '%',    'numerique', null,  null  ],
                ['Temps de coagulation',             's',    'numerique', 6,     9     ],
                ['Temps de saignement',              's',    'numerique', 2,     6     ],
            ],

            // ── Parasitologie ─────────────────────────────────────────────────
            'Parasitologie' => [
                ['Goutte épaisse',                   null,           'positif/negatif', null, null ],
                ['Densité parasitaire',              '/µl de sang',  'numerique',       null, null ],
                ['Charge (FG)',                      '/µl de sang',  'numerique',       null, null ],
                ['Microfilaire',                     null,           'positif/negatif', null, null ],
                ["Test d'Emel",                      null,           'positif/negatif', null, null ],
            ],

            // ── Gynécologie ───────────────────────────────────────────────────
            'Gynécologie' => [
                ['DIG',                              null,   'qualitatif', null, null ],
            ],

            // ── Immunologie – Sérologie ───────────────────────────────────────
            'Immunologie – Sérologie' => [
                ['VDRL',                             null,   'positif/negatif', null, null ],
                ['TPHA',                             null,   'positif/negatif', null, null ],
                ['Chlamydia',                        null,   'positif/negatif', null, null ],
                ['Sérologie Chlamydia',              null,   'numerique',       null, null ],
                ['ASLO',                             'UI',   'numerique',       null, 200  ],
                ['Arthritest',                       null,   'positif/negatif', null, null ],
                ['HIV',                              null,   'positif/negatif', null, null ],
                ['Widal TO',                         null,   'numerique',       null, null ],
                ['Widal TH',                         null,   'numerique',       null, null ],
                ['CRP',                              'mg/l', 'numerique',       null, 6    ],
            ],

            // ── Biochimie ─────────────────────────────────────────────────────
            'Biochimie' => [
                // Divers
                ['Glycémie post-prandiale',          'g/l',   'numerique', 1.4,  2.6  ],
                ['Glycémie à jeun',                  'g/l',   'numerique', 0.6,  1.1  ],
                ['Protéine totale (Adulte)',          'g/l',   'numerique', 66,   83   ],
                ['Protéine totale (Nouveau-né)',      'g/l',   'numerique', 52,   91   ],
                ['Acide urique',                     'mg/l',  'numerique', 25,   77   ],
                // Bilan rénal
                ['Urée',                             'g/l',   'numerique', 0.15, 0.45 ],
                ['Créatinine',                       'mg/l',  'numerique', 8,    14   ],
                ['Amylase',                          'UI/l',  'numerique', null, 90   ],
                // Bilan lipidique
                ['Cholestérol',                      'g/l',   'numerique', 1.4,  2.4  ],
                ['Triglycérides',                    'g/l',   'numerique', 0.35, 1.6  ],
                ['LDL',                              'g/l',   'numerique', 0.8,  1.6  ],
                ['HDL',                              'g/l',   'numerique', 0.35, 0.65 ],
                // Bilan hépatique
                ['SGOT (ASAT)',                      'UI/l',  'numerique', null, 46   ],
                ['SGPT (ALAT)',                      'UI',    'numerique', null, 49   ],
                ['Gamma GT (δGT)',                   'UI',    'numerique', 6,    50   ],
                ['Phosphatase alcaline (ALP)',        'UI/l',  'numerique', null, null ],
                ['Bilirubine directe',               'mg/l',  'numerique', null, 2.5  ],
                ['Bilirubine indirecte',             'mg/l',  'numerique', null, 7.5  ],
                ['Bilirubine totale',                'mg/l',  'numerique', null, null ],
                // Ionogramme
                ['Calcémie',                         'mg/l',  'numerique', 85,   105  ],
                ['Magnésium',                        'mg/l',  'numerique', 16,   25   ],
                ['Phosphore',                        'mg/l',  'numerique', 25,   50   ],
                ['Potassium',                        'mmol/l','numerique', 3.5,  5.3  ],
                ['Sodium',                           'mmol/l','numerique', 135,  155  ],
                ['Chlore',                           'mmol/l','numerique', 95,   115  ],
                // Enzymes cardiaques
                ['CPK',                              'UI/l',  'numerique', 26,   192  ],
                ['CK-MB',                            'UI/l',  'numerique', null, 25   ],
                ['LDH',                              'UI/l',  'numerique', 120,  420  ],
                ['CK-NAC',                           'UI/l',  'numerique', null, null ],
            ],

            // ── Bilan hépatite ────────────────────────────────────────────────
            'Bilan hépatite' => [
                ['Anticorps hépatite',               null,   'positif/negatif', null, null ],
                ['Antigène HBs',                     null,   'positif/negatif', null, null ],
                ['Helicobacter Pylori IgG',          'U/ml', 'numerique',       null, 5    ],
            ],

            // ── Sérologie prénatale ───────────────────────────────────────────
            'Sérologie prénatale' => [
                ['Toxoplasmose Latex',               null,    'positif/negatif', null, null ],
                ['Toxoplasmose IgG',                 'UI/ml', 'numerique',       25,   35   ],
                ['Toxoplasmose IgM',                 'UI/ml', 'numerique',       null, 10   ],
                ['Rubéole Latex',                    null,    'positif/negatif', null, null ],
                ['Rubéole IgG',                      'UI/ml', 'numerique',       25,   35   ],
                ['Rubéole IgM',                      'UI/ml', 'numerique',       null, 15   ],
            ],
        ];

        $created  = 0;
        $updated  = 0;
        $catCount = 0;

        foreach ($catalog as $categoryName => $elements) {
            [$category, $catNew] = [
                Category::firstOrCreate(['name' => $categoryName]),
                false,
            ];

            if ($category->wasRecentlyCreated) {
                $catCount++;
            }

            foreach ($elements as [$nom, $unite, $typeValeur, $refMin, $refMax]) {
                $element = Element::updateOrCreate(
                    ['nom' => $nom, 'category_id' => $category->id],
                    [
                        'unite'       => $unite,
                        'type_valeur' => $typeValeur,
                        'ref_inf_h'   => $refMin,
                        'ref_sup_h'   => $refMax,
                        'ref_inf_f'   => $refMin,
                        'ref_sup_f'   => $refMax,
                    ]
                );

                $element->wasRecentlyCreated ? $created++ : $updated++;
            }
        }

        $this->command->info(
            "Catalogue inséré : {$catCount} catégorie(s) créée(s), " .
            "{$created} élément(s) créé(s), {$updated} mis à jour."
        );
    }
}
