<?php

namespace App\Filament\Widgets;

use App\Models\LotReactif;
use App\Models\Reactif;
use Filament\Widgets\Widget;
// use Illuminate\Support\Collection\DB;
use Illuminate\Support\Facades\DB;

class AlertesStockWidget extends Widget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 2;
    protected static string $view = 'filament.widgets.alertes-stock-widget';

    public function getViewData(): array
    {
        // Réactifs sous le seuil d'alerte
        $reactifsAlerte = Reactif::withSum('lots as stock_restant', 'quantite_restante')
            ->having('stock_restant', '<', DB::raw('seuil_alerte'))
            ->where('est_actif', true)
            ->get()
            ->map(fn($r) => [
                'nom' => $r->nom,
                'stock' => $r->stock_restant ?? 0,
                'seuil' => $r->seuil_alerte,
                'unite' => $r->unite_mesure,
            ]);

        // Lots périmés (consommables mais dépassés)
        $lotsPerimes = LotReactif::where('est_consommable', true)
            ->where('date_peremption', '<', now()->toDateString())
            ->with('reactif')
            ->get()
            ->map(fn($lot) => [
                'nom' => $lot->reactif->nom,
                'lot' => $lot->numero_lot,
                'peremption' => $lot->date_peremption->format('d/m/Y'),
            ]);

        return [
            'reactifsAlerte' => $reactifsAlerte,
            'lotsPerimes' => $lotsPerimes,
        ];
    }

    protected function getView(): string
    {
        return 'filament.widgets.alertes-stock-widget';
    }
}
