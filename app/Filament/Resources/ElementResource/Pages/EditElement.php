<?php

namespace App\Filament\Resources\ElementResource\Pages;

use App\Filament\Resources\ElementResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditElement extends EditRecord
{
    protected static string $resource = ElementResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
