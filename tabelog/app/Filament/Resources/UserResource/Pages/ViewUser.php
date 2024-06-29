<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Route;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    public static function isCurrentPage(): bool
    {

        return Route::currentRouteName() === static::getRouteName();
    }
}
