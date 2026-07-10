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

    public static function canAccess(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    public function mount(): void
    {
        $this->selectedDate = now()->toDateString();
    }

    /**
     * Retourne la liste des bilans du jour avec le total par bilan et le grand total.
     * Un seul aller-retour en base via deux sous-requêtes corrélées.
     *
     * @return array{bilans: \Illuminate\Support\Collection, grand_total: int, nb_bilans: int, nb_factures: int}
     */
    public function getCaisseData(): array
    {
        $bilans = DB::table('bilans')
            ->leftJoin('patients',      'patients.id',      '=', 'bilans.patient_id')
            ->leftJoin('prescripteurs', 'prescripteurs.id', '=', 'bilans.prescripteur_id')
            ->selectRaw("
                bilans.id,
                bilans.ref,
                bilans.type,
                bilans.created_at,
                TRIM(CONCAT(COALESCE(patients.prenom, ''), ' ', COALESCE(patients.nom, ''))) AS patient_nom,
                prescripteurs.nom AS prescripteur_nom,
                (
                    SELECT COUNT(analyses.id)
                    FROM analyses
                    INNER JOIN elements ON elements.id = analyses.element_id
                    WHERE analyses.bilan_id = bilans.id
                      AND elements.prix IS NOT NULL
                ) AS nb_analyses_tarif,
                (
                    SELECT COALESCE(SUM(elements.prix), 0)
                    FROM analyses
                    INNER JOIN elements ON elements.id = analyses.element_id
                    WHERE analyses.bilan_id = bilans.id
                      AND elements.prix IS NOT NULL
                ) AS total_bilan
            ")
            ->whereDate('bilans.created_at', $this->selectedDate)
            ->orderBy('bilans.created_at', 'desc')
            ->get();

        return [
            'bilans'      => $bilans,
            'grand_total' => (int) $bilans->sum('total_bilan'),
            'nb_bilans'   => $bilans->count(),
            'nb_factures' => $bilans->where('total_bilan', '>', 0)->count(),
        ];
    }

    /** Retourne les 60 derniers jours pour le sélecteur de date. */
    public function getDateOptions(): array
    {
        $options = [];
        for ($i = 0; $i < 60; $i++) {
            $date = now()->subDays($i)->toDateString();
            $label = match ($i) {
                0 => "Aujourd'hui (" . now()->format('d/m/Y') . ')',
                1 => "Hier (" . now()->subDay()->format('d/m/Y') . ')',
                default => now()->subDays($i)->translatedFormat('l d F Y'),
            };
            $options[$date] = $label;
        }
        return $options;
    }
}
