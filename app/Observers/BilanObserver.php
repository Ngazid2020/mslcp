<?php

namespace App\Observers;

use App\Models\Bilan;
use App\Models\MouvementStock;
use App\Services\StockService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BilanObserver
{
    public function updating(Bilan $bilan): void
    {
        if (! $bilan->isDirty('statut')) {
            return;
        }

        $ancienStatut  = $bilan->getOriginal('statut');
        $nouveauStatut = $bilan->statut;

        // ── Passage vers en_cours_analyse : déduire le stock ─────────────────
        if ($nouveauStatut === 'en_cours_analyse') {
            if ($bilan->elements()->count() === 0) {
                return;
            }

            $service = new StockService();

            // Vérifier la disponibilité avant toute déduction
            $bilan->load('elements.reactifs');
            $check = $service->verifierDisponibilite($bilan);

            if (! $check['disponible']) {
                throw new \RuntimeException(
                    'Stock insuffisant pour lancer l\'analyse : ' .
                    implode(' | ', array_filter($check['messages'], fn($m) => str_starts_with($m, '❌')))
                );
            }

            try {
                $coutRevient        = $service->deduirePourBilan($bilan);
                $bilan->prix_revient = $coutRevient;

                Log::info("Stock déduit pour le bilan {$bilan->ref}. Coût de revient : {$coutRevient} FC.");
            } catch (\Exception $e) {
                Log::error("Erreur déduction stock — bilan {$bilan->ref} : " . $e->getMessage());
                throw $e;
            }
        }

        // ── Rétrogradation depuis en_cours_analyse : recréditer le stock ─────
        if ($ancienStatut === 'en_cours_analyse' && $nouveauStatut !== 'en_cours_analyse') {
            $this->recrediterStock($bilan);
        }
    }

    /**
     * Recrédite les lots pour tous les mouvements de sortie liés à ce bilan.
     * Crée un mouvement d'ajustement pour traçabilité.
     */
    private function recrediterStock(Bilan $bilan): void
    {
        $mouvements = MouvementStock::where('bilan_id', $bilan->id)
            ->where('type', 'sortie')
            ->with('lot')
            ->get();

        if ($mouvements->isEmpty()) {
            return;
        }

        $userId = Auth::id();

        foreach ($mouvements as $mouvement) {
            $quantiteARendre = abs($mouvement->quantite);
            $mouvement->lot->increment('quantite_restante', $quantiteARendre);

            MouvementStock::create([
                'lot_reactifs_id' => $mouvement->lot_reactifs_id,
                'bilan_id'        => $bilan->id,
                'quantite'        => $quantiteARendre,
                'type'            => 'ajustement',
                'motif'           => "Annulation analyse — bilan {$bilan->ref} repassé en {$bilan->statut}",
                'user_id'         => $userId,
            ]);
        }

        $bilan->prix_revient = null;

        Log::info("Stock recrédité pour le bilan {$bilan->ref} suite à rétrogradation de statut.");
    }
}
