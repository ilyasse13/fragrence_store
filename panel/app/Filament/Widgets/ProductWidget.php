<?php

namespace App\Filament\Widgets;

use App\Models\Brand;
use App\Models\Customer;
use App\Models\Product;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

use function Livewire\before;

class ProductWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Products',Product::count())
            ->chart([1,4,11,23])
            ->color('success'),
            Stat::make('Brands',Brand::count())
            ->description('total brands working with')
            ->chart([1,12,20]),
            Stat::make('Our Customer',Customer::count())
            ->description('total customer baught from us')
            ->descriptionIcon('heroicon-s-users',IconPosition::Before)
            ->chart([1,12,20])
            ->color('success')
        ];
    }
}
