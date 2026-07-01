<?php

namespace App\Http\Controllers;

use App\Models\BilanUrinaire;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BacteriologiePdfController extends Controller
{
    public function generatePdf(int $recordId): StreamedResponse
    {
        $record = BilanUrinaire::with(['patient', 'prescripteur'])->findOrFail($recordId);

        Gate::authorize('download Bilan');

        abort_unless($record->patient, 422, 'Ce bilan urinaire ne possède pas de patient associé.');

        try {
            $c = config('mslcp.contact');
            $mecard = sprintf(
                'MECARD:N:%s,%s;TEL:%s;TEL:%s;EMAIL:%s;ENTREPRISE:%s;TITLE:%s;;',
                $c['nom_famille'], $c['prenom'],
                $c['tel1'], $c['tel2'],
                $c['email'], $c['entreprise'], $c['titre'],
            );

            $qrcode = base64_encode(
                QrCode::format('png')->size(200)->errorCorrection('H')->generate($mecard)
            );

            // output() génère le PDF dans le try/catch — évite un stream corrompu silencieux.
            $output = Pdf::loadView('bacteriologie', compact('record', 'qrcode'))->output();

            return response()->streamDownload(function () use ($output) {
                echo $output;
            }, 'bilan_urinaire_' . $record->id . '.pdf');
        } catch (\Exception $e) {
            report($e);
            abort(500, 'Une erreur est survenue lors de la génération du PDF. Vérifiez que le bilan est complet.');
        }
    }
}
