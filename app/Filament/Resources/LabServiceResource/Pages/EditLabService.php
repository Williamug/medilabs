<?php

namespace App\Filament\Resources\LabServiceResource\Pages;

use App\Filament\Resources\LabServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLabService extends EditRecord
{
    protected static string $resource = LabServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
