<?php

use App\Http\Controllers\BacteriologiePdfController;
use App\Http\Controllers\CaissePdfController;
use App\Http\Controllers\RapportPdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilanPdfController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    $qrCode = QrCode::size(200)->generate('https://example.com');
    return view('welcome', ['qrCode' => $qrCode]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('/bilan/{record}/pdf', [BilanPdfController::class, 'generatePdf'])
        ->name('pdf.bilan');

    Route::get('/bilanhormonal/{record}/pdf', [BilanPdfController::class, 'generateHormonalPdf'])
        ->name('pdf.hormonal');

    Route::get('/bilanurinaire/{record}/pdf', [BacteriologiePdfController::class, 'generatePdf'])
        ->name('pdf.bilanurinaire');

    Route::get('/rapport/pdf',  [RapportPdfController::class, 'pdf'])->name('rapport.pdf');
    Route::get('/rapport/csv',  [RapportPdfController::class, 'csv'])->name('rapport.csv');
    Route::get('/caisse/pdf',   [CaissePdfController::class, 'pdf'])->name('pdf.caisse');
});
