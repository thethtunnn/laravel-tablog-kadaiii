<?php

namespace App\Filament\Exports;

use App\Models\Store;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StoreExporter extends Exporter
{
    protected static ?string $model = Store::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('name'),
            ExportColumn::make('image'),
            ExportColumn::make('description'),
            ExportColumn::make('lowest_price'),
            ExportColumn::make('highest_price'),
            ExportColumn::make('postal_code'),
            ExportColumn::make('Address'),
            ExportColumn::make('opening_time'),
            ExportColumn::make('closing_time'),
            ExportColumn::make('category_id'),
            ExportColumn::make('seating_capacity'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your store export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
