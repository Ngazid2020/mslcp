<?php

namespace App\Filament\Resources\ElementsResource\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AnalyseUrinairesRelationManager extends RelationManager
{
    protected static string $relationship = 'elements';

    protected static ?string $title = 'Analyses bactériologiques';

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nom')
                ->required()
                ->maxLength(255)
                ->disabled(),
            TextInput::make('resultat')
                ->label('Résultat')
                ->maxLength(255),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nom')
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->label('Analyse')
                    ->sortable(),
                Tables\Columns\TextColumn::make('pivot.resultat')
                    ->label('Résultat')
                    ->placeholder('—'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\AttachAction::make()
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DetachAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DetachBulkAction::make(),
                ]),
            ]);
    }
}
