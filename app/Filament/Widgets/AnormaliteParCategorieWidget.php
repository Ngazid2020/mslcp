<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use Filament\Notifications\Notification;
use Filament\Widgets\ChartWidget;

class AnormaliteParCategorieWidget extends ChartWidget
{
    protected static ?string $heading = 'Résultats hors-normes par catégorie';
    protected static ?int $sort = 5;
    protected static string $view = 'filament.widgets.clickable-chart-widget';

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected int | string | array $columnSpan = 'full';

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

        return 'Résultats hors-normes par catégorie — ' . $n . ' derniers mois';
    }

    protected function getData(): array
    {
        $months = (int) ($this->filter ?? 6);

        $bilans = Bilan::query()->with(['patient', 'elements.category'])
            ->where('created_at', '>=', now()->subMonths($months))
            ->get();

        /** @var array<string, array{total: int, anomal: int}> $stats */
        $stats = [];

        foreach ($bilans as $bilan) {
            if (!$bilan->patient) {
                continue;
            }
            foreach ($bilan->elements as $element) {
                $catName = $element->category?->name ?? 'Autre';

                if (!isset($stats[$catName])) {
                    $stats[$catName] = ['total' => 0, 'anomal' => 0];
                }

                $resultat = $element->pivot->resultat;

                if ($resultat === null || $resultat === '') {
                    continue;
                }

                // Inclure les résultats qualitatifs et numériques ; ignorer le texte libre non structuré
                $isQual    = $element->type_valeur === 'qualitatif';
                $isNumeric = is_numeric($resultat);

                if (! $isQual && ! $isNumeric) {
                    continue;
                }

                $stats[$catName]['total']++;

                if ($element->isResultOutOfRange($resultat, $bilan->patient)) {
                    $stats[$catName]['anomal']++;
                }
            }
        }

        // Retirer les catégories sans données numériques et trier par taux décroissant
        $stats = array_filter($stats, fn($s) => $s['total'] > 0);
        uasort($stats, fn($a, $b) => ($b['anomal'] / $b['total']) <=> ($a['anomal'] / $a['total']));

        $labels = [];
        $taux   = [];
        $colors = [];

        foreach ($stats as $catName => $s) {
            $rate     = (int) round($s['anomal'] / $s['total'] * 100);
            $labels[] = $catName . ' (' . $s['total'] . ')';
            $taux[]   = $rate;
            $colors[] = $rate > 30 ? '#c0392b' : ($rate > 15 ? '#d35400' : '#1a7f37');
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

        $color = $taux > 30 ? 'danger' : ($taux > 15 ? 'warning' : 'success');

        Notification::make()
            ->title($label)
            ->body('Taux d\'anomalie : ' . $taux . '%')
            ->color($color)
            ->send();
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                // 'x' => [
                //     'ticks' => [
                //         'maxRotation' => 0,
                //         'autoSkip'    => false,
                //         'font'        => ['size' => 11],
                //         // Sépare "Catégorie (n)" en deux lignes : ["Catégorie", "(n)"]
                //         'callback'    => 'function(value) {
                //             var lbl = this.getLabelForValue(value);
                //             var m = lbl.match(/^(.*?)\s*(\(\d+\))$/);
                //             if (m) return [m[1], m[2]];
                //             var words = lbl.split(" ");
                //             if (words.length <= 1 || lbl.length <= 14) return lbl;
                //             var mid = Math.ceil(words.length / 2);
                //             return [words.slice(0, mid).join(" "), words.slice(mid).join(" ")];
                //         }',
                //     ],
                // ],
                'y' => [
                    'min' => 0,
                    'max' => 100,
                    'ticks' => [
                        'callback' => 'function(value){ return value + "%" }',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => ['display' => false],
            ],
        ];
    }
}
