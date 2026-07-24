<?php

namespace App\Filament\Resources\ReactifResource\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class LotsRelationManager extends RelationManager
{
    protected static string $relationship = 'lots';
    protected static ?string $recordTitleAttribute = 'numero_lot';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('numero_lot')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quantite_initiale')
                    ->label('Quantité initiale')
                    ->numeric()
                    ->required()
                    ->step(0.01),
                Forms\Components\TextInput::make('quantite_restante')
                    ->label('Quantité restante')
                    ->numeric()
                    ->required()
                    ->step(0.01)
                    ->default(0),
                Forms\Components\TextInput::make('prix_achat')
                    ->label('Prix unitaire (FC)')
                    ->numeric()
                    ->step(0.01),
                Forms\Components\DatePicker::make('date_achat')
                    ->label('Date d\'achat'),
                Forms\Components\DatePicker::make('date_peremption')
                    ->label('Date de péremption')
                    ->required(),
                Forms\Components\TextInput::make('fournisseur_lot')
                    ->label('Fournisseur (lot)')
                    ->maxLength(255),
                Forms\Components\Toggle::make('est_consommable')
                    ->label('Consommable')
                    ->default(true),
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Ajouter un lot')
                    ->icon('heroicon-o-plus'),
            ])
            ->columns([
                Tables\Columns\TextColumn::make('numero_lot')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantite_initiale')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantite_restante')
                    ->numeric()
                    ->sortable()
                    ->color(fn($record) => $record->quantite_restante <= 0 ? 'danger' : 'success'),
                Tables\Columns\TextColumn::make('prix_achat')
                    ->label('Prix unitaire')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('date_peremption')
                    ->date()
                    ->sortable()
                    ->color(fn($record) => $record->est_perime ? 'danger' : null),
                Tables\Columns\IconColumn::make('est_consommable')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('est_consommable')
                    ->label('Consommable')
                    ->boolean(),
                Tables\Filters\Filter::make('perime')
                    ->label('Périmés')
                    ->query(fn($query) => $query->where('date_peremption', '<', now()->toDateString())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function getHeaderActions(): array
    // {
    //     return [
    //         CreateAction::make()
    //             ->label('Ajouter un lot')
    //             ->icon('heroicon-o-plus')
    //             ->modalHeading('Nouveau lot')
    //             ->createAnother(false),
    //     ];
    // }
}
