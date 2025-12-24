<?php

use App\Http\Controllers\BacteriologiePdfController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BilanPdfController;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', function () {
    $qrCode = QrCode::size(200)->generate('https://example.com');
    return view('welcome',['qrCode'=>$qrCode]);
});

Route::get('/bilan/{record}/pdf', [BilanPdfController::class, 'generatePdf'])
    ->name('pdf.bilan');

Route::get('/bacteriologie/{record}/pdf', [BacteriologiePdfController::class, 'generatePdf'])
    ->name('pdf.bacteriologie');
