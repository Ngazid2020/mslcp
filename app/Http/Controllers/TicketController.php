<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use Barryvdh\DomPDF\Facade\Pdf;

class TicketController extends Controller
{
    public function show(Bilan $bilan)
    {
        // Charger les relations nécessaires
        $bilan->load(['patient', 'prescripteur', 'elements.category']);

        // Compter le nombre d'éléments pour l'affichage
        $nbElements = $bilan->elements->count();

        // Calcul du total (si pas déjà enregistré)
        if (!$bilan->prix_total) {
            $bilan->prix_total = $bilan->elements->sum('prix');
            $bilan->saveQuietly();
        }

        $pdf = Pdf::loadView('pdf.ticket', compact('bilan', 'nbElements'));

        // Aperçu en ligne dans le navigateur, mais on peut aussi forcer le téléchargement
        return $pdf->stream('ticket-' . $bilan->ref . '.pdf');
    }
}
