<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CaisseDuJour extends Page
{
    protected static ?string $navigationIcon  = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = "Bilans d'analyses";
    protected static ?string $navigationLabel = 'Caisse du jour';
    protected static ?int    $navigationSort  = 99;
    protected static string  $view            = 'filament.pages.caisse-du-jour';

    public string $selectedDate;
    public string $typeFilter = 'tous';

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    public function mount(): void
    {
        $this->selectedDate = now()->toDateString();
    }

    /**
     * Retourne toutes les lignes du jour (bilans + urinaires), fusionnées et triées par heure.
     *
     * @return array{lignes: Collection, grand_total: int, nb_total: int, nb_factures: int}
     */
    public function getCaisseData(): array
    {
        $date = $this->selectedDate;

        // ── Bilans généraux / hormonaux ───────────────────────────────────────
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
            ")
            ->whereDate('bilans.created_at', $date);

        if ($this->typeFilter === 'hormonal') {
            $bilansQuery->where('bilans.type', 'hormonal');
        } elseif ($this->typeFilter === 'general') {
            $bilansQuery->whereNull('bilans.type');
        }

        // ── Bilans urinaires ──────────────────────────────────────────────────
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
            ")
            ->whereDate('bilan_urinaires.created_at', $date);

        // ── Fusion selon le filtre ────────────────────────────────────────────
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

    /** 60 derniers jours pour le sélecteur. */
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

    /** URL vers le PDF de la journée sélectionnée. */
    public function getPdfUrl(): string
    {
        return route('pdf.caisse', [
            'date'        => $this->selectedDate,
            'type_filter' => $this->typeFilter,
        ]);
    }
}
