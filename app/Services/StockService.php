<?php

namespace App\Services;

use App\Models\Bilan;
use App\Models\LotReactif;
use App\Models\MouvementStock;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockService
{
    /**
     * Vérifie la disponibilité des réactifs pour un bilan donné (avant création)
     * Retourne un tableau : ['disponible' => bool, 'messages' => []].
     */
    public function verifierDisponibilite(Bilan $bilan): array
    {
        $elements = $bilan->elements;
        if ($elements->isEmpty()) {
            return ['disponible' => true, 'messages' => []];
        }

        // Eager-load les réactifs pour éviter les N+1
        $elements->load('reactifs');

        // Calcul de la consommation totale par réactif
        $consommationParReactif = [];
        foreach ($elements as $element) {
            foreach ($element->reactifs as $reactif) {
                $reactifId = $reactif->id;
                $quantite = (float) $reactif->pivot->quantite_consommee;
                $consommationParReactif[$reactifId] = ($consommationParReactif[$reactifId] ?? 0) + $quantite;
            }
        }

        $messages = [];
        $disponible = true;

        $reactifs = \App\Models\Reactif::whereIn('id', array_keys($consommationParReactif))
            ->get()->keyBy('id');

        foreach ($consommationParReactif as $reactifId => $quantiteNecessaire) {
            $reactif = $reactifs[$reactifId] ?? null;
            if (!$reactif) continue;

            $stockDisponible = $reactif->stock_disponible;

            if ($stockDisponible < $quantiteNecessaire) {
                $disponible = false;
                $messages[] = "❌ {$reactif->nom} : {$quantiteNecessaire} {$reactif->unite_mesure} nécessaire(s), seulement {$stockDisponible} {$reactif->unite_mesure} disponible(s).";
            } else {
                $messages[] = "✅ {$reactif->nom} : {$quantiteNecessaire} {$reactif->unite_mesure} disponible(s).";
            }
        }

        return [
            'disponible' => $disponible,
            'messages' => $messages,
        ];
    }

    /**
     * Déduit les réactifs pour un bilan (FEFO)
     * Crée les mouvements de stock.
     * Retourne le coût de revient total.
     */
    public function deduirePourBilan(Bilan $bilan): float
    {
        $elements = $bilan->elements;
        if ($elements->isEmpty()) {
            return 0;
        }

        // Eager-load les réactifs pour éviter les N+1
        $elements->load('reactifs');

        // Regrouper par réactif
        $consommationParReactif = [];
        foreach ($elements as $element) {
            foreach ($element->reactifs as $reactif) {
                $reactifId = $reactif->id;
                $quantite = (float) $reactif->pivot->quantite_consommee;
                $consommationParReactif[$reactifId] = ($consommationParReactif[$reactifId] ?? 0) + $quantite;
            }
        }

        $coutTotal = 0;
        $userId = Auth::id();

        DB::transaction(function () use ($consommationParReactif, $bilan, $userId, &$coutTotal) {
            foreach ($consommationParReactif as $reactifId => $quantiteTotal) {
                // Récupérer les lots FEFO avec verrou pour éviter la race condition
                $lots = LotReactif::where('reactif_id', $reactifId)
                    ->where('est_consommable', true)
                    ->where('quantite_restante', '>', 0)
                    ->where('date_peremption', '>=', now()->toDateString())
                    ->orderBy('date_peremption')
                    ->lockForUpdate()
                    ->get();

                $quantiteRestante = $quantiteTotal;

                foreach ($lots as $lot) {
                    if ($quantiteRestante <= 0) break;

                    $quantitePrelevee = $lot->deduire($quantiteRestante);
                    if ($quantitePrelevee > 0) {
                        // Enregistrer le mouvement
                        MouvementStock::create([
                            'lot_reactifs_id' => $lot->id,
                            'bilan_id' => $bilan->id,
                            'quantite' => -$quantitePrelevee, // négatif pour sortie
                            'type' => 'sortie',
                            'motif' => "Bilan {$bilan->ref}",
                            'user_id' => $userId,
                        ]);

                        // Coût de revient
                        if ($lot->prix_achat) {
                            $coutTotal += $quantitePrelevee * $lot->prix_achat;
                        }

                        $quantiteRestante -= $quantitePrelevee;
                    }
                }

                // Si après écoulement il reste de la quantité, on lance une alerte (normalement vérifié avant)
                if ($quantiteRestante > 0) {
                    throw new \Exception("Stock insuffisant pour le réactif ID {$reactifId} (cela n'aurait pas dû arriver).");
                }
            }
        });

        return $coutTotal;
    }
}
