<?php

namespace App\Filament\Imports;

use App\Models\Store;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;

class StoreImporter extends Importer
{
    protected static ?string $model = Store::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('image')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('description')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('lowest_price')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('highest_price')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('postal_code')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('Address')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('opening_time')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('closing_time')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('category_id')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('seating_capacity')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
        ];
    }

    public function resolveRecord(): ?Store
    {
        // return Store::firstOrNew([
        //     // Update existing records, matching them by `$this->data['column_name']`
        //     'email' => $this->data['email'],
        // ]);

        return new Store();
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your store import has completed and ' . number_format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
