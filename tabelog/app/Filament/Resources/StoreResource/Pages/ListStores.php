<?php

namespace App\Filament\Resources\StoreResource\Pages;

use App\Filament\Imports\StoreImporter;
use App\Filament\Resources\StoreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListStores extends ListRecords
{
    protected static string $resource = StoreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\ImportAction::make()
                ->importer(StoreImporter::class)


        ];
    }

    protected function getActions(): array
    {
        return [


            Actions\CreateAction::make(),

        ];
    }
}
