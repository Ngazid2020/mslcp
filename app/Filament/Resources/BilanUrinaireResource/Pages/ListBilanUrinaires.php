<?php

namespace App\Filament\Resources\BilanUrinaireResource\Pages;

use App\Filament\Resources\BilanUrinaireResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBilanUrinaires extends ListRecords
{
    protected static string $resource = BilanUrinaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
