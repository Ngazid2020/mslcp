<?php

namespace App\Filament\Resources\BilanResource\Pages;

use App\Filament\Resources\BilanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Colors\Color;

class EditBilan extends EditRecord
{
    protected static string $resource = BilanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Télécharger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('pdf.bilan', $record->id))
                    ->openUrlInNewTab()
                    ->color(Color::Emerald)
                    ->visible(fn($record) => auth()->user()->can('download', $record)),
            Actions\Action::make('Télécharger Bilan hormonal')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('pdf.hormonal', $record->id))
                    ->openUrlInNewTab()
                    ->color(Color::Pink)
                    ->visible(fn($record) => auth()->user()->can('download', $record)),
            // Actions\DeleteAction::make(),
        ];
    }
}
