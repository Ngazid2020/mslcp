<?php

namespace App\Filament\Resources\BilanResource\RelationManagers;

use App\Models\Analyse;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnalysesRelationManager extends RelationManager
{
    protected static string $relationship = 'analyses';
    protected static ?string $recordTitleAttribute = 'resultat';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('element_id')
                    ->relationship('element', 'nom')
                    ->preload()
                    ->required()
                    ->searchable()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->distinct(),
                Forms\Components\TextInput::make('resultat')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('element.nom')
                    ->label('Élément')
                    ->searchable(),
                    Tables\Columns\TextColumn::make('element.category.name')
                    ->label('Catégorie')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('resultat')
                    ->label('Résultat'),
                Tables\Columns\TextColumn::make('element.unite')
                    ->label('Unité de mesure'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                // Ajoute une action pour lancer l’édition collaborative via Livewire
                
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
