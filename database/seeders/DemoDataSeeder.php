<?php

namespace Database\Seeders;

use App\Models\Bilan;
use App\Models\BilanUrinaire;
use App\Models\Category;
use App\Models\Element;
use App\Models\Maladie;
use App\Models\Patient;
use App\Models\Prescripteur;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Données de démonstration MSLCP — Comores.
 *
 * Génère ~180 bilans généraux + 30 bilans urinaires répartis sur 12 mois,
 * avec saisonnalité réaliste du paludisme (pic janvier-mars).
 *
 * Peut être lancé sur une base existante (ajoute des données sans supprimer).
 *
 * Usage :
 *   php artisan db:seed --class=DemoDataSeeder
 *
 * Pour repartir de zéro :
 *   php artisan migrate:fresh --seed
 */
class DemoDataSeeder extends Seeder
{
    // Taux de positivité goutte épaisse par mois (%) — saisonnalité Comores
    private const MALARIA_RATE = [
        1 => 48, 2 => 55, 3 => 44, 4 => 36,
        5 => 22, 6 => 14, 7 => 11, 8 => 15,
        9 => 25, 10 => 32, 11 => 40, 12 => 46,
    ];

    // Nombre de bilans généraux à créer par mois
    private const BILANS_PAR_MOIS = [
        1 => 18, 2 => 22, 3 => 20, 4 => 16,
        5 => 12, 6 => 10, 7 =>  9, 8 => 11,
        9 => 14, 10 => 16, 11 => 18, 12 => 20,
    ];

    // Noms comoriens
    private const NOMS_H = [
        'Ahmed', 'Said', 'Mohamed', 'Abdallah', 'Hamid', 'Ibrahim', 'Abou',
        'Omar', 'Youssouf', 'Hassan', 'Ali', 'Abdou', 'Farouk', 'Nassuf',
        'Salim', 'Nourdine', 'Souef', 'Toiha', 'Mikidadi', 'Anrifa',
    ];

    private const NOMS_F = [
        'Fatima', 'Mariama', 'Amina', 'Zahara', 'Naïma', 'Aïcha', 'Soifiat',
        'Miremane', 'Houmadi', 'Zoubeida', 'Djamila', 'Nafissatou', 'Saindou',
        'Mouneissa', 'Karidata', 'Roukia', 'Zaliha', 'Ramlati', 'Mwanamke', 'Touria',
    ];

    private const NOMS_FAMILLE = [
        'Abdallah', 'Said', 'Mohamed', 'Ibrahim', 'Hassan', 'Ali', 'Ahmed',
        'Houssein', 'Omar', 'Anrifa', 'Nassuf', 'Hamada', 'Boina', 'Mze',
        'Youssouf', 'Madi', 'Salim', 'Combo', 'Djounaid', 'Mdahoma',
    ];

    private const VILLES = [
        'Moroni', 'Mitsamiouli', 'Itsandra', 'Ntsaouéni', 'Vouvouni',
        'Fomboni', 'Mutsamudu', 'Domoni', 'Bandamadji', 'Ouani',
        'Tsémbehou', 'Chironkamba', 'Bahani', 'Hahaya', 'Ngazidja',
    ];

    public function run(): void
    {
        $this->command->info('Création des patients comoriens...');
        $patients = $this->creerPatients(80);

        $prescripteurs = Prescripteur::all();
        if ($prescripteurs->isEmpty()) {
            Prescripteur::factory(8)->create();
            $prescripteurs = Prescripteur::all();
        }

        $this->command->info('Récupération des éléments d\'analyse...');
        $elements = Element::with('category')->get()->keyBy('nom');
        $maladies = Maladie::all()->keyBy('nom');
        $annee    = now()->year;

        $this->command->info('Génération des bilans généraux...');
        $this->creerBilansGeneraux($patients, $prescripteurs, $elements, $maladies, $annee);

        $this->command->info('Génération des bilans urinaires...');
        $this->creerBilansUrinaires($patients, $prescripteurs, $annee);

        $this->command->info('Données de démonstration créées avec succès.');
    }

    // ─────────────────────────────────────────────────────────────────────────

    /** @return \Illuminate\Database\Eloquent\Collection<int, Patient> */
    private function creerPatients(int $count)
    {
        $created = [];

        for ($i = 0; $i < $count; $i++) {
            $sexe   = fake()->randomElement(['M', 'F']);
            $prenoms = $sexe === 'M' ? self::NOMS_H : self::NOMS_F;
            $age    = fake()->numberBetween(1, 75);

            $created[] = Patient::create([
                'nom'           => fake()->randomElement(self::NOMS_FAMILLE),
                'prenom'        => fake()->randomElement($prenoms),
                'sexe'          => $sexe,
                'age'           => $age,
                'domicile'      => fake()->randomElement(self::VILLES),
                'lieu_naissance'=> fake()->randomElement(self::VILLES),
                'tel'           => '33' . fake()->numberBetween(10000000, 99999999),
            ]);
        }

        // Inclure les patients déjà en base
        return Patient::all();
    }

