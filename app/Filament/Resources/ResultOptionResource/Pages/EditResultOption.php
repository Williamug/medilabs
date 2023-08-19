<?php

namespace App\Filament\Resources\ResultOptionResource\Pages;

use App\Filament\Resources\ResultOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResultOption extends EditRecord
{
    protected static string $resource = ResultOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
