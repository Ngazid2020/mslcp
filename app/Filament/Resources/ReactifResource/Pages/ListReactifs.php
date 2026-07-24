<?php

namespace App\Filament\Resources\ReactifResource\Pages;

use App\Filament\Resources\ReactifResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReactifs extends ListRecords
{
    protected static string $resource = ReactifResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