    private function creerBilansGeneraux(
        $patients,
        $prescripteurs,
        $elements,
        $maladies,
        int $annee
    ): void {
        // Éléments NFS standard
        $nfsNoms = [
            'Hémoglobine', 'Hématocrite', 'Globules rouges',
            'VGM', 'TCMH', 'CCMH',
        ];
        $formulaNoms = [
            'Leucocytes', 'Neutrophiles', 'Lymphocytes', 'Monocytes', 'Éosinophiles',
        ];
        $platNom   = 'Plaquettes';
        $gouteNom  = 'Goutte épaisse / Frottis sanguin';

        $nfsElements    = array_filter($nfsNoms, fn($n) => isset($elements[$n]));
        $formulaElements= array_filter($formulaNoms, fn($n) => isset($elements[$n]));
        $hasPlaqs       = isset($elements[$platNom]);
        $hasGoute       = isset($elements[$gouteNom]);

        $maladiePaludisme = $maladies['Paludisme'] ?? null;
        $maladieAnemie    = $maladies['Anémie']    ?? null;

        foreach (self::BILANS_PAR_MOIS as $mois => $nb) {
            for ($i = 0; $i < $nb; $i++) {
                $patient    = $patients->random();
                $prescripteur = $prescripteurs->random();

                // Date aléatoire dans le mois
                $jour  = fake()->numberBetween(1, 28);
                $date  = Carbon::create($annee, $mois, $jour, fake()->numberBetween(7, 17), 0, 0);

                $bilan = Bilan::create([
                    'patient_id'      => $patient->id,
                    'prescripteur_id' => $prescripteur->id,
                ]);

                // Backdate
                DB::table('bilans')->where('id', $bilan->id)->update([
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);

                $malariaPositif = $this->tirage(self::MALARIA_RATE[$mois]);
                $anemie         = false;

                // ── NFS ──────────────────────────────────────────────────
                foreach ($nfsNoms as $nom) {
                    if (! isset($elements[$nom])) {
                        continue;
                    }
                    $element  = $elements[$nom];
                    $resultat = $this->valeurNFS($nom, $patient->sexe, $patient->age, $malariaPositif);
                    $bilan->elements()->attach($element->id, ['resultat' => $resultat]);

                    if ($nom === 'Hémoglobine' && $resultat < $this->seuilAnemie($patient->sexe, $patient->age)) {
                        $anemie = true;
                    }
                }

                // ── Formule sanguine ─────────────────────────────────────
                foreach ($formulaNoms as $nom) {
                    if (! isset($elements[$nom])) {
                        continue;
                    }
                    $bilan->elements()->attach($elements[$nom]->id, [
                        'resultat' => $this->valeurFormule($nom, $malariaPositif),
                    ]);
                }

                // ── Plaquettes ────────────────────────────────────────────
                if ($hasPlaqs) {
                    $plaqs = $malariaPositif
                        ? fake()->numberBetween(60, 149)   // thrombocytopénie fréquente
                        : fake()->numberBetween(150, 420);
                    $bilan->elements()->attach($elements[$platNom]->id, ['resultat' => $plaqs]);
                }

                // ── Goutte épaisse ────────────────────────────────────────
                if ($hasGoute) {
                    $resultatGoute = $malariaPositif
                        ? fake()->randomElement(['+', '+', '+', '++', '++', '+++', '++++'])
                        : 'négatif';
                    $bilan->elements()->attach($elements[$gouteNom]->id, ['resultat' => $resultatGoute]);
                }

                // ── Maladies ──────────────────────────────────────────────
                $maladiesIds = [];
                if ($malariaPositif && $maladiePaludisme) {
                    $maladiesIds[] = $maladiePaludisme->id;
                }
                if ($anemie && $maladieAnemie) {
                    $maladiesIds[] = $maladieAnemie->id;
                }
                if (! empty($maladiesIds)) {
                    $bilan->maladies()->attach($maladiesIds);
                }
            }
        }
    }

    private function creerBilansUrinaires($patients, $prescripteurs, int $annee): void
    {
        $moisDistrib = [1 => 3, 2 => 2, 3 => 3, 4 => 2, 5 => 2, 6 => 2,
                        7 => 2, 8 => 2, 9 => 3, 10 => 3, 11 => 3, 12 => 3];

        foreach ($moisDistrib as $mois => $nb) {
            for ($i = 0; $i < $nb; $i++) {
                $patient      = $patients->random();
                $prescripteur = $prescripteurs->random();
                $infection    = $this->tirage(30); // 30% d'infection urinaire

                $jour = fake()->numberBetween(1, 28);
                $date = Carbon::create($annee, $mois, $jour, fake()->numberBetween(7, 15), 0, 0);

                $bu = BilanUrinaire::create([
                    'patient_id'      => $patient->id,
                    'prescripteur_id' => $prescripteur->id,
                    // Bandelette urinaire
                    'urobilinogene'   => fake()->randomElement(['Normal', 'Normal', 'Élevé']),
                    'albumine'        => $infection ? fake()->randomElement(['+', '++']) : 'Négatif',
                    'sucre'           => $this->tirage(10) ? '+' : 'Négatif',
                    'acetone'         => 'Négatif',
                    'ph'              => fake()->randomElement(['5.5', '6.0', '6.5', '7.0', '7.5']),
                    'bilirubine'      => 'Négatif',
                    'densite'         => '1.0' . fake()->numberBetween(10, 25),
                    'sang'            => $infection ? fake()->randomElement(['+', '++', 'Négatif']) : 'Négatif',
                    'nitrite'         => $infection ? 'Positif' : 'Négatif',
                    'leucocytes'      => $infection ? fake()->randomElement(['+', '++', '+++']) : 'Négatif',
                    // Microscopie
                    'aspect_urines'          => $infection ? 'Trouble' : 'Limpide',
                    'leucocytes_micro'       => $infection ? fake()->numberBetween(20, 150) . '/mm³' : '< 10/mm³',
                    'hematies'               => $infection ? fake()->numberBetween(5, 50) . '/mm³' : '< 5/mm³',
                    'bacteries'              => $infection ? 'Présentes (nombreuses)' : 'Absentes',
                    'cellules_epitheliales'  => fake()->randomElement(['Rares', 'Quelques', 'Absentes']),
                    'parasites'              => 'Absents',
                    'elements_fongiques'     => 'Absents',
                    'cristaux'               => fake()->randomElement(['Absents', 'Rares oxalates']),
                    // Culture / conclusion
                    'coloration_gram'        => $infection ? 'BGN (Bacilles Gram Négatif)' : null,
                    'culture'                => $infection
                        ? fake()->randomElement([
                            'E. coli > 10⁵ UFC/mL',
                            'Klebsiella pneumoniae > 10⁵ UFC/mL',
                            'Proteus mirabilis > 10⁵ UFC/mL',
                          ])
                        : 'Stérile',
                    'conclusion'             => $infection
                        ? 'Infection urinaire confirmée — antibiogramme disponible'
                        : 'Pas d\'anomalie significative',
                ]);

                DB::table('bilan_urinaires')->where('id', $bu->id)->update([
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    /** Retourne true avec une probabilité de $pct pourcent. */
    private function tirage(int $pct): bool
    {
        return fake()->numberBetween(1, 100) <= $pct;
    }

    private function seuilAnemie(string $sexe, int $age): float
    {
        if ($age < 1)  return 10.5;
        if ($age < 5)  return 11.0;
        if ($age < 16) return 11.5;
        return $sexe === 'F' ? 12.0 : 13.0;
    }

    private function valeurNFS(string $nom, string $sexe, int $age, bool $malaria): float|int
    {
        // En cas de paludisme : anémie probable (50% de chance)
        $anemieInduced = $malaria && $this->tirage(50);

        return match($nom) {
            'Hémoglobine' => $this->hb($sexe, $age, $anemieInduced),
            'Hématocrite' => $this->hb($sexe, $age, $anemieInduced) * 3.0 + fake()->randomFloat(1, -2, 2),
            'Globules rouges' => $anemieInduced
                ? round(fake()->randomFloat(2, 2.8, 3.9), 2)
                : round(fake()->randomFloat(2,
                    ($sexe === 'F' ? 3.8 : 4.2),
                    ($sexe === 'F' ? 5.4 : 6.0)
                  ), 2),
            'VGM'  => $anemieInduced
                ? fake()->numberBetween(58, 79)
                : fake()->numberBetween(80, 100),
            'TCMH' => $anemieInduced
                ? fake()->numberBetween(18, 26)
                : fake()->numberBetween(27, 33),
            'CCMH' => fake()->numberBetween(30, 36),
            default => 0,
        };
    }

    private function hb(string $sexe, int $age, bool $anemie): float
    {
        if ($anemie) {
            $min = 5.5; $max = 11.5;
        } elseif ($age < 1) {
            $min = 13.5; $max = 19.5;
        } elseif ($age < 5) {
            $min = 10.0; $max = 13.5;
        } elseif ($age < 16) {
            $min = 11.0; $max = 14.5;
        } elseif ($sexe === 'F') {
            $min = 11.5; $max = 16.2;
        } else {
            $min = 12.5; $max = 17.8;
        }

        return round(fake()->randomFloat(1, $min, $max), 1);
    }

    private function valeurFormule(string $nom, bool $malaria): float
    {
        return match($nom) {
            'Leucocytes'   => $malaria
                ? round(fake()->randomFloat(1, 3.5, 6.5), 1)   // leucopénie modérée dans le paludisme
                : round(fake()->randomFloat(1, 4.0, 10.5), 1),
            'Neutrophiles' => $malaria
                ? round(fake()->randomFloat(1, 40.0, 65.0), 1)
                : round(fake()->randomFloat(1, 48.0, 70.0), 1),
            'Lymphocytes'  => round(fake()->randomFloat(1, 20.0, 40.0), 1),
            'Monocytes'    => round(fake()->randomFloat(1, 2.0, 10.0), 1),
            'Éosinophiles' => round(fake()->randomFloat(1, 0.0, 7.0), 1),
            default        => 0.0,
        };
    }
}
