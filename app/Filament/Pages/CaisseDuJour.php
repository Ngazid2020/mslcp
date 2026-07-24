<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\DB;

class CaisseDuJour extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = "Bilans d'analyses";
    protected static ?string $navigationLabel = 'Caisse du jour';
    protected static ?int    $navigationSort  = 99;
    protected static string  $view            = 'filament.pages.caisse-du-jour';

    public string $selectedDate;
    public string $typeFilter      = 'tous';
    public string $mode            = 'jour';   // jour | mois | annee
    public string $selectedMois;
    public string $selectedAnnee;
    public string $prescripteurId  = '';

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    public function mount(): void
    {
        $this->selectedDate  = now()->toDateString();
        $this->selectedMois  = now()->format('m');
        $this->selectedAnnee = now()->format('Y');
    }

    public function getCaisseData(): array
    {
        $bilansQuery = DB::table('bilans')
            ->leftJoin('patients',      'patients.id',      '=', 'bilans.patient_id')
            ->leftJoin('prescripteurs', 'prescripteurs.id', '=', 'bilans.prescripteur_id')
            ->selectRaw("
                'bilan'   AS source,
                bilans.id,
                bilans.ref,
                COALESCE(bilans.type, 'general') AS type_bilan,
                bilans.created_at,
                TRIM(CONCAT(COALESCE(patients.prenom,''),' ',COALESCE(patients.nom,''))) AS patient_nom,
                prescripteurs.nom AS prescripteur_nom,
                (
                    SELECT COUNT(a.id) FROM analyses a
                    INNER JOIN elements e ON e.id = a.element_id
                    WHERE a.bilan_id = bilans.id AND e.prix IS NOT NULL
                ) AS nb_analyses_tarif,
                (
                    SELECT COALESCE(SUM(e.prix),0) FROM analyses a
                    INNER JOIN elements e ON e.id = a.element_id
                    WHERE a.bilan_id = bilans.id AND e.prix IS NOT NULL
                ) AS total_ligne
            ");

        $this->applyDateFilter($bilansQuery, 'bilans');

        if ($this->typeFilter === 'hormonal') {
            $bilansQuery->where('bilans.type', 'hormonal');
        } elseif ($this->typeFilter === 'general') {
            $bilansQuery->whereNull('bilans.type');
        }

        if ($this->prescripteurId !== '') {
            $bilansQuery->where('bilans.prescripteur_id', (int) $this->prescripteurId);
        }

        $urinairesQuery = DB::table('bilan_urinaires')
            ->leftJoin('patients',      'patients.id',      '=', 'bilan_urinaires.patient_id')
            ->leftJoin('prescripteurs', 'prescripteurs.id', '=', 'bilan_urinaires.prescripteur_id')
            ->selectRaw("
                'urinaire' AS source,
                bilan_urinaires.id,
                NULL AS ref,
                'urinaire' AS type_bilan,
                bilan_urinaires.created_at,
                TRIM(CONCAT(COALESCE(patients.prenom,''),' ',COALESCE(patients.nom,''))) AS patient_nom,
                prescripteurs.nom AS prescripteur_nom,
                0 AS nb_analyses_tarif,
                COALESCE(bilan_urinaires.prix, 0) AS total_ligne
            ");

        $this->applyDateFilter($urinairesQuery, 'bilan_urinaires');

        if ($this->prescripteurId !== '') {
            $urinairesQuery->where('bilan_urinaires.prescripteur_id', (int) $this->prescripteurId);
        }

        $lignes = match ($this->typeFilter) {
            'general', 'hormonal' => $bilansQuery->get(),
            'urinaire'            => $urinairesQuery->get(),
            default               => $bilansQuery->get()->concat($urinairesQuery->get()),
        };

        $lignes = $lignes->sortByDesc('created_at')->values();

        return [
            'lignes'      => $lignes,
            'grand_total' => (int) $lignes->sum('total_ligne'),
            'nb_total'    => $lignes->count(),
            'nb_factures' => $lignes->where('total_ligne', '>', 0)->count(),
        ];
    }

    private function applyDateFilter($query, string $table): void
    {
        $col = $table . '.created_at';
        match ($this->mode) {
            'mois'  => $query->whereYear($col, $this->selectedAnnee)
                             ->whereMonth($col, (int) $this->selectedMois),
            'annee' => $query->whereYear($col, $this->selectedAnnee),
            default => $query->whereDate($col, $this->selectedDate),
        };
    }

    public function getPeriodeLabel(): string
    {
        return match ($this->mode) {
            'mois'  => \Carbon\Carbon::createFromDate((int) $this->selectedAnnee, (int) $this->selectedMois, 1)
                           ->translatedFormat('F Y'),
            'annee' => 'Année ' . $this->selectedAnnee,
            default => \Carbon\Carbon::parse($this->selectedDate)->translatedFormat('l d F Y'),
        };
    }

    public function getTotalLabel(): string
    {
        return match ($this->mode) {
            'mois'  => 'Total du mois',
            'annee' => "Total de l'année",
            default => 'Total du jour',
        };
    }

    public function getDateOptions(): array
    {
        $options = [];
        for ($i = 0; $i < 60; $i++) {
            $date  = now()->subDays($i)->toDateString();
            $label = match ($i) {
                0 => "Aujourd'hui (" . now()->format('d/m/Y') . ')',
                1 => "Hier (" . now()->subDay()->format('d/m/Y') . ')',
                default => now()->subDays($i)->translatedFormat('l d F Y'),
            };
            $options[$date] = $label;
        }
        return $options;
    }

    public function getMoisOptions(): array
    {
        $options = [];
        for ($m = 1; $m <= 12; $m++) {
            $key = str_pad((string) $m, 2, '0', STR_PAD_LEFT);
            $options[$key] = \Carbon\Carbon::createFromDate(2000, $m, 1)->translatedFormat('F');
        }
        return $options;
    }

    public function getAnneeOptions(): array
    {
        $options = [];
        for ($y = (int) now()->format('Y'); $y >= 2024; $y--) {
            $options[(string) $y] = (string) $y;
        }
        return $options;
    }

    public function getPrescripteurOptions(): array
    {
        return DB::table('prescripteurs')
            ->orderBy('nom')
            ->pluck('nom', 'id')
            ->toArray();
    }

    public function getPdfUrl(): string
    {
        return route('pdf.caisse', [
            'mode'            => $this->mode,
            'date'            => $this->selectedDate,
            'mois'            => $this->selectedMois,
            'annee'           => $this->selectedAnnee,
            'type_filter'     => $this->typeFilter,
            'prescripteur_id' => $this->prescripteurId,
        ]);
    }
}
