<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BilanResource\Pages;
use App\Filament\Resources\BilanResource\RelationManagers;
use App\Models\Bilan;
use App\Models\Element;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BilanResource extends Resource
{
    protected static ?string $model = Bilan::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Bilans d\'analyses';
    protected static ?int $navigationGroupSort = 2;


    // protected static ?int $navigationGroup = ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations')
                    ->schema([
                        Forms\Components\TextInput::make('ref')
                            ->label('Référence')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('type')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'nom')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                TextInput::make('nom'),
                                TextInput::make('prenom'),
                                Select::make('sexe')
                                    ->options([
                                        'M' => 'Masculin',
                                        'F' => 'Féminin'
                                    ]),
                                TextInput::make('domicile'),
                                TextInput::make('lieu_naissance'),
                                TextInput::make('age')
                            ])
                            // ->columns(2)
                            ->label('Patient')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                Section::make('Résultats des analyses')->schema([
                    Repeater::make('Analyses')
                        ->relationship()
                        ->schema([
                            Select::make('element_id')
                                ->relationship('element', 'nom')
                                ->preload()
                                ->required()
                                ->searchable()
                                ->distinct()
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->columnSpan(1),

                            TextInput::make('resultat')
                                ->label('Résultat'),

                        ])
                        ->addactionlabel('Ajouter une autre analyse')
                        ->columnSpan(1)
                        ->columns(2),
                ])
                ->hiddenOn('edit')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ref')
                    ->label('Référence')
                    ->searchable(),
                Tables\Columns\TextColumn::make('type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('patient.nom')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
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

                Action::make('Télécharger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('pdf.bilan', $record->id))
                    ->openUrlInNewTab()
                    ->color(Color::Emerald),
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
        RelationManagers\AnalysesRelationManager::class,
    ];
}

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBilans::route('/'),
            'create' => Pages\CreateBilan::route('/create'),
            'edit' => Pages\EditBilan::route('/{record}/edit'),
        ];
    }
}
