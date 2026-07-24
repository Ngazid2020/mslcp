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

        $mode           = in_array($request->query('mode'), ['jour', 'mois', 'annee'], true)
                            ? $request->query('mode')
                            : 'jour';
        $typeFilter     = $request->query('type_filter', 'tous');
        $prescripteurId = $request->query('prescripteur_id', '');

        // Paramètres du mode jour
        $date = $request->query('date', now()->toDateString());
        try {
            $dateParsed = \Carbon\Carbon::createFromFormat('Y-m-d', $date);
        } catch (\Exception) {
            $dateParsed = null;
        }
        if (!$dateParsed) {
            $dateParsed = now();
        }
        $date = $dateParsed->toDateString();

        // Paramètres des modes mois / année
        $mois  = max(1, min(12, (int) $request->query('mois', now()->month)));
        $annee = max(2020, min((int) now()->format('Y'), (int) $request->query('annee', now()->year)));

        // Fermeture d'application du filtre temporel
        $applyDate = function ($query, string $table) use ($mode, $date, $mois, $annee): void {
            $col = $table . '.created_at';
            match ($mode) {
                'mois'  => $query->whereYear($col, $annee)->whereMonth($col, $mois),
                'annee' => $query->whereYear($col, $annee),
                default => $query->whereDate($col, $date),
            };
        };

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
            ");

        $applyDate($bilansQuery, 'bilans');

        if ($typeFilter === 'hormonal') {
            $bilansQuery->where('bilans.type', 'hormonal');
        } elseif ($typeFilter === 'general') {
            $bilansQuery->whereNull('bilans.type');
        }

        if ($prescripteurId !== '') {
            $bilansQuery->where('bilans.prescripteur_id', (int) $prescripteurId);
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
            ");

        $applyDate($urinairesQuery, 'bilan_urinaires');

        if ($prescripteurId !== '') {
            $urinairesQuery->where('bilan_urinaires.prescripteur_id', (int) $prescripteurId);
        }

        $lignes = match ($typeFilter) {
            'general', 'hormonal' => $bilansQuery->get(),
            'urinaire'            => $urinairesQuery->get(),
            default               => $bilansQuery->get()->concat($urinairesQuery->get()),
        };

        $lignes     = $lignes->sortByDesc('created_at')->values();
        $grandTotal = (int) $lignes->sum('total_ligne');
        $contact    = config('mslcp.contact');

        $periodeLabel = match ($mode) {
            'mois'  => \Carbon\Carbon::createFromDate($annee, $mois, 1)->translatedFormat('F Y'),
            'annee' => 'Année ' . $annee,
            default => $dateParsed->translatedFormat('l d F Y'),
        };

        $totalLabel = match ($mode) {
            'mois'  => 'Total du mois',
            'annee' => "Total de l'année",
            default => 'Total du jour',
        };

        $filename = match ($mode) {
            'mois'  => 'caisse-' . $annee . '-' . str_pad((string) $mois, 2, '0', STR_PAD_LEFT) . '.pdf',
            'annee' => 'caisse-' . $annee . '.pdf',
            default => 'caisse-' . $date . '.pdf',
        };

        $output = Pdf::loadView('caisse-pdf', compact(
            'lignes', 'grandTotal', 'dateParsed', 'typeFilter',
            'contact', 'periodeLabel', 'totalLabel', 'mode'
        ))
            ->setPaper('a4', 'portrait')
            ->output();

        return response()->streamDownload(
            fn () => print($output),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }
}
