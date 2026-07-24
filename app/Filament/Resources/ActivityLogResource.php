<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ActivityLogResource\Pages;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Colors\Color;
use Filament\Tables;
use Filament\Tables\Table;
use Spatie\Activitylog\Models\Activity;

class ActivityLogResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static ?string $navigationIcon    = 'heroicon-o-clipboard-document-list';
    protected static ?string $navigationGroup   = 'Administration';
    protected static ?string $navigationLabel   = 'Journal d\'activité';
    protected static ?string $modelLabel        = 'Entrée du journal';
    protected static ?string $pluralModelLabel  = 'Journal d\'activité';
    protected static ?int    $navigationSort    = 99;

    public static function canViewAny(): bool
    {
        return auth()->user()?->hasRole('administrateur') ?? false;
    }

    public static function canCreate(): bool  { return false; }
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Date / Heure')
                    ->dateTime('d/m/Y H:i:s')
                    ->sortable()
                    ->width('160px'),

                Tables\Columns\BadgeColumn::make('event')
                    ->label('Événement')
                    ->colors([
                        'success' => 'created',
                        'warning' => 'updated',
                        'danger'  => 'deleted',
                    ])
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'created' => 'Créé',
                        'updated' => 'Modifié',
                        'deleted' => 'Supprimé',
                        default   => $state,
                    })
                    ->width('100px'),

                Tables\Columns\TextColumn::make('log_name')
                    ->label('Entité')
                    ->formatStateUsing(fn (string $state) => match ($state) {
                        'patients'         => 'Patient',
                        'bilans'           => 'Bilan',
                        'bilans_urinaires' => 'Bilan urinaire',
                        default            => ucfirst($state),
                    })
                    ->badge()
                    ->color(fn (string $state) => match ($state) {
                        'patients'         => Color::Sky,
                        'bilans'           => Color::Indigo,
                        'bilans_urinaires' => Color::Amber,
                        default            => Color::Gray,
                    })
                    ->width('130px'),

                Tables\Columns\TextColumn::make('subject_id')
                    ->label('ID enregistrement')
                    ->sortable()
                    ->width('80px'),

                Tables\Columns\TextColumn::make('causer.name')
                    ->label('Utilisateur')
                    ->placeholder('Système')
                    ->sortable(),

                Tables\Columns\TextColumn::make('description')
                    ->label('Description')
                    ->wrap(),

                Tables\Columns\TextColumn::make('properties')
                    ->label('Champs modifiés')
                    ->formatStateUsing(function ($state) {
                        if (blank($state)) return '—';

                        $data = is_string($state) ? json_decode($state, true) : (array) $state;

                        if (empty($data['attributes']) && empty($data['old'])) {
                            return '—';
                        }

                        $new = $data['attributes'] ?? [];
                        $old = $data['old'] ?? [];

                        if (empty($old)) {
                            $champs = array_keys($new);
                            return implode(', ', $champs);
                        }

                        $changed = array_keys(array_diff_assoc($new, $old));
                        return implode(', ', $changed) ?: '—';
                    })
                    ->wrap()
                    ->tooltip(function ($record) {
                        $data = is_string($record->properties)
                            ? json_decode($record->properties, true)
                            : (array) $record->properties;

                        if (empty($data)) return null;

                        $lines = [];
                        $new   = $data['attributes'] ?? [];
                        $old   = $data['old'] ?? [];

                        foreach ($new as $key => $val) {
                            if (array_key_exists($key, $old) && $old[$key] != $val) {
                                $lines[] = "{$key}: {$old[$key]} → {$val}";
                            } elseif (!array_key_exists($key, $old)) {
                                $lines[] = "{$key}: {$val}";
                            }
                        }

                        return implode("\n", $lines) ?: null;
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('log_name')
                    ->label('Entité')
                    ->options([
                        'patients'         => 'Patients',
                        'bilans'           => 'Bilans',
                        'bilans_urinaires' => 'Bilans urinaires',
                    ]),

                Tables\Filters\SelectFilter::make('event')
                    ->label('Événement')
                    ->options([
                        'created' => 'Créé',
                        'updated' => 'Modifié',
                        'deleted' => 'Supprimé',
                    ]),

                Tables\Filters\Filter::make('causer_id')
                    ->label('Par moi uniquement')
                    ->query(fn ($query) => $query->where('causer_id', auth()->id())
                                                 ->where('causer_type', 'App\Models\User')),
            ])
            ->actions([
                Tables\Actions\Action::make('detail')
                    ->label('Détail')
                    ->icon('heroicon-o-eye')
                    ->color(Color::Gray)
                    ->modalHeading(fn ($record) => 'Journal — ' . $record->log_name . ' #' . $record->subject_id)
                    ->modalContent(fn ($record) => view('filament.activity-log-detail', ['record' => $record]))
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Fermer'),
            ])
            ->bulkActions([])
            ->paginated([25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
        ];
    }
}
