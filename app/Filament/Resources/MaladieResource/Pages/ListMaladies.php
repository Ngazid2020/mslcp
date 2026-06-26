<?php

namespace App\Filament\Resources\MaladieResource\Pages;

use App\Filament\Resources\MaladieResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMaladies extends ListRecords
{
    protected static string $resource = MaladieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
