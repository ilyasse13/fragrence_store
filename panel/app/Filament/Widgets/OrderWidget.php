<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class OrderWidget extends ChartWidget
{
    protected static ?string $heading = 'Monthly Orders';
    public ?string $filter = 'year';
    protected int | string | array $columnSpan = 'full';
    protected function getData(): array
    {
        return $this->getDataWithFilter();
    }

    protected function getDataWithFilter(): array
    {
        $startDate = match ($this->filter) {
            '6months' => now()->subMonths(6),
            '3months' => now()->subMonths(3),
            default => now()->subYear(),
        };
        
        $data = Trend::model(Order::class)
            ->between($startDate, now())
            ->perMonth()
            ->count();
        
        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'borderColor' => '#3b82f6',
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getFilters(): ?array
    {
        return [
            'year' => 'This Year',
            '6months' => 'Last 6 Months',
            '3months' => 'Last 3 Months',
        ];
    }
    
}
