<?php

namespace App\Filament\Resources\SpacemenResource\Pages;

use App\Filament\Resources\SpacemenResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSpacemens extends ListRecords
{
    protected static string $resource = SpacemenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
