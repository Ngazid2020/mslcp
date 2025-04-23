<?php

namespace App\Filament\Resources\BilanResource\Pages;

use App\Filament\Resources\BilanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBilan extends EditRecord
{
    protected static string $resource = BilanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
