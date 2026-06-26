<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\Patient;
use Filament\Notifications\Notification;
use Filament\Widgets\ChartWidget;

class PatientsAgePyramideWidget extends ChartWidget
{
    protected static ?string $heading   = 'Profil démographique';
    protected static ?int    $sort      = 5;
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

        if ($filter === 'tous') {
            $patients = Patient::all();
        } else {
            $patientIds = Bilan::query()
                ->whereYear('created_at', '=', (int) $filter)
                ->pluck('patient_id')
                ->unique();

            $patients = Patient::query()->whereIn('id', $patientIds)->get();
        }

        $groups  = ['0–4', '5–14', '15–24', '25–34', '35–44', '45–54', '55–64', '65+'];
        $bounds  = [[0,4],[5,14],[15,24],[25,34],[35,44],[45,54],[55,64],[65,130]];

        $hommes  = [];
        $femmes  = [];

        foreach ($bounds as [$min, $max]) {
            $subset   = $patients->filter(fn($p) => $p->age >= $min && $p->age <= $max);
            $hommes[] = $subset->where('sexe', 'M')->count();
            $femmes[] = $subset->where('sexe', 'F')->count();
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
