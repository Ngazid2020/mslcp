<?php

namespace App\Filament\Resources\LotReactifResource\Pages;

use App\Filament\Resources\LotReactifResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLotReactif extends EditRecord
{
    protected static string $resource = LotReactifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
