<?php

namespace App\Filament\Widgets;

use App\Models\LotReactif;
use App\Models\Reactif;
use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AlertesStockWidget extends Widget
{
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 2;
    protected static string $view = 'filament.widgets.alertes-stock-widget';

    public function getViewData(): array
    {
        $today = now()->toDateString();

        // Réactifs sous le seuil — uniquement les lots valides (non périmés, consommables)
        $reactifsAlerte = Cache::remember('alertes_reactifs_stock', 300, function () use ($today) {
            return Reactif::withSum(
                    ['lots' => fn($q) => $q
                        ->where('est_consommable', true)
                        ->where('date_peremption', '>=', $today)],
                    'quantite_restante'
                )
                ->having('lots_sum_quantite_restante', '<', DB::raw('seuil_alerte'))
                ->orHavingNull('lots_sum_quantite_restante')
                ->where('est_actif', true)
                ->get()
                ->map(fn($r) => [
                    'nom'   => $r->nom,
                    'stock' => $r->lots_sum_quantite_restante ?? 0,
                    'seuil' => $r->seuil_alerte,
                    'unite' => $r->unite_mesure,
                ]);
        });

        // Lots périmés avec limite pour éviter de charger toute la table
        $lotsPerimes = Cache::remember('alertes_lots_perimes', 300, function () use ($today) {
            return LotReactif::where('est_consommable', true)
                ->where('date_peremption', '<', $today)
                ->with('reactif')
                ->orderByDesc('date_peremption')
                ->limit(50)
                ->get()
                ->map(fn($lot) => [
                    'nom'        => $lot->reactif->nom,
                    'lot'        => $lot->numero_lot,
                    'peremption' => $lot->date_peremption->format('d/m/Y'),
                ]);
        });

        return [
            'reactifsAlerte' => $reactifsAlerte,
            'lotsPerimes'    => $lotsPerimes,
        ];
    }

    protected function getView(): string
    {
        return 'filament.widgets.alertes-stock-widget';
    }
}
