<?php

namespace App\Http\Controllers;

use App\Models\Bilan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Symfony\Component\HttpFoundation\StreamedResponse;

class BilanPdfController extends Controller
{
    public function generatePdf(int $recordId): StreamedResponse
    {
        return $this->generate($recordId, 'bilan', 'bilan_');
    }

    public function generateHormonalPdf(int $recordId): StreamedResponse
    {
        return $this->generate($recordId, 'hormonal', 'bilan_hormonal_');
    }

    private function generate(int $recordId, string $view, string $prefix): StreamedResponse
    {
        // findOrFail lance ModelNotFoundException → Laravel renvoie 404 automatiquement
        $record = Bilan::with(['patient', 'elements.category'])->findOrFail($recordId);

        // Lance AuthorizationException → Laravel renvoie 403 automatiquement
        Gate::authorize('download', $record);

        abort_unless($record->patient, 422, 'Ce bilan ne possède pas de patient associé.');

        try {
            $qrcode = $this->buildQrCode();

            // output() génère le PDF maintenant, dans le try/catch.
            // Si DOMPDF échoue, l'exception est capturée avant l'ouverture du stream
            // (évite un HTTP 200 suivi d'un PDF corrompu silencieux).
            $output = Pdf::loadView($view, compact('record', 'qrcode'))->output();

            return response()->streamDownload(function () use ($output) {
                echo $output;
            }, $prefix . $record->ref . '.pdf');
        } catch (\Exception $e) {
            report($e);
            abort(500, 'Une erreur est survenue lors de la génération du PDF. Vérifiez que le bilan est complet.');
        }
    }

    private function buildQrCode(): string
    {
        $c = config('mslcp.contact');

        $mecard = sprintf(
            'MECARD:N:%s,%s;TEL:%s;TEL:%s;EMAIL:%s;ENTREPRISE:%s;TITLE:%s;;',
            $c['nom_famille'],
            $c['prenom'],
            $c['tel1'],
            $c['tel2'],
            $c['email'],
            $c['entreprise'],
            $c['titre'],
        );

        return base64_encode(
            QrCode::format('png')->size(200)->errorCorrection('H')->generate($mecard)
        );
    }
}
