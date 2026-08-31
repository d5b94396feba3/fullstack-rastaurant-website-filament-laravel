<?php

namespace App\Filament\Widgets;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Page;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class RestaurantStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Total Menu Items', MenuItem::count())
                ->description('Active dishes listed')
                ->descriptionIcon('heroicon-m-sparkles')
                ->color('warning'),

            Stat::make('Categories', Category::count())
                ->description('Active menu sections')
                ->descriptionIcon('heroicon-m-rectangle-stack')
                ->color('success'),

            Stat::make('CMS Custom Pages', Page::count())
                ->description('Published information pages')
                ->descriptionIcon('heroicon-m-document-text')
                ->color('info'),
        ];
    }
}