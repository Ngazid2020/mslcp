<?php

namespace App\Filament\Resources\BacteriologieResource\Pages;

use App\Filament\Resources\BacteriologieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBacteriologie extends EditRecord
{
    protected static string $resource = BacteriologieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
