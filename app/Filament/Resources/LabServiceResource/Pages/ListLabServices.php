<?php

namespace App\Filament\Resources\LabServiceResource\Pages;

use App\Filament\Resources\LabServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLabServices extends ListRecords
{
    protected static string $resource = LabServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
