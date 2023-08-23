<?php

namespace App\Filament\Resources\TestOrderResource\Pages;

use App\Filament\Resources\TestOrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageTestOrders extends ManageRecords
{
    protected static string $resource = TestOrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
