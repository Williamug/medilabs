<?php

namespace App\Filament\Widgets;

use App\Models\TestOrder;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class UIncomesChart extends ChartWidget
{
    protected static ?string $heading = 'Income per month';

    protected function getData(): array
    {
        $data = Trend::query(TestOrder::where('payment_status', 'paid'))
            ->between(
                start: now()->subYear(),
                end: now(),
            )
            ->perMonth()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => static::$heading,
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
