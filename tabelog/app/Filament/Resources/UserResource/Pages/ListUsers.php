<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Imports\UserImporter;
use App\Filament\Resources\UserResource;
use Filament\Actions;

use Filament\Resources\Pages\ListRecords;
// use Konnco\FilamentImport\Actions\ImportField;
// use Konnco\FilamentImport\Actions\ImportAction;


class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),


        ];
    }
    protected function getActions(): array
    {
        return [
            // Actions\ImportAction::make()
            //     ->importer(),
            Actions\CreateAction::make(),
        ];
    }
}
