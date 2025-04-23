<?php

namespace App\Filament\Resources\BilanResource\Pages;

use App\Filament\Resources\BilanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBilan extends CreateRecord
{
    protected static string $resource = BilanResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
