<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BilanUrinaireResource\Pages;
use App\Models\BilanUrinaire;
use App\Models\Patient;
use Filament\Forms;
use Filament\Forms\Components\Grid;
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

class BilanUrinaireResource extends Resource
{
    protected static ?string $model = BilanUrinaire::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Bilans d\'analyses';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations')
                    ->schema([
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
                            })
                            ->afterStateUpdated(function ($state, Set $set) {
                                $patient = Patient::find($state);
                                $set('patient_sexe', $patient?->sexe ?? '');
                            })
                            ->live()

                            ->label('Patient'),
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
                    ->columns(3),
                Section::make('Biochimie urinaire')->schema([
                    Forms\Components\TextInput::make('urobilinogene')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('albumine')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('sucre')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('acetone')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('ph')
                        ->label('pH')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('bilirubine')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('densite')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('sang')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('nitrite')
                        ->maxLength(255)
                        ->default(null),
                    Forms\Components\TextInput::make('leucocytes')
                        ->maxLength(255)
                        ->default(null),
                ])->columns(5),
                Section::make('Examen Cytobacteriologique Des Urines')->schema([
                    Section::make('E.Microscopique')->schema([
                        Forms\Components\TextInput::make('aspect_urines')
                            ->maxLength(255)
                            ->default(null),
                    ]),
                    Section::make('E.Macroscopique')->schema([
                        Forms\Components\TextInput::make('cellules_epitheliales')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('leucocytes_micro')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('hematies')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('parasites')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('elements_fongiques')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('bacteries')
                            ->maxLength(255)
                            ->default(null),
                        Forms\Components\TextInput::make('cristaux')
                            ->maxLength(255)
                            ->default(null),
                    ]),
                ]),

                Section::make()->schema([
                    Forms\Components\Textarea::make('coloration_gram')
                    ->label('Coloration de Gram')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('culture')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('conclusion')
                        ->columnSpanFull(),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                
                Tables\Columns\TextColumn::make('patient.nom')
                    ->label('Patient')
                    ->formatStateUsing(fn ($state, $record) => trim($record->patient?->prenom . ' ' . $record->patient?->nom))
                    ->searchable(query: fn (Builder $query, string $search) =>
                        $query->whereHas('patient', fn ($q) =>
                            $q->where('nom', 'like', "%{$search}%")
                              ->orWhere('prenom', 'like', "%{$search}%")
                        )
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('prescripteur.nom')
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
                Action::make('Télécharger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('pdf.bilanurinaire', $record->id))
                    ->openUrlInNewTab()
                    ->color(Color::Emerald),
                    // ->visible(fn($record) => auth()->user()->can('download', $record)),
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
            'index' => Pages\ListBilanUrinaires::route('/'),
            'create' => Pages\CreateBilanUrinaire::route('/create'),
            'edit' => Pages\EditBilanUrinaire::route('/{record}/edit'),
        ];
    }
}
