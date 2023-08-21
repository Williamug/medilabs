<?php

namespace App\Filament\Resources\LabServiceCategoryResource\Pages;

use App\Filament\Resources\LabServiceCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLabServiceCategories extends ManageRecords
{
    protected static string $resource = LabServiceCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
