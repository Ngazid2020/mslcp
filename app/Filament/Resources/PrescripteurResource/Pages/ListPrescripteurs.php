<?php

namespace App\Filament\Resources\PrescripteurResource\Pages;

use App\Filament\Resources\PrescripteurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPrescripteurs extends ListRecords
{
    protected static string $resource = PrescripteurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
