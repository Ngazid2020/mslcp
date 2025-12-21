<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use Filament\Widgets\ChartWidget;

class BilansParMois extends ChartWidget
{
    protected static ?string $heading = 'Bilans par mois';
    protected static ?int $sort = 1; // ordre d'affichage sur le dashboard

    protected function getData(): array
    {
        $data = Bilan::query()
            ->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Transformer les clés (1..12) en noms de mois
        $labels = array_map(fn($m) => date('F', mktime(0, 0, 0, $m, 1)), array_keys($data));

        return [
            'datasets' => [
                [
                    'label' => 'Bilans',
                    'data' => array_values($data),
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
