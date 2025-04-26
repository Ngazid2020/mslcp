<?php

namespace App\Filament\Resources\ElementResource\Pages;

use App\Filament\Resources\ElementResource;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListElements extends ListRecords
{
    protected static string $resource = ElementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // ExcelImportAction::make()
            // ->label('Importer depuis un fichier Excel')
            // ->color("secondary"),
        ];
    }
}
