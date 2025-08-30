<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Bilan; // Ou ton modèle spécifique
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class BilanPdfController extends Controller
{
    public function generatePdf($recordId)
    {
        $record = Bilan::findOrFail($recordId);  
    $meCard = "MECARD:N:SILAI,RAHAMATOU;TEL:+2693330375;TEL:+2694735095;EMAIL:mslcp_silai@yahoo.fr;ENTREPRISE:MSLCP;TITLE:Parasitologue/MSc Biochimie;;";
        $qrData = json_encode([
            'id' => $record->id,
            'nom' => 'Mme RAHAMATOU SILAI',
            'date' => $record->created_at->format('Y-m-d'),
        ]);
// dump($record->elements[0]->category->name);die();
        $qrcode = base64_encode(QrCode::format('png')->size(200)->errorCorrection('H')->generate($meCard));
        // $qrcode = QrCode::size(250)->generate($vcard);
    
        $pdf = Pdf::loadView('bilan', compact('record','qrcode'));
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'bilan_'.$record->nom.'.pdf');
    }
}
