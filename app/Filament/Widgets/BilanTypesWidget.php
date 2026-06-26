<?php

namespace App\Filament\Widgets;

use App\Models\Bilan;
use App\Models\BilanUrinaire;
use Filament\Widgets\ChartWidget;

class BilanTypesWidget extends ChartWidget
{
    protected static ?string $heading = 'Répartition par type';
    protected static ?int $sort = 3;
    protected static string $view = 'filament.widgets.clickable-chart-widget';

    public static function canView(): bool
    {
        return auth()->user()?->can('view Statistiques') ?? false;
    }

    protected function getFilters(): ?array
    {
        return [
            'mois'  => 'Ce mois',
            'trim'  => 'Ce trimestre',
            'annee' => 'Cette année',
            'tout'  => 'Tout',
        ];
    }

    public function getHeading(): string
    {
        $labels = [
            'mois'  => 'Ce mois',
            'trim'  => 'Ce trimestre',
            'annee' => 'Cette année',
            'tout'  => 'Tout',
        ];
        $filter = $this->filter ?? 'annee';

        return 'Répartition par type — ' . ($labels[$filter] ?? $filter);
    }

    protected function getData(): array
    {
        $filter = $this->filter ?? 'annee';

        $general  = Bilan::query()->whereNull('type')
            ->when($filter === 'mois',  fn($q) => $q->where('created_at', '>=', now()->startOfMonth()))
            ->when($filter === 'trim',  fn($q) => $q->where('created_at', '>=', now()->startOfQuarter()))
            ->when($filter === 'annee', fn($q) => $q->whereYear('created_at', '=', now()->year))
            ->count();

        $hormonal = Bilan::query()->where('type', '=', 'hormonal')
            ->when($filter === 'mois',  fn($q) => $q->where('created_at', '>=', now()->startOfMonth()))
            ->when($filter === 'trim',  fn($q) => $q->where('created_at', '>=', now()->startOfQuarter()))
            ->when($filter === 'annee', fn($q) => $q->whereYear('created_at', '=', now()->year))
            ->count();

        $urinaire = BilanUrinaire::query()
            ->when($filter === 'mois',  fn($q) => $q->where('created_at', '>=', now()->startOfMonth()))
            ->when($filter === 'trim',  fn($q) => $q->where('created_at', '>=', now()->startOfQuarter()))
            ->when($filter === 'annee', fn($q) => $q->whereYear('created_at', '=', now()->year))
            ->count();

        return [
            'datasets' => [
                [
                    'data'            => [$general, $hormonal, $urinaire],
                    'backgroundColor' => ['#1B3A6B', '#2e6fb8', '#1a7f37'],
                    'hoverOffset'     => 6,
                ],
            ],
            'labels' => ['Général', 'Hormonal', 'Urinaire (ECBU)'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public function handleChartClick(int $index, int $datasetIndex, string $label): void
    {
        match ($index) {
            0, 1 => $this->redirect(route('filament.admin.resources.bilans.index')),
            2    => $this->redirect(route('filament.admin.resources.bilan-urinaires.index')),
            default => null,
        };
    }
}
