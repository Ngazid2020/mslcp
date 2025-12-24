<?php

namespace App\Filament\Resources\AnalyseUrinaireResource\Pages;

use App\Filament\Resources\AnalyseUrinaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAnalyseUrinaire extends EditRecord
{
    protected static string $resource = AnalyseUrinaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
