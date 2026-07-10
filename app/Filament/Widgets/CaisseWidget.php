<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\DB;

class CaisseWidget extends BaseWidget
{
    protected static ?int $sort = 10;
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected function getStats(): array
    {
        $today = now()->toDateString();
        $month = now()->month;
        $year  = now()->year;

        // Somme des tarifs des éléments rattachés aux bilans du jour
        $jourTotal = (int) DB::table('bilans')
            ->join('analyses', 'bilans.id', '=', 'analyses.bilan_id')
            ->join('elements', 'elements.id', '=', 'analyses.element_id')
            ->whereDate('bilans.created_at', $today)
            ->whereNotNull('elements.prix')
            ->sum('elements.prix');

        // Total du mois courant
        $moisTotal = (int) DB::table('bilans')
            ->join('analyses', 'bilans.id', '=', 'analyses.bilan_id')
            ->join('elements', 'elements.id', '=', 'analyses.element_id')
            ->whereMonth('bilans.created_at', $month)
            ->whereYear('bilans.created_at', $year)
            ->whereNotNull('elements.prix')
            ->sum('elements.prix');

        // Nombre de bilans facturés aujourd'hui (au moins 1 élément avec prix)
        $nbBilans = (int) DB::table('bilans')
            ->join('analyses', 'bilans.id', '=', 'analyses.bilan_id')
            ->join('elements', 'elements.id', '=', 'analyses.element_id')
            ->whereDate('bilans.created_at', $today)
            ->whereNotNull('elements.prix')
            ->distinct()
            ->count('bilans.id');

        return [
            Stat::make('Recettes du jour', number_format($jourTotal, 0, ',', ' ') . ' FC')
                ->description(now()->translatedFormat('l d F Y'))
                ->icon('heroicon-o-banknotes')
                ->color($jourTotal > 0 ? 'success' : 'gray'),

            Stat::make('Recettes du mois', number_format($moisTotal, 0, ',', ' ') . ' FC')
                ->description(now()->translatedFormat('F Y'))
                ->icon('heroicon-o-calendar-days')
                ->color('primary'),

            Stat::make('Bilans facturés aujourd\'hui', $nbBilans)
                ->description($nbBilans > 1 ? $nbBilans . ' bilans avec tarif' : ($nbBilans === 1 ? '1 bilan avec tarif' : 'Aucun bilan facturé'))
                ->icon('heroicon-o-document-check')
                ->color('warning'),
        ];
    }
}
