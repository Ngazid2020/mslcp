<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use Filament\Notifications\Notification;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Cache;

class TopAnormaliesWidget extends ChartWidget
{
    protected static ?string $heading   = 'Top 10 anomalies';
    protected static ?int    $sort      = 4;
    protected static string  $view      = 'filament.widgets.clickable-chart-widget';
    protected int|string|array $columnSpan = 1;

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected function getFilters(): ?array
    {
        return [
            '3'  => '3 derniers mois',
            '6'  => '6 derniers mois',
            '12' => '12 derniers mois',
        ];
    }

    public function getHeading(): string
    {
        $n = (int) ($this->filter ?? 6);

        return 'Top 10 anomalies — ' . $n . ' derniers mois';
    }

    protected function getData(): array
    {
        $months = (int) ($this->filter ?? 6);

        // On cache le résultat final (petit tableau), pas la collection Eloquent brute
        return Cache::remember("top_anomalies_chart_{$months}", 300, function () use ($months) {
            $bilans = Bilan::query()
                ->with(['patient', 'elements'])
                ->where('created_at', '>=', now()->subMonths($months))
                ->get();

            /** @var array<string, array{total: int, anomal: int}> $stats */
            $stats = [];

            foreach ($bilans as $bilan) {
                if (! $bilan->patient) {
                    continue;
                }
                foreach ($bilan->elements as $element) {
                    $resultat = $element->pivot->resultat;
                    if ($resultat === null || $resultat === '') {
                        continue;
                    }
                    if ($element->type_valeur !== 'qualitatif' && ! is_numeric($resultat)) {
                        continue;
                    }
                    $nom = $element->nom;
                    if (! isset($stats[$nom])) {
                        $stats[$nom] = ['total' => 0, 'anomal' => 0];
                    }
                    $stats[$nom]['total']++;
                    if ($element->isResultOutOfRange($resultat, $bilan->patient)) {
                        $stats[$nom]['anomal']++;
                    }
                }
            }

            $stats = array_filter($stats, fn ($s) => $s['total'] >= 5);
            uasort($stats, fn ($a, $b) => ($b['anomal'] / $b['total']) <=> ($a['anomal'] / $a['total']));
            $top = array_slice($stats, 0, 10, true);

            $labels = [];
            $taux   = [];
            $colors = [];

            foreach ($top as $nom => $s) {
                $rate     = round($s['anomal'] / $s['total'] * 100, 1);
                $labels[] = $nom . ' (' . $s['total'] . ')';
                $taux[]   = $rate;
                $colors[] = $rate >= 40 ? '#c0392b' : ($rate >= 20 ? '#d35400' : '#1a7f37');
            }

            return [
                'datasets' => [
                    [
                        'label'           => 'Taux d\'anomalie (%)',
                        'data'            => $taux,
                        'backgroundColor' => $colors,
                        'borderRadius'    => 4,
                    ],
                ],
                'labels' => $labels,
            ];
        });
    }

    protected function getType(): string
    {
        return 'bar';
    }

    public function handleChartClick(int $index, int $datasetIndex, string $label): void
    {
        $cached = $this->getCachedData();
        $taux   = $cached['datasets'][0]['data'][$index] ?? null;

        if ($taux === null) {
            return;
        }

        $color = $taux >= 40 ? 'danger' : ($taux >= 20 ? 'warning' : 'success');

        Notification::make()
            ->title($label)
            ->body('Taux d\'anomalie : ' . $taux . '%')
            ->color($color)
            ->send();
    }

    protected function getOptions(): array
    {
        return [
            'indexAxis'   => 'y',
            'aspectRatio' => 1.8,
            'plugins'   => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'x' => [
                    'beginAtZero' => true,
                    'max'         => 100,
                    'title'       => ['display' => true, 'text' => 'Taux d\'anomalie (%)'],
                ],
            ],
        ];
    }
}
