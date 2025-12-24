<?php

namespace App\Filament\Resources\BacteriologieResource\Pages;

use App\Filament\Resources\BacteriologieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBacteriologies extends ListRecords
{
    protected static string $resource = BacteriologieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
