<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LotReactifResource\Pages;
use App\Models\LotReactif;
use App\Models\Reactif;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LotReactifResource extends Resource
{
    protected static ?string $model = LotReactif::class;

    protected static ?string $navigationIcon    = 'heroicon-o-archive-box';
    protected static ?string $navigationGroup   = 'Eléments et paramètres';
    protected static ?string $navigationLabel   = 'Lots de réactifs';
    protected static ?int    $navigationGroupSort = 3;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('administrateur') ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Lot')->schema([
                    Forms\Components\Select::make('reactif_id')
                        ->label('Réactif')
                        ->options(Reactif::orderBy('nom')->pluck('nom', 'id'))
                        ->searchable()
                        ->preload()
                        ->required(),

                    Forms\Components\TextInput::make('numero_lot')
                        ->label('Numéro de lot')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('fournisseur_lot')
                        ->label('Fournisseur')
                        ->maxLength(255),
                ])->columns(3),

                Forms\Components\Section::make('Quantités et tarif')->schema([
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
                ])->columns(3),

                Forms\Components\Section::make('Dates et état')->schema([
                    Forms\Components\DatePicker::make('date_achat')
                        ->label("Date d'achat"),

                    Forms\Components\DatePicker::make('date_peremption')
                        ->label('Date de péremption')
                        ->required(),

                    Forms\Components\Toggle::make('est_consommable')
                        ->label('Consommable (actif en stock)')
                        ->default(true),
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('reactif'))
            ->columns([
                Tables\Columns\TextColumn::make('reactif.nom')
                    ->label('Réactif')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('numero_lot')
                    ->label('N° lot')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantite_initiale')
                    ->label('Qté initiale')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('quantite_restante')
                    ->label('Qté restante')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($record) => $record->quantite_restante <= 0 ? 'danger' : 'success'),

                Tables\Columns\TextColumn::make('prix_achat')
                    ->label('Prix unitaire')
                    ->suffix(' FC')
                    ->numeric()
                    ->sortable()
                    ->placeholder('—'),

                Tables\Columns\TextColumn::make('date_peremption')
                    ->label('Péremption')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color(fn ($record) => $record->date_peremption < now()->toDateString() ? 'danger' : null),

                Tables\Columns\IconColumn::make('est_consommable')
                    ->label('Actif')
                    ->boolean(),

                Tables\Columns\TextColumn::make('fournisseur_lot')
                    ->label('Fournisseur')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('date_peremption')
            ->filters([
                Tables\Filters\SelectFilter::make('reactif_id')
                    ->label('Réactif')
                    ->relationship('reactif', 'nom')
                    ->searchable()
                    ->preload(),

                Tables\Filters\TernaryFilter::make('est_consommable')
                    ->label('Consommable')
                    ->boolean(),

                Tables\Filters\Filter::make('perime')
                    ->label('Périmés')
                    ->query(fn ($query) => $query->where('date_peremption', '<', now()->toDateString())),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(25);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListLotReactifs::route('/'),
            'create' => Pages\CreateLotReactif::route('/create'),
            'edit'   => Pages\EditLotReactif::route('/{record}/edit'),
        ];
    }
}
