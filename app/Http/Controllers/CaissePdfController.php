<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CaissePdfController extends Controller
{
    public function pdf(Request $request): StreamedResponse
    {
        Gate::authorize('view Statistiques');

        $date       = $request->query('date', now()->toDateString());
        $typeFilter = $request->query('type_filter', 'tous');

        // Valider la date
        try {
            $dateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception) {
            $dateParsed = now();
        }

        $bilansQuery = DB::table('bilans')
            ->leftJoin('patients',      'patients.id',      '=', 'bilans.patient_id')
            ->leftJoin('prescripteurs', 'prescripteurs.id', '=', 'bilans.prescripteur_id')
            ->selectRaw("
                'bilan' AS source,
                bilans.id,
                bilans.ref,
                COALESCE(bilans.type, 'general') AS type_bilan,
                bilans.created_at,
                TRIM(CONCAT(COALESCE(patients.prenom,''),' ',COALESCE(patients.nom,''))) AS patient_nom,
                prescripteurs.nom AS prescripteur_nom,
                (
                    SELECT COUNT(a.id) FROM analyses a
                    INNER JOIN elements e ON e.id = a.element_id
                    WHERE a.bilan_id = bilans.id AND e.prix IS NOT NULL
                ) AS nb_analyses_tarif,
                (
                    SELECT COALESCE(SUM(e.prix),0) FROM analyses a
                    INNER JOIN elements e ON e.id = a.element_id
                    WHERE a.bilan_id = bilans.id AND e.prix IS NOT NULL
                ) AS total_ligne
            ")
            ->whereDate('bilans.created_at', $date);

        if ($typeFilter === 'hormonal') {
            $bilansQuery->where('bilans.type', 'hormonal');
        } elseif ($typeFilter === 'general') {
            $bilansQuery->whereNull('bilans.type');
        }

        $urinairesQuery = DB::table('bilan_urinaires')
            ->leftJoin('patients',      'patients.id',      '=', 'bilan_urinaires.patient_id')
            ->leftJoin('prescripteurs', 'prescripteurs.id', '=', 'bilan_urinaires.prescripteur_id')
            ->selectRaw("
                'urinaire' AS source,
                bilan_urinaires.id,
                NULL AS ref,
                'urinaire' AS type_bilan,
                bilan_urinaires.created_at,
                TRIM(CONCAT(COALESCE(patients.prenom,''),' ',COALESCE(patients.nom,''))) AS patient_nom,
                prescripteurs.nom AS prescripteur_nom,
                0 AS nb_analyses_tarif,
                COALESCE(bilan_urinaires.prix, 0) AS total_ligne
            ")
            ->whereDate('bilan_urinaires.created_at', $date);

        $lignes = match ($typeFilter) {
            'general', 'hormonal' => $bilansQuery->get(),
            'urinaire'            => $urinairesQuery->get(),
            default               => $bilansQuery->get()->concat($urinairesQuery->get()),
        };

        $lignes     = $lignes->sortByDesc('created_at')->values();
        $grandTotal = (int) $lignes->sum('total_ligne');
        $contact    = config('mslcp.contact');

        $output = Pdf::loadView('caisse-pdf', compact('lignes', 'grandTotal', 'dateParsed', 'typeFilter', 'contact'))
            ->setPaper('a4', 'portrait')
            ->output();

        $filename = 'caisse-' . $date . '.pdf';

        return response()->streamDownload(
            fn () => print($output),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
}
