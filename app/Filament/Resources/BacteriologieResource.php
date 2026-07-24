<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BacteriologieResource\Pages;
use App\Filament\Resources\ElementsResource\RelationManagers\AnalyseUrinairesRelationManager;
use App\Models\Bacteriologie;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BacteriologieResource extends Resource
{
    protected static ?string $model = Bacteriologie::class;

    protected static ?string $navigationIcon    = 'heroicon-o-bug-ant';
    protected static ?string $navigationGroup   = 'Bilans d\'analyses';
    protected static ?string $navigationLabel   = 'Bactériologies';
    protected static ?int    $navigationSort    = 4;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole(['administrateur', 'laborantin']) ?? false;
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informations')->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'nom')
                    ->getOptionLabelFromRecordUsing(fn (Patient $record) => trim($record->prenom . ' ' . $record->nom))
                    ->getSearchResultsUsing(fn (string $search) => Patient::query()
                        ->where('nom', 'like', "%{$search}%")
                        ->orWhere('prenom', 'like', "%{$search}%")
                        ->orderBy('nom')
                        ->limit(50)
                        ->get()
                        ->mapWithKeys(fn ($p) => [$p->id => trim($p->prenom . ' ' . $p->nom)])
                    )
                    ->required()
                    ->searchable()
                    ->preload()
                    ->createOptionForm([
                        Grid::make(2)->schema([
                            TextInput::make('nom')->required(),
                            TextInput::make('prenom')->required(),
                            TextInput::make('tel')->label('Téléphone'),
                            Select::make('sexe')
                                ->options(['M' => 'Masculin', 'F' => 'Féminin'])
                                ->required(),
                            TextInput::make('domicile'),
                            TextInput::make('lieu_naissance')->required(),
                            TextInput::make('age')
                                ->numeric()->required()->minValue(0)->maxValue(120),
                        ])
                    ])
                    ->label('Patient'),

                Forms\Components\Select::make('prescripteur_id')
                    ->label('Prescripteur')
                    ->relationship('prescripteur', 'nom')
                    ->createOptionForm([
                        Grid::make(2)->schema([
                            TextInput::make('nom')->label('Nom complet'),
                            TextInput::make('tel')->label('Téléphone'),
                            TextInput::make('email')->label('Email'),
                            TextInput::make('adresse')->label('Adresse'),
                        ])
                    ])
                    ->preload()
                    ->searchable(),

                TextInput::make('ref')
                    ->label('Référence')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Générée automatiquement (URI-AAAA-MM-NNN)'),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['patient', 'prescripteur']))
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('ref')
                    ->label('Référence')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient.nom')
                    ->label('Patient')
                    ->formatStateUsing(fn ($state, $record) => trim($record->patient?->prenom . ' ' . $record->patient?->nom))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('prescripteur.nom')
                    ->label('Prescripteur')
                    ->sortable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([])
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
            AnalyseUrinairesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBacteriologies::route('/'),
            'create' => Pages\CreateBacteriologie::route('/create'),
            'edit'   => Pages\EditBacteriologie::route('/{record}/edit'),
        ];
    }
}
