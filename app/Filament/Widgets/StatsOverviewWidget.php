<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\BilanUrinaire;
use App\Models\Patient;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected function getStats(): array
    {
        $now      = now();
        $prev     = now()->subMonthNoOverflow();

        $thisMonth = $this->countBilansForMonth($now->year, $now->month);
        $lastMonth = $this->countBilansForMonth($prev->year, $prev->month);
        $delta     = $thisMonth - $lastMonth;
        $deltaStr  = ($delta >= 0 ? '+' : '') . $delta . ' vs mois dernier';

        $totalPatients = Patient::query()->count();

        [$taux, $totalNum] = $this->tauxAnomalieCeMois($now);

        return [
            Stat::make('Bilans ce mois', $thisMonth)
                ->description($deltaStr)
                ->descriptionIcon($delta >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($delta >= 0 ? 'success' : 'warning')
                ->icon('heroicon-o-clipboard-document-list'),

            Stat::make('Patients enregistrés', $totalPatients)
                ->description('Total dans la base')
                ->descriptionIcon('heroicon-m-user-group')
                ->icon('heroicon-o-users')
                ->color('info'),

            Stat::make('Taux d\'anomalie', $taux . '%')
                ->description($totalNum . ' analyses numériques ce mois')
                ->descriptionIcon($taux > 25 ? 'heroicon-m-exclamation-triangle' : 'heroicon-m-check-circle')
                ->color($taux > 25 ? 'danger' : 'success')
                ->icon('heroicon-o-beaker'),
        ];
    }

    private function countBilansForMonth(int $year, int $month): int
    {
        return Bilan::query()->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count()
            + BilanUrinaire::query()->whereYear('created_at', '=', $year)->whereMonth('created_at', '=', $month)->count();
    }

    private function tauxAnomalieCeMois(Carbon $now): array
    {
        $bilans = Bilan::query()->with(['patient', 'elements'])
            ->whereYear('created_at', '=', $now->year)
            ->whereMonth('created_at', '=', $now->month)
            ->get();

        $total = 0;
        $anomalies = 0;

        foreach ($bilans as $bilan) {
            if (!$bilan->patient) {
                continue;
            }
            foreach ($bilan->elements as $element) {
                $resultat = $element->pivot->resultat;
                if (!is_numeric($resultat)) {
                    continue;
                }
                $total++;
                if ($element->isResultOutOfRange($resultat, $bilan->patient)) {
                    $anomalies++;
                }
            }
        }

        $taux = $total > 0 ? (int) round($anomalies / $total * 100) : 0;

        return [$taux, $total];
    }
}
