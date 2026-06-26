<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MaladieResource\Pages;
use App\Models\Maladie;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MaladieResource extends Resource
{
    protected static ?string $model = Maladie::class;

    protected static ?string $navigationIcon = 'heroicon-o-bug-ant';
    protected static ?string $navigationGroup = 'Rapports';
    protected static ?string $navigationLabel = 'Maladies';
    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasRole('administrateur') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Maladie')
                    ->schema([
                        TextInput::make('nom')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('code')
                            ->label('Code (optionnel)')
                            ->maxLength(20)
                            ->placeholder('Ex: PAL, TYP…'),
                        Toggle::make('actif')
                            ->label('Active dans les formulaires')
                            ->default(true)
                            ->inline(false),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nom')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('code')
                    ->placeholder('—')
                    ->sortable(),
                IconColumn::make('actif')
                    ->boolean()
                    ->sortable(),
                TextColumn::make('bilans_count')
                    ->label('Cas enregistrés')
                    ->counts('bilans')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Modifié le')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('nom')
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMaladies::route('/'),
            'create' => Pages\CreateMaladie::route('/create'),
            'edit'   => Pages\EditMaladie::route('/{record}/edit'),
        ];
    }
}
