<?php

namespace App\Filament\Resources\ElementsResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
                TextInput::make('type_valeur'),
                TextInput::make('resultat')
                    ->default(fn($record) => $record?->type_valeur),



                // Radio::make('type_valeur')
                //     ->live()
                //     ->options([
                //         'positif/negatif' => 'Positif/Négatif',
                //         'positif/numerique' => 'Positif ou Numérique',
                //         'negatif/numerique' => 'Négatif ou Numérique',
                //     ])
                //     ->afterStateUpdated(function ($state, Set $set) {
                //         // Réinitialise les sous-choix quand on change de mode
                //         $set('sous_choix', null);
                //         $set('valeur_numerique', null);
                //     }),

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
            ->recordTitleAttribute('nom')
            ->columns([
                Tables\Columns\TextColumn::make('nom'),
                Tables\Columns\TextColumn::make('category.name'),
                Tables\Columns\TextColumn::make('resultat'),
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
