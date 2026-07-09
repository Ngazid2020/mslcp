<?php

namespace App\Filament\Resources\ElementsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ElementsRelationManager extends RelationManager
{
    protected static string $relationship = 'elements';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nom')
                    ->required()
                    ->maxLength(255)
                    ->disabled(),
                Select::make('category')
                    ->relationship('category', 'name')
                    ->disabled(),
                Hidden::make('type_valeur'),

                // Saisie numérique (ou texte libre) — masquée pour les éléments qualitatifs
                TextInput::make('resultat')
                    ->label('Résultat')
                    ->hidden(fn(Get $get) => $get('type_valeur') === 'qualitatif'),

                // Saisie qualitative : négatif / + / ++ / +++ / ++++
                Select::make('resultat')
                    ->label('Résultat')
                    ->options([
                        'négatif' => '— Négatif',
                        '+'       => '+ (faible parasitémie)',
                        '++'      => '++ (parasitémie modérée)',
                        '+++'     => '+++ (forte parasitémie)',
                        '++++'    => '++++ (très forte parasitémie)',
                    ])
                    ->hidden(fn(Get $get) => $get('type_valeur') !== 'qualitatif')
                    ->live(),

                // Radio secondaire : Positif/Négatif (s'affiche pour les 3 modes)
                Radio::make('sous_choix')
                    ->live()
                    ->hidden(fn(Get $get) => !$get('type_valeur')) // Caché si type_valeur vide
                    ->options(function (Get $get) {
                        $type = $get('type_valeur');

                        return match ($type) {
                            'positif/negatif' => [
                                'positif' => 'Positif',
                                'negatif' => 'Négatif',
                            ],
                            'positif/numerique' => [
                                'positif' => 'Positif',
                                'negatif' => 'Négatif (saisie numérique)',
                            ],
                            'negatif/numerique' => [
                                'negatif' => 'Négatif',
                                'positif' => 'Positif (saisie numérique)',
                            ],
                            default => [],
                        };
                    })
                    ->afterStateUpdated(function ($state, Set $set, Get $get) {
                        $type = $get('type_valeur');

                        // Si "positif" est choisi, on définit directement le résultat
                        if ($state === 'positif' && str_contains($type, 'positif')) {
                            $set('resultat', 'positif');
                        }
                        // Si "negatif" est choisi, on définit directement de résultat
                        elseif ($state === 'negatif' && $type === 'negatif/numerique') {
                            $set('resultat', 'negatif');
                        }
                        // Si "negatif" est choisi dans un mode sans numérique
                        elseif ($state === 'negatif' && $type === 'positif/negatif') {
                            $set('resultat', 'negatif');
                        }
                        // Sinon (cas numérique), on laisse le champ texte gérer la valeur
                        else {
                            $set('resultat', null);
                        }
                    }),



                // Champ caché qui stocke la valeur finale
                TextInput::make('resultat')
                    ->hidden()
                    ->dehydrated(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('category'))
            ->recordTitleAttribute('nom')
            ->columns([
                Tables\Columns\TextColumn::make('nom'),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie'),
                Tables\Columns\TextColumn::make('unite')
                    ->label('Unité'),
                Tables\Columns\TextColumn::make('resultat')
                    ->badge()
                    ->color(function ($record, $livewire) {
                        $resultat = $record->pivot?->resultat;

                        if ($resultat === null || $resultat === '') {
                            return 'gray';
                        }

                        $patient = $livewire->getOwnerRecord()->patient;

                        if (! $patient) {
                            return 'gray';
                        }

                        // Pour les éléments qualitatifs : négatif = success, tout le reste = danger
                        if ($record->type_valeur === 'qualitatif') {
                            return $record->isResultOutOfRange($resultat, $patient) ? 'danger' : 'success';
                        }

                        if (! is_numeric($resultat)) {
                            return 'gray';
                        }

                        return $record->isResultOutOfRange($resultat, $patient)
                            ? 'danger'
                            : 'success';
                    }),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
