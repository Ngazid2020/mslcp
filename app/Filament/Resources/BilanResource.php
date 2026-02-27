<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BilanResource\Pages;
use App\Filament\Resources\BilanResource\RelationManagers;
use App\Filament\Resources\ElementsResource\RelationManagers\ElementsRelationManager;
use App\Models\Bilan;
use App\Models\Category;
use App\Models\Element;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\CheckboxList;
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
    protected static ?string $navigationLabel = 'Bilans d\'analyse généraux';

    protected static ?int $navigationGroupSort = 2;


    // protected static ?int $navigationGroup = ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'nom')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('nom'),
                                        TextInput::make('prenom'),
                                        TextInput::make('tel')
                                            ->label('Téléphone'),
                                        Select::make('sexe')
                                            ->options([
                                                'M' => 'Masculin',
                                                'F' => 'Féminin'
                                            ]),
                                        TextInput::make('domicile'),
                                        TextInput::make('lieu_naissance'),
                                        TextInput::make('age')
                                            ->numeric()
                                            ->minValue(0)
                                            ->maxValue(120),
                                    ])
                            ])
                            ->afterStateHydrated(function ($state, callable $set) {
                                $patient = $state ? Patient::find($state) : null;
                                $set('patient_sexe', $patient?->sexe ?? '');
                                $set('patient_prenom', $patient?->prenom ?? '');
                            })
                            ->afterStateUpdated(function ($state, Set $set) {
                                $patient = Patient::find($state);
                                $set('patient_sexe', $patient->sexe);
                                $set('patient_prenom', $patient->prenom);
                            })
                            ->live()

                            ->label('Patient'),
                        TextInput::make('patient_prenom')
                            ->disabled()
                            ->dehydrated(false)
                            ->reactive()
                            ->label('Prénom')
                            ->default(fn($record) => $record?->patient?->prenom ?? ''),
                        TextInput::make('patient_sexe')
                            ->disabled()
                            ->dehydrated(false)
                            ->reactive()
                            ->label('Sexe')
                            ->default(fn($record) => $record?->patient?->sexe ?? ''),
                        Select::make('prescripteur_id')
                            ->relationship('prescripteur', 'nom')
                            ->createOptionForm([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('nom'),
                                        TextInput::make('adresse'),
                                        TextInput::make('tel'),
                                        TextInput::make('email'),
                                    ])
                            ])
                            ->preload()
                            ->searchable(),
                    ])
                    ->columns(4),
                Section::make('Résultats des analyses')->schema([
                    CheckboxList::make('categorie')
                        ->label(__('Catégories'))
                        ->options(Category::query()->orderBy('name')->pluck('name', 'id'))
                        ->columns(4)
                        ->reactive()
                        ->afterStateUpdated(function ($state, callable $set) {
                            // $state contient les IDs des catégories sélectionnées
                            if (empty($state)) {
                                $set('elements', []);
                                return;
                            }
                            // Récupère tous les IDs des éléments appartenant aux catégories sélectionnées
                            $elementIds = Element::whereIn('category_id', $state)->pluck('id')->toArray();
                            $set('elements', $elementIds);
                        }),
                    CheckboxList::make('elements')
                        ->label(__('Liste des éléments'))
                        ->relationship('elements', 'id')
                        ->options(function (callable $get) {
                            $categories = $get('categorie') ?? [];
                            if (empty($categories)) {
                                return Element::query()->orderBy('nom')->pluck('nom', 'id');
                            }
                            $elements = Element::whereIn('category_id', $categories)
                                ->orderBy('nom')
                                ->pluck('nom', 'id')
                                ->toArray();
                            natcasesort($elements);
                            return $elements;
                        })
                        ->columns(3)
                        ->searchable()
                        ->reactive()
                        ->columnSpanFull(),
                ])
                    ->hiddenOn('edit')

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('ref')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient.nom')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:m:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),

                Action::make('Télécharger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('pdf.bilan', $record->id))
                    ->openUrlInNewTab()
                    ->color(Color::Emerald)
                    ->visible(fn($record) => auth()->user()->can('download', $record)),
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
            ElementsRelationManager::class,
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
