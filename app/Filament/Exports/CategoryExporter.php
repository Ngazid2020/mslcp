<?php

namespace App\Filament\Exports;

use App\Models\Category;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class CategoryExporter extends Exporter
{
    protected static ?string $model = Category::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $n    = number_format($export->successful_rows);
        $body = "Export des catégories terminé — {$n} " . ($export->successful_rows > 1 ? 'lignes exportées' : 'ligne exportée') . '.';

        if ($failed = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failed) . ' ' . ($failed > 1 ? 'lignes ont échoué' : 'ligne a échoué') . '.';
        }

        return $body;
    }
}
