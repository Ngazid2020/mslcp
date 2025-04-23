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
            ExportColumn::make('ref_inf_h'),
            ExportColumn::make('ref_sup_h'),
            ExportColumn::make('ref_inf_f'),
            ExportColumn::make('ref_sup_f'),
            ExportColumn::make('ref_inf_enf'),
            ExportColumn::make('ref_sup_enf'),
            ExportColumn::make('ref_inf_nour'),
            ExportColumn::make('ref_sup_nour'),
            ExportColumn::make('unite'),
            ExportColumn::make('category_id'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your element export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
