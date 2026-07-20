<?php

namespace App\Filament\Resources\BilanResource\Pages;

use App\Filament\Resources\BilanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBilan extends CreateRecord
{
    protected static string $resource = BilanResource::class;

    protected function getRedirectUrl(): string
    {
        // Redirige vers la route du ticket après création
        return route('ticket.show', $this->record);
    }
}
