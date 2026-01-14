<?php

namespace App\Filament\Resources\BilanUrinaireResource\Pages;

use App\Filament\Resources\BilanUrinaireResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

class EditBilanUrinaire extends EditRecord
{
    protected static string $resource = BilanUrinaireResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Télécharger')
                ->icon('heroicon-o-document-arrow-down')
                ->url(fn($record) => route('pdf.bilanurinaire', $record->id))
                ->openUrlInNewTab()
                ->color(Color::Emerald),
            Actions\DeleteAction::make(),
        ];
    }
}
