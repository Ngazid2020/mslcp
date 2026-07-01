<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\BilanUrinaire;
use Filament\Notifications\Notification;
use Filament\Widgets\ChartWidget;

class BilansParMois extends ChartWidget
{
    protected static ?string $heading = 'Évolution mensuelle';
    protected static ?int $sort = 2;
    protected static string $view = 'filament.widgets.clickable-chart-widget';

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected int | string | array $columnSpan = 'full';

    private const MONTHS_FR = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

    protected function getFilters(): ?array
    {
        $year = now()->year;

        return [
            (string) $year       => 'Année ' . $year,
            (string) ($year - 1) => 'Année ' . ($year - 1),
            (string) ($year - 2) => 'Année ' . ($year - 2),
        ];
    }

    public function getHeading(): string
    {
        $year = $this->filter ?? (string) now()->year;

        return 'Évolution mensuelle — ' . $year;
    }

    protected function getData(): array
    {
        $year = (int) ($this->filter ?? now()->year);

        $generalByMonth = Bilan::query()
            ->selectRaw('MONTH(created_at) as m, COUNT(*) as n')
            ->whereYear('created_at', $year)
            ->groupBy('m')
            ->pluck('n', 'm');

        $urinaireByMonth = BilanUrinaire::query()
            ->selectRaw('MONTH(created_at) as m, COUNT(*) as n')
            ->whereYear('created_at', $year)
            ->groupBy('m')
            ->pluck('n', 'm');

        $general  = [];
        $urinaire = [];
        $labels   = [];

        for ($month = 1; $month <= 12; $month++) {
            $general[]  = (int) ($generalByMonth[$month] ?? 0);
            $urinaire[] = (int) ($urinaireByMonth[$month] ?? 0);
            $labels[]   = self::MONTHS_FR[$month - 1];
        }

        return [
            'datasets' => [
                [
                    'label'           => 'Bilans (gén. + hormonal)',
                    'data'            => $general,
                    'borderColor'     => '#1B3A6B',
                    'backgroundColor' => 'rgba(27, 58, 107, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.35,
                    'pointRadius'     => 4,
                ],
                [
                    'label'           => 'Bilans urinaires + bactério',
                    'data'            => $urinaire,
                    'borderColor'     => '#1a7f37',
                    'backgroundColor' => 'rgba(26, 127, 55, 0.1)',
                    'fill'            => true,
                    'tension'         => 0.35,
                    'pointRadius'     => 4,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    public function handleChartClick(int $index, int $datasetIndex, string $label): void
    {
        $year  = (int) ($this->filter ?? now()->year);
        $month = $index + 1;

        $noms = [
            1 => 'Janvier', 2 => 'Février', 3 => 'Mars',    4 => 'Avril',
            5 => 'Mai',     6 => 'Juin',    7 => 'Juillet',  8 => 'Août',
            9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre',
        ];

        $bilansCount   = Bilan::query()
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();

        $urinaireCount = BilanUrinaire::query()
            ->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->count();

        Notification::make()
            ->title(($noms[$month] ?? $label) . ' ' . $year)
            ->body($bilansCount . ' bilan(s) général/hormonal · ' . $urinaireCount . ' bilan(s) urinaire')
            ->info()
            ->send();
    }
}
