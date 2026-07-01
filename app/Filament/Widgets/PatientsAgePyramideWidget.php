<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\Patient;
use Filament\Notifications\Notification;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class PatientsAgePyramideWidget extends ChartWidget
{
    protected static ?string $heading   = 'Profil démographique';
    protected static ?int    $sort      = 6;
    protected static string  $view      = 'filament.widgets.clickable-chart-widget';
    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected function getFilters(): ?array
    {
        $year = now()->year;

        return [
            (string) $year       => 'Année ' . $year,
            (string) ($year - 1) => 'Année ' . ($year - 1),
            'tous'               => 'Tous les patients',
        ];
    }

    public function getHeading(): string
    {
        $year = now()->year;
        $labels = [
            (string) $year       => 'Année ' . $year,
            (string) ($year - 1) => 'Année ' . ($year - 1),
            'tous'               => 'Tous les patients',
        ];
        $filter = $this->filter ?? (string) $year;

        return 'Profil démographique — ' . ($labels[$filter] ?? $filter);
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? (string) now()->year;

        $groups = ['0–4', '5–14', '15–24', '25–34', '35–44', '45–54', '55–64', '65+'];

        $caseExpr = 'CASE
            WHEN age BETWEEN 0 AND 4 THEN 0
            WHEN age BETWEEN 5 AND 14 THEN 1
            WHEN age BETWEEN 15 AND 24 THEN 2
            WHEN age BETWEEN 25 AND 34 THEN 3
            WHEN age BETWEEN 35 AND 44 THEN 4
            WHEN age BETWEEN 45 AND 54 THEN 5
            WHEN age BETWEEN 55 AND 64 THEN 6
            ELSE 7 END';

        $query = Patient::query()
            ->selectRaw("sexe, ($caseExpr) as tranche_idx, COUNT(*) as n")
            ->groupByRaw("sexe, tranche_idx");

        if ($filter !== 'tous') {
            $patientIds = Bilan::query()
                ->whereYear('created_at', '=', (int) $filter)
                ->distinct()
                ->pluck('patient_id');
            $query->whereIn('id', $patientIds);
        }

        $rows   = $query->get();
        $hommes = array_fill(0, 8, 0);
        $femmes = array_fill(0, 8, 0);

        foreach ($rows as $row) {
            $idx = (int) $row->tranche_idx;
            if ($row->sexe === 'M') {
                $hommes[$idx] = (int) $row->n;
            } elseif ($row->sexe === 'F') {
                $femmes[$idx] = (int) $row->n;
            }
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Hommes',
                    'data'            => $hommes,
                    'backgroundColor' => '#2e6fb8',
                    'borderRadius'    => 3,
                ],
                [
                    'label'           => 'Femmes',
                    'data'            => $femmes,
                    'backgroundColor' => '#c0392b',
                    'borderRadius'    => 3,
                ],
            ],
            'labels' => $groups,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function handleChartClick(int $index, int $datasetIndex, string $label): void
    {
        $cached = $this->getCachedData();
        $hommes = $cached['datasets'][0]['data'][$index] ?? 0;
        $femmes = $cached['datasets'][1]['data'][$index] ?? 0;
        $total  = $hommes + $femmes;

        Notification::make()
            ->title('Tranche ' . $label . ' ans')
            ->body($total . ' patient(s) · ' . $hommes . ' homme(s), ' . $femmes . ' femme(s)')
            ->info()
            ->send();
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis' => 'y',
            'plugins'   => [
                'legend' => ['display' => true, 'position' => 'top'],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'ticks'       => ['precision' => 0],
                    'title'       => ['display' => true, 'text' => 'Nombre de patients'],
                ],
                'y' => [
                    'title' => ['display' => true, 'text' => 'Tranche d\'âge'],
                ],
            ],
        ];
    }
}
