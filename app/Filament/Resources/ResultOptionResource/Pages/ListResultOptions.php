<?php

namespace App\Filament\Resources\ResultOptionResource\Pages;

use App\Filament\Resources\ResultOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResultOptions extends ListRecords
{
    protected static string $resource = ResultOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
