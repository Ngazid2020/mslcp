<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BilanResource\Pages;
use App\Filament\Resources\ElementsResource\RelationManagers\ElementsRelationManager;
use App\Models\Bilan;
use App\Models\Category;
use App\Models\Element;
use App\Models\Maladie;
use App\Models\Patient;
use App\Services\StockService;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Cache;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BilanResource extends Resource
{
    protected static ?string $model = Bilan::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Bilans d\'analyses';
    protected static ?string $navigationLabel = 'Bilans d\'analyse généraux';
    protected static ?int $navigationGroupSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // ─── 1. Informations patient / prescripteur ─────────────────
                Section::make('Informations')
                    ->schema([
                        Forms\Components\Select::make('patient_id')
                            ->relationship('patient', 'nom')
                            ->getOptionLabelFromRecordUsing(fn(Patient $record) => trim($record->prenom . ' ' . $record->nom))
                            ->getSearchResultsUsing(
                                fn(string $search) => Patient::query()
                                    ->where('nom', 'like', "%{$search}%")
                                    ->orWhere('prenom', 'like', "%{$search}%")
                                    ->orderBy('nom')
                                    ->limit(50)
                                    ->get()
                                    ->mapWithKeys(fn($p) => [$p->id => trim($p->prenom . ' ' . $p->nom)])
                            )
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('nom')->required(),
                                        TextInput::make('prenom')->required(),
                                        TextInput::make('tel')->label('Téléphone'),
                                        Select::make('sexe')
                                            ->options(['M' => 'Masculin', 'F' => 'Féminin'])
                                            ->required(),
                                        TextInput::make('domicile'),
                                        TextInput::make('lieu_naissance')->required(),
                                        TextInput::make('age')
                                            ->numeric()
                                            ->required()
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
                            ->label('Prescripteur')
                            ->relationship('prescripteur', 'nom')
                            ->createOptionForm([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('nom')->label('Nom complet'),
                                        TextInput::make('tel')->label('Téléphone'),
                                        TextInput::make('email')->label('Email'),
                                        TextInput::make('adresse')->label('Adresse'),
                                    ])
                            ])
                            ->preload()
                            ->searchable(),
                        Select::make('statut')
                            ->label('Statut')
                            ->options([
                                'en_attente_prelevement' => 'En attente de prélèvement',
                                'preleve'                => 'Prélevé',
                                'en_cours_analyse'       => 'En cours d\'analyse',
                                'termine'                => 'Terminé',
                            ])
                            ->required()
                            ->default('en_attente_prelevement'),
                    ])
                    ->columns(3),

                // ─── 2. Maladies détectées ──────────────────────────────────
                Section::make('Maladies détectées')
                    ->schema([
                        CheckboxList::make('maladies')
                            ->relationship('maladies', 'nom')
                            ->options(fn() => Cache::remember(
                                'form_maladies_actives',
                                300,
                                fn() => Maladie::query()->where('actif', true)->orderBy('nom')->pluck('nom', 'id')
                            ))
                            ->columns(3)
                            ->columnSpanFull()
                            ->helperText('Cocher les pathologies diagnostiquées lors de ce bilan.'),
                    ])
                    ->columns(1),

                // ─── 3. Résultats des analyses (sélection des éléments) ────
                Section::make('Résultats des analyses')
                    ->schema([
                        CheckboxList::make('categorie')
                            ->label(__('Catégories'))
                            ->options(fn() => Cache::remember(
                                'form_categories_all',
                                3600,
                                fn() => Category::query()->orderBy('name')->pluck('name', 'id')
                            ))
                            ->columns(4)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (empty($state)) {
                                    $set('elements', []);
                                    return;
                                }
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
                    ->hiddenOn('edit'),

                // ─── 4. Vérification de la disponibilité des réactifs ─────
                Section::make('Disponibilité des réactifs')
                    ->schema([
                        Forms\Components\Actions::make([
                            Forms\Components\Actions\Action::make('verifierStock')
                                ->label('Vérifier la disponibilité')
                                ->icon('heroicon-o-check-circle')
                                ->color('info')
                                ->action(function ($get) {
                                    $elements = Element::whereIn('id', $get('elements') ?? [])->get();

                                    if ($elements->isEmpty()) {
                                        \Filament\Notifications\Notification::make()
                                            ->title('Aucun élément sélectionné')
                                            ->body('Veuillez d\'abord sélectionner des analyses.')
                                            ->warning()
                                            ->send();
                                        return;
                                    }

                                    $bilan = new Bilan();
                                    $bilan->setRelation('elements', $elements);

                                    $service = new StockService();
                                    $result = $service->verifierDisponibilite($bilan);

                                    if ($result['disponible']) {
                                        \Filament\Notifications\Notification::make()
                                            ->title('✅ Stock disponible')
                                            ->body(implode("\n", $result['messages']))
                                            ->success()
                                            ->send();
                                    } else {
                                        \Filament\Notifications\Notification::make()
                                            ->title('❌ Stock insuffisant')
                                            ->body(implode("\n", $result['messages']))
                                            ->danger()
                                            ->send();
                                    }
                                })
                        ]),
                    ])
                    ->collapsible()
                    ->collapsed(fn($livewire) => $livewire instanceof \Filament\Resources\Pages\CreateRecord),
            ]);
    }

    // ─── TABLE ──────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->with(['patient', 'prescripteur']))
            ->columns([
                Tables\Columns\TextColumn::make('ref')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('patient.nom')
                    ->label('Patient')
                    ->formatStateUsing(fn($state, $record) => trim($record->patient?->prenom . ' ' . $record->patient?->nom))
                    ->searchable(
                        query: fn(Builder $query, string $search) =>
                        $query->whereHas(
                            'patient',
                            fn($q) => $q->where('nom', 'like', "%{$search}%")
                                ->orWhere('prenom', 'like', "%{$search}%")
                        )
                    )
                    ->sortable(),
                Tables\Columns\TextColumn::make('prix_total')
                    ->label('Total')
                    ->suffix(' FC')
                    ->sortable()
                    ->formatStateUsing(fn($state) => number_format($state ?? 0, 0, ',', ' ')),
                Tables\Columns\TextColumn::make('statut')
                    ->label('Statut')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'en_attente_prelevement' => 'warning',
                        'preleve'                => 'info',
                        'en_cours_analyse'       => 'primary',
                        'termine'                => 'success',
                        default                  => 'gray',
                    })
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'en_attente_prelevement' => 'En attente prélèv.',
                        'preleve'                => 'Prélevé',
                        'en_cours_analyse'       => 'En cours analyse',
                        'termine'                => 'Terminé',
                        default                  => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Créé le')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\Action::make('changerStatut')
                    ->label('Changer statut')
                    ->icon('heroicon-o-arrows-right-left')
                    ->color('warning')
                    ->form([
                        Select::make('statut')
                            ->label('Nouveau statut')
                            ->options([
                                'en_attente_prelevement' => 'En attente de prélèvement',
                                'preleve'                => 'Prélevé',
                                'en_cours_analyse'       => 'En cours d\'analyse',
                                'termine'                => 'Terminé',
                            ])
                            ->default(fn($record) => $record->statut)
                            ->required(),
                    ])
                    ->action(function (Bilan $record, array $data): void {
                        $record->statut = $data['statut'];
                        $record->save();

                        Notification::make()
                            ->title('Statut mis à jour avec succès')
                            ->success()
                            ->send();
                    }),
                Tables\Actions\EditAction::make(),
                ActionGroup::make([
                    Tables\Actions\Action::make('ticket')
                        ->label('Ticket')
                        ->icon('heroicon-o-ticket')
                        ->color('info')
                        ->url(fn($record) => route('ticket.show', $record))
                        ->openUrlInNewTab(),
                    Action::make('bilan_general')
                        ->label('Bilan général')
                        ->icon('heroicon-o-document-text')
                        ->url(fn($record) => route('pdf.bilan', $record->id))
                        ->openUrlInNewTab()
                        ->color(Color::Emerald),
                    Action::make('bilan_hormonal')
                        ->label('Bilan hormonal')
                        ->icon('heroicon-o-beaker')
                        ->url(fn($record) => route('pdf.hormonal', $record->id))
                        ->openUrlInNewTab()
                        ->color(Color::Violet),
                ])
                    ->label('Télécharger')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color(Color::Emerald)
                    ->button()
                    ->visible(fn($record) => auth()->user()->can('download', $record)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultPaginationPageOption(25);
    }

    // ─── RELATIONS & PAGES ──────────────────────────────────────────────────

    public static function getRelations(): array
    {
        return [
            ElementsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBilans::route('/'),
            'create' => Pages\CreateBilan::route('/create'),
            'edit'   => Pages\EditBilan::route('/{record}/edit'),
        ];
    }
}
