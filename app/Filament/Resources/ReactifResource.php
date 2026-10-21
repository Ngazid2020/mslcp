<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReactifResource\Pages;
use App\Filament\Resources\ReactifResource\RelationManagers\LotsRelationManager;
use App\Models\Reactif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReactifResource extends Resource
{
    protected static ?string $model = Reactif::class;
    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Gestion des réactifs';
    protected static ?int $navigationGroupSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informations générales')
                    ->schema([
                        Forms\Components\TextInput::make('nom')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('reference')
                            ->label('Référence')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('fournisseur')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('unite_mesure')
                            ->label('Unité de mesure')
                            ->default('ml')
                            ->required()
                            ->maxLength(50),
                        Forms\Components\TextInput::make('seuil_alerte')
                            ->label('Seuil d\'alerte')
                            ->numeric()
                            ->default(5)
                            ->suffix(fn($get) => $get('unite_mesure') ?? ''),
                        Forms\Components\Toggle::make('est_actif')
                            ->label('Actif')
                            ->default(true),
                        
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('reference')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fournisseur')
                    ->searchable(),
                Tables\Columns\TextColumn::make('unite_mesure')
                    ->label('Unité'),
                Tables\Columns\TextColumn::make('stock_disponible')
                    ->label('Stock total')
                    ->sortable()
                    ->formatStateUsing(fn($record) => number_format($record->stock_disponible, 2) . ' ' . $record->unite_mesure)
                    ->color(fn($record) => $record->stock_disponible < $record->seuil_alerte ? 'danger' : 'success'),
                Tables\Columns\IconColumn::make('est_actif')
                    ->boolean(),
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
                Tables\Filters\TernaryFilter::make('est_actif')
                    ->label('Actif')
                    ->boolean(),
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

    public static function getRelations(): array
    {
        return [
            LotsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReactifs::route('/'),
            'create' => Pages\CreateReactif::route('/create'),
            'edit' => Pages\EditReactif::route('/{record}/edit'),
        ];
    }
}
