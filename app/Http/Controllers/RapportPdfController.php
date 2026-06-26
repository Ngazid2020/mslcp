<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use App\Models\Maladie;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RapportPdfController extends Controller
{
    private const MONTHS_FR = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Août', 'Sep', 'Oct', 'Nov', 'Déc'];

    public function pdf(Request $request): StreamedResponse
    {
        Gate::authorize('view Rapports');

        [$maladie, $annee, $monthly] = $this->buildData($request);

        $contact = config('mslcp.contact');
        $output  = Pdf::loadView('rapport-epidemio', compact('maladie', 'annee', 'monthly', 'contact'))
            ->setPaper('a4', 'portrait')
            ->output();

        $filename = 'rapport-epidemio-' . $annee . ($maladie ? '-' . \Str::slug($maladie->nom) : '') . '.pdf';

        return response()->streamDownload(
            fn () => print($output),
            $filename,
            ['Content-Type' => 'application/pdf']
        );
    }

    public function csv(Request $request): StreamedResponse
    {
        Gate::authorize('view Rapports');

        [$maladie, $annee, $monthly] = $this->buildData($request);

        $maladieLabel = $maladie ? $maladie->nom : 'Toutes';
        $filename     = 'rapport-epidemio-' . $annee . '.csv';

        return response()->streamDownload(function () use ($monthly, $maladieLabel, $annee) {
            $out = fopen('php://output', 'w');
            // BOM UTF-8 pour Excel
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, ['Rapport épidémiologique MSLCP'], ';');
            fputcsv($out, ['Maladie', $maladieLabel], ';');
            fputcsv($out, ['Année', $annee], ';');
            fputcsv($out, [], ';');
            fputcsv($out, ['Mois', 'Cas détectés', 'Total bilans', 'Pourcentage (%)'], ';');

            for ($m = 1; $m <= 12; $m++) {
                $row = $monthly[$m];
                fputcsv($out, [
                    $row['mois'],
                    $row['cas'],
                    $row['total_bilans'],
                    str_replace('.', ',', (string) $row['pct']),
                ], ';');
            }

            $total = $monthly['total'];
            fputcsv($out, ['Total', $total['cas'], $total['total_bilans'],
                str_replace('.', ',', (string) $total['pct'])], ';');

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /** @return array{?Maladie, int, array<int|string, mixed>} */
    private function buildData(Request $request): array
    {
        $maladieId = $request->query('maladie_id') ? (int) $request->query('maladie_id') : null;
        $annee     = (int) ($request->query('annee') ?: now()->year);

        $maladie = $maladieId ? Maladie::findOrFail($maladieId) : null;

        $totalCas = 0;
        $maxCas   = 0;
        $peakMois = null;
        $monthly  = [];

        for ($m = 1; $m <= 12; $m++) {
            $query = DB::table('bilan_maladie')
                ->join('bilans', 'bilan_maladie.bilan_id', '=', 'bilans.id')
                ->whereYear('bilans.created_at', $annee)
                ->whereMonth('bilans.created_at', $m);

            if ($maladieId) {
                $query->where('bilan_maladie.maladie_id', '=', $maladieId);
            }

            $cas         = $query->count();
            $totalBilans = Bilan::query()
                ->whereYear('created_at', '=', $annee)
                ->whereMonth('created_at', '=', $m)
                ->count();

            $totalCas += $cas;

            if ($cas > $maxCas) {
                $maxCas   = $cas;
                $peakMois = self::MONTHS_FR[$m - 1];
            }

            $monthly[$m] = [
                'mois'         => self::MONTHS_FR[$m - 1],
                'cas'          => $cas,
                'total_bilans' => $totalBilans,
                'pct'          => $totalBilans > 0 ? round($cas / $totalBilans * 100, 1) : 0.0,
            ];
        }

        $totalBilansAnnee = Bilan::query()->whereYear('created_at', '=', $annee)->count();

        $monthly['total'] = [
            'mois'         => 'Total',
            'cas'          => $totalCas,
            'total_bilans' => $totalBilansAnnee,
            'pct'          => $totalBilansAnnee > 0 ? round($totalCas / $totalBilansAnnee * 100, 1) : 0.0,
        ];

        $monthly['_meta'] = [
            'max_cas'   => $maxCas,
            'peak_mois' => $peakMois ?? '—',
        ];

        return [$maladie, $annee, $monthly];
    }
}
