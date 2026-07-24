<?php

namespace App\Observers;

use App\Models\Bilan;
use App\Services\StockService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class BilanObserver
{
    /**
     * Handle the Bilan "updating" event.
     */
    public function updating(Bilan $bilan): void
    {
        // Vérifier si le statut change vers "en_cours_analyse"
        if ($bilan->isDirty('statut') && $bilan->statut === 'en_cours_analyse') {
            // Vérifier que le bilan a des éléments (et donc des réactifs)
            if ($bilan->elements()->count() === 0) {
                return;
            }

            try {
                $service = new StockService();
                $coutRevient = $service->deduirePourBilan($bilan);

                // Si la colonne prix_revient existe, on la met à jour
                if (Schema::hasColumn('bilans', 'prix_revient')) {
                    $bilan->prix_revient = $coutRevient;
                }

                // Optionnel : log pour traçabilité
                Log::info("Stock déduit pour le bilan {$bilan->ref}. Coût de revient : {$coutRevient} FC.");

            } catch (\Exception $e) {
                // Si une erreur survient (ex: stock insuffisant), on peut annuler ou logger
                Log::error("Erreur lors de la déduction du stock pour le bilan {$bilan->ref} : " . $e->getMessage());
                // Pour bloquer le changement de statut, on peut relancer l'exception
                throw $e;
            }
        }
    }
}