<?php

namespace App\Filament\Resources\CategoryAnalyseResource\Pages;

use App\Filament\Resources\CategoryAnalyseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategoryAnalyses extends ListRecords
{
    protected static string $resource = CategoryAnalyseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
