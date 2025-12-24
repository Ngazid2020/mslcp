<?php

namespace App\Filament\Resources\AnalyseUrinaireResource\Pages;

use App\Filament\Resources\AnalyseUrinaireResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAnalyseUrinaires extends ListRecords
{
    protected static string $resource = AnalyseUrinaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
