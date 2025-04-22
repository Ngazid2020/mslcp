<?php

namespace App\Filament\Resources\ElementResource\Pages;

use App\Filament\Resources\ElementResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateElement extends CreateRecord
{
    protected static string $resource = ElementResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
