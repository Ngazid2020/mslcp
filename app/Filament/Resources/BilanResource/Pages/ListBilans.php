<?php

namespace App\Filament\Resources\BilanResource\Pages;

use App\Filament\Resources\BilanResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListBilans extends ListRecords
{
    protected static string $resource = BilanResource::class;

    protected function getHeaderActions(): array
    {
        return 
        [
            Actions\CreateAction::make(),
        ];
    }
}
