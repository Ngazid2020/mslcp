<?php

namespace App\Filament\Resources;

use App\Filament\Exports\ElementExporter;
use App\Filament\Resources\ElementResource\Pages;
use App\Models\Element;
use Filament\Forms;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportBulkAction;
use Filament\Tables\Table;

class ElementResource extends Resource
{
    protected static ?string $model = Element::class;

    protected static ?string $navigationIcon = 'heroicon-o-eye-dropper';
    protected static ?string $navigationGroup = 'Eléments et paramètres';
    protected static ?string $navigationLabel = 'Éléments d\'analyse';
    protected static ?int $navigationGroupSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informations de l\'élément')->schema([
                    Grid::make(['default' => 1, 'md' => 2, 'xl' => 3])->schema([
                        Forms\Components\TextInput::make('nom')
                            ->label("Nom de l'élément")
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('unite')
                            ->label('Unité de mesure')
                            ->maxLength(255)
                            ->default(null),
                        Select::make('category_id')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Section::make()->schema([
                            Radio::make('type_valeur')
                                ->options([
                                    'numerique'         => 'Numérique',
                                    'qualitatif'        => 'Qualitatif (négatif / + / ++ / +++)',
                                    'positif/negatif'   => 'Positif / Négatif',
                                    'positif/numerique' => 'Positif ou Numérique',
                                    'negatif/numerique' => 'Négatif ou Numérique',
                                ])
                                ->inline(),
                        ]),

                    ])

                ])->columns(3),
                Section::make()->schema([
                    Grid::make(['default' => 1, 'md' => 2, 'xl' => 5])->schema([
                        Section::make('Homme Adulte')->schema([
                            Forms\Components\TextInput::make('ref_inf_h')
                                ->label('Norme inférieure')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('ref_sup_h')
                                ->label('Norme supérieure')
                                ->maxLength(255)
                                ->default(null),
                        ])->columnSpan(1),
                        Section::make('Femme Adulte')->schema([
                            Forms\Components\TextInput::make('ref_inf_f')
                                ->label('Norme inférieure')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('ref_sup_f')
                                ->label('Norme supérieur')
                                ->maxLength(255)
                                ->default(null),
                        ])->columnSpan(1),
                        Section::make('Enfant')->schema([
                            Forms\Components\TextInput::make('ref_inf_enf')
                                ->label('Norme inférieure')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('ref_sup_enf')
                                ->label('Norme supérieur')
                                ->maxLength(255)
                                ->default(null),
                        ])->columnSpan(1),
                        Section::make('Nourrisson')->schema([
                            Forms\Components\TextInput::make('ref_inf_nour')
                                ->label('Norme inférieure')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('ref_sup_nour')
                                ->label('Norme supérieur')
                                ->maxLength(255)
                                ->default(null),
                        ])->columnSpan(1),
                        Section::make('Nouveau-né(e)')->schema([
                            Forms\Components\TextInput::make('ref_inf_nne')
                                ->label('Norme inférieure')
                                ->maxLength(255)
                                ->default(null),
                            Forms\Components\TextInput::make('ref_sup_nne')
                                ->label('Norme supérieur')
                                ->maxLength(255)
                                ->default(null),
                        ])->columnSpan(1),

                    ])
                ])

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with('category'))
            ->columns([
                Tables\Columns\TextColumn::make('nom')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('unite')
                    ->searchable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Catégorie')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('type_valeur')
                    ->sortable()
                    ->searchable(),
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
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    ExportBulkAction::make()
                        ->exporter(ElementExporter::class)
                        ->label('Exporter'),

                ]),
            ])
            ->headerActions([
                // ExportAction::make()
                //     ->exporter(ElementExporter::class)
            ])
            ->defaultPaginationPageOption(25);
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
            'index' => Pages\ListElements::route('/'),
            'create' => Pages\CreateElement::route('/create'),
            'edit' => Pages\EditElement::route('/{record}/edit'),
        ];
    }
}
