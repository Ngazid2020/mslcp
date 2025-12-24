<?php

namespace App\Filament\Resources\CategoryAnalyseResource\Pages;

use App\Filament\Resources\CategoryAnalyseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategoryAnalyse extends EditRecord
{
    protected static string $resource = CategoryAnalyseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
