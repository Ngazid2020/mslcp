<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;

class TicketController extends Controller
{
    public function show(Bilan $bilan)
    {
        Gate::authorize('view', $bilan);

        $bilan->load(['patient', 'prescripteur', 'elements.category']);

        $nbElements = $bilan->elements->count();

        if ($bilan->prix_total === null) {
            $bilan->refreshTotal();
        }

        $pdf = Pdf::loadView('pdf.ticket', compact('bilan', 'nbElements'));

        return $pdf->stream('ticket-' . $bilan->ref . '.pdf');
    }
}
