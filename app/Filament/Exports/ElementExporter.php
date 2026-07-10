<?php

namespace App\Filament\Exports;

use App\Models\Element;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class ElementExporter extends Exporter
{
    protected static ?string $model = Element::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('nom'),
            ExportColumn::make('ref_inf_h')->label('ref_inf_h'),
            ExportColumn::make('ref_sup_h')->label('ref_sup_h'),
            ExportColumn::make('ref_inf_f')->label('ref_inf_f'),
            ExportColumn::make('ref_sup_f')->label('ref_sup_f'),
            ExportColumn::make('ref_inf_enf')->label('ref_inf_enf'),
            ExportColumn::make('ref_sup_enf')->label('ref_sup_enf'),
            ExportColumn::make('ref_inf_nour')->label('ref_inf_nour'),
            ExportColumn::make('ref_sup_nour')->label('ref_sup_nour'),
            ExportColumn::make('unite'),
            ExportColumn::make('category_id')->label('category_id'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $n    = number_format($export->successful_rows);
        $body = "Export des éléments terminé — {$n} " . ($export->successful_rows > 1 ? 'lignes exportées' : 'ligne exportée') . '.';

        if ($failed = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failed) . ' ' . ($failed > 1 ? 'lignes ont échoué' : 'ligne a échoué') . '.';
        }

        return $body;
    }
}
