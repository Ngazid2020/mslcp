<?php

namespace App\Filament\Resources\MaladieResource\Pages;

use App\Filament\Resources\MaladieResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaladie extends EditRecord
{
    protected static string $resource = MaladieResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
