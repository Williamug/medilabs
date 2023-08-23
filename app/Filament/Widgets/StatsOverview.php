<?php

namespace App\Filament\Widgets;

use App\Models\LabService;
use App\Models\Patient;
use App\Models\TestOrder;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?string $pollingInterval = null; //or 10s

    protected function getStats(): array
    {
        return [
            Stat::make('Patients', Patient::all()->count()),
            Stat::make('Lab Services', LabService::all()->count()),
            Stat::make('Total Income', TestOrder::query()->where('payment_status', 'paid')->count()),
        ];
    }
}
