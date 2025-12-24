<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnalyseUrinaireResource\Pages;
use App\Filament\Resources\AnalyseUrinaireResource\RelationManagers;
use App\Models\AnalyseUrinaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AnalyseUrinaireResource extends Resource
{
    protected static ?string $model = AnalyseUrinaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Bactériologie';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('category_analyse_id')
                    ->relationship('category_analyse', 'name')
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('resultat')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('category_analyse.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnalyseUrinaires::route('/'),
            'create' => Pages\CreateAnalyseUrinaire::route('/create'),
            'edit' => Pages\EditAnalyseUrinaire::route('/{record}/edit'),
        ];
    }
}
